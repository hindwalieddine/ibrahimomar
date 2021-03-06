<?php
class index
{
	function show($data,$fin='yes')
	{
		if(!is_array($data))
		{
			echo $data; die();
		}
		if($fin=='yes')
		{$w='';}
		else
		{$w='width="100%"';}
		$item='<table '.$w.' border="1" bordercolor="black">';
		foreach($data as $id => $val)
		{
			if(is_array($val))
			{
				$item=$item.'<tr><td>'.$id.'</td><td>'.$this->show($val,'no').'</td></tr>';
			}
			else
			{
				$item=$item.'<tr><td>'.$id.'</td><td>'.$val.'</td></tr>';
			}
		}
		$item=$item.'</table>';
		if($fin=='yes')
		{die($item);}
		return $item;
	}
	function constructBasicDB()
	{
		if(file_exists("../../source/basicDB/DB.txt"))
		{
			$DBdir = "../../source/basicDB/DB.txt";
			$DBfile = fopen($DBdir, 'r');
			$DBsql = fread($DBfile, filesize($DBdir));
			fclose($DBfile);
			$queries=explode(';',$DBsql,-1);
			$error='';
			foreach($queries as $ind=>$query)
			{	if($query)
				{
					if(!mysql_query($query))
					{
						$error.= mysql_error().' _'.$query.'_ <br/>';
					}
				}
			}
			if($error!='')
			{
				echo $error.'<br/>--------------------------------<br/>';
				return false;
			}
			else
			{
				return $error;
			}
		}
		else
		return false;
	}
	function createStaticPagesAuto()//automaticaly add an "addPage" , "editPage" , "page" for tables in database . And also add the static pages ("settings","login",....)
	{
		$c='';
		$static=scandir('../../source/static/');//add the static pages if they r not exist
		unset($static[0]);
		unset($static[1]);
		foreach($static as $value)
		{
			if (!file_exists('../../index/'.$value))
			{	//sleep(1);
				$c=$c.'File '.$value.' Added<br />';
				copy("../../source/static/".$value, '../../index/'.$value);
			}
		}
		if($c=='')
		{
			$c='No Static pages Added<br/>';
		}
		return $c.'<br/>--------------------------------<br/>';
	}
	function createFilesFromDbTablesAuto()//automaticaly add an "addPage" , "editPage" , "page" for tables in database . And also add the static pages ("settings","login",....)
	{
		echo $this->createStaticPagesAuto();
		echo'<br/>';
		$item=array();
		$c='';
		$sql0='SELECT DATABASE()';
		$result0=mysql_query($sql0);
		$row0=mysql_fetch_assoc($result0);
		$DB=$row0['DATABASE()'];
		$sql="SHOW FULL TABLES ";
		$result=mysql_query($sql);
		while($row=mysql_fetch_assoc($result))
		{
			if($row['Tables_in_'.$DB]!='image' && $row['Tables_in_'.$DB]!='login')//exclude this tables
			{
				$item[]=$row['Tables_in_'.$DB];
			}
		}
		foreach($item as $id=>$value)
		{
			if (!file_exists("../../index/".$value.".php"))
			{	//sleep(1);
				copy("../../source/dinamic/item.php", "../../index/".$value.".php");
				$c=$c.$value.'.php File Added<br />';
			}
			if (!file_exists("../../index/add".ucfirst($value).".php"))
			{	//sleep(1);
				copy("../../source/dinamic/addItem.php", "../../index/add".ucfirst($value).".php");
				$c=$c.'add'.ucfirst($value).'.php File Added<br />';
			}
			if (!file_exists("../../index/edit".ucfirst($value).".php"))
			{	//sleep(1);
				copy("../../source/dinamic/editItem.php", "../../index/edit".ucfirst($value).".php");
				$c=$c.'edit'.ucfirst($value).'.php File Added<br />';
			}
		}
		if($c=='')
		{
			$c='No Dinamic Pages Added';
		}
		return $c.'<br/>--------------------------------<br/>'.$this->addAllPrivilegesAuto();
	}
	function deleteTableAndItsFiles($table)//automaticaly add an "addPage" , "editPage" , "page" for tables in database . And also add the static pages ("settings","login",....)
	{
		$item=array();
		$c='';
		$sql='DROP TABLE `'.$table.'`';
		$result=mysql_query($sql);
		//if($result)
		//{
			if (file_exists("../../index/".$table.".php"))
			{	//sleep(1);
				unlink('../../index/'.$table.".php");
				$c=$c.$table.".php File Deleted<br />";
			}
			if (file_exists("../../index/add".ucfirst($table).".php"))
			{	//sleep(1);
				unlink("../../index/add".ucfirst($table).".php");
				$c=$c."add".ucfirst($table).".php File Deleted<br />";
			}
			if (file_exists("../../index/edit".ucfirst($table).".php"))
			{	//sleep(1);
				unlink("../../index/edit".ucfirst($table).".php");
				$c=$c."edit".ucfirst($table).".php File Deleted<br />";
			}
		//}
		if($c=='')
		{
			$c='No Changes';
		}
		return $c;
	}
	function clearAdmin()//automaticaly add an "addPage" , "editPage" , "page" for tables in database . And also add the static pages ("settings","login",....)
	{
		$return='Foreign Tables Removed:<br/>--------------------------------<br/>';
		
		$sql0='SELECT DATABASE()';
		$result0=mysql_query($sql0);
		$row0=mysql_fetch_assoc($result0);
		$DB=$row0['DATABASE()'];
		
		$sql="SHOW FULL TABLES ";
		$result=mysql_query($sql);

		while($row=mysql_fetch_assoc($result))
		{
			if(strpos($row['Tables_in_'.$DB],'control_p_')===false)
			{
				$res=$this->deleteTableAndItsFiles($row['Tables_in_'.$DB]);
				$return.=$row['Tables_in_'.$DB].':<br/>'.$res.'<br/><br/>';
			}
		}
		$res2=$this->deleteAllPrivilegesAuto();
		$return.=$res2.'<br/><br/>';
		$res3=$this->addAllPrivilegesAuto();
		$return.=$res3;
		return $return;
		
	}
	function deleteAllPrivilegesAuto()//automaticaly add all the pages to the privilege table and also asign them to the super control_p_admin with id=1 and make the basic menu for all pages
	{
		$c=mysql_query('TRUNCATE TABLE `control_p_privilege_to_group`');
		$b=mysql_query('TRUNCATE TABLE `control_p_page_levels`');
		$a=mysql_query('TRUNCATE TABLE `control_p_privilege`');
		
		if($a && $b && $c)
		{
		echo('Privileges Deleted<br/>--------------------------------<br/>');
		}
	}
	function addAllPrivilegesAuto()//automaticaly add all the pages to the privilege table and also asign them to the super control_p_admin with id=1 and make the basic menu for all pages
	{
		$i=0;
		if ($handle = opendir('../../index/')) 
		{
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") 
				{
					$Ffile=$file;
					$itemPage=true;
					if(stripos($file,'add')!==false && $file!='address.php')
					{
						$Ffile=strtolower(substr($file,3));
						$itemPage=false;
					}
					if(stripos($file,'edit')!==false)
					{
						$Ffile=strtolower(substr($file,4));
						$itemPage=false;
					}
					$sql='INSERT INTO control_p_privilege (name) VALUES ("'.substr($file,0,-4).'")';
					$sql1='INSERT INTO control_p_privilege (name) VALUES ("delete_'.substr($file,0,-4).'")';
					if($itemPage)
					{
						mysql_query($sql1);
					}
					$sql3='INSERT INTO control_p_page_levels (page,menu_display_names,menu_pages) VALUES ("'.substr($file,0,-4).'","'.$this->toView(substr($Ffile,0,-4)).'","'.substr($Ffile,0,-4).'")';
					if(mysql_query($sql))
					{
						//$sql2='INSERT INTO control_p_privilege_to_group (control_p_group_id,control_p_privilege_id) VALUES ("0","'.$id.'")';
							mysql_query($sql3);
							$i++;
						
					}
					else
					{
						die('Error Filling Database(Group Privileges)');
					}
					
				}
			}
			closedir($handle);
			echo($i.' Privilege(s) Added<br/>--------------------------------<br/>');
		}
	}
	function getSeqArray($page)
	{
		if(!$this->checkTableIfExist('control_p_seq'))
		{
			return false;
		}
		$sql='SELECT * FROM `control_p_seq` WHERE `page_name`="'.$page.'"';
		$result=mysql_query($sql);
		if(mysql_num_rows($result)==1)
		{
			$row=mysql_fetch_assoc($result);
			if($row['seq_array']!='')
			{
				eval($row['seq_array']);
				if(isset($seq))
				{
					if(is_array($seq))
					{
						return $seq;
					}
				}
			}
		}
		return false;
	}
	function checkTableIfExist($table)//check table if exist in db
	{
		if(mysql_query('SELECT * FROM `'.$table.'`'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function checkColumnIfExist($column,$table)//check table if exist in db
	{
		if(mysql_query('SELECT '.$column.' FROM `'.$table.'`'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function capitalize($data)
	{
		$item=ucfirst(strtolower($data));
		return $item;
	}
	function composeSelectBox($data)
	{
		
		if($pos=strrpos($data,'_id'))
		{
			$table=substr($data, 0, $pos);
			if($this->hasLanguage($table))
			{
				$filter1['filterBy']='language_id';
				$filter1['keyword']=1;
				$filter1['exact']=true;
				$filterData['multiFilterBy'][]=$filter1;
				$item=$this->getAllGeneralItemsWithJoins($filterData,$table);
				if(!$item)
				{
					$item=true;
				}
			}
			else
			{
				$item=$this->getAllGeneralItemsWithJoins('',$table);
				if(!$item)
				{
					$item=true;
				}
			}
			return $item;
		}
		else
		{
			return false;
		}
	}
	function composeSelectBoxWithFilter($data,$filterData)
	{
		
		if($pos=strrpos($data,'_id'))
		{
			$table=substr($data, 0, $pos);
			$item=$this->getAllGeneralItemsWithJoins($filterData,$table);
			if(!$item)
			{
				$item=true;
			}
			return $item;
		}
		else
		{
			return false;
		}
	}
	function showPercentage($data)
	{
		$view='<span style="width=50px;float:left!important" >'.$data['percent'].'% </span><span style="width=200px;height:15px;border:1px solid grey;float:right!important" >';
		for($i=0;$i<$data['percent'];$i++)
		{
			$view=$view.'<img height="7px" width="2px" src="..\public\design-images\percentage.JPG" >';
		}
		for($j=0;$j<(100-$data['percent']);$j++)
		{
			$view=$view.'<img height="7px" width="2px" src="..\public\design-images\percentageLeft.JPG" >';
		}
		$view=$view.'</span>';
		return $view;
	}
/*	function showPercentage($data)
	{
		$view=$data['percent'].'%';
		return $view;
	}*/
	function showValue($data,$keyId)//show the name() instead of showing the id in the vew page, this function tests the value if it is an id or name :give the function $data['id'],$data['lang'] .. to get acurate language result 
	{
		//$this->show($data);
		setlocale(LC_CTYPE,'arabic');
		if($pos=strrpos($keyId,'_id'))
		{
			$table=substr($keyId, 0, $pos);
			if(is_array($data))
			{
				$item=$this->getGeneralItemByIdAndLangId($data['id'],$data['lang'],$table);
				if(isset($item[$data['id']][$this->getTableDisplayName($table,'')]))
				{
					return $this->capitalize($item[$data['id']][$this->getTableDisplayName($table,'')]);
				}
				else 
				{
					return 'Root';
				}
			}
			else
			{
				$item=$this->getGeneralItemById($data,$table);
				if(isset($item[$data][$this->getTableDisplayName($table,'')]))
				{
					if($this->getTableDisplayName($table,'')=='first_name')
					{
						$all=$this->capitalize($item[$data]['id']);
						$all.=': ';
						$all.=$this->capitalize($item[$data]['first_name']);
						$all.=' ';
						$all.=$this->capitalize($item[$data]['last_name']);
						return $all;
					}
					else
					{
						return $this->capitalize($item[$data][$this->getTableDisplayName($table,'')]);
					}
				}
				else 
				{
					return 'Root';
				}
			}
		}
		else
		{
			if(is_array($data))
			{
				return $data['id'];
			}
			else
			{
				if($keyId=='description')
				{
					return ucfirst($data);
				}
				return $this->capitalize($data);
			}
		}
	}
	function getGeneralParentId($data,$table)
	{
		if(isset($data['column']) && isset($data['id']) && isset($table))
		{
			$sql='SELECT '.$data['column'].' FROM `'.$table.'` WHERE id="'.$data['id'].'"';
			if($result=mysql_query($sql))
			{
				$row=mysql_fetch_assoc($result);
				$item=$row[$data['column']];
				return $item;
			}
			else
			{
				return 'Empty';
			}
		}
		else
		{
			return 'Empty';
		}
	}
	
	function isForien($data)//this function check if the column name $data is a forien key or not
	{
		if($pos=strrpos($data,'_id'))//if forien it returns ForienTableName_ForienTableDisplayName to be used on view page or search
		{
			$table=substr($data, 0, $pos);
			$item['show']=$table.'_'.$this->getTableDisplayName($table,'');//this output is used in the view composition
			if($this->checkTableIfExist($table.'_language'))
			{
				$item['sql']='`'.$table.'_language'.'`.`'.$this->getTableDisplayName($table,'').'`';//this output is used in sql composition
			}
			else
			{
				$item['sql']='`'.$table.'`.`'.$this->getTableDisplayName($table,'').'`';//this output is used in sql composition
			}
			$item['table']=$table;
			return $item;
		}
		else// if it is not a forien key
		{
			return false;
		}
	}
	function isOptional($id,$table)//return whether the column is optional or not
	{
		$cols=$this->getGeneralColums($table);
		if($cols['keys'][$id]['Null']=='NO')
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	/*
	Function to get the display name(s) of the table
	- $table : the table to get the data from
	- $data['multiple'] : boolean to ask for muliple display names if exist or only one of them
	*/
	function getTableDisplayName($table,$data)// returns the column that represents the table in the view from indexes in table ..  if not found .. check field "name" if exist and return "name" .. if also not exist .. return primary key
	{
			
			if(!is_array($data))
			{
				$data['multiple']=false;
			}
			else
			{
				if(!isset($data['multiple']))
				{
					$data['multiple']=false;
				}
			}
			
			$cols=$this->getGeneralColums($table);
			$PRI=$cols['primaryKeys'];
			$PRI=$PRI[0];
			if($this->checkTableIfExist($table.'_language'))
			{
				$sql='SHOW KEYS FROM `'.$table.'_language'.'` WHERE Key_name="display_name"';
			}
			else
			{
				$sql='SHOW KEYS FROM `'.$table.'` WHERE Key_name="display_name"';
			}
			$result = mysql_query($sql);
			$row='';
			while($row0 = mysql_fetch_assoc($result))
			{	
				$row[] = $row0;
			}
			if($row)
			{
				if(count($row)>1 && $data['multiple'])
				{
					foreach($row as $Cid=>$Cvalue)
					{
						$return[]=$Cvalue['Column_name'];
					}
					return $return;
				}
				else
				{
					return $row[0]['Column_name'];
				}
			}
			else
			{
				if($this->checkTableIfExist($table.'_language'))
				{
					$sql='SHOW COLUMNS FROM `'.$table.'_language` WHERE Field="name"';
				}
				else
				{
					$sql='SHOW COLUMNS FROM `'.$table.'` WHERE Field="name"';
				}
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if($row)
				{
					return 'name';
				}
				else
				{
					return $PRI;
				}
			}
		
	}
	/* missing language case */
	function GetFullDisplayName($id,$table)
	{
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		$item=$this->GetGeneralItemById($id,$table);
		$item=$item[$id];
		$display_name_value='';
		$display_name0='';
		$data['multiple']=true;
		$display_name=$this->getTableDisplayName($table,$data);
		//var_dump($item);
		if(is_array($display_name))
		{
			foreach($display_name as $idDN=>$dataDN)
			{
				$display_name0[]=$item[$dataDN];
			}
			$display_name_value=implode(' ',$display_name0);
		}
		else
		{
			$display_name_value=$item[$display_name];
		}
		return $display_name_value;
	}
/*	function getTableDisplayName($table)// returns the column that represents the table in the view from indexes in table ..  if not found .. check field "name" if exist and return "name" .. if also not exist .. return primary key
	{
			$cols=$this->getGeneralColums($table);
			$PRI=$cols['primaryKeys'];
			$PRI=$PRI[0];
			
			$sql='SHOW KEYS FROM `'.$table.'` WHERE Key_name="display_name"';
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			if($row)
			{
				return $row['Column_name'];
			}
			else
			{
				//return 'id';
				$sql='SHOW COLUMNS FROM `'.$table.'` WHERE Field="name"';
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if($row)
				{
					return 'name';
				}
				else
				{
					return $PRI;
				}
			}
		
	}*/
	function getColumnIndex($column,$table)// returns the column that represents the table in the view from indexes in table ..  if not found .. check field "name" if exist and return "name" .. if also not exist .. return primary key
	{
			$sql='SHOW KEYS FROM `'.$table.'` WHERE Column_name="'.$column.'"';
			
			$result = mysql_query($sql);
			if(mysql_num_rows($result)>0)
			{ 
				$row = mysql_fetch_assoc($result);
				return $row['Key_name'];
			}
			else
			{
				return $column;
			}
		
	}
	function getIdByName($name,$table)
	{
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		$sql='SELECT '.$PRI.' FROM `'.$table.'` WHERE name="'.$name.'"';
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		if($row)
		{
			return $row[$PRI];
		}
		else
		{
			return false;
		}
	}
	function isAllowed($data)//check if the inputs control_p_group and page name exists in the table control_p_privilege_to_group
	{
		if($data['control_p_group_id']==0)
		{
			return true;
		}
		$table='control_p_privilege_to_group';
		$data2['control_p_privilege_id']=$this->getIdByName($data['control_p_privilege'],'control_p_privilege');
		$data2['control_p_group_id']=$data['control_p_group_id'];
		$res=$this->checkGeneralItemIfExist($id='0',$data2,$table);
		if(!empty($res))
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	function isAllowed_2($x,$y)//(same as isAllowed function different input type )check if the inputs control_p_group and page name exists in the table control_p_privilege_to_group
	{
		if($x==0)
		{
			return true;
		}
		$data['control_p_group_id']=$x;
		$data['control_p_privilege']=$y;
		$table='control_p_privilege_to_group';
		$data2['control_p_privilege_id']=$this->getIdByName($data['control_p_privilege'],'control_p_privilege');
		$data2['control_p_group_id']=$data['control_p_group_id'];
		$res=$this->checkGeneralItemIfExist($id='0',$data2,$table);
		if(!empty($res))
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	function getViewColumns($table)//returns the number of columns displayed when viewing the table
	{
		$sql='SELECT columns FROM control_p_table_view_columns WHERE table_name="'.$table.'" LIMIT 1';
		$result = mysql_query($sql);
		if($row = mysql_fetch_assoc($result))
		{
			return $row['columns'];
		}
		else//in case the number of cols not defined use 5 as default
		{
			return '5';
		}
	}
	function toView($data)//remove "_" and capitalize first letter of th input word and remove "id" if its forien 
	{//var_dump($data);

		if(strpos($data,'control_p_')!==false)
		{
			$data=str_replace('control_p_','',$data);
		}
		$tempItem=explode("_",$data);
		for($i=0 ;$i<count($tempItem) ;$i++)
		{
			if($tempItem[$i]!='id')
			{
				if(substr($tempItem[$i], 0, 4)=='edit')
				{
					$tempItem[$i]='edit '.substr($tempItem[$i], 4);
				}
				if(substr($tempItem[$i], 0, 3)=='add' && $tempItem[$i]!='address' && $tempItem[$i]!='additional')
				{
					$tempItem[$i]='add '.substr($tempItem[$i], 3);
				}
				$tempItem[$i]=ucfirst($tempItem[$i]);
			}
			else
			{
				$tempItem[$i]='';
			}
		}
		$item=implode(" ",$tempItem);
		return $item;
	}
	function getGeneralColums($table)
	{
		$sql ='SHOW COLUMNS FROM `'.$table.'`';
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{	
			$item['keys'][$row['Field']] = $row; // fill up the array
		}//var_dump($row);die();
		foreach($item['keys'] as $keyId=>$keyValue)
		{
			if($keyId!='password')
			$item['filterKeys'][$keyId]=$keyValue;
		}
		foreach($item['keys'] as $keyId2=>$keyValue2)
		{
			if($keyValue2['Key']=='PRI')
			{
				$item['primaryKeys'][$keyId2]=$keyValue2['Field'];
			}
		}
		$item['primaryKeys']=array_values($item['primaryKeys']);
		//var_dump($item['primaryKeys']);
	
		return $item; // array must return something 	
		
	}
	function getGeneralIndexes($table)
	{
		$item=array();
		$sql ='SHOW INDEX FROM `'.$table.'`';
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{	
			$item[]= $row; // fill up the array
		}//var_dump($row);die();
		return $item; // array must return something 	
		
	}
	function getGeneralUniqueIndexes($table)
	{
		$item='';
		$sql ='SHOW INDEX FROM `'.$table.'` WHERE `Non_unique`="0" ';
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			$item[$row["Key_name"]][]=$row ;
		}//var_dump($row);die();
		return $item; // array must return something 	
		
	}
	function getMenuList($data)//get the roots that this this page belongs to ... in an array with each "page" and its "display_name"
	{
		$menu=array();
		$filterData['filterBy']='page';
		$filterData['keyword']=$data['page'];
		$column=$this->getGeneralColums('control_p_page_levels');
		$filterData['filterKeys']=$column['filterKeys'];
		if($row=$this->getAllGeneralExactItemsWithJoins($filterData,'control_p_page_levels'))
		{
			foreach($row as $id=>$value)
			{
				$menu['menu_display_names']=explode("-", $value['menu_display_names']);
				$menu['menu_pages']=explode("-", $value['menu_pages']);
			}
		}
		else
		{
			$menu['menu_pages']=explode("-", $data['page']);
			$menuTemp=explode("-", $data['page']);
			foreach($menuTemp as $id2=>$value2 )
			{
				$menu['menu_display_names'][$id2]=$this->toView($value2);
			}
		}
		
		return $menu;
	}
	function deleteGeneralItems($data,$table)
	{ //var_dump($data);die();
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		$imageExist=array();
		$item_images=false;
		$images=false;
		foreach($cols['keys'] as $key1=>$value1)// check if the table has an image in order to delete it too
		{
			if($key1=='image_id')//direct id link to the image
			{
				$imageExist[]=$key1;
			}
		}
		if($this->checkTableIfExist('image_to_'.$table))//table joining the image with table (multiple images)
		{
			$imageExist[]='table';
		}
		if(!is_array($data))
		{
			return false;
		}
		$fillSQL='';
		foreach ($data as $key => $value)
		{
			if($value!='0')
			{
				if(array_search('image_id', $imageExist)!==false)//get the name of the images before the item is deleted
				{
					$item=$this->getGeneralItemById($value,$table);
					$idImage=$item[$value]['image_id'];
					$images[]=$idImage;
					$imgItem=$this->getGeneralItemById($idImage,'image');
					$imagesFiles[]=$imgItem[$idImage]['name'];
				}
				if(array_search('table', $imageExist)!==false)//get the name of the images before the item is deleted
				{
					$data2['column']=$table;
					$data2['value']=$value;
					$itemImages=$this->getGeneralIdByForeignId($data2,'image_to_'.$table);// get the ids of the images related to this item
					foreach($itemImages as $key4=>$value4)
					{
						$item_images[]=$value4;
					}
				}
				if($fillSQL=='')
				{
					$fillSQL=$fillSQL.'WHERE '.$PRI.'="'.$value.'" ';
				}
				else
				{
					$fillSQL=$fillSQL.'OR '.$PRI.'="'.$value.'" ';
				}
			}
		}
		if($fillSQL=='')
		{
			return true;
		}
		$sql = 'DELETE FROM `'.$table.'` '.$fillSQL;
		if ($result = mysql_query($sql))
		{
			if($images)//delete the images from database and from images folder
			{
				$this->deleteGeneralItems($images,'image');
				foreach($imagesFiles as $key3=>$value3)
				{
					$this->deleteImageFile($value3);
				}
			}
			if($item_images)//get the name of the images before the item is deleted
			{
				$this->deleteGeneralItems($item_images,'image_to_'.$table);
			}
			return true;
		}
		else
		{
			return false;
		}
	}
	function deleteOrfanImages($data,$table)
	{ /*vardump($data); die();*/
		if(count($data))
		{
			foreach($data as $ind=>$id)
			{
				$imgItem=$this->getGeneralItemById($id,'image');
				$this->deleteImageFile($imgItem[$id]['name']);
			}
			$this->deleteGeneralItems($data,'image');
		}
		else 
		{ /*vardump($data); die();*/ }
	}
	function getGeneralIdByForeignId($data,$table)
	{
		
		$item=array();
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		$sql='SELECT `'.$PRI.'` FROM `'.$table.'` WHERE `'.$data["column"].'_id`="'.$data['value'].'" ';
		$result=mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{	
			$item[] = $row[$PRI];
		}
		return $item;
		
	}
	function deleteImageFile($name)
	{	
		if($name!='default.jpg')
		{
			$dir='../../../public/images/'.$name;
			$thumbDir='../../../public/images/thumbs/'.$name;
			if(unlink($dir) && unlink($thumbDir))
			{
				return TRUE;
			}
		}
	}
	function checkIdIfExist($id,$table)
	{
		$item = array();
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];//this is the primary key default id
		$sql = 'SELECT '.$PRI.' FROM `'.$table.'` WHERE '.$PRI.'="'.$id.'"'; // change by function
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row[$PRI]] = $row; // fill up the array
		}
		return $item; // array must return something 	
	}
	function checkIfExist($value,$column,$table)
	{
		$item = array();
		if(!$this->checkTableIfExist($table))
		{
			return $item;
		}
		$sql = 'SELECT `'.$column.'` FROM `'.$table.'` WHERE `'.$column.'`="'.$value.'"'; // change by function
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row[$column]] = $row; // fill up the array
		}
		return $item; // array must return something 	
	}
//************************************************************************************************
	/*
	function getAllItems($status='all',$table) 
	{
		if($status=='all')
		{
			$sql2='';
		}	
		else
		{
			$sql2 ='WHERE status = "'.addslashes($status).'"'; 
		}
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT id , name  FROM `'.$table.'` '.$sql2; // change by function
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row['id']] = $row; // fill up the array
		}
		return $item; // array must return something 	
	}
	
	// gets item with specific id    TESTED
	function getItemById($id,$table) 
	{
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT id,name ,status FROM `'.$table.'` WHERE id = "'.$id.'"'; // change by function
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row['id']] = $row; // fill up the array
		}
		return $item; // array must return something 	
	}

	//get the item id of the specified name or  returns id  
	function getItemId($data,$table)
	{
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT id FROM `'.$table.'` WHERE name = "'.$data['name'].'" LIMIT 1 '; // change by function
		$result = mysql_query($sql); // use it to fetch
		$row = mysql_fetch_assoc($result);
		{	
			$item= $row['id']; // fill up the array
		}
		
		return $item; // array must return something 	
	}

	//get the item id of the specified mane returns id  
	function checkItemIfExist($id,$data,$table)
	{
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT id FROM `'.$table.'` WHERE ( name = "'.$data['name'].'" AND id!="'.$id.'")'; // change by function
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item= $row['id']; // fill up the array
		}
		
		return $item; // array must return something 	
	}
	
	//edit item with the specified id
	function editItem($id,$data,$table)   //$name_en,$name_ar
	{
		if($data['name']=='')
		{
			return FALSE;
		}
		$sql = 'UPDATE `'.$table.'` SET  name="'.addslashes($this->capitalize($data['name'])).'" , status="'.addslashes($data['status']).'" WHERE id="'.$id.'"';
		if ($result = mysql_query($sql))
		{
			return TRUE ;
		}
	}

	//add new item         TESTED
	function addItem($data,$table)   //$name_en,$name_ar 
	{
		if($data['name']=='')
		{
			return FALSE;
		}
		else
		{
			$sql = 'INSERT INTO '.$table.'( name, status) VALUES ( "'.addslashes($this->capitalize($data['name'])).'","'.addslashes($data['status']).'")';
			if ($result = mysql_query($sql))
			{
				return $id=mysql_insert_id();
			}
		}
	}

//**********************************************  add simple item functions **************************
	//add new Child item
	function addChildItem($data,$table,$parentTable)    //$data[] contain the name and status ,and $table is the table itself and the $parentTable is the parent table for this table
	{
		$sql = 'INSERT INTO '.$table.'( name,'.$parentTable.'_id, status) VALUES ( "'.addslashes($this->capitalize($data['name'])).'","'.addslashes($data[''.$parentTable.'_id']).'","'.addslashes($data['status']).'")';
		if ($result = mysql_query($sql))
			{
				return $id=mysql_insert_id();
			}
	}

	function editChildItem($id,$data,$table,$parentTable)
	{ 
		$sql = 'UPDATE `'.$table.'` SET  status="'.addslashes($data['status']).'",name="'.addslashes($data['name']).'",'.$parentTable.'_id="'.addslashes($data[$parentTable.'_id']).'" WHERE id="'.addslashes($id).'"';
		if ($result = mysql_query($sql))
		{
			return TRUE ;
		}
	
	}
	
	//get the country id of the specified mane returns id  
	function checkChildItemIfExist($id,$data,$table,$parentTable)
	{
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT id FROM `'.$table.'` WHERE ( name = "'.addslashes($data['name']).'" AND '.$parentTable.'_id="'.addslashes($data[$parentTable.'_id']).'") AND id!="'.addslashes($id).'"'; // change by function
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item= $row['id']; // fill up the array
		}
		
		return $item; // array must return something 	
	}	

	//get the city of the specified id   TESTED
	function getChildItemById($id,$table,$parentTable)
	{
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT id,name,'.$parentTable.'_id ,status FROM `'.$table.'` WHERE id = "'.addslashes($id).'"'; // change by function
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row['id']] = $row; // fill up the array
		}
		return $item; // array must return something 	
	}
		
	//get the city id of the specified username returns id  
	function getChildItemId($data,$table,$parentTable)
	{
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT id FROM `'.$table.'` WHERE name = "'.addslashes($data['name']).'"  AND '.$parentTable.'_id = "'.addslashes($data[$parentTable.'_id']).'" LIMIT 1 '; // change by function
		$result = mysql_query($sql); // use it to fetch
		$row = mysql_fetch_assoc($result);
		{	
			$item= $row['id']; // fill up the array
		}
		
		return $item; // array must return something 	
	}
	
	//get all the ACTIVE cities by default  TESTED
	function getAllChildItems($parentId,$status='all',$table,$parentTable)
	{
		if($status=='all')
		{
			$sql2='';
		}	
		else
		{
			$sql2 =' AND status = "'.addslashes($status).'"'; 
		}
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT id , name  FROM `'.$table.'` WHERE '.$parentTable.'_id ="'.addslashes($parentId).'"'.$sql2; // change by function
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row['id']] = $row; // fill up the array
		}
		return $item; // array must return something 	
	}
	*/
//*****************************************************end of child item functions *********************
	function getAllGeneralItemsWith2KeysWithJoins($filterData,$table)//return the same as getAllGeneralItemsWithJoins if the primary keys =1 and  if the primary keys =2
	{
		if(!is_array($filterData))//if there is $filterData given is not array
		{
			$filterData= Array();
		}
			$column=$this->getGeneralColums($table);
			$filterData['filterKeys']=$column['filterKeys'];


//***************************************************************************************
		if(isset($filterData['limit']))//if there is paging or limit on output
		{
			$limit=$filterData["limit"];
		}
		else//empty stinr will be added to the end of sql
		{
			$limit='';
		}
//***************************************************************************************
		if($this->checkTableIfExist($table.'_language'))
		{
			$tableLang=$table.'_language';
			$dispN=$this->getTableDisplayName($tableLang,'');
		}
		else
		{
			$tableLang=false;
		}
		if(isset($filterData['orderBy']))//if there is a filter by set
		{
			if($filterData['orderBy']!='')
			{
				$nowTable=$table;
				if(!$this->checkColumnIfExist($filterData['orderBy'],$table))
				{
					$nowTable=$tableLang;
				}
				$orderBy='ORDER By `'.$nowTable.'`.`'.$filterData["orderBy"].'` '.$filterData["order"];
			}
			else
			{
				$orderBy='';
			}
		}
		else//case wont be executed cuz by default the variable id defined as null is the page
		{
			$orderBy='';
		}

//***************************************************************************************
		if( isset($filterData['multiFilterBy']))//if there is a filter by set
		{
			if(!isset($filterData['multiFilterBy']))// if the mutliFilterBy data is not set (just 1 filter)
			{
				/*if($filterData['filterBy']!='all')//if filter is not set to default
				{
					if($res=$this->isForien($filterData['filterBy']))//if the key is forien then the key name will be changed to new name according to the output of the table
					{
						$filterBy='WHERE ('.$res['sql'].' LIKE "%'.$filterData["keyword"].'%" )';
					}
					else
					{
						$filterBy='WHERE (`'.$table.'`.`'.$filterData["filterBy"].'` LIKE "%'.$filterData["keyword"].'%" )';
					}
				}
				else
				{
					$i=1;
					foreach($filterData['filterKeys'] as $keyName=>$keyValue)//filterKeys are the names of the colomns of the table in db but without some elements like (password )
					{
						if($i==1)
						{
							$filterBy='WHERE ( ';
						}
						if($i<count($filterData['filterKeys']))
						{
							if($res=$this->isForien($keyName))//if the key is forien then the key name will be changed to new name according to the output of the table
							{
								$filterBy=$filterBy.' '.$res['sql'].' LIKE "%'.$filterData["keyword"].'%" OR ';
							}
							else
							{
								$filterBy=$filterBy.' `'.$table.'`.`'.$keyName.'` LIKE "%'.$filterData["keyword"].'%" OR ';
							}
						}
						else
						{
							if($res=$this->isForien($keyName))//if the key is forien then the key name will be changed to new name according to the output of the table
							{
								$filterBy=$filterBy.' '.$res['sql'].' LIKE "%'.$filterData["keyword"].'%"';
							}
							else
							{
								$filterBy=$filterBy.' `'.$table.'`.`'.$keyName.'` LIKE "%'.$filterData["keyword"].'%"';
							}
							$filterBy=$filterBy.' ) ';
						}
						$i++;
					}
				}*/
			}
			else//if the multiFilterData is set (multi filters)
			{
				$filters=count($filterData['multiFilterBy']);
				$filterBy='WHERE (';
				$x=1;
				foreach($filterData['multiFilterBy'] as $ind=>$filterDataChild)
				{
					if($filterDataChild['filterBy']!='all')
					{
						$like='%';
						$oparator=' LIKE ';
						$checkId=false;//if we want LIKE search && we didnt specifiy the search if on id or name ... default it will search the name
						if(isset($filterDataChild['exact']))
						{
							if($filterDataChild['exact']==true)
							{
								$like='';
								$oparator=' = ';
								$checkId=true;//if we want exact search && we didnt specifiy the search if on id or name ... default it will search the id
							}
						}
						if(isset($filterDataChild['searchId']))
						{
							if($filterDataChild['searchId']==true)
							{
								$checkId=true;
							}
						}
						if(($res=$this->isForien($filterDataChild['filterBy'])) && !$checkId)//if the key is forien (and we r using like) then the key name will be changed to new name according to the output of the table
						{
							$filterBy=$filterBy.' '.$res['sql'].$oparator.'"'.$like.$filterDataChild["keyword"].$like.'" ';
							//if($x!=$filters){ $filterBy=$filterBy.' AND '; }
						}
						else
						{
							$nowTable=$table;
							if(!$this->checkColumnIfExist($filterDataChild["filterBy"],$table))
							{
								$nowTable=$tableLang;
							}
							$filterBy=$filterBy.' `'.$nowTable.'`.`'.$filterDataChild["filterBy"].'`'.$oparator.'"'.$like.$filterDataChild["keyword"].$like.'" ';
							//if($x!=$filters){ $filterBy=$filterBy.' AND '; }
						}
					}
					else// in case one of the filters = all
					{
						$like='%';
						$oparator=' LIKE ';
						$checkId=false;//if we want LIKE search && we didnt specifiy the search if on id or name ... default it will search the name
						if(isset($filterDataChild['exact']))
						{
							if($filterDataChild['exact']==true)//if the search want the exact keyword (not like)
							{
								$like='';
								$oparator=' = ';
								$checkId=true;//if we want exact search && we didnt specifiy the search if on id or name ... default it will search the id
							}
						}
						if(isset($filterDataChild['searchId']))
						{
							if($filterDataChild['searchId']==true)//if the search want the exact keyword (not like)
							{
								$checkId=true;
							}
						}
						$i=1;
						$FDwithLang=$filterData['filterKeys'];
						if($tableLang)
							{
								
								$FDwithLang[$dispN]='';
							}
						foreach($FDwithLang as $keyName=>$keyValue)//filterKeys are the names of the colomns of the table in db but without some elements like (password )
						{
							if($i==1){$filterBy=$filterBy.' (';}
							if($i<count($FDwithLang))
							{
								if(($res=$this->isForien($keyName)) && !$checkId)//if the key is forien  (and we r using like) then the key name will be changed to new name according to the output of the table
								{
									$filterBy=$filterBy.' '.$res['sql'].$oparator.'"'.$like.$filterDataChild['keyword'].$like.'" OR ';
								}
								else
								{
									$nowTable=$table;
									if(!$this->checkColumnIfExist($keyName,$table))
									{
										$nowTable=$tableLang;
									}
									$filterBy=$filterBy.' `'.$nowTable.'`.`'.$keyName.'`'.$oparator.'"'.$like.$filterDataChild['keyword'].$like.'" OR ';
								}
							}
							else
							{
								if(($res=$this->isForien($keyName)) && !$checkId)//if the key is forien then the key name will be changed to new name according to the output of the table
								{
									$filterBy=$filterBy.' '.$res['sql'].$oparator.'"'.$like.$filterDataChild['keyword'].$like.'")';
								}
								else
								{
									$nowTable=$table;
									if(!$this->checkColumnIfExist($keyName,$table))
									{
										$nowTable=$tableLang;
									}
									$filterBy=$filterBy.' `'.$nowTable.'`.`'.$keyName.'`'.$oparator.'"'.$like.$filterDataChild['keyword'].$like.'")';
								}
							}
							$i++;
						}
					}
					if($x==$filters){ $filterBy=$filterBy.' ) '; }else{ $filterBy=$filterBy.' AND '; }
					$x++;
				}
				
			}
		}
		else//case wont be executed cuz by default the variable id defined as null is the page
		{
			$filterBy='';
		}
//***************************************************************************************

//***************************************************************************************
		$joinsSelect='';
		$joinsInner='';
		//$joinsFrom='';
		foreach($filterData['filterKeys'] as $keyName=>$keyValue)//filterKeys are the names of the colomns of the table in db but without some elements like (password )
				{
					if($pos=strrpos($keyName,'_id'))
					{
						$forienTable=substr($keyName, 0, $pos);
						$forienTableO=$forienTable;
						if($forienTable!=$table)//in case the table hase parent_id and looks like TableName_id no joins then
						{
							$langJoin='';
							if( $this->checkTableIfExist($forienTableO.'_language'))//if this table has an extended language table it must innerjoin it and add  where lang to 1
							{
								$forienTable=$forienTableO.'_language';
								
								$colsO=$this->getGeneralColums($forienTableO);
								$PRIO=$colsO['primaryKeys'];
								$PRIO=$PRIO[0];
									
								if($table!=$forienTable)
								{
									$joinsInner=' INNER JOIN `'.$forienTable.'` ON (`'.$forienTable.'`.`'.$forienTableO.'_id` = `'.$forienTableO.'`.`'.$PRIO.'`)'.' AND ( `'.$forienTable.'`.language_id="1" ) '.$joinsInner;
								}
							}
							elseif($this->hasLanguage($forienTable))
							{
								$langJoin=' AND ( `'.$forienTable.'`.language_id="1" ) ';
							}
							$cols=$this->getGeneralColums($forienTable);
							$PRI=$cols['primaryKeys'];
							$PRI=$PRI[0];
							if(!isset($PRIO)){ $PRIO=$PRI; }
							$forienColumn=$this->getTableDisplayName($forienTable,'');
							//$joinsFrom=$joinsFrom.', '.$forienTable.' ';
							$joinsSelect=$joinsSelect.',`'.$forienTable.'`.`'.$forienColumn.'` AS `'.$forienTableO.'_'.$forienColumn.'` ';
							$joinsInner=' INNER JOIN `'.$forienTableO.'` ON (`'.$table.'`.`'.$forienTableO.'_id` = `'.$forienTableO.'`.`'.$PRIO.'`)'.$langJoin.$joinsInner;
						}
					}
				}
//***************************************************************************************
		$item = array(); // use it to avoid return false from database
		
		$cols=$this->getGeneralColums($table);
		$PRIS=$cols['primaryKeys'];
		$PRI=$PRIS[0];
		$allPRIS=count($cols['primaryKeys']);
		
		if($tableLang)
		{
			$joinsInner.=' INNER JOIN `'.$tableLang.'`
						ON (`'.$table.'`.`'.$PRI.'` = `'.$tableLang.'`.'.$table.'_id)
						AND(`'.$tableLang.'`.language_id="1") ';

			$joinsSelect.=', `'.$tableLang.'`.*';
		}
		$sql = 'SELECT `'.$table.'`.* '.$joinsSelect.'  FROM `'.$table.'` '.$joinsInner.' '.$filterBy.' '.$orderBy.' '.$limit; // change by function
		//if($table=='property_language') die($sql);
		$result = mysql_query($sql);

		//if(mysql_error()) $this->show(mysql_error());
		while($row = mysql_fetch_assoc($result))
		{	
			if($allPRIS==1)
			{
				$item[$row[$PRI]] = $row; // fill up the array
			}
			if($allPRIS==2)
			{
				$item[$row[$PRI]][$row[$PRIS[1]]] = $row;
			}
		}
		/*
		if($this->checkTableIfExist($table.'_language'))
		{
			foreach($item as $ind1=>$item1)
			{
				$itmLang=$this->getGeneralItemByIdAndLangId($item[$ind1][$PRI],'1',$table.'_language');
				$item[$ind1]=array_merge($itmLang[$ind1],$item[$ind1]);
			}
		}*/
		//if($table=='property') $this->show($sql);
		return $item; // array must return something 	
	}
	function getAllGeneralItemsWithJoins($filterData,$table)
	{
		$item=array();
		$cols=$this->getGeneralColums($table);
		$PRIS=$cols['primaryKeys'];
		$PRI=$PRIS[0];
		$allPRIS=count($cols['primaryKeys']);
		if($allPRIS==2)
		{
			$allItem=$this->getAllGeneralItemsWith2KeysWithJoins($filterData,$table);
			foreach($allItem as $id=>$value)
			{
				foreach($value as $id1=>$value1)
				{
					$item[]=$value1;
				}
			}
		}
		if($allPRIS==1)
		{
			$item=$this->getAllGeneralItemsWith2KeysWithJoins($filterData,$table);
		}
			//die(mysql_error());
		return $item; // array must return something 	
	}

	function getAllGeneralExactItemsWithJoins($filterData,$table)//this function filter result by exactly the value given (use = not like) and it filter forien table by ids too ex. project_id=2
	{
		if(!is_array($filterData))//if there is $filterData given is not array
		{
			$filterData= Array();
			$filterData['filterBy']='';
			$column=$this->getGeneralColums($table);
			$filterData['filterKeys']=$column['filterKeys'];
		}
		else//in case there is filter and keyword and no forien keys send
		{
			if(!isset($filterData['filterKeys']))
			{
				$column=$this->getGeneralColums($table);
				$filterData['filterKeys']=$column['filterKeys'];
			}
		}
//***************************************************************************************
		if(isset($filterData['limit']))//if there is paging or limit on output
		{
			$limit=$filterData["limit"];
		}
		else//empty stinr will be added to the end of sql
		{
			$limit='';
		}
//***************************************************************************************
		if(isset($filterData['orderBy']))//if there is a filter by set
		{
			if($filterData['orderBy']!='')
			{
				$orderBy='ORDER By '.$filterData["orderBy"].' '.$filterData["order"];
			}
			else
			{
				$orderBy='';
			}
		}
		else//case wont be executed cuz by default the variable id defined as null is the page
		{
			$orderBy='';
		}
//***************************************************************************************
		if($filterData['filterBy']!='')//if there is a filter by set
		{
			if(!isset($filterData['multiFilterBy']))// if the mutliFilterBy data is not set (just 1 filter)
			{
				if($filterData["keyword"]!="")
				{
					if($filterData['filterBy']!='all')//if filter is not set to default
					{
						if($res=$this->isForien($filterData['filterBy']))//if the key is forien then the key name will be changed to new name according to the output of the table
						{
							$filterBy='WHERE ('.$table.'.'.$filterData['filterBy'].' = "'.$filterData["keyword"].'" )';
						}
						else
						{
							$filterBy='WHERE ('.$table.'.'.$filterData["filterBy"].' = "'.$filterData["keyword"].'" )';
						}
					}
					else
					{
						$i=1;
						foreach($filterData['filterKeys'] as $keyName=>$keyValue)//filterKeys are the names of the colomns of the table in db but without some elements like (password )
						{
							if($i==1)
							{
								$filterBy='WHERE ( ';
							}
							if($i<count($filterData['filterKeys']))
							{
								if($res=$this->isForien($keyName))//if the key is forien then the key name will be changed to new name according to the output of the table
								{
									$filterBy=$filterBy.' '.$table.'.'.$keyName.' = "'.$filterData["keyword"].'" OR ';
								}
								else
								{
									$filterBy=$filterBy.' '.$table.'.'.$keyName.' = "'.$filterData["keyword"].'" OR ';
								}
							}
							else
							{
								if($res=$this->isForien($keyName))//if the key is forien then the key name will be changed to new name according to the output of the table
								{
									$filterBy=$filterBy.' '.$table.'.'.$keyName.' = "'.$filterData["keyword"].'"';
								}
								else
								{
									$filterBy=$filterBy.' '.$table.'.'.$keyName.' = "'.$filterData["keyword"].'"';
								}
								$filterBy=$filterBy.' ) ';
							}
							$i++;
						}
					}
				}
				else//the keyword is null and we r using equal not like so no results will be shown 
				{
					$filterBy='';
				}
			}
			else//if the multiFilterData is set (multi filters)
			{
				$filters=count($filterData['multiFilterBy']);
				$filterBy='WHERE (';
				$x=1;
				foreach($filterData['multiFilterBy'] as $filterDataChild['filterBy']=>$filterDataChild['keyword'])
				{
					if($res=$this->isForien($filterDataChild['filterBy']))//if the key is forien then the key name will be changed to new name according to the output of the table
					{
						$filterBy=$filterBy.' '.$table.'.'.$filterDataChild["filterBy"].'="'.$filterDataChild["keyword"].'" ';
						if($x!=$filters){ $filterBy=$filterBy.' AND '; }
					}
					else
					{
						$filterBy=$filterBy.' '.$table.'.'.$filterDataChild["filterBy"].'="'.$filterDataChild["keyword"].'" ';
						if($x!=$filters){ $filterBy=$filterBy.' AND '; }
					}
					$x++;
				}
				$filterBy=$filterBy.' )';
			}
		}
		else//case wont be executed cuz by default the variable id defined as null is the page
		{
			$filterBy='';
		}
//***************************************************************************************

//***************************************************************************************
		$joinsSelect='';
		//$joinsFrom='';
		$joinsInner='';
		foreach($filterData['filterKeys'] as $keyName=>$keyValue)//filterKeys are the names of the colomns of the table in db but without some elements like (password )
				{
					if($pos=strrpos($keyName,'_id'))
					{
						$forienTable=substr($keyName, 0, $pos);
						if($forienTable!=$table)//in case the table hase parent_id and looks like TableName_id no joins then
						{
							$cols=$this->getGeneralColums($forienTable);
							$PRI=$cols['primaryKeys'];
							$PRI=$PRI[0];
							$forienColumn=$this->getTableDisplayName($forienTable,'');
							//$joinsFrom=$joinsFrom.', '.$forienTable.' ';
							$joinsSelect=$joinsSelect.','.$forienTable.'.'.$forienColumn.' AS '.$forienTable.'_'.$forienColumn.' ';
							$joinsInner=' INNER JOIN `'.$forienTable.'` ON ('.$table.'.'.$forienTable.'_id = '.$forienTable.'.'.$PRI.')'.$joinsInner;
						}
					}
				}
		
//***************************************************************************************
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT `'.$table.'`.* '.$joinsSelect.'  FROM `'.$table.'` '.$joinsInner.' '.$filterBy.' '.$orderBy.' '.$limit; // change by function
		//die($sql);
		$result = mysql_query($sql); // use it to fetch
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row[$PRI]] = $row; // fill up the array
		}
		return $item; // array must return something 	
	}
	function getAllGeneralItems($status='all',$filterData,$table)
	{
		if(!is_array($filterData))//if there is $filterData given is not array
		{
			$filterData= Array();
		}
//***************************************************************************************
		if(isset($filterData['limit']))//if there is paging or limit on output
		{
			$limit=$filterData["limit"];
		}
		else//empty stinr will be added to the end of sql
		{
			$limit='';
		}
//***************************************************************************************
		if(isset($filterData['orderBy']))//if there is a filter by set
		{
			if($filterData['orderBy']!='')
			{
				$orderBy='ORDER By '.$filterData["orderBy"].' '.$filterData["order"];
			}
			else
			{
				$orderBy='';
			}
		}
		else//case wont be executed cuz by default the variable id defined as null is the page
		{
			$orderBy='';
		}
//***************************************************************************************
		if($filterData['filterBy']!='')//if there is a filter by set
		{
			if($filterData['filterBy']!='all')//if filter is not set to default
			{
				if($status=='all')//then there is no where in the sql statment
				{
					$filterBy='WHERE ('.$filterData["filterBy"].' LIKE "%'.$filterData["keyword"].'%" )';
				}
				else
				{
					$filterBy='AND ('.$filterData["filterBy"].' LIKE "%'.$filterData["keyword"].'%" )';
				}
			}
			else
			{
				$i=1;
				foreach($filterData['filterKeys'] as $keyName=>$keyValue)//filterKeys are the names of the colomns of the table in db but without some elements like (password )
				{
					if($i==1)
					{
						if($status=='all')
						{
							$filterBy='WHERE ( ';
						}
						else
						{
							$filterBy='AND ( ';
						}
					}
					elseif($i<count($filterData['filterKeys']))
					{
						$filterBy=$filterBy.' '.$keyName.' LIKE "%'.$filterData["keyword"].'%" OR ';
					}
					else
					{
						$filterBy=$filterBy.' '.$keyName.' LIKE "%'.$filterData["keyword"].'%"';
						$filterBy=$filterBy.' ) ';
					}
					$i++;
				}
			}
		}
		else//case wont be executed cuz by default the variable id defined as null is the page
		{
			$filterBy='';
		}
//***************************************************************************************
		if($status=='all')
		{
			$sql2='';
		}	
		else
		{
			$sql2 ='WHERE status = "'.addslashes($status).'"'; 
		}
//***************************************************************************************
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT *  FROM `'.$table.'` '.$sql2.' '.$filterBy.' '.$orderBy.' '.$limit; // change by function
		//var_dump($sql);die();
		$result = mysql_query($sql); // use it to fetch
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row[$PRI]] = $row; // fill up the array
		}
		return $item; // array must return something 	
	}
	
	// gets item with specific id    TESTED
	function getGeneralItemById($id,$table) 
	{
		$item = array(); // use it to avoid return false from database
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		if(!is_array($id))
		{
			if($this->checkTableIfExist($table.'_language'))
			{
				$table_lang=$table.'_language';
				$sql = 'SELECT `'.$table.'`.*,`'.$table_lang.'`.* FROM `'.$table.'`,`'.$table_lang.'` WHERE `'.$table_lang.'`.'.$table.'_id=`'.$table.'`.id AND`'.$table.'`.'.$PRI.' = "'.$id.'" '; // change by function
			}
			else
			{
				$sql = 'SELECT * FROM `'.$table.'` WHERE '.$PRI.' = "'.$id.'"'; // change by function
			}
		}
		else
		{
			if($this->checkTableIfExist($table.'_language'))
			{
				$table_lang=$table.'_language';
				$sql = 'SELECT `'.$table.'`.*,`'.$table_lang.'`.* FROM `'.$table.'`,`'.$table_lang.'` WHERE `'.$table_lang.'`.'.$table.'_id=`'.$table.'`.id AND`'.$table.'`.'.$PRI.' = "'.$id['id'].'" AND  `'.$table_lang.'`.`language_id` = "'.$id['language_id'].'"'; // change by function
			}
			else
			{
				$sql = 'SELECT * FROM `'.$table.'` WHERE '.$PRI.' = "'.$id['id'].'" AND  `language_id` = "'.$id['language_id'].'"'; // change by function
			}
			
		}
		//die($sql);
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row[$PRI]] = $row; // fill up the array
		}
		return $item; // array must return something 	
	}
	function getGeneralItemByIdAndLangId($id,$lang,$table) 
	{
		$item = array(); // use it to avoid return false from database
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		$sql = 'SELECT * FROM `'.$table.'` WHERE '.$PRI.' = "'.$id.'" AND `language_id`='.$lang; // change by function
		//die($sql);
		$result = mysql_query($sql); // use it to fetch
		while($row = mysql_fetch_assoc($result))
		{	
			$item[$row[$PRI]] = $row; // fill up the array
		}
		if(!$item && $lang!=1)
		{
			$item=$this->getGeneralItemByIdAndLangId($id,'1',$table);
		}
		//$this->show($item);
		return $item; // array must return something 
	}
	//get the item id of the specified name or  returns id  
	function getGeneralItemId($data,$table)
	{	
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		$fillSQL='';
		if(!is_array($data))
		{
			$data= array();
		}
		foreach ($data as $key => $value)
		{
			if($fillSQL=='')
			{
				$fillSQL=$fillSQL.'WHERE '.$key.'="'.$value.'" ';
			}
			else
			{
				$fillSQL=$fillSQL.'AND '.$key.'="'.$value.'" ';
			}
		}
		$item = array(); // use it to avoid return false from database
		$sql = 'SELECT '.$PRI.' FROM `'.$table.'` '.$fillSQL.' LIMIT 1 '; // change by function
		//die($sql);
		$result = mysql_query($sql); // use it to fetch
		$row = mysql_fetch_assoc($result);
		{	
			$item= $row[$PRI]; // fill up the array
		}
		
		return $item; // array must return something 	
	}

	//this function must return an id just if an inpunt of the values given by $data[] are already exists
	//otherwise it will return an empty array
	//give $id the id of the item being edited while editing,else $id=0 while adding new item
	//give $data['columnNameInDB']="inputValue"; fill all the required colomns
	function checkGeneralItemIfExist($id,$data0,$table)
	{	
		$item =''; // use it to avoid return false from database
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		$data0[$PRI]=$id;
		$indexes=$this->getGeneralUniqueIndexes($table);
		
		foreach($indexes as $ind =>$cols2)
		{
			$data=array();
			$missingInfo=false;
			foreach ($cols2 as $ind2 => $values)
			{
				if(!isset($data0[$values['Column_name']]))
				{
					$missingInfo=true;
					break;
				}
				$data[$values['Column_name']]=$data0[$values['Column_name']];
			}
			if(!$missingInfo && $ind!="PRIMARY") //break if not all the colums of the index_key given
			{
				if(!is_array($data))
				{
					$data= array();
				}
				$fillSQL='';
				foreach ($data as $key => $value)
				{
					$returnA[]=$key;
					if($fillSQL=='')
					{
						$fillSQL=$fillSQL.'WHERE (`'.$key.'`="'.addslashes($value).'" ';
					}
					else
					{
						$fillSQL=$fillSQL.'AND `'.$key.'`="'.addslashes($value).'" ';
					}
				}
				if($fillSQL!='')
				{
					$fillSQL=$fillSQL.') AND `'.$PRI.'`!="'.$id.'"';
					$sql = 'SELECT '.$PRI.' FROM `'.$table.'` '.$fillSQL; // change by function
					//if($table=="member") echo $sql.'<br/>';
					$result = mysql_query($sql); // use it to fetch
					while($row = mysql_fetch_assoc($result))
					{
						$item[]='('.implode(',',$returnA).')'; // return to user like "(phone,email,name)"
						unset($returnA);// not to effect the new loop term
					}
				}
			}
		}
		//if($table=="member") $this->show($item);
		if(is_array($item))
		{
		return implode(' Or ',$item);
		}
		else
		{
			return $item;
		}
	}
	
	function editGeneralItem($id,$data,$table)   //$name_en,$name_ar
	{
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		if(!is_array($data))
		{
			$data= array();
		}
		$fillSQL='';
		foreach ($data as $key => $value)
		{
			if($fillSQL=='')
				{
					if($key=='password')
					{
						if($value!='')
						{
							$fillSQL=$fillSQL.'SET `'.$key.'`=MD5("'.$value.'") ';
						}
					}
					else
					{
						$fillSQL=$fillSQL.'SET `'.$key.'`="'.addslashes($value).'" ';
					}
				}
				else
				{
					if($key=='password')
					{
						if($value!='')
						{
							$fillSQL=$fillSQL.', `'.$key.'`=MD5("'.$value.'") ';
						}
					}
					else
					{
						$fillSQL=$fillSQL.', `'.$key.'`="'.addslashes($value).'" ';
					}
				}
		}
		if($fillSQL=='')//
		{
			return false;
		}
		else
		{
			$fillSQL=$fillSQL.' WHERE '.$PRI.'="'.$id.'"';
		}
		$sql = 'UPDATE `'.$table.'` '.$fillSQL;
		
		if ($result = mysql_query($sql))
		{
			return TRUE ;
		}
		else
		{
			return FALSE ;
		}
	}

	function editGeneralItemByIdAndLangId($id,$data,$table)   //$name_en,$name_ar
	{
		if($this->hasLanguage($table))
		{
			$langId=' AND `language_id`='.$data['language_id'];
		}
		else
		{
			$langId='';
		}
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		if(!is_array($data))
		{
			$data= array();
		}
		$fillSQL='';
		foreach ($data as $key => $value)
		{
			if($fillSQL=='')
				{
					if($key=='password')
					{
						if($value!='')
						{
							$fillSQL=$fillSQL.'SET `'.$key.'`=MD5("'.$value.'") ';
						}
					}
					else
					{
						$fillSQL=$fillSQL.'SET `'.$key.'`="'.addslashes($value).'" ';
					}
				}
				else
				{
					if($key=='password')
					{
						if($value!='')
						{
							$fillSQL=$fillSQL.', `'.$key.'`=MD5("'.$value.'") ';
						}
					}
					else
					{
						$fillSQL=$fillSQL.', `'.$key.'`="'.addslashes($value).'" ';
					}
				}
		}
		if($fillSQL=='')//
		{
			return false;
		}
		else
		{
			$fillSQL=$fillSQL.' WHERE '.$PRI.'="'.$id.'"'.$langId;
		}
		$sql = 'UPDATE `'.$table.'` '.$fillSQL;
		
		if ($result = mysql_query($sql))
		{
			return TRUE ;
		}
		else
		{
			return FALSE ;
		}
	}

	function addGeneralItem($data,$table)
	{ 
		if($table=='background'){if(!isset($data['body_background_id'])) $data['body_background_id']=5; if($data['type_id']==0) $data['type_id']=11;}
		//$this->show($data);
		if(!is_array($data))
		{
			$data= array();
		}
		$fillSQLcol='';
		$fillSQLval='';
		foreach ($data as $key => $value)
		{
				if($fillSQLval=='')
				{if($key!='date_cr'){
				$fillSQLcol=$fillSQLcol.'`'.$key.'`';}
					if($key=='password')
					{
						$fillSQLval=$fillSQLval.'MD5("'.$value.'")';
					}
					else
					{if($key!='date_cr'){
					$fillSQLval=$fillSQLval.'"'.addslashes($value).'"';
						
					}
					}
				}
				else
				{if($key!='date_cr'){
				$fillSQLcol=$fillSQLcol.',`'.$key.'`';}
					if($key=='password')
					{
						$fillSQLval=$fillSQLval.',MD5("'.$value.'")';
					}
					else
					{if($key!='date_cr'){
					$fillSQLval=$fillSQLval.',"'.addslashes($value).'"';}
					}
				}
		}
		$sql = 'INSERT INTO `'.$table.'`('.$fillSQLcol.') VALUES ('.$fillSQLval.')';
		//die($sql);
		if ($result = mysql_query($sql))
		{
			if($id=mysql_insert_id())
			{
				return $id;
			}
			else
			{
				return true;
			}
		}
	}
	function editGeneralItemNewLang($id,$data,$table)   //$name_en,$name_ar
	{
		$cols=$this->getGeneralColums($table);
		$PRI=$cols['primaryKeys'];
		$PRI=$PRI[0];
		if(!is_array($data))
		{
			$data= array();
		}
		$data[$PRI]=$id;
		$fillSQLcol='';
		$fillSQLval='';
		if($this->checkColumnIfExist('image_id',$table))
		{
			$motherItem=$this->getGeneralItemById($id,$table);
			$data['image_id']=$motherItem[$id]['image_id'];
		}
		foreach ($data as $key => $value)
		{
				if($fillSQLval=='')
				{
					$fillSQLcol=$fillSQLcol.'`'.$key.'`';
					if($key=='password')
					{
						$fillSQLval=$fillSQLval.'MD5("'.$value.'")';
					}
					else
					{
						$fillSQLval=$fillSQLval.'"'.addslashes($value).'"';
					}
				}
				else
				{
					$fillSQLcol=$fillSQLcol.',`'.$key.'`';
					if($key=='password')
					{
						$fillSQLval=$fillSQLval.',MD5("'.$value.'")';
					}
					else
					{
						$fillSQLval=$fillSQLval.',"'.addslashes($value).'"';
					}
				}
		}
		$sql = 'INSERT INTO `'.$table.'`('.$fillSQLcol.') VALUES ('.$fillSQLval.')';
		//die($sql);
		if ($result = mysql_query($sql))
		{
			if($id=mysql_insert_id())
			{
				return $id;
			}
			else
			{
				return true;
			}
		}
	}
	function hasFiles($table)
	{
		$result=$this->checkIfExist($table,'table','files');
		return $result;
	}
	function hasImages($table)
	{
		$result=$this->checkTableIfExist('image_to_'.$table);
		return $result;
	}
	function hasLanguage($table)
	{
		if(mysql_query('SELECT language_id FROM `'.$table.'`'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function isLanguageDefined($data,$table)
	{
		if($result=mysql_query('SELECT `language_id` FROM `'.$table.'` WHERE `language_id`="'.$data['language_id'].'" AND `'.str_replace('_language','',$table).'_id`="'.$data['id'].'"'))
		{
			if(mysql_num_rows($result))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	function uploadFile($data) // $name,$status 
	{
		if(is_uploaded_file($data['tmp_name']))
		{ 
			$new_name=date('d-m-y h-i-s A');
			$old_name=$data['name'];
			$strpos=strrpos($old_name,'.');
			$ext=substr($old_name,$strpos,strlen($old_name));
			$old_name=substr($old_name,0,$strpos);
			$new_name=$old_name.' '.$new_name.$ext;
			if(!file_exists('../../../public/files'))
			{
				mkdir('../../../public/files');
			}
			if(!file_exists('../../../public/files/'.$data['table']))
			{
				mkdir('../../../public/files/'.$data['table']);
			}
			if(!file_exists('../../../public/files/'.$data['table'].'/'.$data['id']))
			{
				mkdir('../../../public/files/'.$data['table'].'/'.$data['id']);
			}
			if(!file_exists('../../../public/files/'.$data['table'].'/'.$data['id'].'/'.$new_name))
			{
				if(move_uploaded_file($data['tmp_name'],'../../../public/files/'.$data['table'].'/'.$data['id'].'/'.$new_name))
				{
					return $new_name;
				}
				else
				{
					return false;
				}
			}
			
		}
		else
		{
			return false;
		}
	}
	function deleteFile($dir)
	{	
		$dir='../../../public/files/'.$dir;
		if(unlink($dir))
		{
			return TRUE;
		}
	}
	function send_one ($text, $subject, $name, $sender_email, $to)
	{
		
		$headers="From:$name <$sender_email>\r\n"; 
		$headers .= "Reply-To: $sender_email\r\n"; 
		$headers .= "Date: " . date("r") . "\r\n"; 
		$headers .= "Return-Path: $sender_email\r\n"; 
		$headers .= "MIME-Version: 1.0\r\n"; 
		$headers .= "Message-ID: " . date("r") . $name ."\r\n"; 
		$headers .= "Content-Type: text/html; charset=utf-8\r\n"; 
		$headers .= "X-Priority: 1\r\n"; 
		$headers .= "Importance: High\r\n"; 
		$headers .= "X-MXMail-Priority: High\r\n"; 
		$headers .= "X-Mailer: PHP Mailer 1.0\r\n"; 
		
		mail($to,$subject, $text, $headers);
		return true;
	}
	function getColType($col,$table)
	{
		$cols=$this->getGeneralColums($table);
		if(strpos($cols['keys'][$col]['Type'],'(')===false)
		{
			$item['type']=$cols['keys'][$col]['Type'];
			$item['length']='';
		}
		else
		{
			$item['type']=substr($cols['keys'][$col]['Type'],0,strpos($cols['keys'][$col]['Type'],'('));
			$item['length']=substr($cols['keys'][$col]['Type'],strpos($cols['keys'][$col]['Type'],'(')+1,-1);
		}
		return $item;
	}
	function getNextStep($page,$seq)
	{
		/*$item='end';
		if($this->checkTableIfExist('Control_p_page_levels'))
		{
			$sql='SELECT `next` FROM `Control_p_page_levels` WHERE page="'.$page.'"';
			$result=mysql_query($sql);
			if(mysql_num_rows($result)>0)
			{
				$row=mysql_fetch_assoc($result);
				if($row['next'])
				{
					$item=$row['next'];
				}
			}
		}
		return $item;*/
		$item='end';
		foreach($seq as $ind=>$data)
		{
			if($data['page']==$page)
			{
				if(isset($seq[$ind+1]))
				{
					$item=$seq[$ind+1]['page'];
				}
			}
		}
		return $item;
	}
	function getPrevStep($next,$seq)
	{
		/*$item='start';
		if($this->checkTableIfExist('Control_p_page_levels'))
		{
			$sql='SELECT `page` FROM `Control_p_page_levels` WHERE next="'.$next.'"';
			$result=mysql_query($sql);
			if(mysql_num_rows($result)>0)
			{
				$row=mysql_fetch_assoc($result);
				if($row['page'])
				{
					$item=$row['page'];
				}
			}
		}
		return $item;*/
		$item='start';
		foreach($seq as $ind=>$data)
		if($data['page']==$next)
		{
			if($data['col']!='start')
			{
				
				$item=$seq[$ind-1]['page'];
			}
		}//die($item);
		return $item;
		
	}
	function getParentPage($page)
	{
		$item=false;
		if($this->checkTableIfExist('Control_p_page_levels'))
		{
			$sql='SELECT `next` FROM `Control_p_page_levels` WHERE `page`="'.$page.'"';
			$result=mysql_query($sql);
			if(mysql_num_rows($result)>0)
			{
				$row=mysql_fetch_assoc($result);
				if($row['next'])
				{
					if($row['next'])
					$item=unserialize($row['next']);
				}
			}
		}
		return $item;
	}
//******************************************* end of general functions *******************************
	function getFolderPath($id)
	{
		$returnA=array();
		$return='';
		$folder=$this->getGeneralItemById($id,'control_p_folder');
		$folder=$folder[$id];
		$returnA[]=$folder['name'].'/';
		while($folder['control_p_folder_id']!=0)
		{
			$newId=$folder['control_p_folder_id'];
			$folder=$this->getGeneralItemById($newId,'control_p_folder');
			$folder=$folder[$newId];
			$returnA[]=$folder['name'].'/';
		}
		foreach(array_reverse($returnA) as $ind=>$val)
		{
			$return.=$val;
		}
		return $return;
	}
}
?>