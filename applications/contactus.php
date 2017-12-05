<?php require_once("../public/configuration.php");
	$cnct=new cnct_class();$cnct->cnct();?>
<?php require_once("../models/index/index.php"); 	
	$index=new index(); ?>
<?php
$message='<b>'.$_POST["type"].'</b><br><br>';
$message.=$_POST['message'];
$message = str_replace("
", "<br/>", $message);
$index->send_one ($message, $_POST['subject'], $_POST['name'], $_POST['email'], 'info@ibrahimomar.com');
header('Location:../index/contactus.php?send=yes');
?>