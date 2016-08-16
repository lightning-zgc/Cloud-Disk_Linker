<?php
$approot = '.';
require_once('function.php');
$user = getuser();
if ($user !== 0 and $user !== 1) {
  $time = time();
  $name = base64_encode(@$_POST['filename']);
  $size = htmlspecialchars(@$_POST['filesize'], ENT_QUOTES);
  $long = htmlspecialchars(@$_POST['long'], ENT_QUOTES);
  $last_time = htmlspecialchars(@$_POST['lastModified'], ENT_QUOTES);
  $qd=md5(uniqid(mt_rand(),1));
  $link = sqls();
  $sql = "insert into user_file_list(user,fileid) values('$user','$qd')";
  $ret = mysql_query($sql, $link);
  if ($ret === false) {
    die("Insert Failed: " . mysql_error($link));
  } else {}
    $sql = "insert into file_info(fileid,name,uptime,size,`long`,last_time) values('$qd','$name','$time','$size','$long','$last_time')";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
      die("Insert Failed: " . mysql_error($link));
    } else {}
  sqlc($link);
  $myfile = fopen("./disk/$qd.data","wb");
  fclose($myfile);
  echo json_encode(['code' => '2', 'msg' => $qd]);
}else {
  echo json_encode(['code' => '0', 'msg' => '上传文件前请登入']);
}
 ?>
