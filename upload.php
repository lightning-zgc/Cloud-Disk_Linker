<?php
$approot = '.';
require_once('function.php');
$file = @$_POST['file'];
$start = @$_POST['start'];
$md5 = @$_POST['md5'];
if(!$md5 and !$file){
  echo json_encode(array('code' => '0', 'msg' => 'void'));
  exit;
}
$md5 = $md5?$md5:md5($file);
$link = sqls();
$is=0;
$sql = "select * from upload where md5='$md5' order by id desc limit 1";
	$ret = mysql_query($sql, $link);
	if ($ret === false) {
		die("er");
	} else {
    while($row = mysql_fetch_assoc($ret)){
    $is=1;
  }
  }
if($is){
  echo json_encode(array('code' => '2', 'msg' => 'Already In'));
}elseif (!$is and !$file) {
  echo json_encode(array('code' => '3', 'msg' => 'Null, please upload'));
}else {
  $sql = "insert into upload(md5,nr,start) values('$md5','$file','$start')";
  	$ret = mysql_query($sql, $link);
  	if ($ret === false) {
  		die("Insert Failed: " . mysql_error($link));
  	} else {
      echo json_encode(array('code' => '1', 'msg' => 'Success'));
    }
}
sqlc($link);
?>
