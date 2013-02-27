<?
/*********************************************************
辅助函数
日期：08-05-09
人员：zjb
*********************************************************/

//网站用函数           start
//

function GetGlobalTitle($lan=""){
	
	global $maindb;
	$title="";
	$url=basename($_SERVER['PHP_SELF'],".php");
	
	$rd = $maindb->Execute("SELECT * FROM t_global WHERE Language=?", array($lan));
	if ($rd->RecordCount() > 0)
	{
		$global = $rd->FetchObject();
		$globaltitle=$global->TITLE;
	}
	$title=$globaltitle;
	
if($url!=""){
		
		$rd = $maindb->Execute("SELECT * FROM t_seo WHERE Url=?", array($url));
		
	if ($rd->RecordCount() > 0)
	{
		$seo = $rd->FetchObject();
		$title=$seo->TITLE."-".$globaltitle;
	}
		
	else{	
	
	
if(isset($_GET['nid'])){
	
	$rd = $maindb->Execute("SELECT * FROM t_news WHERE id=?", array($_GET['nid']));
	if ($rd->RecordCount() > 0)
	{
		$news = $rd->FetchObject();
		if($news->WEBTITLE!=""){
			$title=$news->WEBTITLE."-".$globaltitle;
		}
		
	}
	
	}else if(isset($_GET['pid'])){
		
		
	$rd = $maindb->Execute("SELECT * FROM t_products WHERE id=?", array($_GET['pid']));
	
	if ($rd->RecordCount() > 0)
	{
		$products = $rd->FetchObject();
		if($products->WEBTITLE!=""){
		$title=$products->WEBTITLE."-".$globaltitle;
		}
	}
		
	}
	}
}



return $title;
	
	
}


function GetGlobalKeywords($lan=""){
	
	global $maindb;
	$keywords="";
	$url=basename($_SERVER['PHP_SELF'],".php");
	
	$rd = $maindb->Execute("SELECT * FROM t_global WHERE Language=?", array($lan));
	if ($rd->RecordCount() > 0)
	{
		$global = $rd->FetchObject();
		$keywords=$global->KEYWORDS;
	}
	
if($url!=""){
		
		$rd = $maindb->Execute("SELECT * FROM t_seo WHERE Url=?", array($url));
		
	if ($rd->RecordCount() > 0)
	{
		$seo = $rd->FetchObject();
		$keywords=$seo->KEYWORDS;
	}
		
	else{	
	
	
if(isset($_GET['nid'])){
	
	$rd = $maindb->Execute("SELECT * FROM t_news WHERE id=?", array($_GET['nid']));
	if ($rd->RecordCount() > 0)
	{
		$news = $rd->FetchObject();
		
			$keywords=$news->WEBKEY;
		
	}
	
	}else if(isset($_GET['pid'])){
		
		
	$rd = $maindb->Execute("SELECT * FROM t_products WHERE id=?", array($_GET['pid']));
	
	if ($rd->RecordCount() > 0)
	{
		$products = $rd->FetchObject();
		$keywords=$products->WEBKEY;
	}
		
	}
	}
}

return $keywords;
	
	
}



function GetGlobalDescription($lan=""){
	
	global $maindb;
	$description="";
	$url=basename($_SERVER['PHP_SELF'],".php");
	
	$rd = $maindb->Execute("SELECT * FROM t_global WHERE Language=?", array($lan));
	if ($rd->RecordCount() > 0)
	{
		$global = $rd->FetchObject();
		$description=$global->DESCRIPTION;
	}
	
if($url!=""){
		
		$rd = $maindb->Execute("SELECT * FROM t_seo WHERE Url=?", array($url));
		
	if ($rd->RecordCount() > 0)
	{
		$seo = $rd->FetchObject();
		$description=$seo->DESCRIPTION;
	}
		
	else{	
	
	
if(isset($_GET['nid'])){
	
	$rd = $maindb->Execute("SELECT * FROM t_news WHERE id=?", array($_GET['nid']));
	if ($rd->RecordCount() > 0)
	{
		$news = $rd->FetchObject();
		
			$description=$news->WEBDESC;
		
	}
	
	}else if(isset($_GET['pid'])){
		
		
	$rd = $maindb->Execute("SELECT * FROM t_products WHERE id=?", array($_GET['pid']));
	
	if ($rd->RecordCount() > 0)
	{
		$products = $rd->FetchObject();
		$description=$products->WEBDESC;
	}
		
	}
	}
}
return $description;
	
	
}






function GetKeywords($lan="")
{
	$keywords = GetProductKeywords();
	if ($keywords == "")
	{
		$keywords = GetTypeKeywords();
	}
	if ($keywords == "")
	{
		$keywords = GetNewsKeywords();
	}
	if ($keywords == "")
	{
		$keywords = GetConfigKeywords($lan);
		if ($keywords == "")
		{
			$keywords = GetConfigKeywords();
		}
	}
	else
	{
		$keywords .= " - ".GetConfigKeywords($lan);
	}
	if ($keywords == "")
	{
		$keywords = GetCompany($lan);
	}

	return '<meta name="keywords" content="'.$keywords.'">';
}

function GetDescription($lan="")
{
	$desc = GetProductDescription();
	if ($desc == "")
	{
		$desc = GetTypeDescription();
	}
	if ($desc == "")
	{
		$desc = GetNewsDescription();
	}
	if ($desc == "")
	{
		$desc = GetConfigDescription($lan);
	}
	if ($desc == "")
	{
		$desc = GetCompany($lan);
	}

	return '<meta name="description" content="'.$desc.'">';
}

function GetCompany($lan="")
{
	$code = "page_company";
	if ($lan != "")
		$code .= "_".$lan;
	else
		$code .= "_".GetDirLan();
	$name = GetConfigVal($code);
	return $name;
}

function GetDirLan()
{
	$self = $_SERVER['PHP_SELF'];
	$dir = dirname($self);
	$dir_arr = explode("/", $dir);
	$lan = $dir_arr[count($dir_arr)-1];

	return $lan;
}

function GetConfigTitle($lan="")
{
	if ($lan == "")
		$lan = GetDirLan();
	$key = "page_title_".$lan;
	return GetConfigVal($key);
}

function GetConfigKeywords($lan="")
{
	if ($lan == "")
		$lan = GetDirLan();
	$key = "page_keywords_".$lan;
	return GetConfigVal($key);
}

function GetConfigDescription($lan="")
{
	if ($lan == "")
		$lan = GetDirLan();
	$key = "page_description_".$lan;
	return GetConfigVal($key);
}

function GetConfigVal($code)
{
	global $maindb;

	$rd = $maindb->Execute("SELECT * FROM t_config WHERE code=?", array($code));
	if ($rd->RecordCount() > 0)
	{
		return $rd->fields['value'];
	}
	return "";
}

function GetProductTitle()
{
	if (isset($_GET['pid']))
	{
		return GetTableFieldVal("t_products", array("page_title","ProName"), $_GET['pid']);
	}
	return "";
}

function GetProductKeywords()
{
	if (isset($_GET['pid']))
	{
		return GetTableFieldVal("t_products", array("page_keywords","ProName"), $_GET['pid']);
	}
	return "";
}

function GetProductDescription()
{
	if (isset($_GET['pid']))
	{
		return GetTableFieldVal("t_products", array("page_description","ProName"), $_GET['pid']);
	}
	return "";
}

function GetTypeTitle()
{
	if (isset($_REQUEST['tid']))
	{
		return GetTableFieldVal("t_protype", array("page_title","Called"), $_REQUEST['tid']);
	}
	return "";
}

function GetTypeKeywords()
{
	if (isset($_REQUEST['tid']))
	{
		return GetTableFieldVal("t_protype", array("page_keywords","Called"), $_REQUEST['tid']);
	}
	return "";
}

function GetTypeDescription()
{
	if (isset($_REQUEST['tid']))
	{
		return GetTableFieldVal("t_protype", array("page_description","Called"), $_REQUEST['tid']);
	}
	return "";
}

function GetNewsTitle()
{
	if (isset($_REQUEST['nid']))
	{
		return GetTableFieldVal("t_news", array("page_title","Title"),$_REQUEST['nid']);
	}
}

function GetNewsKeywords()
{
	if (isset($_REQUEST['nid']))
	{
		return GetTableFieldVal("t_news", array("page_keywords","Title"),$_REQUEST['nid']);
	}
}

function GetNewsDescription()
{
	if (isset($_REQUEST['nid']))
	{
		return GetTableFieldVal("t_news", array("page_description","Title"),$_REQUEST['nid']);
	}
}

function GetTableFieldVal($table, $fields, $id)
{
	global $maindb;

	$val = "";

	$rd = $maindb->Execute("SELECT * FROM {$table} WHERE id=?", array($id));
	if ($rd->RecordCount() == 1)
	{
		if (isset($rd->fields[$fields[0]]) && $rd->fields[$fields[0]] != "")
		{
			$val = $rd->fields[$fields[0]];
		}
		else
		{
			$val = $rd->fields[$fields[1]];
		}
	}


	return $val;
}

function Baseurl()
{
	return dirname($_SERVER['PHP_SELF']);
}

/**
 * @param string $url 未重写的网址，不包括后面的参数
 * @param string $str 要重写成的网址字符串
 * @param mix $paras 参数数组
 * */
function BuildUrl($url, $str, $paras, $rewrite=false,$addbase=true)
{
	if ($rewrite)
		return RewriteUrl($str, $paras,$addbase);
	else
		return UnRewriteUrl($url, $paras);
}

/**
 * 生成转换后的URL地址
 * rewrite地址规则为：xxxxxx-tid-1-p-2.html
 * xxxxxx为前面的SEO文字，tid-1-p-2为实际参数其它tid,p为参数名称，1,2为参数值
 * @param string $str为SEO文字
 * @param array $paras为后面的参数数组
 * */
function RewriteUrl($str,$paras,$addbase=true)
{
	$retUrl = str_replace("-","_",$str);
	$retUrl = str_replace(" ","_",$str);
	$retUrl = str_replace("/","",$str);
	$retUrl = urlencode($retUrl);
	$para_str = "";
	foreach($paras as $key=>$val)
	{
		if ($para_str != "")
			$para_str .= "-".$key."-".$val;
		else
			$para_str .= $key."-".$val;
	}

	if ($para_str != "")
		$retUrl .= "-".$para_str.".html";
	else
		$retUrl .= ".html";

	if ($addbase)
		return BaseUrl()."/".$retUrl;
	return $retUrl;
}

/**
 * 不开启URL重写时使用的URL地址
 * 格式为xxx.php?tid=1&p=2
 * @param string $url
 * @param array $paras
 * */
function UnRewriteUrl($url, $paras)
{
	$retUrl = $url;
	$para_str = "";
	foreach($paras as $key=>$val)
	{
		if ($para_str != "")
		{
			$para_str .= "&".$key."=".$val; 
		}
		else
		{
			$para_str .= $key."=".$val;
		}
	}

	if ($para_str != "")
		$retUrl .= "?".$para_str;

	return $retUrl;
}

function GetParentPathName($tid)
{
	global $maindb;

	$typeName = array();
	$rd = $maindb->Execute("SELECT * FROM t_protype WHERE id=?",array($tid));
	if ($rd->RecordCount() > 0)
	{
		$typeObj = $rd->FetchObject();

		$parent = explode("-",$typeObj->PARENTPATH);
		foreach($parent as $tid)
		{
			$rd = $maindb->Execute("SELECT * FROM t_protype WHERE id=?", array($tid));
			if ($rd->RecordCount() > 0)
			{
				$typeName[$rd->fields['id']] = $rd->fields['Called'];
			}
		}

		$typeName[$typeObj->ID] = $typeObj->CALLED;
	}

	return $typeName;
}

function GetDownloadUrl($url)
{
	if (stripos($url,"http://") >= 0)
	{
		return $url;
	}
	
	return "../upload/".$url;
}

//发邮件
function SendEmail($email,$subject,$body)
{
	if (!class_exists("PHPMailer"))
	{
		include(ROOTDIR."/lib/class.phpmailer.php");
	}

	/*$client = new nusoap_client('http://server.iecworld.com/MailService.asmx?WSDL',true);
	$addMailPara = array(
		'strCredential' => 'cn-passion.com11',
		'strTo' => $email,
		'strSubject' => $subject,
		'strMessage' => $body
	);
	$client->soap_defencoding = 'utf-8';
	$client->call('AddMail',$addMailPara);
	$client->call('GetAndSendMail');*/

	$mail = new PHPMailer();
	//$mail->debug = true;
	$mail->CharSet      = 'UTF-8';
	$mail->IsSMTP(); // set mailer to use SMTP
	$mail->Host = "smtp.sinanet.com"; // specify main and backup server
	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = "pass@iecworld.com"; // SMTP username
	$mail->Password = "6666"; // SMTP password

	$mail->From = "pass@iecworld.com";
	$mail->FromName = $subject;
	$mail->AddAddress($email, "");

	$mail->Subject = $subject;
	$mail->Body = $body;
	//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

	if(!$mail->Send())
	{
	 return false;
	}

	return true;
}

//08-10-12添加
//读取父类下所有子类的ID
function GetTypeId($db,$pid,$lan)
{
	$typeIdArr = array();
	$subType = GetProductSubType($db,$pid,$lan,"");
	foreach($subType as $t)
	{
		$typeIdArr[] = $t['ID'];
		$subTypeIdArr = GetTypeId($db,$t['ID'],$lan);
		$typeIdArr = array_merge($typeIdArr,$subTypeIdArr);
	}
	$typeIdArr[] = $pid;

	return $typeIdArr;
}


//08-08-12添加
//分级读取产品分类表
//$db        数据库连接
//$pid       父级分类ID
//$currId    当前子分类ID
function GetProductSubType($db,$pid,$lan,$order="",$limit=0)
{
	$typeArr = array();
	$paraArray = array();
	$where = " WHERE IsShow=1 AND PID=?";
	$paraArray[] = $pid;
	if ($lan != "")
	{
		$where .= " AND Language=?";
		$paraArray[] = $lan;
	}
	$limits = "";
	if ($limit > 0)
	{
		$limits = " LIMIT 0,".$limit;
	}
	$typeRs = $db->Execute("SELECT * FROM t_protype ".$where." ORDER BY OrderBy ".$order.$limits,$paraArray);
	while (!$typeRs->EOF)
	{
		$typeObj = $typeRs->FetchObject();
		$typeArr[] = array(
			'ID' => $typeObj->ID,
			'Called' => $typeObj->CALLED,
			'Memo' => $typeObj->MEMO,
			'Pid' => $typeObj->PID,
			'TypeLevel' => $typeObj->TYPELEVEL,
			'ParentPath' => $typeObj->PARENTPATH,
			'PicUrl' => $typeObj->PICURL,
			'object' => $typeObj,
		);
		$typeRs->MoveNext();
	}

	return $typeArr;
}

//08-10-08添加
//分级读取PPG产品分类表
//$db        数据库连接
//$pid       父级分类ID
//$currId    当前子分类ID
function GetPpgProductSubType($db,$pid,$lan,$order="")
{
	$typeArr = array();
	$paraArray = array();
	$where = " WHERE IsShow=1 AND PID=?";
	$paraArray[] = $pid;
	if ($lan != "")
	{
		$where .= " AND Language=?";
		$paraArray[] = $lan;
	}
	$typeRs = $db->Execute("SELECT * FROM t_ppgprotype ".$where." ORDER BY OrderBy ".$order,$paraArray);
	while (!$typeRs->EOF)
	{
		$typeObj = $typeRs->FetchObject();
		$typeArr[] = array(
			'ID' => $typeObj->ID,
			'Called' => $typeObj->CALLED,
			'Memo' => $typeObj->MEMO,
			'Pid' => $typeObj->PID,
			'TypeLevel' => $typeObj->TYPELEVEL,
			'ParentPath' => $typeObj->PARENTPATH,
			'object' => $typeObj,
		);
		$typeRs->MoveNext();
	}

	return $typeArr;
}

//08-10-20添加
//中文字符串截取
function substr_for_gb2312($str,$start,$len=null)
{
  preg_match_all("/./u", $str, $ar);
 
    if(func_num_args() >= 3) {
       $end = func_get_arg(2);
       return join("",array_slice($ar[0],$start,$end));
    } else {
       return join("",array_slice($ar[0],$start));
    }
}


//输出超链接
//$openType			链接打开方式
//$pagename			链接地址
//$params			链接参数
//$popupLocation	弹出窗口方式位置
function GetLinkHref($openType,$pagename,$popupLocation=array())
{
	$href = "";

	switch($openType)
	{
		case 'old':
			$href = '<a href="'.$pagename.'">';
			break;
		case 'new':
			$href = '<a href="'.$pagename.'" target="_blank">';
			break;
		case 'popup':
			$top = 0;
			$left = 0;
			$width = 800;
			$height = 600;
			if (isset($popupLocation['top']))
			{
				$top = $popupLocation['top'];
			}
			if (isset($popupLocation['left']))
			{
				$left = $popupLocation['left'];
			}
			if (isset($popupLocation['width']))
			{
				$width = $popupLocation['width'];
			}
			if (isset($popupLocation['height']))
			{
				$height = $popupLocation['height'];
			}
			$href = '<a href="###" onclick="window.open(\''.$pagename.'\',\'\',\'top='.$top.',left='.$left.',width='.$width.',height='.$height.',scrollbars=1,resizable=1\')">';
			break;
	}

	echo $href;
}

//网站会员登录检查
function UserLoginCheck($loginUrl,$info)
{
	if (!isset($_SESSION['S_SITE_USERID']) || $_SESSION['S_SITE_USERID']=="")
	{
		echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>';
		echo '<script>';
		echo 'alert("'.$info.'");';
		echo 'location.href="'.$loginUrl.'?returl='.$_SERVER['PHP_SELF'].'";';
		echo '</script>';
		echo '</html>';
		exit();
	}
}

//网站用函数              end


//后台用函数               start

/**
 * 向表中添加新字段
 * @param string $table 表名
 * @param string $fields 字段名
 * */
function AddFields($db, $table, $fields)
{
	$rd = $db->Execute("show fields from {$table}");
	$fields_array = array();
	while(!$rd->EOF)
	{
		$fields_array[] = $rd->fields['Field'];
		$rd->MoveNext();
	}
	if (!in_array($fields, $fields_array))
	{
		$sql = "ALTER TABLE `{$table}` ADD `{$fields}` TEXT NOT NULL";
		$db->Execute($sql);
	}
}

//自定义字段输出
function CustomerFieldEdit($type,$defaultName,$defaultValue,$setValue)
{
	global $SysConfig;

	$retStr = "";
	//根据uiTypeArr的类型决定输出内容
	switch($type)
	{
		case "text":
			if ($setValue != "")
				$defaultValue = $setValue;
			$retStr = '<input type="text" name="'.$defaultName.'" value="'.$defaultValue.'" class="sys_input">';
			break;
		case "textarea":
			if ($setValue != "")
				$defaultValue = $setValue;
			$retStr = '<textarea name="'.$defaultName.'" rows="4" cols="50" class="txt">'.$defaultValue.'</textarea>';
			break;
		case "select":
			$retStr = '<select name="'.$defaultName.'" id="'.$defaultName.'">';
			$retStr .= "<option value=''>请选择</option>";
			if ($defaultValue != "")
			{
				$tempArr = explode("\n",strtoupper($defaultValue));
				$len = count($tempArr);
				if ($len <= 0)
				{
					
				}
				else
				{
					 if ($len == 3)
					 {
						// $SysConfig['customerdb']->debug = true;
						$table = str_replace("TABLE:","",$tempArr[0]);
						$id = str_replace("ID:","",$tempArr[1]);
						$name = str_replace("NAME:","",$tempArr[2]);

						$rd = $SysConfig['customerdb']->Execute("SHOW TABLES");
						$table_array = array();
						while(!$rd->EOF)
						{
							$table_array[] = strtoupper($rd->fields[0]);
							$rd->MoveNext();
						}

						if (in_array($table,$table_array))
						{
							$rd = $SysConfig['customerdb']->Execute("SHOW FIELDS FROM ".strtolower($table));
							$field_array = array();
							while(!$rd->EOF)
							{
								$field_array[] = strtoupper($rd->fields['Field']);
								$rd->MoveNext();
							}

							if (in_array($id,$field_array) && in_array($name,$field_array))
							{
								$rd = $SysConfig['customerdb']->Execute("SELECT * FROM ".strtolower($table));
								while(!$rd->EOF)
								{
									$obj = $rd->FetchObject();
									$selected = "";
									if ($setValue == $obj->$id)
										$selected = "selected='selected'";
									$retStr .= '<option value="'.$obj->$id.'"'.$selected.'>'.$obj->$name.'</option>';
									$rd->MoveNext();
								}
							}
						}
					 }
					 else
					{
						$tempArr = explode("|",$defaultValue);
						$len = count($tempArr);
						for ($i=0; $i<$len; $i++)
						{
							$selected = "";
							if ($setValue == $tempArr[$i])
								$selected = " selected='selected'";
							$retStr .= '<option value="'.$tempArr[$i].'"'.$selected.'>'.$tempArr[$i].'</option>';
						}
					 }
				}
			}
			
			/*for ($i=0; $i<$len; $i++)
			{
				$selected = "";
				if ($setValue == $tempArr[$i])
					$selected = " selected='selected'";
				$retStr .= '<option value="'.$tempArr[$i].'"'.$selected.'>'.$tempArr[$i].'</option>';
			}*/
			$retStr .= "</select>";
			break;
		case "file":
			$retStr = '
			   <div class="file-box">

<input type="text" name="'.$defaultName.'" value="'.$setValue.'" class="sys_input" style="float:left; height:22px;">

<input type="button" name="'.$defaultName.'btn" class="btn1" value="浏览..." />
    </div>
<span id="'.$defaultName.'result" style="float:left; padding-left:20px;"></span>';
			$retStr .= '<script>';
			$retStr .= '$(function()
						{
							$("input[name='.$defaultName.'btn]").upload({
								name:"Filedata",
								method:"post",
								enctype:"multipart/form-data",
								action:"'.$SysConfig['swfupload'].'",
								onSubmit:function(){
									$("#'.$defaultName.'result").html("正在上传");
								},
								onComplete:function(data){
									$("input[name='.$defaultName.']").val(data);
									$("#'.$defaultName.'result").html("上传成功");
								}
							});
						})';
			$retStr .= '</script>';
			break;
	}

	return $retStr;
}

//权限判断
//$needPower			系统权限代码
//$userPower			用户具有的权限，以：分隔开
function UserIsInRole($needPower, $userPower)
{
	$powerArr = explode(":",$userPower);
	foreach($powerArr as $power)
	{
		if ($power == $needPower)
			return true;
	}

	return false;
}

//Webadmin Session检测
//$frame			是否框架窗口
function LoginCheck($loginurl,$frame)
{
	if (!isset($_SESSION['SWEBADMIN_USERID']) || $_SESSION['SWEBADMIN_USERID'] == '')
	{
		if ($frame)
			echo '<script>window.parent.location.href="'.$loginurl.'";</script>';
		else
			echo '<script>window.location.href="'.$loginurl.'";</script>';
		exit();
	}
}

//admin session检测
function AdminLoginCheck($loginurl,$frame)
{
	if (!isset($_SESSION['S_USERID']) || $_SESSION['S_USERID'] == '')
	{
		if ($frame)
			echo '<script>window.parent.location.href="'.$loginurl.'";</script>';
		else
			echo '<script>window.location.href="'.$loginurl.'";</script>';
		exit();
	}
}

function AjaxLoginCheck()
{
	if (!isset($_SESSION['SWEBADMIN_USERID']) || $_SESSION['SWEBADMIN_USERID'] == '')
	{
		echo json_encode(array('result'=>'登陆超时，请重新登录'));
		exit();
	}
}

//替换FCKEDITOR内容中上传的图片文件地址
function FckReplace($content,$dir,$save)
{
	/*$result = "";
	if ($save)
		$result = str_replace($dir."upload","../upload",$content);
	else
		$result = str_replace("../upload",$dir."upload",$content);

	return $result;*/
	return $content;
}

//更新网站文件
function UpdateWebFile($old,$new,$addpref,$addlast)
{
	$f = fopen($old,"r");
	$content = fread($f,filesize($old));
	fclose($f);

	$content = str_replace(".html",".php",$content);
	$content = str_replace(".htm",".php",$content);
	if (strpos($content,"jquery.js") ===false)
	{
		$content = str_replace('</head>','<script src="http://testweb.iecworld.com/js/jquery.js"></script></head>',$content);
	}
	/*$content .= '<?echo \'<script src="\'.$SysConfig[\'rooturl\'].\'js/producttype1.js"></script>\';?>';*/
	/*$content .= '<?if (isset($config[\'producttype\']) && $config[\'producttype\'][\'value\']=="true")';
	$content .= '{';
	$content .= '	echo \'<script src="\'.$SysConfig[\'rooturl\'].\'js/producttype.js"></script>\';';
	$content .= '}?>';*/

	$content = $addpref.$content.$addlast;

	$f = fopen($new,"w");
	fwrite($f,$content);
	fclose($f);

	unlink($old);
}

//获取文件最后修改时间
//$file			文件全路径
function FileLastUpdate($file)
{
	if (file_exists($file))
	{
		$time = filemtime($file);
		return date("Y-m-d H:i:s",$time);
	}

	return "";
}

//是否是可编辑的文本文件
function CanEditFile($name,$allowExt)
{
	$tmpArr = explode(".",$name);
	$ext = $tmpArr[count($tmpArr) - 1];

	foreach($allowExt as $aext)
	{
		if ($ext == $aext)
			return true;
	}

	return false;
}


//返回web请求串
//$except			不加到请求串中的参数数组
function GetRequestString($except)
{
	$postarr = array();
	while(list($key,$val) = each($_GET))
	{
		if ($key == "PHPSESSID")
			continue;
		if (CheckString($key,$except))
			continue;
		$postarr[] = "$key=$val";
	}
	while(list($key,$val) = each($_POST))
	{
		if ($key == "PHPSESSID")
			continue;
		if (CheckString($key,$except))
			continue;
		$postarr[] = "$key=$val";
	}
	$poststring = implode("&",$postarr);

	return $poststring;
}

//内部函数
function CheckString($key,$except)
{
	foreach($except as $str)
	{
		if (strtolower($key) == $str)
			return true;
	}

	return false;
}

//保存图片
function SavePicture($name,$path,$newname="",$root=ROOTDIR,$limitsize=2048)
{
	return SaveFile($name,$path,$newname,$root,$limitsize,array("jpg","jpeg","gif","png"));
}

//保存zip
function SaveZipFile($name,$path,$newname="",$root=ROOTDIR,$limitsize=32768)
{
	return SaveFile($name,$path,$newname,$root,$limitsize,array("zip"));
}

//保存flash
function SaveFlash($name,$path,$newname="",$root=ROOTDIR,$limitsize=32768)
{
	return SaveFlash($name,$path,$newname,$root,$limitsize,array("swf"));
}

//保存文本文件
function SaveTextFile($name,$path,$newname,$extArr,$root=ROOTDIR)
{
	return SaveFile($name,$path,$newname,$root,1024,$extArr);
}

//保存功能模块文件
function SavePluginFile($name,$path,$newname,$replace=false,$root=ROOTDIR)
{
	return SaveFile($name,$path,$newname,$root,4096,array("zip"),$replace);
}

//内部函数，保存文件
function SaveFile($name,$path,$newname,$root,$limitsize,$extArr,$replace=true)
{
	if (isset($_FILES[$name]))
	{
		$filename = $_FILES[$name]['name'];
		$type = $_FILES[$name]['type'];
		$tmp = $_FILES[$name]['tmp_name'];
		$size = $_FILES[$name]['size'];

		if ($size <= 0)
			return array(false,"文件不存在");
		if (round($size/1024,2) >= $limitsize)
			return array(false,"文件太大，无法上传");

		$tmpArr = explode(".",$filename);
		$ext = $tmpArr[count($tmpArr)-1];

		if (CheckString($ext,$extArr))
		{
			//$newname = $newname;
			if ($newname == "")
				$newname = RandName($ext);
			if (!$replace)
			{
				if (file_exists($root.$path."/".$newname))
					return array(false,"文件已存在");
			}
			move_uploaded_file($tmp,$root.$path."/".$newname);
			return array(true,$newname);
		}
		else
		{
			return array(false,"文件格式错误");
		}
	}

	return array(false,"请选择文件");
}

//内部函数,生成随机文件名
function RandName($ext)
{
	$new = date("YmdHis").rand(10,99).".".$ext;
	if (file_exists($new))
	{
		$new = RandName($ext);
	}

	return $new;
}

//设置系根目录
function globalpath()
{
	global $SysConfig;
	if($SysConfig['independ'])
	{
		return $SysConfig['domain'];
	}
	else
	{
		return $SysConfig['domain']."/".$_SESSION['SWEBADMIN_USERNAME'];
	}
}

//分解权限字符串为数组
//$power		权限字符串
//返回			key/val对数组
function GetPowerArray($power,$desc)
{
	$retArr = array();
	/*$arr = explode("|",$power);
	foreach($arr as $item)
	{
		$tmp = explode(":",$item);
		$pitem = new PowerItem($tmp[1],$tmp[0],false);
		$retArr[] = $pitem;
	}*/
	$parr = explode("|",$power);
	$darr = explode("|",$desc);

	if (count($parr) == count($darr))
	{
		$len = count($parr);
		for ($i=0; $i<$len; $i++)
		{
			$pitem = new PowerItem($parr[$i],$darr[$i],false);
			$retArr[] = $pitem;
		}
	}

	return $retArr;
}

function GetEditPowerArray($power,$desc,$adminRole)
{
	$retArr = array();

	$parr = explode("|",$power);
	$darr = explode("|",$desc);

	if (count($parr) == count($darr))
	{
		$len = count($parr);
		for ($i=0; $i<$len; $i++)
		{
			$pitem = new PowerItem($parr[$i],$darr[$i],UserIsInRole($parr[$i],$adminRole));
			$retArr[] = $pitem;
		}
	}

	return $retArr;
}

//返回IP地址
function GetIPAddr()
{
	return $_SERVER['REMOTE_ADDR'];
}

//链接类
class Linker
{
	var $link;
	var $css;
	var $name;
	var $target = '_self';
	var $id;

	//$link			链接URL
	//$name			链接名称
	//$id			链接ID
	//$class		CSS样式
	function Linker($link,$name,$id="",$css="")
	{
		$this->link = $link;
		$this->name = $name;
		$this->css = $css;
		$this->id = $id;
	}
}

//js linker
class JsLinker
{
	var $link;
	var $id;
	var $flag;
	var $param;
	var $showAlert;

	function JsLinker($link,$id,$flag=true)
	{
		$this->link = $link;
		$this->id = $id;
		$this->flag = $flag;

		$this->param = 'id';
		$this->showAlert = false;
	}
}

//权限项
class PowerItem
{
	var $code;
	var $name;
	var $checked;

	function PowerItem($code,$name,$checked)
	{
		$this->code = $code;
		$this->name = $name;
		$this->checked = $checked;
	}
}
?>
