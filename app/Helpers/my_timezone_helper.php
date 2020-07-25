<?php

if(!function_exists('my_timezone'))
{
    function my_timezone()
    {
        // default timezone menjadi Asia/Jakarta
		$timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        return $date;
    }
}