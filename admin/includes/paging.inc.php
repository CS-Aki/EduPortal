<?php
$list = new ListController();
$total = $list->countClass();

if (!isset($_SESSION["min"])) {
    $_SESSION["min"] = 0; // Initial value for 'min'
}
if (!isset($_SESSION["max"])) {
    $_SESSION["max"] = 5; // Initial value for 'max'
}

if (!isset($_SESSION["counter"])) {
    $_SESSION["counter"] = 1; // Initial value for 'max'
}

// Decrement min and max when 'Previous' is clicked
if (isset($_GET["paging"]) && $_GET["paging"] == "prev" . "=" . urlencode($_SESSION["counter"])) {
    $_SESSION["min"] = max(0, $_SESSION["min"] - 5); // Prevent 'min' from going below 0
    $_SESSION["max"] = max(5, $_SESSION["max"] - 5);
    $_SESSION["counter"] = max(1, $_SESSION["counter"] - 1);
    //echo "This is the counter " . $_SESSION["counter"];   
}

// Increment min and max when 'Next' is clicked
if (isset($_GET["paging"]) && $_GET["paging"] == "next" . "=" . urlencode($_SESSION["counter"])) {

        $_SESSION["min"] += 5;
        $_SESSION["max"] += 5;
        $_SESSION["counter"] += 1;
      //  echo "This is the counter " . $_SESSION["counter"];   

        $temp = round($total[0]['count'] / 5) + 1;

        if($_SESSION["counter"] > $temp){
            $_SESSION["min"] -= 5;
            $_SESSION["max"] -= 5;
            $_SESSION["counter"] -= 1;
            return;
        }

        // if($_SESSION["max"] > $total[0]['count']){
        //     $_SESSION["min"] -= 5;
        //     $_SESSION["max"] -= 5;
        //     $_SESSION["counter"] -= 1;
        //     if($total[0]['count'] % 5 != 0){
        //         $_SESSION["min"] += 5;
        //         $_SESSION["counter"] += 1;
        //         $_SESSION["max"] = $total[0]['count'];
        //     }
        // }
        
        

}

if (isset($_GET["className"])) {
 //$_SESSION["className"] = $_GET["className"];
 // $_SESSION["daySched"] = $_GET["daySched"];
 // $_SESSION["startingHourSched"] = $_GET["startingHourSched"];
 // $_SESSION["startingMinSched"] = $_GET["startingMinSched"];
 // $_SESSION["startTimePeriod"] = $_GET["startTimePeriod"];
 // $_SESSION["endingHourSched"] = $_GET["endingHourSched"];
 // $_SESSION["endingMinSched"] = $_GET["endingMinSched"];
 // $_SESSION["endTimePeriod"] = $_GET["endTimePeriod"];
 // $_SESSION["status"] = $_GET["status"];
 // $_SESSION["classProf"] = $_GET["classProf"];
}
