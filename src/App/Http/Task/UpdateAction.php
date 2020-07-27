<?php

namespace App\Http\Task;

use App\Entity\Task;
use App\Http\AbstractAction;
use App\Services\Task\UpdateTask;
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

class UpdateAction extends AbstractAction
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
        $id = $request->getAttribute('id');
        $isAuth = $this->sessionManager->getStorage()->getMetadata('isAuth');

        if (!$isAuth) {
            return new RedirectResponse('/user/login');
        }

        $repository = $this->em->getRepository(Task::class);
        /** @var Task $task */
        $task = $repository->find($id);

        if ($task === null) {
            return new HtmlResponse('Task not found', 404);
        }

        $params = $request->getParsedBody();
        if (!empty($params)) {
            try {
                $service = new UpdateTask($this->em, $task);
                $service->handle($params);
                return new RedirectResponse('/task', 302);
            } catch (InvalidArgumentException $e) {
                $errors[] = $e->getMessage();
            }
        }

        return new HtmlResponse(
            $this->template->render(
                'task/update.twig',
                [
                    'task' => $task,
                    'isAuth' => $isAuth,
                    'errors' => $errors,
                ]
            )
        );
    }
}