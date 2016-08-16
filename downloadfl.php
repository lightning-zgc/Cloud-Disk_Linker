<?php
$approot = '.';
require_once('function.php');
set_time_limit(0);
$user = getuser();
if ($user !== 0 and $user !== 1) {
  $fileid = htmlspecialchars(@$_GET['fileid'], ENT_QUOTES);
  if(strlen($fileid) != 32){
    echo json_encode(['code' => '0', 'msg' => '你想干什么=.=']);
    exit;
  }else{
    $link = sqls();
    $sql = "select * from file_info where fileid = '$fileid' limit 1";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
  		die("er");
  	} else {
      $row = mysql_fetch_assoc($ret);
      $name = $row['name'];
    }
    if($row['size'] >= 15*1000*1000) {
      echo '文件过大，请用“预览”方式下载';
      exit;
    }
    header('Content-type: application/octet-stream');
    header('Accept-Ranges: '.$row['size']);
    header('Content-Disposition: attachment; filename='.urlencode(base64_decode($name)));
    $sql = "select * from file_list where fileid = '$fileid' order by start";
    $ret = mysql_query($sql, $link);
    if ($ret === false) {
  		die("er");
  	} else {
      while($row = mysql_fetch_assoc($ret)) {
        $md5 = $row['md5'];
        $link2 = sqls();
        $sql2 = "select * from upload where md5 = '$md5' limit 1";
        $ret2 = mysql_query($sql2, $link2);
        if ($ret2 === false) {
      		die("er");
      	} else {
          $row = mysql_fetch_assoc($ret2);
          echo $row['nr'];
        }
      }
  	}
    sqlc($link);
    sqlc($link2);
  }
}else {
  echo json_encode(['code' => '0', 'msg' => '下载文件前请登入']);
}
 ?>
