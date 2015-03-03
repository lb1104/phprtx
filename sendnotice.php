<?php 

include('check.php');

$receiver = $_GET["receiver"];
$msg = $_GET["msg"];
$title = $_GET["title"];
$delaytime = $_GET["delaytime"];

if ((strlen($receiver) == 0) 
	&& (strlen($msg) == 0) 
	&& (strlen($title) == 0)
	&& (strlen($delaytime) == 0))
{
	$receiver = $_POST["receiver"];
	$msg = $_POST["msg"];
	$title = $_POST["title"];
	$delaytime = $_POST["delaytime"];
}

if (strlen($receiver) == 0)
{
	$receiver = "";
}
if(strlen($msg) == 0) 
{
	$msg = "";
}
if(strlen($title) == 0)
{
	$title = "";
}
if(strlen($delaytime) == 0)
{
	$delaytime = 0;
}

$receiver = iconv("UTF-8", "gbk", $receiver);
$msg = iconv("UTF-8", "gbk", $msg);
$title = iconv("UTF-8", "gbk", $title);

$php_errormsg = NULL;

$ObjApi= new COM("Rtxserver.rtxobj");
$objProp= new COM("Rtxserver.collection");
$Name = "ExtTools";
$ObjApi->Name = $Name;

$objProp->Add("msgInfo", $msg);
$objProp->Add("MsgID", "1");
$objProp->Add("Type", "0");
$objProp->Add("AssType", "0");
if (strlen($title) == 0)
{
	$objProp->Add("Title", "通知");
}
else
{
	$objProp->Add("Title", $title);
}
$objProp->Add("DelayTime", $delaytime);
if (strtolower($receiver) == "all")
{
	$objProp->Add("Username", $receiver);
	$objProp->Add("SendMode", "1");
}
else
{
	$objProp->Add("Username", $receiver);
}


$Result = @$ObjApi->Call2(0x2100, $objProp);

$errstr = $php_errormsg;
if(strcmp($nullstr, $errstr) == 0)
{
	echo "操作成功!";
}
else
{
	echo $errstr."<br>";
}