<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $userName;
    /**
     * @ORM\Column(type="string")
     */
    protected $email;
    /**
     * @ORM\Column(type="text")
     */
    protected $content;
    /**
     * @ORM\Column(type="integer")
     */
    protected $status;
    /**
     * @ORM\Column(type="integer")
     */
    protected $editedByAdmin;

    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($value): void
    {
        Assert::notEmpty($value, 'Username cant be empty');
        $this->userName = $value;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value): void
    {
        Assert::email($value, 'Invalid Email');
        $this->email = $value;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($value): void
    {
        Assert::notEmpty($value, 'Content cant be empty');
        $this->content = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(int $value): void
    {
        $this->status = $value;
    }

    public function getEditedByAdmin()
    {
        return $this->editedByAdmin;
    }

    public function setEditedByAdmin(int $value): void
    {
        $this->editedByAdmin = $value;
    }
}