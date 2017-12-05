<?php include("../public/layouts/theme_1/header-index.php"); ?>

    <?php

//***************** get the slide show image list *************
/******* this filter is used a lot so we define it in the header and no need to define it again here ... we just add it to the filter array
	$statusF['keyword']='INACTIVE';// $statusF is a filter u define in this way (later i tell u more details)
	$statusF['filterBy']='status';//column name
	$statusF['exact']=true; // use = or like in sql .. 
	$statusF['searchId']=false; // later i tell u ..
*/
	
$filterData=Array();// define an array to give as parameter to the function
$filterData['multiFilterBy'][]=$slidF; // fill 1st filter in the array  , you can add more filters later , multyFilterBy is used 
//$filterData['multiFliterBy'][]=$statusF; // example
//$filterData['multiFilterBy'][]=$dateFilter;// example
$pages=$index->getAllGeneralItemsWithJoins($filterData,"image_to_page"); // first parameter is an array to filter or sort etc (optional) , the second parameter is the table name (not optional)


$filterData=Array();
$filterData['multiFilterBy'][]=$statusF;
$toppages=$index->getAllGeneralItemsWithJoins($filterData,"top_product");
//***************** get the product list *************

//$index->show($pages); // (used to only preview data) show is a function i made it same as var dump or print but more clear  ... used to show array ... sho  take a parameter as Arrey
//$index->show($toppages);
?>

<tr>
 <td colspan="5"  height="15" style="border:0px solid black"></td>
 </tr>
 
<tr>
 <td  width="150" style="border:0px solid black"></td>
<td class="backgroudslid"> 
    
	<div class="fluid_container">
    	
        <div class="camera_wrap camera_azure_skin" id="camera_wrap_1">
		<!--    <div data-src="../images/slides/women.png">
             
            </div>
			 <div  data-src="images/slides/women.png">  </div>
			 <div  data-src="images/slides/women1.png">  </div>
			 <div  data-src="images/slides/women2.png">  </div> -->
			 	
			<!--
            <div data-thumb="images/slides/thumbs/bridge.jpg" data-src="images/slides/bridge.jpg">  </div>
            <div data-thumb="images/slides/thumbs/leaf.jpg"  data-src="images/slides/leaf.jpg">   </div>
            <div data-thumb="images/slides/thumbs/road.jpg"  data-src="images/slides/road.jpg">  </div> 
         
            <div data-thumb="images/slides/thumbs/sea.jpg" data-src="images/slides/sea.jpg"></div>
               
            <div data-thumb="images/slides/thumbs/shelter.jpg" data-src="images/slides/shelter.jpg"> </div>
                
            
            <div data-thumb="images/slides/thumbs/tree.jpg" data-src="images/slides/tree.jpg"> </div>
			
			<div data-thumb="images/slides/thumbs/bridge.jpg" data-src="images/slides/bridge1.jpg">  </div>
            <div data-thumb="images/slides/thumbs/leaf.jpg"  data-src="images/slides/leaf1.jpg">   </div>
            <div data-thumb="images/slides/thumbs/road.jpg"  data-src="images/slides/road1.jpg">  </div> 
         
            <div data-thumb="images/slides/thumbs/sea.jpg" data-src="images/slides/sea1.jpg"></div>
               
            <div data-thumb="images/slides/thumbs/shelter.jpg" data-src="images/slides/shelter1.jpg"> </div>
                
            
            <div data-thumb="images/slides/thumbs/tree.jpg" data-src="images/slides/tree1.jpg"> </div>
			-->
			<!-- Image width="928" height="389" -->
             
             <?php foreach($pages as $id=>$page){ ?>
			 
			 <?php 
			 $imgName = $page['image_name'];?>
			 
			 
			 
			<div data-thumb="../public/images/thumbs/<?php echo $imgName;?>" data-src="../public/images/<?php echo $imgName;?>"> </div> 
			 
			 <?php } ?>
			 
        </div><!-- #camera_wrap_1 -->

        </div><!-- #camera_wrap_2 -->
		
		

		
</td>
 <td  width="150" style="border:0px solid black"></td>
</tr>
<tr>
<td  width="150" style="border:0px solid black"></td>
<td  style="border:0px solid red" width="980">
<table width="980" class="backgroudtransparent">
   <tr>
     <?php foreach($toppages as $id=>$toppage){
	  $top_name = $toppage['name'];
	  $top_image_name  = $toppage['image_name'];
	  $top_description = $toppage['description'];?>		 
     
	 <td rowspan="2" width="128">
	 <?php
     // list the directory
      $path = "../public/files/top_product/".$id;
      $handle = opendir($path);
      while($file = readdir($handle)){
	  if(substr($file,0,1) != "."){
	  //echo $path."/";
	  //echo $file."<br/>";
	  $file = str_replace(" ", "%20", $file);
      //echo $file."<br/>";
	  $name = $path."/".$file;
	  //echo $name;
	  ?>
	  <img style="text-align:center;" src= <?php echo $name;?>>
     <?php
	 }
	 }
	 closedir($handle);
    ?>
     
     </td>
	 <td>
	   <table>
	   <tr><td style="border:0px solid black" class="topproductname"><?php echo $top_name;?></td></tr>
	   <tr><td class="topproductdescription"><?php echo $top_description;?> </td></tr>
	   </table>
	 </td>
	 
			
			 <?php  } ?>
    </tr>
</table>
<!-- <img style="text-align:center;" src="../public/design-images/products.jpg"> -->
</td>
<td  width="150" style="border:0px solid black"></td>
</tr>
<tr>
 <td colspan="5"  height="15" style="border:0px solid black"></td>
 </tr>
<?php include("../public/layouts/theme_1/footer.php"); ?>
