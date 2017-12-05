 <?php session_start(); ?>
<?php ob_start("a"); ?>
<?php require_once("../models/index/index.php");
$index=new index();
?>
<?php require_once("../models/index/custom.php");
$custom=new custom();
?>
<?php require_once('../public/configuration.php');
$cnct=new cnct_class();
$cnct->cnct();
?>
<?php
require_once("../public/constants.php");
$C= 'ConstantsControl_p_admin';
$C = new ReflectionClass($C);
?>
<?php
$statusF['keyword']='ACTIVE';
$statusF['filterBy']='status';
$statusF['exact']=true;
$statusF['searchId']=false;


$idF['filterBy']='id';
$idF['exact']=true;  
$idF['searchId']=false; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" > 
    <title>Products</title> 
    <meta name="description" content="Camera a free jQuery slideshow with many effects, transitions, adaptive layout, easy to customize, using canvas and mobile ready"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--///////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //		Styles
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
    <link rel='stylesheet' id='camera-css'  href='../public/css/camera.css' type='text/css'> 



</head>
<body>


 <table width="1281" cellpadding="0" cellspacing="0"  class="center" style="border:px solid black">
 <tr>
     
    <td width="150" style="border:0px solid black"></td>
    <!-- background-color:#e4dbdb; -->
    <td width="981"  height="166"  class="backgroundheaderindex">
        <p style="margin-left:25.5px;"><img src="../public/design-images/logo.png"></p>
        <img class="headerimage" src="../public/design-images/complaints.png" border="0" usemap="#Map">
<map name="Map">
  <area shape="rect" coords="642,-1,794,42" href="products.php">
  <area shape="rect" coords="801,1,932,40" href="index.php">
  <area shape="rect" coords="527,2,634,38" href="agents.php">
  <area shape="rect" coords="376,1,517,44" href="complaints.php">
  <area shape="rect" coords="237,1,328,36" href="contactus.php">
</map></td>
    <td width="150" style="border:0px solid blue"></td>
    
  </tr>
 <?php // include("slideshow/demo/slideshow.htm")?>
  