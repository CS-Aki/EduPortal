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

    public function getPostDetails($title, $classCode){
        $content = $this->fetchPostDetails($title, $classCode);
        if($content == null){
            echo "Controller error";
        }
        return $content;
    }

    public function getComments($title, $classCode){
          return $this->fetchComments($title, $classCode);
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

}

?>