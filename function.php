<?php
$approot=$approot?$approot:'.';
header("content-Type: text/html; charset=UTF-8");
date_default_timezone_set('Asia/Shanghai');      //这里设置了时区
ini_set("session.cookie_httponly",1);
ini_set("display_errors",0);

function sqls(){
$link = mysql_connect('localhost', 'root', '') or die('Could not connect: ' . mysql_error());
mysql_select_db('linker') or die('er');
mysql_query("set names 'utf8'",$link);
return $link;
}

function sqlc($link){
    mysql_close($link);
}

function unescape($str){
$ret = '';
$len = strlen($str);
for ($i = 0; $i < $len; $i++){
if ($str[$i] == '%' && $str[$i+1] == 'u'){
$val = hexdec(substr($str, $i+2, 4));
if ($val < 0x7f) $ret .= chr($val);
else if($val < 0x800) $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f));
else $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f));
$i += 5;
}
else if ($str[$i] == '%'){
$ret .= urldecode(substr($str, $i, 3));
$i += 2;
}
else $ret .= $str[$i];
}
return $ret;
}

?>
