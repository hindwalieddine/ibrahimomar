<?php require_once('../connection/connect.php'); ?>
<?php require_once("../../../models/index/index.php");
$index=new index();
$cnct=new cnct_class();
$cnct->cnct();
?>
<style>
td
{
	padding:5px;
}
.delete
{
border:1px #aecd6f solid;
color:#aecd6f";
}
.delete:hover
{
border:1px #aecd6f solid;
color:#aecd6f";
background:red;
cursor:pointer;
}
</style>
<?php
		if(isset($_POST['id']) && isset($_POST['type'])) {
			$id=$_POST['id'];
			$relatives=$index->getRelatives(Array('citizen_id'=>$id));
				/*
				$filter['keyword']=$id;
				$filter['filterBy']='citizen_1';
				$filter['exact']=true;
				$filter['searchId']=false;
				
				$Fdata['multiFilterBy'][]=$filter;
				//$index->show($Fdata);
				$result1=$index->getAllGeneralItemsWithJoins($Fdata,'relationship');
				
				$filter2['keyword']=$id;
				$filter2['filterBy']='citizen_2';
				$filter2['exact']=true;
				$filter2['searchId']=false;
				
				$Fdata2['multiFilterBy'][]=$filter2;
				
				$result2=$index->getAllGeneralItemsWithJoins($Fdata2,'relationship');
				*/

				if(count($relatives)) 
				{
					echo '<table style="width:90%" >';
						?>
						<?php
						foreach ($relatives as $Rind => $Rdata)
						{
								echo '<tr style="cursor:pointer" ><td onclick="window.open(\'../../index/citizen.php?id='.$Rdata['citizen']['id'].'\')" style="background:#aecd6f;color:#ffffff;border:1px #aecd6f solid" >'.$Rdata['relation'].'</td><td onclick="window.open(\'../../index/citizen.php?id='.$Rdata['citizen']['id'].'\')" style="text-align:right;border:1px #aecd6f solid" >'.$Rdata['citizen']['name'].'</td><td ><div class="delete" onclick="deleteRelationship(\''.$Rdata['relationship_id'].'\');" ><center>X</center></div></td></tr>';
						}
					echo '</table>';
						
				}
		} 
		else 
		{
			echo 'direct access not allowed to this script!';
		}
?>