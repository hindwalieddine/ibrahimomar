<?php require_once('../public/layouts/theme_1/_header.html');?>
<?php 
$path_parts0 = pathinfo(__FILE__);
$page0=$path_parts0['filename'];
$table0=strtolower($page0);
$Table0=$index->capitalize($table0);
if(file_exists("../source/custom/".$page0.".php"))
{
	eval(file_get_contents("../source/custom/".$page0.".php"));
}
else
{
	eval(file_get_contents("../source/template/iframe/item.php"));
}
?>