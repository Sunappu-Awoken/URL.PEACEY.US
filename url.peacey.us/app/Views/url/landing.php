<?php include __DIR__ . '/../partials/head.php'; ?>

<!-- Hero Section -->
<section class="hero">
  <div class="container mx-auto text-center py-16">
    <img 
      src="<?= htmlspecialchars($data['logo']) ?>" 
      alt="<?= htmlspecialchars($data['logo_alt'] ?? $data['title']) ?>" 
      class="mx-auto mb-6 max-w-xs"
    />
    <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($data['headline']) ?></h1>
    <p class="text-lg text-gray-700 mb-8"><?= htmlspecialchars($data['subheadline']) ?></p>
    <a href="<?= htmlspecialchars($data['cta_link']) ?>" class="btn btn-primary"><?= htmlspecialchars($data['cta_text']) ?></a>
  </div>
</section>

<!-- Features Section -->
<section class="features bg-gray-50 py-12">
  <div class="container mx-auto grid grid-cols-1 md:grid-cols-<?= count($data['features']) ?> gap-8">
    <?php foreach ($data['features'] as $feature): ?>
      <div class="feature text-center px-6">
        <h3 class="font-semibold text-xl mb-2"><?= htmlspecialchars($feature['title']) ?></h3>
        <p><?= htmlspecialchars($feature['description']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Steps / How It Works -->
<section class="steps py-12">
  <div class="container mx-auto space-y-12">
    <?php foreach ($data['steps'] as $step): ?>
      <div class="step flex items-center">
        <div class="step-number text-3xl font-bold mr-4"><?= htmlspecialchars($step['number']) ?></div>
        <p><?= htmlspecialchars($step['description']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Testimonials -->
<?php if (!empty($data['testimonials'])): ?>
<section class="testimonials bg-white py-12">
  <div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center"><?= htmlspecialchars($data['testimonials_title'] ?? 'What Our Users Say') ?></h2>
    <?php foreach ($data['testimonials'] as $testimonial): ?>
      <blockquote class="italic text-center max-w-2xl mx-auto mb-8">
        “<?= htmlspecialchars($testimonial['quote']) ?>”
        <footer class="mt-4">— <?= htmlspecialchars($testimonial['author']) ?><?= !empty($testimonial['company']) ? ', ' . htmlspecialchars($testimonial['company']) : '' ?></footer>
      </blockquote>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>
