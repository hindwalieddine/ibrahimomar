<?php include("../public/layouts/theme_1/header-agents.php"); ?>

    <?php

//***************** get the slide show image list *************
/******* this filter is used a lot so we define it in the header and no need to define it again here ... we just add it to the filter array
	$statusF['keyword']='INACTIVE';// $statusF is a filter u define in this way (later i tell u more details)
	$statusF['filterBy']='status';//column name
	$statusF['exact']=true; // use = or like in sql .. 
	$statusF['searchId']=false; // later i tell u ..
*/
	

$filterData=Array();
$filterData['multiFilterBy'][]=$statusF;
$agents=$index->getAllGeneralItemsWithJoins($filterData,"agent");
//***************** get the product list *************

//$index->show($agents); // (used to only preview data) show is a function i made it same as var dump or print but more clear  ... used to show array ... sho  take a parameter as Arrey

?>

<tr>
<td  width="150" style="border:0px solid black"></td>
<td  width="981"  class="backgroudtransparent">
	   <h1>وكلائنا في العالم العربي<h1>	   
</td>
<td  width="150" style="border:0px solid blue">
</td>
</tr>

<tr>
<td  width="150" style="border:0px solid black"></td>
<td  width="981"  class="backgroudtransparent" style="border:0px solid black">
     
<table align="center">

   <?php  $i=0;
    foreach($agents as $id=>$agent){
    $i++;
	   if($i%2==0){
	   ?> 
	   <td width="150" style="border:0px solid blue"> <?php echo($agent['telephone']);?> </td>	 
	   <td width="200" style="border:0px solid red"> <?php echo($agent['name']);?>  </td> 
	   </tr>

	   <?php }
	   else{
	   ?>  
	   <tr>
	   <td width="150" style="border:0px solid blue"> <?php echo($agent['telephone']);?> </td>	 
	   <td width="200" style="border:0px solid red"> <?php echo($agent['name']);?>  </td> 	 
	   <td width="20" style="border:0px solid blue"></td>
	   <?php }
    
	}?>
      
  
</table>	  	   
</td>
<td  width="150" style="border:0px solid blue">
</td>
</tr>








<?php include("../public/layouts/theme_1/footer.php"); ?>