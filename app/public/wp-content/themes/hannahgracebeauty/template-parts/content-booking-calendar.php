<?php
/*
@package: wwd blankslate
*/
?>

<section class="booking-calendar-container">
<h4>Choose Your Preferred Booking Time</h>
<?php
$time = date("Y-m-d", time());
// var_dump(date('Y-m-d', strtotime($_POST['selectedTime'])));
$selectedDate = 
	isset($_POST['selectedTime']) ? 
		date('Y-m-d', strtotime($_POST['selectedTime'])) : 
			(isset($_POST['selectedDate']) ? 
				$_POST['selectedDate'] : 
					$time);

// var_dump($selectedDate);
$selectedTime = $_POST['selectedTime'];
$dateparts = explode('-', $selectedDate);
$month = $dateparts[1];
$year = $dateparts[0];

// $calendar = build_calendar($numMonth, $numYear);
$daysOfWeek = array('S','M','T','W','T','F','S');
$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
$numberDays = date('t',$firstDayOfMonth);
$dateComponents = getdate($firstDayOfMonth);
$monthName = $dateComponents['month'];
$dayOfWeek = $dateComponents['wday'];
$prev_month = date('Y-m-d', strtotime($selectedDate . ' - 1 month'));
$next_month = date('Y-m-d', strtotime($selectedDate . ' + 1 month'));

$calendar = "<div class='SBW'>&nbsp;</div>";
$calendar .= "<div class='calender-caption-container'>";
$calendar .= "<div><button type='submit' name='selectedDate' value='" .$prev_month. "' class='float-left'><<</button></div>";
$calendar .= "<div class='calendar-caption'>" .$monthName. " " .$year. "</div>";
$calendar .= "<div><button type='submit' name='selectedDate' value='" .$next_month. "' class='float-right'>>></button></div>";
$calendar .= "</div>";

$calendar .= "<table class='booking-calendar table table-condensed'>";
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
	$isBackDate = $date <= date('Y-m-d');
	if ($selectedDate == $date) {
		$calendar .= "<td class='day '" .((date('Y-m-d') == $date) ? "selected" : null). "' rel='$date'>";
	} else {
		$calendar .= "<td class='day' rel='$date'>";
	}
	if ($isBackDate) {
		$calendar .= $currentDay;
	} else {
		$calendar .= "<button type='submit' value='" .$date. "' name='selectedDate' />" .$currentDay. "</button></td>";		
	}
	$calendar .= "</td>";

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
// echo $calendar;

?>
<div class="calendar-container">
	<div class="calendar 123">
	<?php echo '<form method="GET">' .$calendar. '</form>';	?>
	</div>
	<div class="calendar-times">
<?php
	echo selectTimesofDay('09:00', '17:59', '15 minutes', $selectedDate, $selectedTime);
?>
	</div>
</div>

<input type='text' value='<?php echo $selectedDate; ?>' name='booking-date' />
<input type='text' value='<?php echo date('H:i', strtotime($_POST['selectedTime'])); ?>' name='booking-time' />
</section>
<?php
function selectTimesofDay($start=false, $end=false, $interval='5 minutes', $selectedDate, $selectedTime){
    $interval = DateInterval::createFromDateString($interval);
    $rounding_interval = $interval->i * 60;
    $date = new DateTime(
        date('Y-m-d H:i', round(strtotime($selectedDate .' '. $start) / $rounding_interval) * $rounding_interval)
    );
    $end = new DateTime(
        date('Y-m-d H:i', round(strtotime($selectedDate .' '. $end) / $rounding_interval) * $rounding_interval)
    );

    $opts = array();
    while ($date < $end) {
        $data = $date->format('g:i a');
        $opts[] = '<button name="selectedTime" value="' .$date->format('Y-m-d H:i'). '">'.$data.'</button>';
        $date->add($interval);
    }

    return count($opts) < 1 ? 
        '<option value="-1">- closed -</option>' : 
        implode("\n", $opts);
}
?>
<script>
	(function($) {
		$("button[name=selectedDate").on('click', function(e) {
			$("input[name=booking-date]").val($(this).val());
		})
	})(jQuery)
</script>