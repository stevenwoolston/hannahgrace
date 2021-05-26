<?php
/*
@package: wwd blankslate
*/
?>

<section class="booking-calendar-container">
<h1>Booking Calendar</h1>
<?php

function build_calendar($month, $year) {
	$daysOfWeek = array('S','M','T','W','T','F','S');
	$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
	$numberDays = date('t',$firstDayOfMonth);
	$dateComponents = getdate($firstDayOfMonth);
	$monthName = $dateComponents['month'];
	$dayOfWeek = $dateComponents['wday'];
	$calendar = "<table class='calendar table table-condensed table-bordered'>";
	$calendar .= "<form method='GET'>";
	$calendar .= "<caption>";
	$calendar .= "<button type='submit' name='direction' value='-1' class='float-left'><<</button>";
	$calendar .= $monthName. " " .$year;
	$calendar .= "<button type='submit' name='direction' value='1' class='float-right'>>></button>";
	$calendar .= "</caption>";
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
			$calendar .= "<td class='day bg-success' rel='$date'>";
			$calendar .= "<button type='submit' value='" .$date. "' name='selectedDate' />" .$currentDay. "</button></td>";
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

if (isset($_POST['back']) || isset($_POST['forward'])) {

	if (isset($_POST['back'])) {

	}
}
$post_monthname = $_POST['monthname'];
$post_year = $_POST['year'];
$post_direction = $_POST['direction'];
$post_selectedDate = $_POST['selectedDate'];

$time = time();
$numMonth = date('m', $time);

if (!isset($post_month)) {
	$post_month = date("F", mktime(0, 0, 0, $numMonth, 10));
}
if (!isset($post_year)) {
	$post_year = date('Y', $time);
}

$calendar_date = mktime(0, 0, 0, (int)$post_month, 1, (int)$post_year);
var_dump($calendar_date);
if (isset($post_direction)) {
	$calendar_date = strtotime($post_direction. " months", $calendar_date);
}
var_dump($calendar_date);
// $time = mktime(0,0,0,$month,1,$year);

$time = time();
$numDay = date('d', $calendar_date);
$numMonth = date('m', $calendar_date);
$nameMonth = date("F", mktime(0, 0, 0, $numMonth, 10));
$numYear = date('Y', $calendar_date);
$calendar = build_calendar($numMonth, $numYear);
echo $calendar;
?>
<input type='text' value='<?php echo $nameMonth; ?>' name='monthname' />
<input type='text' value='<?php echo $numYear; ?>' name='year' />
</section>