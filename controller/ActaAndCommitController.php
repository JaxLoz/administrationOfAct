<?php

namespace controller;

use dao\ActAndCommitmentDao;
use model\ActAndCommiment;

require 'dao/ActAndCommitmentDao.php';
require 'model/ActAndCommiment.php';


class ActaAndCommitController
{
    private $actCommitDao;

    public function __construct()
    {
        $this->actCommitDao = new ActAndCommitmentDao();
    }

    public function updateActAndCommimentPut()
    {

        $data = json_decode(file_get_contents("php://input"), true);
        $newInfoActCommit = new ActAndCommiment();
        $oldInfoActCommit = new ActAndCommiment();

        $newInfoActCommit->setIdAct($data['newId_Act']);
        $newInfoActCommit->setIdCommiment($data['newId_Commitment']);
        $oldInfoActCommit->setIdAct($data['oldId_Act']);
        $oldInfoActCommit->setIdCommiment($data['oldId_Commitment']);

        $Updated = $this->actCommitDao->updateActAndCommiment($newInfoActCommit, $oldInfoActCommit);

        if($Updated){

            http_response_code(204);
        }else{

            http_response_code(500);
        }

    }

    public function insertActAndCommitmentPost()
    {

        $data = json_decode(file_get_contents("php://input"), true);
        $newActAndCommit = new ActAndCommiment();
        $newActAndCommit->setIdAct($data['id_act']);
        $newActAndCommit->setIdCommiment($data['id_commitment']);

        $ActAndCommitCreate = $this->actCommitDao->insertActAndCommitIds($newActAndCommit);

        if($ActAndCommitCreate){
            http_response_code(201);
        }else{

            http_response_code(500);
        }
    }

    public function removeActAndCommitmentDelete()
    {
        $infAC = new ActAndCommiment();
        $infAC->setIdAct($_GET['idAct']);
        $infAC->setIdCommiment($_GET['idCommit']);

        $infoDeleted = $this->actCommitDao->deleteActAndCommitment($infAC);

        if($infoDeleted){
            http_response_code(204);
        }else{

            http_response_code(404);
        }

    }
}