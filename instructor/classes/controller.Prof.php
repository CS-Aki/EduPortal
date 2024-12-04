<?php

class InstructorController extends Instructor
{
    public function getProfClass(){
        $classList = $this->fetchInstructorClass();
        return $classList;
    }

    public function getAllProf()
    {
        $instructorList = $this->fetchAllInstructor();

        if (count($instructorList) == 0 || count($instructorList) == null) {
            $_SESSION["msg"] = "No Records Founds";
            header("Location: admin-dashboard.php?adminBtn=Instructor List");
            exit();
        }

        return $instructorList;
    }

    public function searchInstructor()
    {
        $profName = $_POST["searchClassInstructor"];
        $result = $this->findInstructor($profName);
        if (count($result) == 0 || count($result) == null) {
            $_SESSION["msg"] = "No Records Founds";
            header("Location: admin-dashboard.php?adminBtn=Instructor List");
            exit();
        }
        return $result;
    }

    public function getAllProfClasses(){
        $profName = $_POST["user_name"];

        $list = $this->fetchAllProfClass($profName);
        if($list == 0 || $list == null){
            echo "Error";
            return;
        }

        return $list;
    }

    public function convertClassCode(){
        $classCode = $this->findClassCode();
        echo "Class Code " . $classCode;
        $details = $this->fetchClassDetails($classCode);
        return $details;
    }

    public function getClassDetails($classCode){
        // echo $classCode;
        $details = $this->fetchClassDetails($classCode);
        // echo $details[0]["class_code"];
        return $details;
      //  echo $details[0]["title"];
    }

    // public function addPost(){
    //     $classCode = $_POST["class-code"];
    //     $title = $_POST["title"];
    //     $desc = $_POST["desc"];
    //     $type = $_POST["type"];
    //     $profName = $_POST["profName"];

    //     $result = $this->sendPostToDb($classCode,$profName,$title, $desc, $type);
    //     if($result == false){
    //         echo "Failed";
    //     }
    // }

    public function getSession(){
        return $this->fetchSession();
    }

    public function changeVisibility($id, $status){
        
        if($status == "Hidden") $status = "Visible";
        else $status = "Hidden";
       
        return $this->visibilityEdit($id, $status);
    }

    public function classDetails($classCode){
        // echo $classCode;
        $details = $this->fetchClassDetails($classCode);
        // echo $details[0]["class_code"];
        return $details;
      //  echo $details[0]["title"];
    }

    // Bad naming lmao but it just gets all the posts inside that class
    public function postDetails($classCode){
        $details = $this->fetchPost($classCode);
        return $details;
    }

    public function getPostDetails($postID, $classCode){
        $content = $this->fetchPostDetails($postID, $classCode);
        if($content == null){
            echo "Controller error";
        }
        return $content;
    }

    public function getComments($title, $classCode){
        return $this->fetchComments($title, $classCode);
    }

    public function postComment($postID, $classCode, $comment){
        return $this->insertComment($postID, $classCode, $comment);
    }

    public function createPost($classCode, $type, $title, $desc, $date, $time){
        date_default_timezone_set('Asia/Manila');
        $currentDateTime = date('Y-m-d H:i');
        $userDateTime = $date . ' ' . $time;
        $currentDate = new DateTime($currentDateTime);
        $userDate = new DateTime($userDateTime);
     
        if ($userDate > $currentDate) {

        } else {
            echo "<div class='alert alert-error' role='alert'>";
            echo "<span>INVALID INPUT</span>";
            echo "</div>";
            exit();
        }

       $result =  $this->addPost($classCode, $type, $title, $desc, $date, $time);
       if($result == true){
            // echo $classCode;
            return $this->getPost($title, $classCode);
            // echo "<div class='alert alert-success' role='alert'>";
            // echo "<span>Post Success</span>";
            // echo "</div>";
       }else{
          echo "ERROR POSTING";
          return null;
       }
    }

    public function submitAttendance($classCode, $studentId, $status){
        date_default_timezone_set('Asia/Manila');
        $currentDate = date("Y/m/d");
        
        if($this->isSameStatus($classCode, $studentId, $currentDate, $status) == true){
            echo "Same Status";
            return;
        }

         $this->insertAttendance($classCode, $studentId, $currentDate, $status);
    }

    public function updatePicture($userId, $profile){
        return $this->updateProfilePicture($userId, $profile);
    }

    public function createQuiz($quizTitle, $classCode, $questions){
        $totalPoints = 0;
        foreach ($questions as $question) {
             $totalPoints += $question["points"];
        }
        // echo $totalPoints;
        $result = $this->uploadQuiz($quizTitle, $classCode, $questions, $totalPoints);
        if($result == false){
            echo "Error Uploading Quiz In Db\n";
            return;
        }

        echo "Success Uploading Quiz In Db\n";
    }

    public function uploadGdriveData($postId, $classCode, $fileName, $gdriveId, $fileSize, $userId){
       $result = $this->insertGdriveData($postId, $classCode, $fileName, $gdriveId, $fileSize, $userId);

       if($result == false){
        echo "ERROR UPLOADING GDRIVE DATA INTO DB";
        return;
       }

       echo "GDRIVE DATA SUCCESS";
    }

    public function getFiles($postId, $classCode){
        $content = $this->getFIlesInDb($postId, $classCode);

        if($content == null){
            // echo "Controller error";
            return;
        }

        return $content;

    }
}
