<?php
$approot = '.';
require_once('function.php');
// header('Content-type: image/jpeg');
// unlink("newfile.jpg");
$myfile = fopen("newfile.jpg", "w") or die("Unable to open file!");
fwrite($myfile, '');
fclose($myfile);
$link = sqls();
$sql = "select * from upload order by start";
	$ret = mysql_query($sql, $link);
	if ($ret === false) {
		die("er");
	} else {
    while($row = mysql_fetch_assoc($ret)){
    $echo = unescape(base64_decode($row['nr']));
		// fwrite($myfile, $echo);
		echo file_put_contents("newfile.jpg",$echo,FILE_APPEND).'<br />';
// 		echo $echo;
// 		echo ++$i;
  }
  }
// fwrite($myfile, $echo);
// fclose($myfile);
	sqlc($link);
	// header('location: newfile.jpg');
// echo "完成";
 ?>
