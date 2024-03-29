<?php

namespace dao;

use PDO;
use util\DbConnection;
use model\User;

require ".\util\DbConnection.php";
//require ".\model\User.php";
class UserDao
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DbConnection::getInstance()->getConnection();
    }

    public function loginVerification(&$user)
    {
        $userLog = null;
        $userEmail = $user->getEmail();
        $userPassword = $user->getPassword();
        try {
            $sql = "select * from user where email like :email and user_password like :password";
            $stament = $this->pdo->prepare($sql);
            $stament->bindParam(":email", $userEmail);
            $stament->bindParam(":password", $userPassword);
            $stament->execute();

            if ($stament->rowCount() > 0) {
                $userLog = $stament->fetch(PDO::FETCH_ASSOC);

            }


        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $userLog;
    }

    public function getUsers()
    {
        $infoUser = null;

        $sql = "select u.firstname, u.lastname, u.email, u.phone, r.rol_name from user as u inner join rol as r on u.id_rol = r.id";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        $infoUser = $stm->fetchAll(PDO::FETCH_ASSOC);

        if(isset($infoUser)){
            return $infoUser;
        }

        return $infoUser;
    }

    public function getUserId($id)
    {
        $infoUser = null;

        $sql = "select u.firstname, u.lastname, u.email, u.phone, r.rol_name from user as u inner join rol as r on u.id_rol = r.id where u.id = :id";
        $stm = $this->pdo->prepare($sql);
        $stm->bindParam(':id', $id);
        $stm->execute();
        $infoUser = $stm->fetch(PDO::FETCH_ASSOC);

        if(isset($infoUser)){
            return $infoUser;
        }

        return $infoUser;
    }

    public function getUserForRol($rol)
    {
        $infoUser = null;
        $sql = "select u.firstname, u.lastname, u.email, u.phone, r.rol_name from user as u inner join rol as r on u.id_rol = r.id where r.rol_name = :rol";
        $stm = $this->pdo->prepare($sql);
        $stm->bindParam(':rol', $rol);
        $stm->execute();
        $infoUser = $stm->fetchAll(PDO::FETCH_ASSOC);

        if(isset($infoUser)){
            return $infoUser;
        }

        return $infoUser;
    }

    public function registerUser(User &$user)
    {
        
        $userFirtsname = $user->getFirtsname();
        $userLastname = $user->getLastname();
        $userEmail = $user->getEmail();
        $userPassword = $user->getPassword();
        $userPhone = $user->getPhone();
        $idRol = $user->getIdRol();
        $userInsert = null;

        try {
            $sql = "insert into user (firstname, lastname, email, user_password, phone, id_rol) values (:firtsname, :lastname, :email, :password, :phone, :rol)";
            $stament = $this->pdo->prepare($sql);
            $stament->bindParam(":firtsname", $userFirtsname);
            $stament->bindParam(":lastname", $userLastname);
            $stament->bindParam(":email", $userEmail);
            $stament->bindParam(":password", $userPassword);
            $stament->bindParam(":phone", $userPhone);
            $stament->bindParam(':rol', $idRol);
            $stament->execute();
            $affectedRows = $stament->rowCount();

            if($affectedRows > 0){
               $userInsert = $this->getUserId($this->pdo->lastInsertId());
            }else{
                return $userInsert;
            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return $userInsert;
    }

    public function deleteUser($id)
    {

        try {

            $sqlSelect = "select * from user where id = ?";
            $stm = $this->pdo->prepare($sqlSelect);
            $stm->bindParam(1, $id);
            $stm->execute();
            if($stm->rowCount() > 0){
                $infoUserDelete = $stm->fetch(PDO::FETCH_ASSOC);
            }

            if(isset($infoUserDelete)){
                $sql = "DELETE FROM user WHERE id = ?";
                $stamente = $this->pdo->prepare($sql);
                $stamente->bindParam(1, $id);
                $stamente->execute();

            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return $infoUserDelete;

    }

    public function updateUser(&$user)
    {
        $iUserUpd = [
            "id" => $user->getId(),
            "firstname" => $user->getFirtsname(),
            "lastname" => $user->getLastname(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "phone" => $user->getPhone()
        ];
        try{

            $sql = "update user set 
                firstname = :firstname, 
                lastname = :lastname, 
                email = :email, 
                user_password = :password, 
                phone = :phone 
                where id = :id";

            $stm = $this->pdo->prepare($sql);
            $stm->bindParam(":firstname", $iUserUpd["firstname"]);
            $stm->bindParam(":lastname", $iUserUpd["lastname"]);
            $stm->bindParam(':email', $iUserUpd['email']);
            $stm->bindParam(':password', $iUserUpd['password']);
            $stm->bindParam(':phone', $iUserUpd['phone']);
            $stm->bindParam(':id', $iUserUpd['id']);
            $stm->execute();

            if($stm->rowCount() > 0){
                $sqlSelect = "select * from user where id = :id";
                $sts = $this->pdo->prepare($sqlSelect);
                $sts->bindParam(':id', $iUserUpd['id']);
                $sts->execute();
                $infUser = $sts->fetch(PDO::FETCH_ASSOC);
            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return $infUser;
    }

}