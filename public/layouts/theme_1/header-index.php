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


$slidF['keyword']='1';
$slidF['filterBy']='page_id';
$slidF['exact']=true;
$slidF['searchId']=false;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" > 
    <title>Ibrahim Omar</title> 
    <meta name="description" content="Camera a free jQuery slideshow with many effects, transitions, adaptive layout, easy to customize, using canvas and mobile ready"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--///////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //		Styles
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
    <link rel='stylesheet' id='camera-css'  href='../public/css/camera.css' type='text/css'> 
    <style>


		a:hover {
			text-decoration: none;
		}
		#back_to_camera {
			clear: both;
			display: block;
			height: 80px;
			line-height: 40px;
			padding: 20px;
		}
		.fluid_container {
			margin: 0;
			max-width: 1000px;
			width: 90%;
		}
	</style>

    <!--///////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //		Scripts
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
    
    <script type='text/javascript' src='../public/js/jquery.min.js'></script>
    <script type='text/javascript' src='../public/js/jquery.mobile.customized.min.js'></script>
    <script type='text/javascript' src='../public/js/jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src='../public/js/camera.min.js'></script> 
    
    <script>
		jQuery(function(){
			
			jQuery('#camera_wrap_1').camera({
				thumbnails: true
			});

			jQuery('#camera_wrap_2').camera({
				height: '400px',
				loader: 'bar',
				pagination: false,
				thumbnails: true
			});
		});
	</script>
 
</head>
<body>


 <table width="1281" cellpadding="0" cellspacing="0" class="center" style="border:0px solid black">
 <tr>
     
    <td width="150" style="border:0px solid black"></td>
    
    <td width="981"  height="166" class="backgroundheaderindex">
        <p style="margin-left:25.5px;"><img src="../public/design-images/logo.png"></p>
        <img class="headerimage" src="../public/design-images/menu-index.png" usemap="#Map">
        <map name="Map">
        <area shape="rect" coords="795,0,929,40" href="index.php">
        <area shape="rect" coords="656,2,794,37" href="products.php">
        <area shape="rect" coords="503,2,657,37" href="agents.php">
        <area shape="rect" coords="372,2,502,41" href="complaints.php">
        <area shape="rect" coords="242,2,371,42" href="contactus.php">
        </map></td>
    <td width="150" style="border:0px solid blue"></td>
    
  </tr>
 <?php // include("slideshow/demo/slideshow.htm")?>
  