<?php include("../public/layouts/theme_1/header-contactus.php"); ?>

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

<tr>
<td  width="150" style="border:0px solid black"></td>
<td  width="981"  class="backgroudtransparent">
	   <h1>اتصل بنا<h1>	   
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
  <td width="311" style="border:1px solid blue;vertical-align:top;margin-top:0px;">

 <table>

    <tr>
      <td width="379" align="right" class="fontcontact"  style="border:0px solid red">	:للمزيد من المعلومات الإتصال على</td>
	</tr>
	<tr>
	  <td align="right" class="fontcontact"  style="border:0px solid red"> 961 3 871877 : هاتف  </td>
	<tr>
	  <td align="right" class="fontcontact"  style="border:0px solid red"> <a href="mailto:salonibrahimomar@hotmail.com">Salonibrahimomar@hotmail.com</a>:  بريد الكتروني</td>
	</tr>
    <tr><td></td></tr>
	<tr>
      <td align="right" class="fontcontact"  style="border:0px solid red"> <a href="https://www.facebook.com/pages/%D9%85%D8%B3%D8%AA%D8%AD%D8%B6%D8%B1%D8%A7%D8%AA-%D8%A7%D8%A8%D8%B1%D8%A7%D9%87%D9%8A%D9%85-%D8%B9%D9%85%D8%B1-%D9%84%D8%AA%D8%B5%D9%84%D9%8A%D8%AD-%D8%A7%D9%84%D8%B4%D8%B9%D8%B1-%D8%AD%D8%A7%D9%84%D9%8A%D8%A7-%D9%81%D9%8A-%D8%A7%D9%84%D8%B9%D8%B1%D8%A7%D9%82/116714651809792"><img align="top" src="../public/design-images/fb-icon.png" width="100"> 
	
	  
	  </a>  : فيسبوك </td>
    </tr>
      

</table>
</td>
<td width="470" style="border:1px solid red">
<form action="mailer.php" method="post" name="form1" id="form1" class="classfont" onsubmit="check_email_address()"><table width="500">

</td>


<td width="347" align="right" valign="middle"><input name="name" type="text" id="name" class="class1"/>

</td>
<td width="98" align="top">
<p dir="rtl" class="contactfont" style="border:0px solid blue">الاسم بالكامل<span dir="ltr"> <span dir="ltr"> </span>:</span></p>
</td>
</tr>
<tr>
<td align="right">
<input name="from" type="text" id="from" class="class1"/> </td>
<td width="140">

<p dir="rtl" class="contactfont" style="border:0px solid blue">بريد الالكترونى<span dir="ltr"> <span dir="ltr"> </span>:</span></p></td>
<td width="39">
</tr>
<tr>
<td align="right">
<input name="subject" type="text" id="subject" class="class1"/>


</td>
<td>

<p dir="rtl" class="contactfont" style="border:0px solid blue">الموضوع   <span dir="ltr"> <span dir="ltr"> </span>:</span></p></td>

</tr>
<tr>
<td align="right">


<!-- if the variable "wrong_code" is sent from previous page then display the error field -->
<div dir="rtl" class="contactfontsmall">الرجاء إدخال الرموز بالحقل الذي في الأسفل طبقا لما تظهر في الصورة <span dir="ltr">
<?php if(isset($_GET['wrong_code'])){?>
<div class="class2">رمز التحقق غير صحيح</div> 
<?php ;}?>
<br/>
<input name="verif_box" type="text" id="verif_box" class="class1"/>
<img src="verificationimage.php?<?php echo rand(0,9999);?>" alt="verification image, type it in the box" width="50" height="24" align="absbottom" />
</td>
<td align="right" class="contactfont" style="border:0px solid blue">
<p dir="rtl"> الحماية<span dir="ltr"> <span dir="ltr"> </span>:</span></p></td>

</tr>
<tr>
<td>
<textarea name="message" cols="35" rows="5" id="message"  class="message"></textarea>

<input name="Submit" type="submit" class="bottomform" value="إرسال"/>
</td>
<td valign="middle">
<p dir="rtl" class="contactfont" style="border:0px solid blue"> الرسالة  <span dir="ltr"> <span dir="ltr"> </span>:</span></p></td>

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








<?php include("../public/layouts/theme_1/footer.php"); ?>