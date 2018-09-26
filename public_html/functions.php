<?php
function confirm_query($result_set)
{ 
    if (!$result_set)
	{
		die("Database query failed.");
	}
}

function convert_time($youtube_time){
    $start = new DateTime('@0'); // Unix epoch
    $start->add(new DateInterval($youtube_time));
    return $start->format('H:i:s');
}




?>