<?php

use Aura\Router\RouterContainer;

$routerContainer = new RouterContainer();
$routerMap = $routerContainer->getMap();

$routerMap->get('home', '/', \App\Http\Task\ListAction::class);
$routerMap->get('task-list', '/task', \App\Http\Task\ListAction::class);
$routerMap->get('task-create-get', '/task/create', \App\Http\Task\CreateAction::class);
$routerMap->post('task-create-post', '/task/create', \App\Http\Task\CreateAction::class);
$routerMap->get(
    'task-update-get',
    '/task/update/{id}',
    \App\Http\Task\UpdateAction::class
)
    ->tokens(['id' => '\d+']);
$routerMap->post(
    'task-update-post',
    '/task/update/{id}',
    \App\Http\Task\UpdateAction::class
)
    ->tokens(['id' => '\d+']);


$routerMap->get('user-create-get', '/user/create', \App\Http\User\CreateAction::class);
$routerMap->post('user-create-post', '/user/create', \App\Http\User\CreateAction::class);
$routerMap->get('user-login-get', '/user/login', \App\Http\User\LoginAction::class);
$routerMap->post('user-login-post', '/user/login', \App\Http\User\LoginAction::class);
$routerMap->get('user-logout-get', '/user/logout', \App\Http\User\LogoutAction::class);