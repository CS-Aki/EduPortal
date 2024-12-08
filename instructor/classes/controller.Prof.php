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

    public function createPost($classCode, $type, $title, $desc, $endDate, $endTime, $startingDate, $startingTime, $points, $attempt){
        if (session_id() === "") session_start();

        // date_default_timezone_set('Asia/Manila');
    
        // // Get the current date and time
        // $currentDateTime = date('Y-m-d H:i');
        // $currentDate = new DateTime($currentDateTime);
    
        // // Combine user input for ending and starting dates and times
        // $endDateTime = new DateTime($endDate . ' ' . $endTime);
        // $startingDateTime = new DateTime($startingDate . ' ' . $startingTime);
    
        // // Validate the conditions
        // if ($startingDateTime < $currentDate) {
        //     echo "<div class='alert alert-error' role='alert'>";
        //     echo "<span>Starting time and date should not be less than the current time and date.</span>";
        //     echo "</div>";
        //     exit();
        // }
    
        // if ($startingDateTime > $endDateTime) {
        //     echo "<div class='alert alert-error' role='alert'>";
        //     echo "<span>Starting time and date should not be greater than the deadline time and date.</span>";
        //     echo "</div>";
        //     exit();
        // }
    
        // if ($endDateTime <= $currentDate) {
        //     echo "<div class='alert alert-error' role='alert'>";
        //     echo "<span>Deadline time and date should be greater than the current time and date.</span>";
        //     echo "</div>";
        //     exit();
        // }

       $result =  $this->addPost($classCode, $type, $title, $desc, $endDate, $endTime, $startingDate, $startingTime, $points, $attempt);
       if($result == true){
            // echo $classCode;
            return $this->getPostViaId($_SESSION["postId"], $classCode);
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

    public function createQuiz($classCode, $questions, $postId, $removedElements, $removedChoices){
        $totalPoints = 0;


        foreach ($questions as $question) {
             $totalPoints += $question["points"];
        }
        // echo $totalPoints;
        $result = $this->uploadQuiz($classCode, $questions, $totalPoints, $postId, $removedElements, $removedChoices);
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

    public function getQuizDetails($postId, $classCode){
        $details = $this->fetchQuizDetails($postId, $classCode);
        if($details == null){
            // echo "No Quiz Yet";
        }

        return $details;
    }

    public function removeChoice($questionId, $choiceValue, $answerKey){
        // $result = $this->removeChoiceInDb($questionId, $choiceValue, $answerKey);

        // $ansResult = true;

        // if($choiceValue == $answerKey){
        //    $ansResult = $this->updateAnswerKey($questionId, $answerKey);
        // }
     
        // if($ansResult == false){
        //     echo "ERROR UPDATING ANSWER KEY";
        // }

        // if($result == false){
        //     echo "ERROR REMOVING CHOICE \n\n\n";
        //     return;
        // }

        // echo "REMOVE SUCCESSFULLY";
    }

    public function removeQuiz($postId){
        $result = $this->removeQuizInDb($postId);
        if($result == false){
            echo "DELETION FAILED";
        }
    }
}
