<?php


namespace App\Services\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UpdateTask
{
    /** @var EntityManager */
    protected $em;
    /** @var Task */
    protected $task;

    /**
     * UpdateTask constructor.
     * @param EntityManager $em
     * @param Task $task
     */
    public function __construct(EntityManager $em, Task $task)
    {
        $this->em = $em;
        $this->task = $task;
    }

    /**
     * @param array $params
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle($params): void
    {
        if ($params['content'] !== $this->task->getContent()) {
            $this->task->setEditedByAdmin(1);
            $this->task->setContent($params['content']);
        }

        $this->task->setStatus(isset($params['status']) ? 1 : 0);

        $this->em->persist($this->task);
        $this->em->flush();
    }
}