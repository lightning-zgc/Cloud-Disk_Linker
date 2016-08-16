<?php
$approot = '.';
require_once('function.php');
// header('Content-type: image/jpeg');
// unlink("newfile.jpg");
$myfile = fopen("newfile.png", "ab") or die("Unable to open file!");
// fseek($myfile,1024);
// fwrite($myfile, '');
// fclose($myfile);
$link = sqls();
$sql = "select count(*) from upload";
	$ret = mysql_query($sql, $link);
	if ($ret === false) {
		die("er");
	} else {
    $row = mysql_fetch_assoc($ret);
		$count = $row['count(*)'];
	}
$sql = "select * from upload where download = 0 order by start limit 1";
	$ret = mysql_query($sql, $link);
	if ($ret === false) {
		die("er");
	} else {
    $row = mysql_fetch_assoc($ret);
		if(!$row){
			echo '2';
			fclose($myfile);
			sqlc($link);
			exit;
		}
		// fseek($myfile,$row['start']*50000);
    // $echo = unescape(base64_decode($row['nr']));
		$echo = $row['nr'];
		fwrite($myfile, $echo);

		// echo file_put_contents("newfile.jpg",$echo,FILE_APPEND).'<br />';
// 		echo $echo;
// 		echo ++$i;

  }
// fwrite($myfile, $echo);
fclose($myfile);
echo ($row['start']+1)/$count;
$sql = "update upload set download = 1 where id = ".$row['id'];
	$ret = mysql_query($sql, $link);
	if ($ret === false) {
		die("er");
	} else {}
	sqlc($link);
	// header('location: newfile.jpg');
// echo "完成";
 ?>
