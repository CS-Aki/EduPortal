<?php 

class StudentController extends ClassRm{
    public function joinClass($classCode){
    
        if(strlen($classCode) != 8){
            echo "<br><div class='alert alert-danger' role='alert'>";
            echo "<span>Code Must be 8 Letters Long!</span>";
            echo "</div>";
            return;
        }
        
        if($this->isClassCodeExist($classCode) == false){
            echo "<br><div class='alert alert-danger' role='alert'>";
            echo "<span>Class Not Found!</span>";
            echo "</div>";
            return;
        }

        if($this->alreadyInClass($classCode, $_SESSION['user_id']) == true){
            echo "<br><div class='alert alert-danger' role='alert'>";
            echo "<span>You are already in this class</span>";
            echo "</div>";
            return;
        }

        if($this->isClassActive($classCode) == false){
            echo "<br><div class='alert alert-danger' role='alert'>";
            echo "<span>Class Not Available!</span>";
            echo "</div>";
            return;
        }

        $classNum = $this->getClassNum($classCode);
        $result = $this->joiningClass($_SESSION['id'], $_SESSION['name'], $classCode, $classNum[0]["class_num"]);

        if($result == false){
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<span>Failed to join class</span>";
            echo "</div>";
        }else{
            echo "<div class='alert alert-success' role='alert'>";
            echo "<span>Joined Class Successfully</span>";
            echo "</div>";
        }
    }

        

    public function getClassDetails($classCode){
        // echo $classCode;
        $details = $this->fetchClassDetails($classCode);
        // echo $details[0]["class_code"];
        return $details;
      //  echo $details[0]["title"];
    }

    public function getClassDetails1($classCode){
        // echo $classCode;
        $details = $this->fetchClassDetails1($classCode);
        // echo $details[0]["class_code"];
        return $details;
      //  echo $details[0]["title"];
    }

    public function getPostDetails($postId, $classCode){
        $content = $this->fetchPostDetails($postId, $classCode);
        if($content == null){
            // echo "Controller error";
        }
        return $content;
    }

    public function getComments($postId, $classCode){
          return $this->fetchComments($postId, $classCode);
    }

    public function postComment($title, $classCode, $comment){
        return $this->insertComment($title, $classCode, $comment);
    }

    public function getProfileDetails($name, $email){
        $profile = $this->fetchStudentProfile($name, $email);
    
        return $profile;
    }

    public function updatePicture($userId, $profile){
        return $this->updateProfilePicture($userId, $profile);
    }

    public function searchInstructor($profName){
        return $this->findInstructor($profName);
    }

    public function getAttendance($studentId){
        date_default_timezone_set('Asia/Manila');

        $currentDate = date("Y-m-d");
        // echo $currentDate;

        $classCode = $_GET["class"];
        $status = $this->fetchStudentAttendance($studentId, $classCode, $currentDate);

        if($status == null || count($status) == 0){
            // echo "Error fetching attendance";
            return;
        }

        return $status;
    }

    public function getFiles($postId, $classCode){
        $content = $this->getFIlesInDb($postId, $classCode);

        if($content == null){
            // echo "Controller error";
            return;
        }

        return $content;
    }
    // $_SESSION["postId"], $_SESSION["storeCode"], $fileNames[$i], htmlspecialchars($fileId), $fileSizes[$i]
    public function uploadGdriveData($postId, $classCode, $fileName, $fileId, $fileSize, $userId){
        $result = $this->insertGdriveData($postId, $classCode, $fileName, $fileId, $fileSize, $userId);

        if($result == false){
         echo "ERROR UPLOADING GDRIVE DATA INTO DB";
         return;
        }
 
        echo "GDRIVE DATA SUCCESS";
    }

    public function getSubmissions($classCode){
        $result = $this->fetchSubmissions($classCode);
        
        if($result == null){
 
            // return;
        }

        return $result;
    }

    public function getSubmittedFiles($postId, $classCode){
        if (session_id() === "") session_start();
        $result = $this->fetchSubmittedInPost($postId, $classCode, $_SESSION["id"]);
        return $result;
    }

    public function getQuizDetails($postId, $classCode){
        $details = $this->fetchQuizDetails($postId, $classCode);
        if($details == null){
            echo "No Quiz Yet";
        }

        return $details;
    }

    public function submitAnswers($userId, $postId, $classCode, $status, $answer, $questionId){
        $result = $this->submitAnswersToQuiz($userId, $postId, $classCode, $status, $answer, $questionId);
        if($result == false){
            echo "Error uploading answers to db";
            exit();
        }
    }

    public function getQuizResult($postId, $classCode, $userId){
        $result = $this->getQuizResultFromDb($postId, $classCode, $userId);
        return $result;
    }

    public function listOfQuiz($classCode){
        $content = $this->getQuizInClass($classCode);
        if($content == null){
            // echo "Controller error";
        }
        return $content;
    }

    public function listOfActs($classCode){
        $content = $this->getActsInClass($classCode);
        if($content == null){
            // echo "Controller error";
        }
        return $content;
    }

    public function getQuizContent($postId, $classCode){
        $content = $this->getQuiz($postId, $classCode);
        return $content;
    }
}

?>