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
  <td width="511" style="border:0px solid blue;vertical-align:top;">

 <table>

    <tr>
      <td width="511" class="h2"  style="border:0px solid red">	:للمزيد من المعلومات الإتصال على</td>
	</tr>
	<tr>
	  <td class="fontcontact"  style="border:0px solid red"> 00 961 70 880033 <b>: هاتف</b>  </td>
	<tr>
	  <td class="fontcontact"  style="border:0px solid red"> <a href="mailto:info@ibrahimomar.com">info@ibrahimomar.com</a><b>:  بريد الكتروني</b></td>
	</tr>
    <tr><td></td></tr>
	<tr>
      <td class="fontcontact"  style="border:0px solid red"> <a href="https://www.facebook.com/pages/%D9%85%D8%B3%D8%AA%D8%AD%D8%B6%D8%B1%D8%A7%D8%AA-%D8%A7%D9%84%D8%AE%D8%A8%D9%8A%D8%B1-%D8%A7%D9%84%D9%84%D8%A8%D9%86%D8%A7%D9%86%D9%8A-%D8%A5%D8%A8%D8%B1%D8%A7%D9%87%D9%8A%D9%85-%D8%B9%D9%85%D8%B1-%D9%84%D8%A5%D8%B5%D9%84%D8%A7%D8%AD-%D8%A7%D9%84%D8%B4%D8%B9%D8%B1Ibrahim-Omar-Hair-Repair/182579368460406">مستحضرات ابراهيم عمر لتصليح الشعر </a>
	
	  
	   <span dir="ltr" class="bold"> : فيسبوك</span>   </td> 
	  
    </tr>
      

</table>
</td>
<td width="470" style="border:0px solid red">
<form action="../applications/contactus.php" method="post" name="form1" id="form1" class="classfont" onsubmit="checkEmail()" ><table width="500">
<input type="hidden" name="type" value="Contact Us Form">
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

<p dir="rtl" class="contactfont" style="border:0px solid blue">الموضوع   <span dir="ltr"> <span dir="ltr"> </span>:</span></p></td>

</tr>
<tr>
<td>
<textarea name="message" cols="40" rows="5" id="message"  class="message"></textarea>

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