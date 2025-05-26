<?php
/**
 * fn.php
 *
 * Core helpers for URL shortening using MySQL.
 * Depends on a `links` table.
 */

 function connect_to_mysql() {
    $connect_error = 'Sorry, we are experiencing connection issues. Please try again later...';
    $conn = mysqli_connect(
        '127.0.0.1',               // force TCP
        'peaceysy_peacey',         // DB user
        'Supportmanager1111$',     // DB pass
        'peaceysy_peacey',         // database
        3306                      // ← the port in phpMyAdmin
    ) or die($connect_error);
    return $conn;
}


/**
 * Validate that a string is a well-formed URL.
 */
function validateUrl(string $url): bool {
    return !empty($url) && filter_var($url, FILTER_VALIDATE_URL) !== false;
}

/**
 * Generate a random 6-char hex alias that isn’t already in the DB.
 */
function generateAlias(int $length = 6): string {
    $conn = connect_to_mysql();
    do {
        $alias = bin2hex(random_bytes((int)ceil($length / 2)));
        $stmt = $conn->prepare("SELECT COUNT(*) FROM links WHERE alias = ?");
        $stmt->bind_param("s", $alias);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
    } while ($count > 0);
    return $alias;
}

/**
 * Save a new link record.
 * Returns true on success.
 */
function saveLink(string $url, string $alias, string $description = ''): bool {
    $conn = connect_to_mysql();
    $stmt = $conn->prepare(
        "INSERT INTO links (alias, url, description) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $alias, $url, $description);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

/**
 * Retrieve the original URL for a given alias.
 * Returns the URL or null if not found.
 */
function getOriginalUrl(string $alias): ?string {
    $conn = connect_to_mysql();
    $stmt = $conn->prepare("SELECT url FROM links WHERE alias = ? LIMIT 1");
    $stmt->bind_param("s", $alias);
    $stmt->execute();
    $stmt->bind_result($url);
    if ($stmt->fetch()) {
        $stmt->close();
        return $url;
    }
    $stmt->close();
    return null;
}

/**
 * Build the full short URL for display.
 */
function buildShortUrl(string $alias): string {
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'];
    return rtrim("$scheme://$host", '/') . '/' . $alias;
}

/**
 * Fetch all links, optionally filtered by URL substring or date.
 * $search: substring to match in URL (case-insensitive)
 * $date:    'YYYY-MM-DD' to match start of created_at
 */
function getAllLinks(string $search = '', string $date = ''): array {
    $conn = connect_to_mysql();
    $sql = "SELECT alias, url, description, created_at FROM links";
    $clauses = [];
    $params = [];
    $types  = '';

    if ($search !== '') {
        $clauses[] = "url LIKE ?";
        $params[]  = '%' . $search . '%';
        $types    .= 's';
    }
    if ($date !== '') {
        $clauses[] = "created_at LIKE ?";
        $params[]  = $date . '%';
        $types    .= 's';
    }
    if (!empty($clauses)) {
        $sql .= ' WHERE ' . implode(' AND ', $clauses);
    }
    $sql .= ' ORDER BY created_at DESC';

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $links = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $links;
}

/**
 * Fetch admin row by username.
 * Returns ['id'=>…, 'username'=>…, 'password_hash'=>…] or null.
 */
function getAdminByUsername(string $username): ?array {
    $conn = connect_to_mysql();
    $stmt = $conn->prepare(
      "SELECT id, username, password_hash FROM admins WHERE username = ? LIMIT 1"
    );
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
    return $admin ?: null;
}

/**
 * Verify a plaintext password against the stored hash.
 */
function verifyAdminCredentials(string $username, string $password): bool {
    $admin = getAdminByUsername($username);
    if (!$admin) {
        return false;
    }
    return password_verify($password, $admin['password_hash']);
}
