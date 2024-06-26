<?php

namespace dao;

use modelDao\CrudDao;
use PDO;
use PDOException;

class InvitationDao extends CrudDao
{
    public function __construct()
    {
        parent::__construct("invitation");
    }

    public function getInfoUserAndMeetingForEmail($idInvitation): array
    {
        $infoInvitation = [];
        $sql = "select u.firstname, u.lastname, m.title, m.place, m.star_date, m.star_time, c.email from invitation as i
                inner join credentials as c on i.id_credentials = c.id
                inner join user as u on u.id_credential = c.id
                inner join meeting as m on i.id_meeting = m.id
                where i.id = :idInvitation;";

        try{
            $stm = parent::getCon()->prepare($sql);
            $stm->bindParam(":idInvitation", $idInvitation);

            if($stm->execute()) {
                $infoInvitation = $stm->fetch(PDO::FETCH_ASSOC);
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return $infoInvitation;
    }

    public function getInvitationsByCredentials($email)
    {
        $infoInvitation = null;
        $sql = "select i.id as id_invitation, c.email, u.firstname, u.lastname, m.title, m.star_date, m.star_time, m.place from invitation as i
    inner join credentials as c on i.id_credentials = c.id
    inner join user as u on u.id_credential = c.id
    inner join meeting as m on i.id_meeting = m.id
    where c.email = ? AND i.assistance = 0 AND (m.star_date >= DATE(convert_tz(NOW(), '+00:00', '-05:00')) OR (m.star_date = DATE(convert_tz(NOW(), '+00:00', '-05:00')) AND m.star_time > TIME(CONVERT_TZ(curtime(),'+00:00', '-05:00'))))";

        try{
            $stm = parent::getCon()->prepare($sql);
            $stm->bindValue(1, $email);

            if($stm->execute()) {
                $infoInvitation = $stm->fetchAll(PDO::FETCH_ASSOC);
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return $infoInvitation;
    }

    public function deleteInvitationByMeetingId($idMeeting): bool
    {

        $invitationDeleted = false;
        $sql = "delete from invitation where id_meeting = :idMeeting";

        try{
            $stm = parent::getCon()->prepare($sql);
            $stm->bindParam(":idMeeting", $idMeeting);
            $stm->execute();

            if($stm->rowCount() > 0) {
                $invitationDeleted = true;
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return $invitationDeleted;
    }

    public function getInfoGuestByMeetingId($meetingId)
    {
        $infoGuest = null;
        $sql = "select i.id, i.assistance, c.email, u.firstname, u.lastname, m.title, m.star_date, m.star_time, m.place from invitation as i
    inner join credentials as c on i.id_credentials = c.id
    inner join user as u on u.id_credential = c.id
    inner join meeting as m on i.id_meeting = m.id
    where m.id = ?";

        try{
            $stm = parent::getCon()->prepare($sql);
            $stm->bindValue(1, $meetingId);

            if($stm->execute()) {
                $infoGuest = $stm->fetchAll(PDO::FETCH_ASSOC);
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return $infoGuest;
    }
}