<?php
namespace App\Models;


/**
 * Class User
 * @package App\Models
*/
class User
{
    /** @var int */
    private $id;

    /** @var string */
    private $email;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Book
     */
    public function setId(int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Book
    */
    public function setEmail(?string $email): Book
    {
        $this->email = $email;
        return $this;
    }
}