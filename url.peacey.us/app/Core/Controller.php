<?php
namespace App\Core;

class Controller
{
    protected function view($template, $data = [])
    {
        extract($data);
        include __DIR__ . '/../Views/' . $template . '.php';
    }
}