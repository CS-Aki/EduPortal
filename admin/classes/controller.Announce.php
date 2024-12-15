<?php 

class AnnounceController extends Announcement
{
    public function postAnnouncement($subject, $fromDate, $toDate, $msgType, $audience, $message){
     
        $result = $this->postAnnouncementInDb($subject, $fromDate, $toDate, $msgType, $audience, $message);
        if($result == false){
            echo "INSERTING ANNOUNCEMENT FAILED";
            return;
        }

        echo "Posting of Announcement Succss";
    }

    public function getAllAnnouncement(){
        $result = $this->getAllAnnouncementInDb();

        return $result;
    }

    public function getAnnouncement($announceId){
        return $this->getAnnouncementInDb($announceId);
    }
}