<?php
    include("connection.php");
    //TO BE ADDED FUNCTIONS
    //Error handlers
    //Protection against SQL injection, change mysqli to prepared statement, etc
    //Number of views per post
    //Button to see who viewed the post and those who has not view yet
    // s

    // When clicking on a post, automatically get the id, prof name, content and comments

    //Insert into db the post of prof
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST["prof_name"];
        $content = $_POST["content"];
        $id = $_POST["id"];

        //Fixes the issue where quotes will give an error
        $content = str_replace("'", "\'", $content);

        if(isset($_POST["postBtn"])){
            $contentType = $_POST["postBtn"];
            $temp = "";

            //Put this in a separate function for readability, return the value inside a variable
            switch($contentType){
              case "Material":
                $temp = "Material";
                break;
              case "Activity":
                $temp = "Activity";
                break;
              case "Quiz":
                $temp = "Quiz";
                break;
              default:
                exit();
                break;
            }

            $sql = "INSERT INTO posts (`prof_name`,`content_type`,`content`) VALUES ('$name','$temp','$content')";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
        }

        //When post is clicked, it'll display prof post content and all the comments
        if(isset($_POST["displayBtn"])){
            $id = $_POST["id"];
            $classCode = $_POST["classCode"];
            $sql = "SELECT posts.prof_name, posts.title, posts.content, comments.name, comments.comment FROM posts
                    INNER JOIN comments ON posts.post_id = comments.post_id WHERE posts.post_id='$id' AND posts.class_code='$classCode' ";
            $result = mysqli_query($conn, $sql);

            $displayProfCont = true;
            
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){

                    if($displayProfCont == true){
                        echo "Posted by {$row['prof_name']} <br> Title: {$row['title']} <br> Description: {$row['content']} <br><br> Replies:";
                        $displayProfCont = false;
                    }

                    echo "<br> User: {$row['name']} = {$row['comment']}";
                }
            }else{
              // Put this in a separate function
              // This will run if there is no comment on professor post yet
              // Might cause error because of class code, keep in mind
              $sql = "SELECT prof_name, title, content FROM posts WHERE post_id='$id' AND class_code='$classCode'";
              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)){
                      if($displayProfCont == true){
                          echo "Posted by {$row['prof_name']} <br> Title: {$row['title']} <br> Description: {$row['content']} <br><br> Replies:";
                          $displayProfCont = false;
                      }
                  }
              }

            }

            mysqli_close($conn);
        }

        //Displays all the posts by the professor, first thing to see in classroom
        if(isset($_POST["viewAllContentBtn"])){
            $sql = "SELECT prof_name, title, content_type FROM posts WHERE prof_name = '$name' AND visibility='Visible'";
            $result = mysqli_query($conn, $sql);

            $materials = array();
            $quizzes = array();
            $activities = array();

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                  //Separates each data into their own category
                  if($row["content_type"] == "Material"){
                     array_push($materials, $row['title']);
                     // $materials[] = $row['content'];
                  }else if($row["content_type"] == "Activity"){
                    array_push($activities, $row['title']);
                     // $activities[] = $row['content'];
                  }else if($row["content_type"] == "Quiz"){
                    array_push($quizzes, $row['title']);
                     // $quizzes[] = $row['content'];
                  }

                // echo "{$row['prof_name']} = {$row['content']} <br><br>";
            }

            mysqli_close($conn);

            }

            //An assoc array to store array with sorted data
            $contents = array("Materials" => $materials, "Quizzes" => $quizzes,"Activities" => $activities);

            foreach($contents as $key => $value){
                 echo "<br>" . $key . "<br><br>";
               foreach($value as $info){
                 echo $info . "<br><br>";
               }
            }
        }

        //Edit or Update the contents of the post
        if(isset($_POST["editBtn"])){
            $newContent = $_POST['edited_content'];
            $newContent = str_replace("'", "\'", $newContent);

            $sql = "UPDATE posts SET `content` = '$newContent' WHERE post_id= '$id'";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
        }

        //Uploading of materials via URL
        if(isset($_POST["uploadURLBtn"])){
            $url = $_POST["url"];
            $sql = "INSERT INTO posts (`prof_name`, `content`) VALUES ('$name','$url')";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
        }


        // A test function to get all URL in the database and make it clickable
        // Working but still needs modification
        if(isset($_POST["displayURL"])){
            $url = $_POST["url"];
            $sql = "SELECT `content` FROM posts WHERE prof_name='$name' AND content LIKE 'https:%'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0){
                while($rows = mysqli_fetch_assoc($result)){
                    echo "<a href='{$rows['content']}'>{$rows['content']}</a><br>";
                }
            }

            mysqli_close($conn);
        }

        //Deletion of Post
        if(isset($_POST["deleteBtn"])){
            $sql = "DELETE FROM posts WHERE post_id='$id'";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
            //Maybe add a function where it'll automatically adjust the id number after deletion
        }

        // Commenting in a Post
        if(isset($_POST["commentBtn"])){
            $comment = $_POST["comment"];
            $comment = str_replace("'", "\'", $comment);
            $id = $_POST["id"];
            $studentName = $_POST["student_name"];
            // Create a function for $content where we'll get the content by its id and returning it here

            // $sql = "UPDATE posts SET comment = '$comment' WHERE id='$id' AND prof_name='$profName'";
            $sql = "INSERT INTO comments (post_id, name, comment) VALUES ('$id', '$studentName', '$comment')";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
        }

        //Edits the state view of the post
        if(isset($_POST["changeVisibilityBtn"])){
            $id = $_POST["id"];
            $isVisible = $_POST["changeVisibilityBtn"]; //Placeholder for the function if post will be hidden or visible

            if ($isVisible == "Visible") {$isVisible = "Visible";}
            else {$isVisible = "Hidden";}

            $sql = "UPDATE posts SET visibility='$isVisible' WHERE post_id='$id'";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
        }

        if(isset($_POST["generateClassCode"])){
          $alphabet = "abcdefghijklmnopqrstuvwxyz0123456789";
          $classCodeHolder = "";
          for($i = 1; $i <= 8; $i++){
            $randomCaps = rand(1, 100);
            $randomize = rand(0, strlen($alphabet) - 1);

            if(!is_numeric($alphabet[$randomize])){
                if($randomCaps >= 50){
                    $classCodeHolder .= strtoupper($alphabet[$randomize]);
                    continue;
                }
            }
            $classCodeHolder .= $alphabet[$randomize];
          }
          
          echo $classCodeHolder;
        }

    }
?>
