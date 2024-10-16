<?php
$sched = $_SESSION['list'][$_SESSION['classNumber']]['class_schedule'];
$daySched = "";
$startingHour = "";
$startingMin = "";
$startingPeriod = "";
$endingHour = "";
$endingMin = "";
$endingPeriod = "";

$len = mb_strlen($sched);

echo "<br>";
$last = strpos($sched, ")");
$divider = strpos($sched, ":");
$timeDivider = strpos($sched, "-");
$startOfEnd = false;
// echo "The divider " . $divider;
//   echo $last;
$sHourValid = true;
$sMinValid = true;
$eHourValid = true;
$eMinValid = true;

for ($i = 1; $i < $len; $i++) {
    if ($i < $last) $daySched .= mb_substr($sched, $i, 1);

    if ($i == $divider) $sHourValid = false;

    if ($i > $last + 1 && $sHourValid) $startingHour .= mb_substr($sched, $i, 1);
    // echo (mb_substr($sched, $i, 1) . " ");

    if (mb_substr($sched, $i, 1) == "P" || mb_substr($sched, $i, 1) == "A") $sMinValid = false;

    if ($i > $divider && $sMinValid == true) $startingMin .= mb_substr($sched, $i, 1);

    if ($sMinValid == false && $i < $timeDivider) $startingPeriod .= mb_substr($sched, $i, 1);

    if (mb_substr($sched, $i, 1) == "-") {
        $startOfEnd = true;
        continue;
    }

    if ($startOfEnd == true) {
        if (mb_substr($sched, $i, 1) != ":" && $eHourValid == true) $endingHour .= mb_substr($sched, $i, 1);

        if (mb_substr($sched, $i, 1) == ":" && $eHourValid == true) $eHourValid = false;

        if (mb_substr($sched, $i, 1) == "P" || mb_substr($sched, $i, 1) == "A") $eMinValid = false;

        if ($eHourValid == false && mb_substr($sched, $i, 1) != ":" && $eMinValid == true) $endingMin .= mb_substr($sched, $i, 1);

        if ($eMinValid == false) $endingPeriod .= mb_substr($sched, $i, 1);
    }
}


// echo "The Day " . $day;
// echo "<br>The starting hour " . $startingHour;
// echo "<br>The starting min " . $startingMin;
// echo "<br>The starting period " . $startingPeriod;
// echo "<br>The ending hour " . $endingHour;
// echo "<br>The ending min " . $endingMin;
// echo "<br>The ending period " . $endingPeriod;
