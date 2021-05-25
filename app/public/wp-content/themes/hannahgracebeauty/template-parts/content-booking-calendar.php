<?php
/*
@package: wwd blankslate
*/
?>

<section class="booking-calendar-container">
<h1>Booking Calendar</h1>

<input type="text" id="booking-datepicker" data-date-format="yyyy-M-dd" name="bookingdate" readonly>
<input type="text" name="bookingtime">


<?php

function build_calendar($month, $year) {

	if (isset($_POST['back']) || isset($_POST['forward'])) {

		if (isset($_POST['back'])) {

		}
	}
	var_dump($_POST['monthname']);
	var_dump($_POST['year']);
	var_dump($_POST['back']);
	var_dump($_POST['forward']);

	$daysOfWeek = array('S','M','T','W','T','F','S');
	$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
	$numberDays = date('t',$firstDayOfMonth);
	$dateComponents = getdate($firstDayOfMonth);
	$monthName = $dateComponents['month'];
	$dayOfWeek = $dateComponents['wday'];
	$calendar = "<table class='calendar table table-condensed table-bordered'>";
	$calendar .= "<form method='GET'>";
	$calendar .= "<input type='text' value='" .$monthName. "' name='monthname' />";
	$calendar .= "<input type='text' value='" .$year. "' name='year' />";
	$calendar .= "<caption><button type='submit' name='back' class='float-left'><<</button>$monthName $year<button type='submit' class='float-right' name='forward'>>></button></caption>";
	$calendar .= "<tr>";
	foreach($daysOfWeek as $day) {
		$calendar .= "<th class='header'>$day</th>";
	}
	$currentDay = 1;
	$calendar .= "</tr><tr>";
	if ($dayOfWeek > 0) {
		$calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
	}
	$month = str_pad($month, 2, "0", STR_PAD_LEFT);
	while($currentDay <= $numberDays){
		if($dayOfWeek == 7){
			$dayOfWeek = 0;
			$calendar .= "</tr><tr>";
		}
		$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
		$date = "$year-$month-$currentDayRel";

		// Is this today?
		if(date('Y-m-d') == $date) {
			$calendar .= "<td class='day success' rel='$date'><b>$currentDay</b></td>";
		} else {
			$calendar .= "<td class='day' rel='$date'>$currentDay</td>";
		}

		$currentDay++;
		$dayOfWeek++;
	}
	if($dayOfWeek != 7){
		$remainingDays = 7 - $dayOfWeek;
		$calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
	}
	$calendar .= "</tr>";
	$calendar .= "</form>";
	$calendar .= "</table>";
	return $calendar;
}
$time = time();
$numDay = date('d', $time);
$numMonth = date('m', $time);
$numYear = date('Y', $time);
$calendar = build_calendar($numMonth, $numYear);
echo $calendar;
?>
</section>