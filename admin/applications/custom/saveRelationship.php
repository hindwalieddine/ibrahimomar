<?php	session_start(); ?>
<?php	require_once("../../models/index/index.php"); ?>
<?php	require_once("../connection/connect.php");
$index=new index(); ?>
<?php	require_once("../../models/index/simpleImage.php");
$image=new simpleImage();
$cnct=new cnct_class();
$cnct->cnct();
//$index->show($_POST);
?>
<html>

<body STYLE="background-color:transparent;color:red;">
<p style="vertical-align:middle;border:1px solid gray;">
<?php
if(!isset($_POST))
{
	die();
}
$data['citizen_1']=$_POST['citizen_1_existing_id'];
$data['relationship_type_id']=$_POST['relationship_type_id'];
if($_POST['citizen_2_existing_id'])
{
	$data['citizen_2']=$_POST['citizen_2_existing_id'];
	if($index->addGeneralItem($data,'relationship'))
	{
		echo 'Successfully Added';
		$_SESSION['context']['citizen']=$data['citizen_2'];
	}
}
else
{
	$_POST['citizen'];
	if($citId=$index->addGeneralItem($_POST['citizen'],'citizen'))
	{
		$data['citizen_2']=$citId;
		if($index->addGeneralItem($data,'relationship'))
		{
			echo 'Successfully Added';
			$_SESSION['context']['citizen']=$data['citizen_2'];
		}
		else
		{
			$index->deleteGeneralItems(Array($citId),'citizen');
			echo 'Sorry, Please Try Again';
		}
	}
}
//$index->show($data);
?>
</p>
</body>
</html>