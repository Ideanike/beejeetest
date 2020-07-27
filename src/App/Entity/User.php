<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $login;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $value): void
    {
        $this->login = $value;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $value): void
    {
        $this->password = password_hash($value, PASSWORD_DEFAULT);
    }

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}