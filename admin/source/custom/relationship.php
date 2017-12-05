//************************************* check if the user control_p_group allow him to enter this page *******
$path_parts = pathinfo(__FILE__);
$page=$path_parts['filename'];
$data['control_p_privilege']=$page;
$data['control_p_group_id']=$_SESSION['control_p_group_id'];
if(!$index->isAllowed($data))
{
if(strpos($_SERVER["HTTP_REFERER"],'?')===false) $char='?' ; else $char='&'; header('Location:'.$_SERVER["HTTP_REFERER"].$char.'note=No Permition');
}
$data['control_p_privilege']='delete_'.$page;
if($index->isAllowed($data))
{
	$canDelete=true;
}
else
{
	$canDelete=false;
}
//************************************* check if the user control_p_group allow him to enter this page *******
//********************************** General Constants  ********************************************
$table=$page;
$Table=$index->capitalize($table);
//********************************** End Of General Constants  ********************************************
//******************************************************** sub menu *****************************
$Mdata['page']=$page;
$menu=$index->getMenuList($Mdata);
?>
	<!-----------------------Page Body------------------------>
<?php
echo "<script language='javascript' >window.location = 'addRelationship.php';</script>";
die('Please enable JavaScript To Continue');
?>
//******************************************************** sub menu *****************************
//******************************************************** Filters Sort Search********************

<?php require_once('../public/layouts/theme_1/_footer.html');