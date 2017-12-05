<?php require_once('../connection/connect.php'); ?>
<?php require_once("../../../models/index/index.php");
$index=new index();
$cnct=new cnct_class();
$cnct->cnct();
?>
<?php
	
		if(isset($_POST['queryString']) && isset($_POST['inputId'])) {
			$queryString=$_POST['queryString'];
			$inputId=$_POST['inputId'];
			if(strlen($queryString) >0) {
				$data['column']='name';
				$data['return'][]='id';
				$data['return'][]='name';
				$data['return'][]='date_of_birth';
				/*
				$data['return'][]='job';
				$data['return'][]='marital_status_id';
				$data['return'][]='number_of_children';
				$data['return'][]='email';
				*/
				$data['value']=$queryString;
				$data['limit']='10';
				$result=$index->getSuggestions($data,'citizen');
				if(count($result)) 
				{
					echo '<ul>';
						?>
						<?php
						foreach ($result as $Rind => $Rdata)
						{
							$description='';
							if($Rdata["date_of_birth"])
							{
								$description='<br />DOB:'.$Rdata["date_of_birth"];
							}
							echo '<li onClick="setCitizen(\''.$inputId.'\',\''.$Rdata["id"].'\'); fill(\''.$Rdata["name"].'\',\''.$inputId.'\')" >'.$Rdata["id"].' : '.$Rdata["name"].$description.'</li>';
						}
					echo '</ul>';
						
				}
				else 
				{
					echo 'New Citizen<script>setTimeout("$(\'#'.$inputId.'_suggestions\').fadeOut();", 2000);</script>';
				}
			} else {
				// do nothing
			}
		} else {
			echo 'There should be no direct access to this script!';
		}
?>