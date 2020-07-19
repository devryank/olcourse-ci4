<?php

if(!function_exists('my_timezone'))
{
    function my_timezone()
    {
		$timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        return $date;
    }
}