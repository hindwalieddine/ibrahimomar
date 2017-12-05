//************************************* check if the user control_p_group allow him to enter this page *******
$path_parts = pathinfo(__FILE__);
$page=$path_parts['filename'];
$data['control_p_privilege']=$page;
$data['control_p_group_id']=$_SESSION['control_p_group_id'];
//************************************* check if the user control_p_group allow him to enter this page *******
if(!$index->isAllowed($data))
{
	if(isset($_SERVER["HTTP_REFERER"]))
	{
		$pathA=explode('/',$_SERVER["HTTP_REFERER"]);
		if(str_replace('.php','',$pathA[count($pathA)-1])!=$page)
		{
			if(strpos($_SERVER["HTTP_REFERER"],'?')===false) $char='?' ; else $char='&'; 
			//ob_end_clean();
			$wlurl=$_SERVER["HTTP_REFERER"].$char.'note=No Permition';
			echo "<script language='javascript' >window.location = '".$wlurl."';</script>";
			die('No Permition, Please enable JavaScript To Continue');
			header('Location:'.$_SERVER["HTTP_REFERER"].$char.'note=No Permition');
		}
		else
		{
			//ob_end_clean();
			echo "<script language='javascript' >window.location = 'index.php?note=No Permition';</script>";
			die('No Permition, Please enable JavaScript To Continue');
			header('Location:index.php?note=No Permition');
		}
	}
	else
	{
		//ob_end_clean();
		echo "<script language='javascript' >window.location = 'index.php?note=No Permition';</script>";
		die('No Permition, Please enable JavaScript To Continue');
		header('Location:index.php?note=No Permition');
	}
}
//******************************************************** sub menu *****************************
$data['page']=$page;
$menu=$index->getMenuList($data);
?>
<?php

$tables[0]='relationship';//just the name of the table
$relationship_types=$index->getAllGeneralItemsWithJoins('','relationship_type');
$countries=$index->getAllGeneralItemsWithJoins('','country');
$marital_statuses=$index->getAllGeneralItemsWithJoins('','marital_status');
$professions=$index->getAllGeneralItemsWithJoins('','profession');
?>
<script language="javascript">
function show_relatives(citizenId)
{
	if(citizenId != 0) 
	{
		//$('#'+input.id).addClass('load');
		$.post("../applications/custom/relatives.php", {id: ""+citizenId+"" ,type: "all"}, function(data)
			{
				if(data.length >0) 
				{
					$('#relatives_div').html(data);
					//$('#'+input.id).removeClass('load');
				}
			});
	}
}
function show_relativesDelay(citizenId)
{
	
	setTimeout(function() 
	{ 
		if(citizenId != 0) 
		{
			//$('#'+input.id).addClass('load');
			$.post("../applications/custom/relatives.php", {id: ""+citizenId+"" ,type: "all"}, function(data)
				{
					if(data.length >0) 
					{
						$('#relatives_div').html(data);
						//$('#'+input.id).removeClass('load');
					}
				});
		}
	},3000);
}
data0='';
function suggest(input)
{
	
	if(input.id=='citizen_2')
	{
		$('#form_table').show(600);
	}
	inputString=input.value;
	if(inputString.length == 0) {
		$('#'+input.id+'_suggestions').fadeOut(600);
	} else {
	$('#'+input.id).addClass('load');
		$.post("../applications/custom/autosuggest.php", {queryString: ""+inputString+"" ,inputId: ""+input.id+""}, function(data){
			if(data.length >0 && data!=data0) {
				$('#'+input.id+'_suggestions').fadeIn(600);
				$('#'+input.id+'_suggestionsList').html(data);
				$('#'+input.id).removeClass('load');
				data0=data;
			}
		});
	}
}
function deleteRelationship(r_id)
{
		if (confirm('Are You Sure'))
		{
		
		$.post("../applications/custom/deleteRelationship.php", {table: "relationship" ,id: ""+r_id+""}, function(data){
		//alert(data);
			if(data==1) 
			{
				show_relatives($('#citizen_1_existing_id').val());
			}
			else
			{
				alert('Sorry, Please Try Again');
			}
		});
		}
}
function setCitizen(fill_id,citizenId)
{ 
	$('#'+fill_id+'_existing_id').val(citizenId);
	
	if(citizenId!='0')
	{ //alert(fill_id);
		if(fill_id=='citizen_2')
		{
			$('#form_table').hide(600);
		}
		if(fill_id=='citizen_1')
		{
			show_relatives(citizenId);
		}
		$('.'+fill_id).attr('disabled','disabled');
	}
	else
	{
		if(fill_id=='citizen_2')
		{
			$('#form_table').show(600);
			setNOC();
			//alert();
		}
		$('.'+fill_id).removeAttr('disabled');
	}

}
function fill(thisValue,fill_id) 
{ 
		if(thisValue!=0)
		{
			$('#'+fill_id).val(thisValue);
		}
		setTimeout("$('#"+fill_id+"_suggestions').fadeOut();", 600);
}
</script>
<link href="../public/css/suggestion.css" rel="stylesheet" type="text/css">	
	<div id="body">	
		
		<div id="firstColumn" >
		<div >
			<input id="add_item_buttom" type="button" style="width:<?php echo(strlen($tables[0])*9); ?>px" onClick="window.location='<?php echo $tables[0]; ?>.php'" value="<?php echo $index->toView($tables[0]); ?>" >
		</div>
		<table >


			<?php
				foreach($menu['menu_pages'] as $menu_id=>$mnu)
				{
					$display_name=$menu['menu_display_names'][$menu_id];
					//var_dump($menu['menu_pages']); die();
			?>
					
			<?php 
					$res=$index->isAllowed_2($_SESSION['control_p_group_id'],$mnu); if($res) { ?><tr ><td><span ><a href="<?php echo $mnu;?>.php"><?php if($display_name=="")echo $index->toView($mnu); else { echo $display_name; }?></a></span></td></tr><?php } ?>	
			<?php
				}
			?>
		</table>
		</div>
		<div id="secondColumn"  >

			<center>
			<h1>Manage <?php echo ' '.$index->toView($tables[0]).'s '; ?></h1>
			</center>
			
			<form method="POST" action="../applications/custom/saveRelationship.php" name='form' id='form' enctype="multipart/form-data" >

				<table  >
				<tr style="" >
				<th style="background:#aecd6f;color:#ffffff;border-right:3px white solid">
				Citizen
				</th>
				
				<th >
				</th>
				
				<th style="background:#aecd6f;color:#ffffff;border-right:3px white solid">
				Is 
				</th>
				
				<th style="background:#aecd6f;color:#ffffff;" >
				Of Citizen
				</th>
				
				</tr>
				<tr>
				<td>
				<table style="width:290px;" >
				<tr>
				<!--citizen 2 input to show suggestions -->
				<td style="width:140px;" >
				<label  >Name:  <font color="red" >*</font></label>
				</td>
				<td style="width:150px;" >
				<input name="citizen[name]" id="citizen_2" onkeyup="suggest(this)" onblur="setCitizen(this.id,0); fill(0,this.id);" value="" maxlength="100" type="text"  class="doc_text" >
				<input type="hidden" name="citizen_2_existing_id" id="citizen_2_existing_id" value="0" >
				<div class="suggest" >
				  <div class="suggestionsBox" id="citizen_2_suggestions" style="display: none;"><img src="../../public/design-images/arrow.png" style="position: relative; top: -12px; left: 0px;" alt="upArrow" />
					<div class="suggestionList" id="citizen_2_suggestionsList"> &nbsp; </div>
				  </div>
				</div>
				</td>
				</tr>
				</table>
				<!------------------------------------->
				</td>
				<td>
				<div style="width:200px;" ></div>
				</td>
				<td>
				<select name="relationship_type_id" >
				<?php
					foreach($relationship_types as $indRT=>$dataRT) 
					{
				?>
				<option value="<?php echo $dataRT['id']; ?>" ><?php echo $dataRT['name']; ?></option>
				<?php
					}
				?>
				</select>
				</td>
				<td>
				<!--citizen 2 input to show suggestions -->
				<input name="citizen_1" id="citizen_1" onkeyup="suggest(this)" onblur="setCitizen(this.id,0); fill(0,this.id);" value="" type="text" class="doc_text" >
				<input type="hidden" name="citizen_1_existing_id" id="citizen_1_existing_id" value="0" >
				<div class="suggest" >
				  <div class="suggestionsBox" id="citizen_1_suggestions" style="display: none;"><img src="../../public/design-images/arrow.png" style="position: relative; top: -12px; left: 0px;" alt="upArrow" />
					<div class="suggestionList" id="citizen_1_suggestionsList"> &nbsp; </div>
				  </div>
				</div>
				<!------------------------------------->
				</td>
				</tr>
				<tr>
				<td colspan="2" >
					<table style="width:290px;" id="form_table" >
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Sex: </label></td>
											<td>
											
																		<table border="0" width="100%" >
																<tr>
																	<td>
																	<input type="radio" checked  style="width:10px" name="citizen[sex]" id="noSex_optional" value="0" ><label> Male</label>
																	</td>
																	<td>
																	<input type="radio" style="width:10px" name="citizen[sex]" id="yesSex_optional" value="1" ><label> Female</label>
																	</td>
																</tr>
															</table>
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Date Of Birth:  <font color="red" >*</font></label></td>
											<td>
											
												
												
															<input type="text"  alt="date" readonly  name="citizen[date_of_birth]" id="Citizen-Date Of Birth" value="" maxlength="" >
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Country : </label></td>
											<td>
											<select name="citizen[country_id]" id="Citizen-Country _optional"  >
												<option value="null">Select</option>
												<?php
												foreach($countries as $indCO=>$dataCO)
												{
												?>
													<option value="<?php echo $dataCO['id']; ?>" ><?php echo $dataCO['name']; ?></option>
												<?php
												}
												?>
											</select>
						<!------------------------------ Set The Language To English As Default -------------------------------------->
									<!------------------------------ End Set The Language To English As Default -------------------------------------->
											</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Marital Status :  <font color="red" >*</font></label></td>
											<td>
											
						
							<select name="citizen[marital_status_id]" id="Citizen-Marital Status "  >
								<option value="null">Select</option>
								<?php
								foreach($marital_statuses as $indMS=>$dataMS)
								{
								?>
									<option value="<?php echo $dataMS['id']; ?>" ><?php echo $dataMS['name']; ?></option>
								<?php
								}
								?>
							</select>
						<!------------------------------ Set The Language To English As Default -------------------------------------->
									<!------------------------------ End Set The Language To English As Default -------------------------------------->
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Number Of Children: </label></td>
											<td>
											
												
												
															<input type="text" name="citizen[number_of_children]" id="Citizen-Number Of Children_optional" value="" maxlength="11" >
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Number Of Cars: </label></td>
											<td>
											
												
												
															<input type="text" name="citizen[number_of_cars]" id="Citizen-Number Of Cars_optional" value="" maxlength="11" >
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Profession : </label></td>
											<td>
											
						
							<select name="citizen[profession_id]" id="Citizen-Profession _optional"  >
								<option value="null">Select</option>
								<?php
								foreach($professions as $indPRO=>$dataPRO)
								{
								?>
									<option value="<?php echo $dataPRO['id']; ?>" ><?php echo $dataPRO['name']; ?></option>
								<?php
								}
								?>
							</select>
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Tel: </label></td>
											<td>
											
												
												
															<input type="text" name="citizen[tel]" id="Citizen-Tel_optional" value="" maxlength="20" >
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Mobile: </label></td>
											<td>
											
												
												
															<input type="text" name="citizen[mobile]" id="Citizen-Mobile_optional" value="" maxlength="20" >
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Other Number: </label></td>
											<td>
											
												
												
															<input type="text" name="citizen[other_number]" id="Citizen-Other Number_optional" value="" maxlength="20" >
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Email: </label></td>
											<td>
											
												
												
															<input type="text" name="citizen[email]" id="Citizen-Email_optional" value="" maxlength="70" >
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Resident: </label></td>
											<td>
											
																		<table border="0" width="100%" >
																<tr>
																	<td>
																	<input type="radio" checked  style="width:10px" name="citizen[resident]" id="noResident_optional" value="0" ><label> No</label>
																	</td>
																	<td>
																	<input type="radio" style="width:10px" name="citizen[resident]" id="yesResident_optional" value="1" ><label> Yes</label>
																	</td>
																</tr>
															</table>
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
						<tr><td><label>Paid: </label></td>
											<td>
											
																		<table border="0" width="100%" >
																<tr>
																	<td>
																	<input type="radio" checked  style="width:10px" name="citizen[paid]" id="noPaid_optional" value="0" ><label> No</label>
																	</td>
																	<td>
																	<input type="radio" style="width:10px" name="citizen[paid]" id="yesPaid_optional" value="1" ><label> Yes</label>
																	</td>
																</tr>
															</table>
														</td>
										</tr>
									
						<script language="javascript">
						$(function(){
							$("#da").hide();
						});
						</script>
										
												<tr><td colspan="2" ></td></tr>
					</table>

				</td>
				<td style="vertical-align:top;" colspan="2" >
				<div id="relatives_div" ></div>
				</td>
				</tr>
				</table>
				<input class="submit" type="submit" onclick="" value="Add<?php echo ' '.$index->toView($tables[0]); ?>" />
				<!------------------------------------------- iframe data ------------------------------------------------------------->
				<script language="javascript" >

				function init() {
					document.getElementById('form').onsubmit=function() {
					if($('#citizen_1_existing_id').val()==0)
					{
						alert('You must select a Valid Citizen from suggestion list on the right side');
						return false;
					}
					else
					{
						if($('#citizen_2_existing_id').val()==0)
						{
							if(!check('form'))
							{
								return false; 
							}
						}
					}
					
					document.getElementById('form').target = '_application'; //'upload_target' is the name of the iframe
					document.getElementById('_application').style.width="100%";
					document.getElementById('_application').style.height="400px";
					//show_relativesDelay($('#citizen_1_existing_id').val());
					setTimeout(function() {	show_relatives($('#citizen_1_existing_id').val()); },3000);

					//show_relatives();
				}
				}
				window.onload=init;
				</script>
				<script language="javascript">
					$(function() {
						var pickerOpts = 
						{
							showAnim: 'fold',
							//showOn: 'both',
							hideIfNoPrevNext: true,
							nextText: 'Later',
							dateFormat:"dd-mm-yy",
							changeFirstDay: false,
							changeMonth: false,
							changeYear: true,
							closeAtTop: false,
							showOtherMonths: true,
							showStatus: true,
							showWeeks: true,
							duration: "fast",
							yearRange: "1940:1993"
						};
						$("input[alt='date']").datepicker(pickerOpts);
					});
				</script>
				<iframe id="_application" name="_application" src="" style="width:800px;height:200px;"  frameborder="0" scrolling="no" allowtransparency="true" ></iframe>
			</form>
<!--------------------------------------------- End iframe data ------------------------------------------------------------------------>
<?php // if(isset($_SESSION)){ /*unset($_SESSION['post']); unset($_SESSION['parentPage']);*/ $index->show($_SESSION); } ?>
</div>
</div>
<?php require_once('../public/layouts/theme_1/_footer.html'); ?>