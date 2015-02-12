<?php
session_start(); 

$sign=rawurldecode($_REQUEST['sign']);
$olduser=rawurldecode($_REQUEST['user']);

$user = iconv("UTF-8", "gbk", $olduser);

$RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");
$UserAuth = $RootObj->UserAuthObj;

$bisSuccess = $UserAuth->SignatureAuth($user, $sign); 

if($bisSuccess)
{
	$_SESSION['uname'] = $olduser;

	echo "success!".$_SESSION['uname'];
}
else
{
	echo "failed!";
}