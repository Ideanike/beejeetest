<?php

namespace App\Http\User;

use App\Http\AbstractAction;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutAction extends AbstractAction
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->sessionManager->getStorage()->setMetadata('isAuth', 0);
        return new RedirectResponse('/task', 302);
    }
}