<?php
if (session_id() === "") session_start();

require_once("../log and reg backend/classes/connection.php");
require_once("student backend/classes/model.ClassRm.php");
require_once("student backend/classes/controller.Lists.php");
require_once("student backend/classes/controller.Student.php");

$listController = new ListController();

// echo $_SESSION["user_id"];

$grades = $listController->getAllGrades(); // There's session id inside model classroom

$total = $listController->totalActCount(); // There's session id inside model classroom


if ($total != null) {
    foreach ($total as $item) {
        // Initialize the class_code key if not already set
        if (!isset($totalPerClass[$item["class_code"]])) {
            $totalPerClass[$item["class_code"]] = [
                "Activity" => 0,
                "Quiz" => 0,
                "Exam" => 0,
                "Seatwork" => 0,
                "Assignment" => 0,
            ];
        }

        // Store total_posts under their respective content_type
        if ($item["content_type"] == "Activity") {
            $totalPerClass[$item["class_code"]]["Activity"] = $item["total_posts"];
        } elseif ($item["content_type"] == "Quiz") {
            $totalPerClass[$item["class_code"]]["Quiz"] = $item["total_posts"];
        } elseif ($item["content_type"] == "Seatwork") {
            $totalPerClass[$item["class_code"]]["Seatwork"] = $item["total_posts"];
        } elseif ($item["content_type"] == "Assignment") {
            $totalPerClass[$item["class_code"]]["Assignment"] = $item["total_posts"];
        } elseif ($item["content_type"] == "Exam") {
            $totalPerClass[$item["class_code"]]["Exam"] = $item["total_posts"];
        }
    }
}

// Debug: Output the resulting array
// print_r($totalPerClass);
// echo "Total act " . $totalAct . "<br>";
// echo "Total quiz " . $totalQuiz . "<br>";
// echo "Total exam " . $totalExam . "<br>";

$gradingSystem = $listController->getGradingSystem($_SESSION["user_id"]);

$actScores = array();
$quizScores = array();
$examScores = array();
$seatworkScores = array();
$assignmentScores = array();
$gradingPerClass = array();

if ($grades != null) {
    foreach ($grades as $grade) {
        if ($grade["content_type"] == "Activity") {
            // Initialize key if it doesn't exist
            if (!isset($actScores[$grade["class_code"]])) {
                $actScores[$grade["class_code"]] = 0;
            }
            $actScores[$grade["class_code"]] += $grade["grade"];
            // echo $grade["class_code"] . "<br>";
        } else if ($grade["content_type"] == "Quiz") {
            // Initialize key if it doesn't exist
            if (!isset($quizScores[$grade["class_code"]])) {
                $quizScores[$grade["class_code"]] = 0;
            }
            $quizScores[$grade["class_code"]] += $grade["grade"];
        }else if ($grade["content_type"] == "Seatwork") {
            // Initialize key if it doesn't exist
            if (!isset($seatworkScores[$grade["class_code"]])) {
                $seatworkScores[$grade["class_code"]] = 0;
            }
            $seatworkScores[$grade["class_code"]] += $grade["grade"];
        }else if ($grade["content_type"] == "Assignment") {
            // Initialize key if it doesn't exist
            if (!isset($assignmentScores[$grade["class_code"]])) {
                $assignmentScores[$grade["class_code"]] = 0;
            }
            $assignmentScores[$grade["class_code"]] += $grade["grade"];
        }else{
            if (!isset($examScores[$grade["class_code"]])) {
                $examScores[$grade["class_code"]] = 0;
            }
            $examScores[$grade["class_code"]] += $grade["grade"];
        }
    }
}

if ($gradingSystem != null) {
    foreach ($gradingSystem as $grade) {
        $gradingPerClass[$grade["class_code"]] = [
            "act_wg"     => $grade["act_wg"],
            "quiz_wg"    => $grade["quiz_wg"],
            "exam_wg"    => $grade["exam_wg"],
            "seatwork_wg"    => $grade["seatwork_wg"],
            "assignment_wg"    => $grade["assignment_wg"],
            "deduction"  => $grade["deduction"]
        ];
    }
}

$i =0;

// foreach ($actScores as $user_id => $score) {
//     $actGSys = $gradingPerClass[$gradingSystem[$i]["class_code"]]["act_wg"] / 100;
//     $calculatedScore = ($score / $totalAct) * $actGSys;
//     $i++;
//     echo "User ID: $user_id - Total Activity Grade: $calculatedScore <br>";
// }

// $quizGSys = $gradingSystem[0]["quiz_wg"] / 100;

// foreach ($quizScores as $user_id => $score) {
//     $calculatedScore = ($score / $totalQuiz) * $quizGSys;
//     echo "User ID: $user_id - Total Quiz Grade: $calculatedScore <br>";
// }

// $examGSys = $gradingSystem[0]["exam_wg"] / 100;

// foreach ($examScores as $user_id => $score) {
//     $calculatedScore = ($score / $totalExam) * $examGSys;
//     echo "User ID: $user_id - Total Quiz Grade: $calculatedScore <br>";
// }

// echo $gradingPerClass["D3Ue732A"]["act_wg"];
// echo "Act Grades ";
// print_r($actScores);
// echo "<br><br>Quiz Grades";
// print_r($quizScores);
// echo "<br><br>Exam Grades";
// print_r($examScores);