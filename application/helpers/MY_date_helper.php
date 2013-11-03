<?php

if (!function_exists('datetostr'))
{
	function datetostr($timestamp = FALSE, $format = 'date')
	{
		$CI =& get_instance();
		$CI->load->language('calendar');
		
		if ($timestamp === FALSE)
			$timestamp = now();
		elseif (!is_int($timestamp))
		{
			if (empty($timestamp) || $timestamp == '0000-00-00 00:00:00')
				return '-';
			$timestamp = strtotime($timestamp);
		}

		if ($format == 'long-date' || $format == 'medium-date')
			$month = strtolower(date('F', $timestamp));
		else
			$month = strtolower(date('M', $timestamp));
		
		$month = ($CI->lang->line('cal_' . $month) === FALSE) ? ucfirst($month) : $CI->lang->line('cal_' . $month);
		$result = date('j', $timestamp) . ' ' . $month . ' ' . date('Y', $timestamp);
		
		if ($format == 'long-date') {
			if (date('H:i:s', $timestamp) != '00:00:00') {
				$result .= ' ' . date(' H:i:s', $timestamp);
			}
		}
		return $result;
	}
}
if (!function_exists('longdatetostr'))
{
	function longdatetostr($timestamp = FALSE, $format = 'date')
	{
		return datetostr($timestamp, 'long-date');
	}
}
if (!function_exists('dateinputtodate'))
{
	function dateinputtodate($date = FALSE, $format = "d/m/Y")
	{
		if ($format == "d/m/Y") {
			$date = str_ireplace("/","-",$date);
		}
		$timestamp = strtotime($date);
		return date("Y-m-d",$timestamp);
	}
}
if (!function_exists('datetodateinput'))
{
	function datetodateinput($date = FALSE)
	{
		$timestamp = strtotime($date);
		return date("d/m/Y",$timestamp);
	}
}

if (!function_exists('datediff'))
{
	function datediff($start = null, $end = null)
	{
		$start = new DateTime( $start );
		$end   = new DateTime( $end );
		$diff  = $start->diff( $end );

		return $diff->format( '%d' );
	}
}

if (!function_exists('excel_date'))
{
	//Only Microsoft would do something this stupid:
	function excel_date($serial){
		
		// Excel/Lotus 123 have a bug with 29-02-1900. 1900 is not a
		// leap year, but Excel/Lotus 123 think it is...
		if ($serial == 60) {
			$day = 29;
			$month = 2;
			$year = 1900;
			
			return sprintf('%02d/%02d/%04d', $month, $day, $year);
		}
		else if ($serial < 60) {
			// Because of the 29-02-1900 bug, any serial date 
			// under 60 is one off... Compensate.
			$serial++;
		}
		
		// Modified Julian to DMY calculation with an addition of 2415019
		$l = $serial + 68569 + 2415019;
		$n = floor(( 4 * $l ) / 146097);
		$l = $l - floor(( 146097 * $n + 3 ) / 4);
		$i = floor(( 4000 * ( $l + 1 ) ) / 1461001);
		$l = $l - floor(( 1461 * $i ) / 4) + 31;
		$j = floor(( 80 * $l ) / 2447);
		$day = $l - floor(( 2447 * $j ) / 80);
		$l = floor($j / 11);
		$month = $j + 2 - ( 12 * $l );
		$year = 100 * ( $n - 49 ) + $i + $l;
		return sprintf('%04d-%02d-%02d', $year, $month, $day);
	}
}

