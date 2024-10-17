<?php

function getScheduleData() {
    $sched = $_SESSION['list'][0]['class_schedule'];
   
    // echo var_dump($sched);
    
    // Initialize variables for schedule details
    $daySched = "";
    $startingHour = "";
    $startingMin = "";
    $startingPeriod = "";
    $endingHour = "";
    $endingMin = "";
    $endingPeriod = "";
    
    // Use regex to extract day, start time, and end time from the schedule
    $pattern = "/\((.*?)\)\s(\d{1,2}):(\d{2})\s([AP]M)-(\d{1,2}):(\d{2})\s([AP]M)/";
    
    // Example: "(Thursday) 10:00 AM-04:00 PM"
    if (preg_match($pattern, $sched, $matches)) {
        $daySched = $matches[1];         // 'Thursday'
        $startingHour = $matches[2];     // '10'
        $startingMin = $matches[3];      // '00'
        $startingPeriod = $matches[4];   // 'AM'
        $endingHour = $matches[5];       // '04'
        $endingMin = $matches[6];        // '00'
        $endingPeriod = $matches[7];     // 'PM'
    }
    
    // Output extracted values
    // echo "Day: $daySched\n";
    // echo "Start Time: $startingHour:$startingMin $startingPeriod\n";
    // echo "End Time: $endingHour:$endingMin $endingPeriod\n";
    
    return array(
        "daySched" => $daySched,
        "startingHour" => $startingHour,
        "startingMin" => $startingMin,
        "startTimePeriod" => $startingPeriod,
        "endingHour" => $endingHour,
        "endingMin" =>  $endingMin,
        "endTimePeriod" => $endingPeriod
    );
}
