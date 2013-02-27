<?php
include_once("config.php");
$result = '保存成功';
$configRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_config ORDER BY id");


if($SysConfig['filewrite']){
/*
----///  文件必需要有可写入权限
*/
	$str = '<?php
	$config = array();
	';
	while (!$configRs->EOF)
	{
		$configObj = $configRs->FetchObject();
		if (isset($_POST[$configObj->CODE]) && trim($_POST[$configObj->CODE])!="")
		{
			$SysConfig['customerdb']->Execute("UPDATE t_config SET value='".$_POST[$configObj->CODE]."' WHERE id=".$configObj->ID);
	
			$str .= '$config[\''.$configObj->CODE.'\'] = array(\'name\'=>\''.$configObj->NAME.'\',\'value\'=>\''.$_POST[$configObj->CODE].'\');
			';
	
		}
		else
		{
			$str .= '$config[\''.$configObj->CODE.'\'] = array(\'name\'=>\''.$configObj->NAME.'\',\'value\'=>\''.$configObj->VALUE.'\');
			';
		}
		$configRs->MoveNext();
	}
	$str .= '?>';
	
	$f = fopen(ROOTDIR.$_SESSION['SWEBADMIN_USERNAME']."/baseconfig.php","w+");
	fwrite($f,$str);
	fclose($f);
}else{
	while (!$configRs->EOF)
	{
		$configObj = $configRs->FetchObject();
		if (isset($_POST[$configObj->CODE]) && trim($_POST[$configObj->CODE])!="")
		{
			$SysConfig['customerdb']->Execute("UPDATE t_config SET value='".$_POST[$configObj->CODE]."' WHERE id=".$configObj->ID);
	
		}
		$configRs->MoveNext();
	}

}

echo json_encode(array('result'=>$result));
?>