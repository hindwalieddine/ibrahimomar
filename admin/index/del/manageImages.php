<?php require_once('../public/layouts/theme_1/_header.html');?>
<?php require_once("../models/index/index.php");
$index=new index();
$cnct=new cnct_class();
$cnct->cnct();
//************************************* check if the user control_p_group allow him to enter this page *******
$path_parts = pathinfo(__FILE__);
$page=$path_parts['filename'];
$data['control_p_privilege']=$page;
$data['control_p_group_id']=$_SESSION['control_p_group_id'];
if(!$index->isAllowed($data))
{
//if(strpos($_SERVER["HTTP_REFERER"],'?')===false) $char='?' ; else $char='&'; header('Location:'.$_SERVER["HTTP_REFERER"].$char.'note=No Permition');
//if(strpos($_SERVER["HTTP_REFERER"],'?')===false) { $char='?' ; } else { $char='&'; } echo  '<script language="javascript" > window.location="'.$_SERVER["HTTP_REFERER"].$char.'note=No Permition"; </script>';
}
//************************************* check if the user control_p_group allow him to enter this page *******
//******************************************* constants *****************************************
$table=strtolower(substr($page,6));//get the name of the table from the file name
$Table=$index->capitalize($table);
//******************************************* constants end *************************************
//******************************************************** sub menu *****************************
$data['page']=$page;
$menu=$index->getMenuList($data);

//********************************************************* get folder uploaded to ************************************
if(isset($_GET['table']) && isset($_GET['id']))// validate the inputs
{
		$T=$_GET['table'];
		$I=$_GET['id'];
}
elseif(isset($_GET['table']) && !isset($_GET['id']) && isset($_SESSION['context'][$_GET['table']]))// get context id if exists
{
		$T=$_GET['table'];
		$I=$_SESSION['context'][$_GET['table']];
}
else
{
	if(strpos($_SERVER["HTTP_REFERER"],'?')===false) { $char='?' ; } else { $char='&'; } echo  '<script language="javascript" > window.location="'.$_SERVER["HTTP_REFERER"].$char.'note=Not Exist"; </script>';
	die('Please enable JavaScript To Continue');
}
$_SESSION['postData']['seq']='';
$_SESSION['postData']['seq']['image_to_'.$T]='';
//********************************************************* get folder uploaded to ************************************
?>
<?php
$F['keyword']=$I;
$F['filterBy']=$T.'_id';
$F['exact']=true;
$F['searchId']=false;
$FD['multiFilterBy'][]=$F;
$files=$index->getAllGeneralItemsWithJoins($FD,'image_to_'.$T);
//$index->show($FD);
?>
<!----------------------------------  Fancy Box ------------------------------------------------->
<script type="text/javascript" src="../public/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../public/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../public/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script language="javascript">
	$(document).ready(function(){
		$("a[rel=images]").fancybox(
				{
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'titlePosition' 	: 'over',
					'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
						return '<span id="fancybox-title-over" >Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
					}
				});
	});
</script>
	
	<div id="body">	
		
		<div id="firstColumn" >
		<div >
			<input id="add_item_buttom" type="button" style="width:<?php echo(strlen($index->toView($T))*9); ?>px" onClick="window.location='<?php echo $T; ?>.php'" value="<?php echo $index->toView($T); ?>" >
		</div>
		<table >
			<?php
				foreach($menu['menu_pages'] as $menu_id=>$mnu)
				{
					$display_name=$menu['menu_display_names'][$menu_id];
					//var_dump($menu['menu_pages']); die();
			?>
					
			<?php 
					$res=$index->isAllowed_2($_SESSION['control_p_group_id'],$mnu); if($res) { ?><tr ><td><span ><a href="<?php if(strpos($mnu, '.php')===false) echo $mnu.'.php'; else echo $mnu; ?>" ><?php if($display_name=="")echo $index->toView($mnu); else { echo $display_name; }?></a></span></td></tr><?php } ?>	
			<?php
				}
			?>
		</table>
		</div>
<div id="secondColumn"  >
		<div id="item_name" style="padding-bottom:30px;" >
			<center><label >Add<?php echo ' '.$index->toView($table).' '; ?></label></center>
		</div>
		
	<form  method="post" action="../applications/item/saveImages.php" name='form' id='form' enctype="multipart/form-data" onsubmit="">
	<table style="float:left;width:200px;" >
	<tr><td><?php echo $index->toView($T).' : '.$index->toView($index->showValue($I,$T.'_id')); ?></td></tr>
	<?php
	for($i=0;$i<1 ;$i++)
	{
	?>
	<tr><td><input type="file" name="<?php echo 'image_to_'.$T; ?>[image_id]" ></td></tr>
	<?php
	}
	?>
	<tr><td colspan="2" ><input type="submit" value="Add<?php echo ' '.$index->toView($table); ?>" /></td></tr>
	<tr><td colspan="2" >
	<iframe id="_application" name="_application" src="" style="width:0px;height:0px;"  frameborder="0" scrolling="no" allowtransparency="true" ></iframe>
	</td></tr>
	</table>
	<!-------------------------------- documents of a table ------------------------------------>
	<table style="float:left;"  >
	<tr>
	<?php
	$dir='../../';
	$edit=true;
	$C=0;
	if(count($files))
	{
		foreach($files as $id=>$file)
		{
				$ext='jpeg';
				if($edit)
				{
					$del='<input type="button" style="width:17px;height:17px;font-size:10px;padding-bottom:10px" value="X" onclick="window.location=\'../applications/item/delImage.php?table='.$T.'&item_id='.$I.'&id='.$id.'\'" >';
				}
				else
				{
					$del='';
				}		
				echo '<td style="padding-right:30px;font-size:12px" align="center" ><a  rel="images" href="'.$dir.'public/images/'.$file['image_name'].'" ><img src="'.$dir.'public/images/thumbs/'.$file['image_name'].'" ></a>'.$del.'</td>';
				if($C==3)
				{
					echo '</tr><tr>';
					$C=-1;
				}
				$C++;
		}
	}
	?>
	</tr>
	</table>
	<!-------------------------------- END: documents of a table ------------------------------------>
	<input type="hidden" name="<?php echo 'image_to_'.$T; ?>[<?php echo $T; ?>_id]" value="<?php echo $I; ?>" >
	</form>
	<!------------------------------------------- iframe data ------------------------------------------------------------->
	<script language="javascript" >
	function init() {
		document.getElementById('form').onsubmit=function() {
		if(!check('form'))
		{ return false; }
		document.getElementById('form').target = '_application'; //'upload_target' is the name of the iframe
		document.getElementById('_application').style.width="100%";
		document.getElementById('_application').style.height="400px";
	}
	}
	window.onload=init;
	</script>
	<!--------------------------------------------- End iframe data ------------------------------------------------------------------------>
</div>
</div>
<?php require_once('../public/layouts/theme_1/_footer.html'); ?>