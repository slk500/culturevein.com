<?php
require_once '../app/bootstrap.php';

$artist_name_slug = $_GET['artist'];
$slug = $_GET['slug'];


$stmt = $mysqli->prepare("SELECT
               video.name, video.release_date,video.video_id,
			   video.duration AS duration_sec
               FROM video
        
               LEFT JOIN music_video_video ON music_video_video.video_id = video.video_id
               LEFT JOIN artist ON artist.music_video_id = music_video_video.music_video_id
          
        ");

$stmt->bind_param("ss", $artist_name_slug, $slug);
$stmt->execute();



$video_id = $db_data['video_id'];


	  $db_all_tags =  $db->query("SELECT IFNULL(CONCAT(name,' (', type, ')'), name) AS title_pl FROM tag ORDER BY name");
	  $db_all_tags = $db_all_tags->fetchAll(PDO::FETCH_COLUMN,0);
	  
	  $db_tags_in_this_video =  $db->query("SELECT DISTINCT name AS title
									FROM tag_video
									JOIN tag ON tag.tag_id = tag_video.tag_id
									WHERE tag_video.video_id = $video_id
									ORDER BY name");

if(!$db_tags_in_this_video )
{
    header('Location:' . "http://culturevein.com/music-video");
}
	  
	  $db_tags_in_this_video = $db_tags_in_this_video->fetchAll(PDO::FETCH_COLUMN, 0);
	  
	  $all_tags_minus_tags_in_video = array_diff($db_all_tags, $db_tags_in_this_video);

				  $hh;
				  $mm;
				  $ss;
				  
				  $ex = explode(":", $duration);
				  
				  $arr_size =  count($ex);
				  if($arr_size == 3){
					  $hh = $ex[0];
					  $mm = $ex[1];
					  $ss = $ex[2];
				  }
				  elseif($arr_size == 2){
					  $hh = 0;
					  $mm = $ex[0];
					  $ss = $ex[1];
				  }
				  elseif($arr_size == 1){
					  $hh = 0;
					  $mm = 0;
					  $ss = $ex[0];
				  }				
				 			 
				 
echo $twig->render('video_music_video.twig', [
                                  
			'db_data' => $db_data,
			'db_tags_in_this_video' => $db_tags_in_this_video,
			'all_tags_minus_tags_in_video' => $all_tags_minus_tags_in_video,
			'ID' => $video_id,
			'hh'=> $hh,
			'mm'=> $mm,
			'ss'=> $ss,
			
                                  ]);