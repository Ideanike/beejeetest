<?php

namespace App\Services\Task;

use App\Entity\Task;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class AddTask
{
    /** @var EntityManager */
    protected $em;

    /**
     * AddTask constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $params
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle($params): void
    {
        $task = new Task();
        $task->setUserName($params['userName']);
        $task->setEmail($params['userEmail']);
        $task->setContent($params['content']);
        $task->setStatus(0);
        $task->setEditedByAdmin(0);
        $this->em->persist($task);
        $this->em->flush();
    }
}