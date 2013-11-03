<?php

if (!function_exists('starts_with'))
{
	function starts_with($needle, $haystack)
	{
		return $needle === "" || strpos($haystack, $needle) === 0;
	}
}

if (!function_exists('ends_width'))
{
	function ends_width($needle, $haystack)
	{
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}
}

if (!function_exists('unhtmlspecialchars'))
{
	function unhtmlspecialchars($str) {
		$trans = get_html_translation_table(HTML_SPECIALCHARS);
		$trans =array_flip($trans);
		$decoded = strtr($str, $trans);
		
		return $decoded;
	}
}

if (!function_exists('br2nl'))
{
	function br2nl($str) {
		$str = str_ireplace("<br />","\n",$str);
		
		return $str;
	}
}

if (!function_exists('br2space'))
{
	function br2space($str) {
		$str = str_ireplace("<br />"," ",$str);
		
		return $str;
	}
}