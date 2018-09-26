<?php require_once('../../app/db_connection.php') ?>

<?php
$q = $_GET['q'];

$query = "SELECT tag.name, tag.slug
													FROM tag_deep
													JOIN tag AS main ON main.tag_id = tag_deep.main_tag_id
													JOIN tag ON tag.tag_id = tag_deep.tag_id
										   WHERE tag_deep.main_tag_id = $q
										   ORDER BY tag.name";

$result = mysqli_query($connection, $query);

$num_of_rows = mysqli_num_rows($result);
$rows="<ul class='col-xs-9 col-sm-12 col-md-12 col-lg-12 list-unstyled white_container center-block'>";

while ($row = mysqli_fetch_assoc($result))
{
  $title_pl = $row["title_pl"];
  $slug = $row["slug"];
  $type = $row["type"]; 
 
$trep = empty($q) ? $title_pl : preg_replace ("/(" . preg_quote($q, '/') . ")/i", "<span class='highlight'>$1</span>",$title_pl);
  
  $rows .= "<li class='col-xs-12 col-sm-6 col-md-4 col-lg-4'><a href='tag/$slug'>$trep";
	$rows .= $type ? "($type)</a></li>" : "</a></li>";       
}
if($num_of_rows > 0 ){echo "<p>{$num_of_rows}</p>"; echo "$rows</ul>";}