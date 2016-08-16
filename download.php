<?php
$approot = '.';
require_once('function.php');
$user = getuser();
if ($user !== 0 and $user !== 1) {
  $fileid = @$_GET['fileid'];
  if(strlen($fileid) != 32){
    echo json_encode(['code' => '0', 'msg' => '你想干什么=.=']);
    exit;
  }else{
    header("location: ./disk/$fileid.data");
  }
}else {
  echo json_encode(['code' => '0', 'msg' => '下载文件前请登入']);
}
 ?>
