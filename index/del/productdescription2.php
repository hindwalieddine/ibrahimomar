
<table align="center" width="1200" style="border:0px solid #DE94E2" cellspacing="0" cellpadding="0">

   <tr>
     <td colspan="5" align="center" valign="top" style="background-color:#DE94E2;border:0px solid red">
     <?php include("../public/layouts/theme_1/_header.html"); ?>
     </td>
   </tr>
       <?php

$filterData=Array();// define an array to give as parameter to the function
 
$idF['keyword']= $_GET['id'];;

$filterData['multiFilterBy'][]=$statusF; // fill 1st filter in the array  , you can add more filters later , multyFilterBy is used 
$filterData['multiFilterBy'][]=$idF; 
//$filterData['multiFliterBy'][]=$nameFilter; // example
//$filterData['multiFilterBy'][]=$dateFilter;// example
$products=$index->getAllGeneralItemsWithJoins($filterData,"product"); // first parameter is an array to filter or sort etc (optional) , the second parameter is the table name (not optional)
//***************** get the product list *************

//$index->show($products); // (used to only preview data) show is a function i made it same as var dump or print but more clear  ... used to show array ... sho  take a parameter as Arrey

$id= $_GET['id'];
$product = $products[$id];
?>
   <tr>
     <td rowspan="3" style="border:0px solid green;">
	   <div style="width:200;float:left;">
       <?php include("../public/layouts/theme_1/offers.php");?>
	   </div>
	 </td>
	 <td colspan="4" height="10" style="border:0px solid pink">
	 </td>
	 </tr>
	 <tr>
	 
<!----------------------------------------------------------- BODY ---------------------->

   </tr>

   <tr>
    <td width="10" style="border:1px solid blue">
	 </td>
     <td width="838" border="1"  style="border:1px solid red">
	  <!-- Product description -->
     <table width="1000" align="center">
        
		<!--
		<tr>
           <td width="345" height="38" style="margin-right:15px">  <a href=""> <img src="../public/design-images/Best-Free-Email-services.png" width="100" /></img></a> </td>
         </tr>
		 
        
        <tr>          
           <td><p dir="rtl">&nbsp;</p> <?php echo '$'.($product['price']); ?>السعر<span dir="ltr"> <span dir="ltr"> </span>:</span></td>
        </tr>
		-->
		<tr>
		<h1 style="margin-right:150"> <?php echo($product['name']); ?> </h1>
		</tr>
        <tr>
           <td>  <img align="right" src="../public/images/<?php echo($product['image_name']); ?>" /> </img>
            <div align="right"> <?php echo($product['description']); ?> </div>
		   </td>
        </tr>      
                
</table>
<!-- End product description-->
     </td>
     <td width="10" style="border:0px solid blue">
	 </td>
	 <td width="130" style="border:0px solid red">
     <div style="margin-left:0px;"><?php include("../public/layouts/theme_1/menu.php");?></div>
     </td>
   </tr>
   <tr>
     <td colspan="5" width="1200 style="border:0px solid black; float:right">
       <?php include("../public/layouts/theme_1/_footer.html");?>
     </td>
   </tr>
</table>




<!---------------------------------------------------------------  BODY END ------------------------------------>

