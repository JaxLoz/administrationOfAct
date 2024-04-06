<?php

namespace model;

class ActAndCommiment
{
    private $id;
    private $id_act;
    private $id_commiment;

    public function __construct()
    {
        $this->id = 0;
        $this->id_act = $id_act = 0;
        $this->id_commiment = $id_commiment = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdAct(): int
    {
        return $this->id_act;
    }

    public function setIdAct(int $id_act): void
    {
        $this->id_act = $id_act;
    }

    public function getIdCommiment(): int
    {
        return $this->id_commiment;
    }

    public function setIdCommiment(int $id_commiment): void
    {
        $this->id_commiment = $id_commiment;
    }

}