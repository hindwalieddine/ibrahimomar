<?php include("../public/layouts/theme_1/header-complaints.php"); ?>
   <?php

//***************** get the proposal from the database *************
/******* this filter is used a lot so we define it in the header and no need to define it again here ... we just add it to the filter array
	$statusF['keyword']='INACTIVE';// $statusF is a filter u define in this way (later i tell u more details)
	$statusF['filterBy']='status';//column name
	$statusF['exact']=true; // use = or like in sql .. 
	$statusF['searchId']=false; // later i tell u ..
*/
	
//$filterData=Array();// define an array to give as parameter to the function
//$filterData['multiFilterBy'][]=$statusF; // fill 1st filter in the array  , you can add more filters later , multyFilterBy is used 
//$filterData['multiFliterBy'][]=$statusF; // example
//$filterData['multiFilterBy'][]=$dateFilter;// example
//$pages=$index->getAllGeneralItemsWithJoins($filterData,"proposal"); // first parameter is an array to filter or sort etc (optional) , the second parameter is the table name (not optional)


$filterData=Array();
$filterData['multiFilterBy'][]=$statusF;
$proposals=$index->getAllGeneralItemsWithJoins($filterData,"proposal");
//***************** get the product list *************

//$index->show($pages); // (used to only preview data) show is a function i made it same as var dump or print but more clear  ... used to show array ... sho  take a parameter as Arrey
//$index->show($proposals);
?>


    <!--///////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //		Scripts
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
    
<script language="javascript">

function checkEmail() {

    var email = document.getElementById('from');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(from.value)) {
    alert('Please provide a valid email address');
    email.focus;
    return false;
 }
}

</script>

<!----------------------------------------------------------- BODY ---------------------->
		
<td  width="150" style="border:0px solid black"></td>

<td  width="981"  class="backgroudtransparent">
	   <h1>شكاوى وإقتراحات <h1>	   

	   </td>
<td  width="150" style="border:0px solid blue">
</td>
</tr>

<tr>
<td  width="150" style="border:0px solid black"></td>
<td  width="981"  class="backgroudtransparent">
<!-- contact us form -->     
<table align="center">
 <tr>
  <td width="511" style="border:0px solid blue;display: inline-block;vertical-align: top;">

 <table width="511" style="border:0px solid red;">
   <tr>
     <?php
     foreach($proposals as $id=>$proposal) // this will loop on all the prodects that are stored in the array
     {  

     ?>
     <td class="h2" style="border:0px solid pink;">
	 <h2><?php echo($proposal['name']); ?></h2>
     </td>  
	 <td width="150" rowspan="2" style="border:0px solid black;"> <img src="../public/design-images/logo.png"></td>
   </tr>
   <tr>
    <td class="paddingright">
	<?php echo($proposal['description']); ?>
	</td>
	</tr>
	
      <?php } ?>

</table>
</td>
<td width="470" style="border:0px solid red">
<form action="../applications/contactus2.php" method="post" name="form1" id="form1" class="classfont" onsubmit="checkEmail()" ><table width="500">
<input type="hidden" name="type" value="Complaints Form">
</td>


<td width="347" align="right" valign="middle"><input name="name" type="text" id="name" class="class1"/>

</td>
<td width="98" align="top">
<p dir="rtl" class="contactfont" style="border:0px solid blue">الاسم بالكامل<span dir="ltr"> <span dir="ltr"> </span>:</span></p>
</td>
</tr>
<tr>
<td align="right">
<input name="email" type="text" id="from" class="class1"/> </td>
<td width="140">

<p dir="rtl" class="contactfont" style="border:0px solid blue">بريد الالكترونى<span dir="ltr"> <span dir="ltr"> </span>:</span></p></td>
<td width="39">
</tr>
<tr>
<td align="right">
<input name="subject" type="text" id="subject" class="class1"/>


</td>
<td>

<p dir="rtl" class="contactfont" style="border:0px solid blue"> الموضوع   <span dir="ltr"> <span dir="ltr"> </span>:</span></p></td>

</tr>
<tr>
<td>
<textarea name="message" cols="40" rows="5" id="message"  class="message"></textarea>

<input name="Submit" type="submit" class="bottomform" value="إرسال"/>
</td>
<td valign="middle">
<p dir="rtl" class="contactfont" style="border:0px solid blue"> الشكوى   <span dir="ltr"> <span dir="ltr"> </span>:</span></p></td>

</tr>

</table>
</form>
</td>
</tr>
</table>

 
<!-- end contact us form -->	  	   
</td>
<td  width="150" style="border:0px solid blue">
</td>
</tr>





		<!---------------------------------------------------------------  BODY END ------------------------------------>

<?php include("../public/layouts/theme_1/footer.php"); ?>