<?php

namespace App\Http\User;

use App\Entity\User;
use App\Http\AbstractAction;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CreateAction extends AbstractAction
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody();
        if (!empty($params)) {
            $user = new User();
            $user->setLogin($params['login']);
            $user->setPassword($params['password']);
            $this->em->persist($user);
            $this->em->flush();
            return new RedirectResponse('/task', 302);
        }

        return new HtmlResponse($this->template->render('user/create.twig', [
            'isAuth' => $this->sessionManager->getStorage()->getMetadata('isAuth')
        ]));
    }
}