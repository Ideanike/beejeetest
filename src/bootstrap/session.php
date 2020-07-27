<?php

use Laminas\Session\Config\StandardConfig;
use Laminas\Session\SessionManager;

$sessionConfig = new StandardConfig();
$sessionConfig->setOptions([
    'remember_me_seconds' => 1800,
    'name'                => 'laminas',
]);
$sessionManager = new SessionManager($sessionConfig);
$sessionManager->start();
$sessionManager->regenerateId(true);
