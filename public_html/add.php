<?php
require_once '../app/bootstrap.php';

	$query  = "SELECT artist_name FROM artist ORDER BY artist_name";
	$result = $mysqli ->query($query);
	
	$artists_names="";

    while ($row = $result->fetch_row()) {
		
		$name = htmlspecialchars($row[0]);
        $artists_names .="<option value='$name'>$name</option>";
    }
	
	
	
echo $twig->render('add.twig', [
                                  
			'artists_names' => $artists_names,
		
			
                                  ]);