<?php
$approot = '.';
require_once('function.php');
$file = @file_get_contents($_FILES['file']['tmp_name']);

$start = @$_GET['start'];
$md5 = @$_POST['md5'];
if(!$md5 and !$file){
  echo json_encode(array('code' => '0', 'msg' => 'void'));
  exit;
}
$md5 = $md5?$md5:md5(mysql_real_escape_string($file));
$link = sqls();
$sql = "select * from upload where md5='$md5' limit 1";
	$ret = mysql_query($sql, $link);
	if ($ret === false) {
		die("er");
	} else {
    $row = mysql_fetch_assoc($ret);
  }
if($row){
  echo json_encode(array('code' => '2', 'msg' => 'Already In'));
}elseif (!$row and !$file) {
  echo json_encode(array('code' => '3', 'msg' => 'Null, please upload'));
}else {
  var_dump($_POST);
  $sql = "insert into upload(md5,nr,start) values('$md5','".mysql_real_escape_string($file)."','$start')";
  	$ret = mysql_query($sql, $link);
  	if ($ret === false) {
  		die("Insert Failed: " . mysql_error($link));
  	} else {
      echo json_encode(array('code' => '1', 'msg' => 'Success'));
      var_dump($_FILES);
      var_dump($file);
    }
}
sqlc($link);
?>
