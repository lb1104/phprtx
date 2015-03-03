<?php
session_start(); 

$pwd=$_REQUEST['pwd'];
$olduser=$_REQUEST['user'];

$user = iconv("UTF-8", "gbk", $olduser);

$RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");

$bisSuccess = $RootObj->Login($user, $pwd); 
$result=array();
if($bisSuccess==0){
	$_SESSION['uname'] = $olduser;
	setcookie("uname", $olduser,strtotime( '+30 days' ));
	$result['uname']=$olduser;
}else{
	$result['error']="登陆失败!".$bisSuccess;
}

echo json_encode($result);