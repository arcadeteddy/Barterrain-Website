<?php
date_default_timezone_set("UTC");
class time_ago_format
	{function convert_datetime($str) 
		{list($date, $time) = explode(' ', $str);
    	list($year, $month, $day) = explode('-', $date);
    	list($hour, $minute, $second) = explode(':', $time);
    	$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    	return $timestamp;}

	function make_ago($timestamp)
		{$difference = time() - $timestamp;
		$periods = array("Second", "Minute", "Hour", "Day", "Week", "Month", "Year", "Decade");
		$lengths = array("60","60","24","7","4.35","12","10");
		for($j = 0; $difference >= $lengths[$j]; $j++)
			$difference /= $lengths[$j];
			$difference = round($difference);
		if($difference != 1) $periods[$j].= "s";
			$text = "$difference $periods[$j] Ago";
			return $text;}}
?>