<?php

namespace model;

class Rol
{

    private $id;
    private $name;

    public function __construct()
    {
        $this->id = 0;
        $this->name = '';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

}