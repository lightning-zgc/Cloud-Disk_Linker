<?php
$approot = '.';
require_once('function.php');
header('Content-type: image/jpeg');
$myfile = fopen("newfile.jpg", "w") or die("Unable to open file!");
$link = sqls();
$sql = "select * from upload order by start";
	$ret = mysql_query($sql, $link);
	if ($ret === false) {
		die("er");
	} else {
    while($row = mysql_fetch_assoc($ret)){
    $echo .= unescape(base64_decode($row['nr']));
  }
  }

  fwrite($myfile, $echo);
  fclose($myfile);
  echo $echo;
sqlc(link);
 ?>
