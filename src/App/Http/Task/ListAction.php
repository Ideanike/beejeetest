<?php

namespace App\Http\Task;

use App\Entity\Task;
use App\Helpers\Pagination;
use App\Helpers\Sort;
use App\Http\AbstractAction;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ListAction extends AbstractAction
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws ReflectionException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $repository = $this->em->getRepository(Task::class);
        $pagination = new Pagination($request, $repository->count([]));
        $sort = new Sort($request, Task::class);

        /** @var Task[] $tasks */
        $tasks = $repository->findBy(
            [],
            $sort->getSort(),
            $pagination->getPageSize(),
            $pagination->getOffset()
        );

        $message = $this->sessionManager->getStorage()->getMetadata('flashMessage');
        $this->sessionManager->getStorage()->setMetadata('flashMessage', null);

        return new HtmlResponse(
            $this->template->render(
                'task/list.twig',
                [
                    'tasks' => $tasks,
                    'pagination' => $pagination,
                    'sort' => $sort,
                    'isAuth' => $this->sessionManager->getStorage()->getMetadata('isAuth'),
                    'message' => $message,
                ]
            )
        );
    }
}