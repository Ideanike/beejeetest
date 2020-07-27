<?php

namespace App\Http\User;

use App\Entity\User;
use App\Http\AbstractAction;
use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LoginAction extends AbstractAction
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $errors = [];

        try {
            $params = $request->getParsedBody();
            if (!empty($params)) {
                if (empty($params['login']) || empty($params['password'])) {
                    throw new InvalidArgumentException('User and Password must set');
                }

                $repository = $this->em->getRepository(User::class);
                /** @var User $user */
                $user = $repository->findOneBy([
                    'login' => $params['login']
                ]);

                if ($user === null) {
                    throw new InvalidArgumentException('User not found');
                }

                if (!$user->validatePassword($params['password'])) {
                    throw new InvalidArgumentException('User not found');
                }

                $this->sessionManager->getStorage()->setMetadata('isAuth', 1);

                return new RedirectResponse('/task', 302);
            }
        } catch (InvalidArgumentException $e) {
            $errors[] = $e->getMessage();
        }

        return new HtmlResponse(
            $this->template->render(
                'user/login.twig',
                [
                    'errors' => $errors,
                    'isAuth' => $this->sessionManager->getStorage()->getMetadata('isAuth')
                ]
            )
        );
    }
}