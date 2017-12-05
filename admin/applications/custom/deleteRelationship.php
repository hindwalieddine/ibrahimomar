<?php	require_once("../../models/index/index.php");
$index=new index(); ?>
<?php	require_once("../connection/connect.php");
$cnct=new cnct_class();
$cnct->cnct();
$table=$_POST['table'];
$Table=$index->capitalize($table);
?>
<?php
	$data = array();
	//var_dump($_POST);die();
	$data['item'.$_POST['id']]=$_POST['id'];
	//var_dump($data);die();
	if($index->deleteGeneralItems($data,$table))
	{ 
		echo '1';
	}
	else
	{
		echo '0';
	}
?>