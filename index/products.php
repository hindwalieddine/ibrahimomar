<?php include("../public/layouts/theme_1/header-products.php"); ?>

    <!-- products.php -->
    <?php

//***************** get the product list *************
/******* this filter is used a lot so we define it in the header and no need to define it again here ... we just add it to the filter array
	$statusF['keyword']='INACTIVE';// $statusF is a filter u define in this way (later i tell u more details)
	$statusF['filterBy']='status';//column name
	$statusF['exact']=true; // use = or like in sql .. 
	$statusF['searchId']=false; // later i tell u ..
*/
	
$filterData=Array();// define an array to give as parameter to the function
$filterData['multiFilterBy'][]=$statusF; // fill 1st filter in the array  , you can add more filters later , multyFilterBy is used 
//$filterData['multiFliterBy'][]=$nameFilter; // example
//$filterData['multiFilterBy'][]=$dateFilter;// example
$products=$index->getAllGeneralItemsWithJoins($filterData,"product"); // first parameter is an array to filter or sort etc (optional) , the second parameter is the table name (not optional)
//***************** get the product list *************

//$index->show($products); // (used to only preview data) show is a function i made it same as var dump or print but more clear  ... used to show array ... sho  take a parameter as Arrey
?>

		<!----------------------------------------------------------- BODY ---------------------->
<?php

//***************** get the product list *************
/******* this filter is used a lot so we define it in the header and no need to define it again here ... we just add it to the filter array
	$statusF['keyword']='INACTIVE';// $statusF is a filter u define in this way (later i tell u more details)
	$statusF['filterBy']='status';//column name
	$statusF['exact']=true; // use = or like in sql .. 
	$statusF['searchId']=false; // later i tell u ..
*/
	
$filterData=Array();// define an array to give as parameter to the function
$filterData['multiFilterBy'][]=$statusF; // fill 1st filter in the array  , you can add more filters later , multyFilterBy is used 
//$filterData['multiFliterBy'][]=$nameFilter; // example
//$filterData['multiFilterBy'][]=$dateFilter;// example
$products=$index->getAllGeneralItemsWithJoins($filterData,"product"); // first parameter is an array to filter or sort etc (optional) , the second parameter is the table name (not optional)
//***************** get the product list *************

//$index->show($products); // (used to only preview data) show is a function i made it same as var dump or print but more clear  ... used to show array ... sho  take a parameter as Arrey
?>

 <tr>
  <td colspan="3"  height="15" style="border:0px solid black"></td>
 </tr>
 
<tr>
 <td  width="150" style="border:0px solid black"></td>
<td class="backgroudslid"> 
    <img src="../public/design-images/products-cover1.jpg">		
</td>
 <td  width="150" style="border:0px solid black"></td>
</tr>


<tr>
<td  width="150" style="border:0px solid black"></td>
<td  width="981"  class="backgroudtransparent">
	   <h1>منتجات إبراهيم عمر لتصليح الشعر<h1>	   
</td>
<td  width="150" style="border:0px solid blue">
</td>
</tr>


<tr>
  <td width="150" style="border:0px solid red;">
  </td>
  
  <td  width="981" style="border:0px solid blue">
  <div class="scroll">
  <!-- TABLE OF ALL PRODUCTS -->
  <table width="981"  style="border:0px solid blue;" class="backgroudtransparent">
  <tr>
    <td colspan="9" height="25" style="border:0px solid pink;"></td>
   </tr>
   
        <?php
        $i=0;
        foreach($products as $id=>$product) // this will loop on all the prodects that are stored in the array
        { $i++; 
		$r=$i/4;
		$whole = floor($r);      // 1
        $fraction = $r - $whole; // .25
        ?>
     <?php if($fraction === 0.25){ ?>
<tr>
	 <td width="35" style="border:0px solid black;"></td> <?php } ?> <!-- LEFT BORDER OF FIRST IMAGE -->
	 
     <td width="219" height="266"  style="border:0px solid yellow;">
	     <!-- Image -->
	     <table width="219" height="266">
		  <tr align="center">
		   <td>
      	   <a href="productdescription.php?id=<?php echo($product['id']); ?>"><img src="../public/images/<?php echo($product['image_name']); ?>"  width="219" height="198"></img></a>
		  </td>
		  </tr>
          <tr>
           <td align="center">
           <?php echo($product['name']); ?>
		   </td>
		  </tr>
		  <tr>
		   <td align="center">
		   <?php echo '$'.($product['price']); ?>
		   </td>
		  </tr>
		 </table>
		 <!-- End Image -->
	 </td>	 
	 <?php if($i%4 != 0){ ?>    <td width="15" style="border:0px solid red;"></td> <?php } ?>
	 <?php if($i%4 === 0){ ?>   <td width="30" style="border:0px solid green;"></td></tr>
	 
   <tr>
    <td colspan="9" height="5" style="border:0px solid pink;"></td>
   </tr>

	 
	 <!--end table --> <?php } ?>
	 <?php } ?>
     

  <tr>
    <td colspan="9" height="61" style="border:0px solid pink;"></td> <!-- Pagination -->
   </tr>
 
	
</table>
</div>
</td>
  
 <td  width="150" style="border:0px solid black"></td> 
</tr>





<tr>
 <td colspan="5"  height="15" style="border:0px solid black"></td>
 </tr>
<?php include("../public/layouts/theme_1/footer.php"); ?>