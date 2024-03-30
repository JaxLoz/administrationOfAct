<?php

namespace model;

class Act
{
    private $id;
    private $progress;

    private $id_user;

    public function __construct()
    {
        $this->id = 0;
        $this->progress = '';
        $this->id_user = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProgress(): string
    {
        return $this->progress;
    }

    public function setProgress(string $progress): void
    {
        $this->progress = $progress;
    }

    public function getIdUser(): int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): void
    {
        $this->id_user = $id_user;
    }




}