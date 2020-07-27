<?php

namespace App\Http\Task;

use App\Http\AbstractAction;
use App\Services\Task\AddTask;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use InvalidArgumentException;
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
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $errors = [];
        $params = $request->getParsedBody();
        if (!empty($params)) {
            try {
                $service = new AddTask($this->em);
                $service->handle($params);
                $this->sessionManager->getStorage()->setMetadata('flashMessage', 'Task added successfully');
                return new RedirectResponse('/task', 302);
            } catch (InvalidArgumentException $e) {
                $errors[] = $e->getMessage();
            }
        }

        $isAuth = $this->sessionManager->getStorage()->getMetadata('isAuth');

        return new HtmlResponse(
            $this->template->render(
                'task/create.twig',
                [
                    'isAuth' => $isAuth,
                    'errors' => $errors,
                ]
            )
        );
    }
}