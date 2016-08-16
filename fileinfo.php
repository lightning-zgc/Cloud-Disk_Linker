<?php
$approot = '.';
require_once('function.php');
$user = getuser();
if ($user !== 0 and $user !== 1) {
  $link = sqls();
  $link2 = sqls();
  $sql = "select * from user_file_list where user='$user'";
$ret = mysql_query($sql, $link);
if ($ret === false) {
die("er");
} else {
while($row = mysql_fetch_assoc($ret)) {
  $fileid = $row['fileid'];
  $sql = "select * from file_info where fileid='$fileid' order by id desc limit 1";
$ret2 = mysql_query($sql, $link2);
if ($ret2 === false) {
die("er");
} else {
  $row = mysql_fetch_assoc($ret2);
  $name = base64_decode($row['name']);
  $uptime = $row['uptime'];
  $size = $row['size'];
  $long = $row['long'];
  $last_time = $row['last_time'];
  $filelist[] = ['name' => $name, 'fileid' => $fileid, 'uptime' => date('Y-m-d h:i:s A',$uptime), 'size' => $size, 'long' => $long, 'last_time' => $last_time];
}
}
}
if(@$filelist) {
echo @json_encode($filelist);
}else {
  echo json_encode(['code' => '1', 'msg' => '无']);
}
sqlc($link);
sqlc($link2);
}else {
  echo json_encode(['code' => '0', 'msg' => '查看文件前请登入']);
}
 ?>
