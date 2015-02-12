<?php
session_start();

if($_SESSION['uname']==''){

	$sign=rawurldecode($_REQUEST['sign']);
	$olduser=rawurldecode($_REQUEST['user']);

	if($sign==''||$olduser==''){
		exit('failed! no sign and user');
	}

	$user = iconv("UTF-8", "gbk", $olduser);

	$RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");
	$UserAuth = $RootObj->UserAuthObj;

	$bisSuccess = $UserAuth->SignatureAuth($user, $sign); 

	if($bisSuccess){
		$_SESSION['uname'] = $olduser;
	}else{
		exit("failed! no login!");
	}

}