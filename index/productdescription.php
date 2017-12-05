﻿<?php include("../public/layouts/theme_1/header-products.php"); ?>
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

       <?php

$filterData=Array();// define an array to give as parameter to the function
 
$idF['keyword']= $_GET['id'];

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

<!----------------------------------------------------------- BODY ---------------------->

	  <!-- Product description -->
   <tr>
    <td  width="150" style="border:0px solid black"></td>
    <td  width="981"  class="backgroudtransparent">
	   <h1><?php echo($product['name']); ?><h1>	
	   
    </td>
    <td  width="150" style="border:0px solid blue">
    </td>
   </tr>	  
     
   <tr>
    <td  width="150" style="border:0px solid black"></td>
    <td  width="981"  class="backgroudtransparent">
    
	<table width="981" align="center" style="border:0px solid black;">
	  		
     <tr>
      <td class="paddingrightandleft" style="border:0px solid yellow;">
      <?php echo($product['description']); ?>

	 </td>
	  <td rowspan="2" class="aligntop" style="border:0px solid green;">  <img align="right" src="../public/images/<?php echo($product['image_name']); ?>" /> </img>
           
	  </td>	
	 </tr>
	 <tr>
	 <td align="right" class="paddingright20top0" id="content"  style="border:0px solid red;">

			     <!-------- Send an email about the product ------>
				 <form action="../applications/contactus3.php" method="post" name="form1" id="form1" class="classfont" onsubmit="checkEmail()" >
        <div class="box">
            <div id="contactFormContainer">
                <div id="contactForm">
                    <fieldset>
					    <input type="hidden" name="type" value="Product description Form  <?php echo($product['name']); ?>">
                        <label for="Name"> الاسم  <span dir="ltr"> <span dir="ltr"> </span> * </span></label>
                        <input id="name" name="name" type="text" />
                        <label for="Email">بريد الالكترونى *</label>
                        <input id="Email" name="email" type="text" />
						<label for="subject">الموضوع *</label>
                        <input id="subject" name="subject" type="text" />
                        <label for="Message">الرسالة *</label>
                        <textarea id="Message" name="message"  rows="3" cols="20"></textarea>
                        <input id="sendMail" type="submit" name="submit" value="أرسل" onclick="closeForm()" />
                        <span id="messageSent">لقد تم إرسال رسالتك بنجاح!</span>
                   </fieldset>
                </div>
                <div id="contactLink"></div>
            </div>


        </div>
		</form>
     <!--------  ------>


	 

	 </td>
           		
     </tr>
    </table>	  	   
   </td>
   <td  width="150" style="border:0px solid blue">
    </td>
   </tr>

     <!-- End product description-->


<!---------------------------------------------------------------  BODY END ------------------------------------>



<?php include("../public/layouts/theme_1/footer.php"); ?>