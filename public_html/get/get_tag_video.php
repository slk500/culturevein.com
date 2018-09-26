<?php require_once '../../app/bootstrap.php' ?>
<?php

$ID = ($_GET['q']);
?>

<?php // TAGI

$query = "SELECT DISTINCT IFNULL(tag.name), tag.name) AS title_pl,
																clean_time(tag_video.start) AS start_time,
																clean_time(tag_video.stop) AS stop_time,
																tag_video.start,tag_video.stop,
                                                                video.duration, video.video_id, tag.tag_id
																FROM tag_video
																JOIN tag ON tag.tag_id = tag_video.tag_id 
                                                                JOIN video ON video.video_id = tag_video.video_id
																WHERE tag_video.video_id=$ID
																ORDER BY tag.name, tag_video.start";


$result = mysqli_query($connection, $query);
confirm_query($result);


if (mysqli_num_rows($result) == 0) {

    echo "<div id='no_scene'>None</div>";
} else {


    echo "<ul class='tag'>";


    $last_tag_title_pl = " ";
    $x = 0;
    $a = null;


    while ($row = mysqli_fetch_assoc($result)) {

        $x++;
        $tag_title_pl = $row["title_pl"];
        $start_time = $row["start_time"];
        $stop_time = $row["stop_time"];
        $start = $row["start"];
        $stop = $row["stop"];
        $duration = $row["duration"];
        $video_id = $row["video_id"];
        $tag_id = $row["tag_id"];


        if ($x == 1) {

            if ($start == NULL) {

                echo "<li class='btn-success'>$tag_title_pl<ol>";
                echo "<span><input type='checkbox' checked onclick='uncomplete_tag($video_id,$tag_id)'> Complete</span>";

                $last_tag_title_pl = $tag_title_pl;

            } else {

                echo "<li class= ", ($stop == $duration ? "'btn-danger'>$tag_title_pl<ol>" : "'btn-warning'>$tag_title_pl<ol><span><input type='checkbox' onclick='complete_tag($video_id,$tag_id)'> Complete</span>");

                echo "<li style='cursor:pointer'><a onclick='playerInstance.seekToPause($start,$stop)'>" . $start_time . " - " . $stop_time . "</a></li>";

                $last_tag_title_pl = $tag_title_pl;

            }


        } elseif ($last_tag_title_pl == $tag_title_pl) {

            echo "<li style='cursor:pointer'><a onclick='playerInstance.seekToPause($start,$stop)'>" . $start_time . " - " . $stop_time . "</a></li>";

            $last_tag_title_pl = $tag_title_pl;

        } elseif ($last_tag_title_pl != $tag_title_pl) {
            echo "</ol></li>";

            if ($start == NULL) {

                echo "<li class='btn-success'>$tag_title_pl<ol>";
                echo "<span><input type='checkbox' checked onclick='uncomplete_tag($video_id,$tag_id)'> Complete</span>";

            } else {

                echo "<li class= ", ($stop == $duration ? "'btn-danger'>$tag_title_pl<ol>" : "'btn-warning'>$tag_title_pl<ol><span><input type='checkbox' onclick='complete_tag($video_id,$tag_id)'> Complete</span>");


                echo "<li style='cursor:pointer'><a onclick='playerInstance.seekToPause($start,$stop)'>" . $start_time . " - " . $stop_time . "</a></li>";

            }
            $last_tag_title_pl = $tag_title_pl;

        }

    }
}
?>

</ol>
</ul>
	