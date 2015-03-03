<?php
include('check.php');

$user=$_SESSION['uname'];

$rtxPath=realpath("d:/rtxserver/");

$rtxOffMsgIndexPath=$rtxPath.'/OffMsg/OffMsgIndex/';

$results=array();
$gbkuser = iconv("UTF-8", "gbk", $user);

$xmlfile=$rtxOffMsgIndexPath.$gbkuser.'.xml';

if(file_exists($xmlfile)){

	$xml = simplexml_load_file($xmlfile);

	//$rec=$xml->OffMsgRec;
	foreach ($xml->OffMsgRec as $row) {
		$attr=$row->attributes();
		$msg=array(
			'CreateTime'=>(String)$attr->CreateTime,
			'Addr'=>(String)$attr->Addr,
			'Type'=>(String)$attr->Type,
			'Sender'=>(String)$attr->Sender,
			'Recievers'=>(String)$attr->Recievers,
			'Title'=>(String)$attr->Title,
			'MsgID'=>(String)$attr->MsgID,
			);
		$msg['CreateDateTime']=date('Y-m-d H:i:s',$msg['CreateTime']);


		$results[]=$msg;
	}
	//var_dump($xml);
}


echo json_encode($results);