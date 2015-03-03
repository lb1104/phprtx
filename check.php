<?php
if(isset($_GET['sessid'])){
	session_id($_GET['sessid']);
}
session_start();

if($_SESSION['uname']==''){
	exit("failed! no login!");
}