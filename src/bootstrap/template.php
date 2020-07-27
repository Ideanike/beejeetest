<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$twigLoader = new FilesystemLoader('templates');
$twig = new Environment($twigLoader, [
    'cache' => 'var/cache/twig',
]);