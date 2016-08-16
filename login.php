<?php
$approot = '.';
require_once('function.php');
$yzm=rand(1000, 9999);
$qd=md5(uniqid(mt_rand(),1));
$cookie=$qd.crc32($yzm);
$userid = @$_POST['userid'];
$pass = @$_POST['pass'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://7plus.mobi/jwc/publicqr.php?user=$userid&pass=$pass");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$ret = curl_exec($ch);
curl_close($ch);
if($ret == 1){
$link = sqls();
$sql = "insert into user_cookie(user,cookie) values('temp','$cookie')";
$ret = mysql_query($sql, $link);
if ($ret === false) {
  die("Insert Failed: " . mysql_error($link));
} else {}
sqlc($link);
setcookie('bduss',$cookie,0,'/',$_SERVER['SERVER_NAME'],null,true);
echo json_encode(['code' => '2', 'msg' => '成功']);
}else {
  echo json_encode(['code' => '0', 'msg' => '账号或密码错误']);
}
 ?>
