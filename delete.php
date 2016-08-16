<?php
$approot = '.';
require_once('function.php');
$user = getuser();
if ($user !== 0 and $user !== 1) {
  $fileid = @$_POST['fileid'];
  if(strlen($fileid) != 32){
    echo json_encode(['code' => '0', 'msg' => '你想干什么=.=']);
    exit;
  }else{
    $link = sqls();
    $sql = "delete from user_file_list where fileid = '$fileid'";
$ret = mysql_query($sql, $link);
if ($ret === false) {
  die("Insert Failed: " . mysql_error($link));
} else {}
  $sql = "delete from file_list where fileid = '$fileid'";
$ret = mysql_query($sql, $link);
if ($ret === false) {
die("Insert Failed: " . mysql_error($link));
} else {}
  $sql = "delete from file_info where fileid = '$fileid';";
$ret = mysql_query($sql, $link);
if ($ret === false) {
die("Insert Failed: " . mysql_error($link));
} else {}
  }
  unlink("./disk/$fileid.data");
  echo json_encode(['code' => '2', 'msg' => 'OK']);
}else {
  echo json_encode(['code' => '0', 'msg' => '下载文件前请登入']);
}
 ?>
