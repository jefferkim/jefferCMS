<?
$cusBaseDir = dirname(__FILE__);
include_once($cusBaseDir."/admin/config.php");
$dbname = basename($cusBaseDir);
$dbhost = "localhost";
$dbpass = "ps5566";
$maindb = ADONewConnection("mysql");
$maindb->NConnect($dbhost,$dbname,$dbpass,$dbname);
$maindb->debug = false;
$maindb->charSet = 'UTF-8';
$maindb->Execute("set names 'utf8'");
$SysConfig['UseRewrite'] = false;

if (file_exists($cusBaseDir."/baseconfig.php"))
{
	include_once($cusBaseDir."/baseconfig.php");
}
else
{
	$f = fopen($cusBaseDir."/baseconfig.php","w+");
	$str = '<?
	$config = array();
	';

	$rs = $maindb->Execute("SELECT * FROM t_config ORDER BY id");
	while (!$rs->EOF)
	{
		$obj = $rs->FetchObject();
		
		$str .= '$config[\''.$obj->CODE.'\'] = array(\'name\'=>\''.$obj->NAME.'\',\'value\'=>\''.$obj->VALUE.'\');
		';
		$rs->MoveNext();
	}
	
	$str .= '?>';

	fwrite($f,$str);
	fclose($f);
	include_once($cusBaseDir."/baseconfig.php");
}
?>




<?php
//转换二进制方法
define("LEN",8);
function IPchange($ip)
{
	$result = "";
	$ipArr=explode(".",$ip);
	foreach($ipArr as $ip)
	{
		$newip=sprintf("%b",$ip);
		$len=strlen($newip);
		$result .= str_repeat("0", LEN-$len).$newip;
	}
	return $result;
}
//单页面 $lan:语言版本  $name:名称 $page:单页面分页  空 表示不分页 1 表示分页,在加资料的时候需要分页的地方加{nextpage}
function signerpost($lan,$name,$page=0) {
	global $maindb;
	$content="";
	$where = "WHERE Language='$lan' AND Called='$name'";
	$contentRs = $maindb->Execute ( "SELECT * FROM t_content " . $where );
	if ($contentRs->RecordCount () > 0) {
		$contentObj = $contentRs->FetchObject ();
		if($page==""){
		echo $contentObj->CONTENT;
		}else{
		
		$content =$contentObj->CONTENT;

		$url = $_SERVER["PHP_SELF"]."?";
		
		$currentLink = $_REQUEST['more'];
		$contentArr =array();
		$contentArr = explode("{nextpage}",$content);
		$pageTotal = count($contentArr);
		if(!$currentLink||$currentLink<1)
		{
		$currentLink = 1;
		}
		if($currentLink>$pageTotal)
		{
		$currentLink = $pageTotal;
		}
		$prepage = $currentLink-1;
		$nextpage = $currentLink+1;
		
		$off_set = 3;  
		$intpage = 6; 
		if($pageTotal<$intpage)
		{
		  $minpage = 1;
		  $maxpage = $pageTotal;
		}
		elseif($pageTotal>$intpage)
		{
		if(($currentLink-$off_set)>=1) $minpage = $currentLink-$off_set;
		else $minpage = 1;
		
		if(($currentLink+$off_set)<=$pageTotal) $maxpage = $currentLink+$off_set;
		else $maxpage = $pageTotal;
		
		if(($currentLink + $off_set)<$intpage)
		{
		  $minpage = 1;
		  $maxpage = $intpage;
		}
		}
		
		if($currentLink>1)
		{
		$pageLink .= "<span class='multi_prelink'><a href='$url&more=$prepage'>上一页</a></span>"."||"."<span class='multi_firstlink'><a href='$url&more=1'>首页</a></span>";
		}
		else
		{
		 $pageLink .= "<span>上一页</span>"."||"."<span>首页</span>";
		}
		
		for($i=$minpage;$i<=$maxpage;$i++)
		{
		  $pageLink .= ($i==$currentLink)?"<span><a href='$url&more=$i'><b><font color=red>$i</font></b></a></span> ":"<span><a href='$url&more=$i'>$i</a></span> ";
		}
		
		
		if($currentLink<$pageTotal)
		{
		  $pageLink .= "<span class='multi_nextlink'><a href='$url&more=$nextpage'>下一页</a></span>"."||"."<span class='multi_lastlink'><a href='$url&more=$pageTotal'>尾页</a></span>";
		}
		else
		{
		  $pageLink .= "<span>下一页</span>"."||"."<span>尾页</span>";
		}
		
		
		
		if($pageTotal>=2)
		{
		echo $contentArr[$currentLink-1];
		echo "<div class='multi_page'>$pageLink</div>";
		}
		else
		{
		echo $content;
		}
				
		
		
		}
	}
}
?>
<?php
//新闻列表
//$newsType:新闻分类 ;$language:语音版本;$IsCommend:是否推荐 1:推荐 0:不推荐;$newsLine:显示条数;
function newslist($newsType, $language, $IsCommend,$newsLine,$nopage,$desca) {
	global $maindb;
	$newsArray=array();
	$linkurl = $_SERVER ['REQUEST_URI'] . "?";
	$newsType = "$newsType";
	$newsTypeId = 0;
	$page = 1;
	$pageCounts = "$newsLine";
	if ($newsType != "") {
		$newsTypeRs = $maindb->Execute ( "SELECT * FROM t_newtype WHERE Called=? AND Language=?", array ($newsType, $language ) );
		if ($newsTypeRs->RecordCount () > 0) {
			$newsTypeId = $newsTypeRs->fields ['id'];
		}
	}
	
	if($nopage!=""){
		$page=1;
		
		}else{
			
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] > 0) {
		$page = $_REQUEST ['page'];
	}	
			
		}
	
	
	
	
	if (isset ( $_REQUEST ['newstype'] ) && $_REQUEST ['newstype'] != "") {
		$newsTypeId = $_REQUEST ['newstype'];
		$linkurl .= "&newstype=" . $_REQUEST ['newstype'];
	}
	if ($IsCommend == 1) {
		$where = " WHERE IsShow=1 AND Language='$language' AND IsCommend=1";
	} else {
		$where = " WHERE IsShow=1 AND Language='$language'";
	}
	if ($newsTypeId >0) {
		$where .= " AND NewType='" . $newsTypeId . "'";
	}
	
	 if (isset ( $_REQUEST ['Province'] ) && $_REQUEST ['Province'] != "") {
	
		$where .= " AND Province='".$_REQUEST ['Province']."'";

	}
 
  if (isset ( $_REQUEST ['Type'] ) && $_REQUEST ['Type'] != "") {
	
		$where .= " AND Type='".$_REQUEST ['Type']."'";

	}
	
  if (isset ( $_REQUEST ['keyword'] ) && $_REQUEST ['keyword'] != "") {
	
		$where .= " AND Title like '%".$_REQUEST ['keyword']."%'";

	}	
	
	$newsRs = $maindb->Execute ( "SELECT count(*) FROM t_news " . $where );
	$counts = $newsRs->fields [0];
	$start = ($page - 1) * $pageCounts;
	
	if($desca){
		$newsRs = $maindb->Execute ( "SELECT * FROM t_news $where ORDER BY OrderBy $desca LIMIT $start,$pageCounts" );
		
	}else{
	
		$newsRs = $maindb->Execute ( "SELECT * FROM t_news $where ORDER BY OrderBy  LIMIT $start,$pageCounts" );
	}

	while ( ! $newsRs->EOF ) {
		$newsArray[] = $newsRs->FetchObject ();
		$newsRs->MoveNext ();
	}

		switch ($language) {
			case "cn" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->lanAll = "共有";
				$pager->lanItems = "条";
				break;
			case "en" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->setFirstText ( 'First' );
				$pager->setPrevText ( 'Prev' );
				$pager->setNextText ( 'Next' );
				$pager->setLastText ( 'Last' );
				$pager->lanAll = "Total:";
				$pager->lanItems = "";
				break;
		}
		$newsArr=array("newsArr"=>$newsArray,"pagerShow"=>$pager);
		return $newsArr;
}
?>
<?php
//图片展示
//$picsType:图片分类 ;$language:语音版本;$num:调用张数;
function piclist($picsType, $language,$num){
global $maindb;
$picArray=array();
$linkurl = $_SERVER['PHP_SELF']."?";
 $page = 1;
 $pageCounts = $num;
 $picType = $picsType;
 $picTypeId = 0;
 $where = " WHERE IsShow=1 AND Language='$language'";
 if ($picType != "")
 {
	$picTypeRs = $maindb->Execute("SELECT * FROM t_pictype WHERE Called=?  AND Language=?",array($picType,$language));
	if ($picTypeRs->RecordCount() >0)
	{
		$picTypeId = $picTypeRs->fields['id'];
	}
 }
 
 
 
 
 if (isset($_REQUEST['pictype']) && $_REQUEST['pictype']!="")
 {
	$picTypeId = $_REQUEST['pictype'];
 }
 if ($picTypeId > 0)
 {
	$where .= " AND TypeID='".$picTypeId."'";
 }
 
 if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
 {
	$page = $_REQUEST['page'];
 }
 
 
 
 
 
 $picRs = $maindb->Execute("SELECT count(*) FROM t_pic ".$where);
 $counts = $picRs->fields[0];
 $start = ($page - 1) * $pageCounts;
if (isset($config['pictureorder']) && $config['pictureorder']['value']=="true")
	$picRs = $maindb->Execute("SELECT * FROM t_pic $where ORDER BY OrderBy LIMIT $start,$pageCounts");
else
	$picRs = $maindb->Execute("SELECT * FROM t_pic $where ORDER BY OrderBy ASC LIMIT $start,$pageCounts");

while (!$picRs->EOF) {
	$picArray[] = $picRs->FetchObject ();
	$picRs->MoveNext ();
 }
 
      switch ($language) {
			case "cn" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->lanAll = "共有";
				$pager->lanItems = "条";
				break;
			case "en" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->setFirstText ( 'First' );
				$pager->setPrevText ( 'Prev' );
				$pager->setNextText ( 'Next' );
				$pager->setLastText ( 'Last' );
				$pager->lanAll = "Total:";
				$pager->lanItems = "";
				break;
		}
		$picArr=array("picArr"=>$picArray,"pagerShow"=>$pager);
		return $picArr;
}
?>
<?php
//产品展示
//$productName:产品分类 ;$typeId:产品分类ID;$language:语音版本;$IsCommend:是否推荐;$lines:行数;$cols:列表;$isShowPage:是否分页;
//$linkUrl:链接地址;$popupStyle:页面跳转方式
function productlist($productName, $typeId, $language, $IsCommend, $num,$gid, $pageD=1) {
	global $maindb;
	global $config;
	$proArray=array();
	if($gid){
	$linkurl = $_SERVER ["PHP_SELF"] . "?gid=".$gid;
	}else{
	$linkurl = $_SERVER ["PHP_SELF"] . "?";
	}
	if ($IsCommend == 1) {
		$where = "WHERE IsShow=1 AND IsCommend=1 AND Language='$language'";		
	} else {
		$where = "WHERE IsShow=1 AND Language='$language'";
	}
	
	$sqlPara = array ();
	$page=isset($pageD)?$pageD:1;	
	$pageCounts=$num;
	$proArray=array();
	$mainType = "$productName";
	$typeid ="$typeId";
	
	if ($mainType != "") {
		$rd = $maindb->Execute ( "SELECT * FROM t_protype WHERE Called=? AND Language='$language'", array ($mainType ));
		if ($rd->RecordCount () == 1) {
			$typeid = $rd->fields ['id'];
		}
	}
	if (isset ( $_REQUEST ['tid'] ) && $_REQUEST ['tid'] != "") {
		$typeid = $_REQUEST ['tid'];
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] > 0)
		$page = $_REQUEST ['page'];
		
		
	if ($typeid != ""&&$typeid>=0) {
		$tid = GetTypeId ( $maindb, $typeid, $language );
		$where .= " AND TypeID in (" . implode ( ",", $tid ) . ")";
		$linkurl .= "&tid=" . $typeid;
	}
	if (isset ( $_REQUEST ['keyword'] ) && $_REQUEST ['keyword'] != "") {
	
		$where .= " AND (ProName like ? OR Memo like ?)";
		$sqlPara [] = "%" . $_REQUEST ['keyword'] . "%";
		$sqlPara [] = "%" . $_REQUEST ['keyword'] . "%";
		$linkurl .= "&keyword=" . $_REQUEST ['keyword'];
	}
	$sql = "SELECT COUNT(*) FROM t_products " . $where;
	
	$proRs = $maindb->Execute ( $sql, $sqlPara );
	
	$counts = $proRs->fields [0];
	if (isset ( $config ['productorder'] ) && $config ['productorder'] ['value'] == true) {
		$sql = "SELECT * FROM t_products " . $where . " ORDER BY OrderBy LIMIT ?,?";
	} else {
		$sql = "SELECT * FROM t_products " . $where . " ORDER BY OrderBy DESC LIMIT ?,?";
	}
	$sqlPara [] = ($page - 1) * $pageCounts;
	$sqlPara [] = intval ( $pageCounts );
	$proRs = $maindb->Execute ( $sql, $sqlPara );
	?>
<?
			while (! $proRs->EOF) {
				$proArray[] = $proRs->FetchObject ();
				$proRs->MoveNext ();
			}

		
		 switch ($language) {
			case "cn" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->lanAll = "共有";
				$pager->lanItems = "条";
				break;
			case "en" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->setFirstText ( 'First' );
				$pager->setPrevText ( 'Prev' );
				$pager->setNextText ( 'Next' );
				$pager->setLastText ( 'Last' );
				$pager->lanAll = "Total:";
				$pager->lanItems = "";
				break;
		}
		$proArr=array("proArr"=>$proArray,"pagerShow"=>$pager);
		return $proArr;
		
		
		
		
        }
        ?>
		
		
	<?php
//产品展示
//$productName:产品分类 ;$typeId:产品分类ID;$language:语音版本;$IsCommend:是否推荐;$lines:行数;$cols:列表;$isShowPage:是否分页;
//$linkUrl:链接地址;$popupStyle:页面跳转方式
function productlist1($productName, $typeId, $language, $IsCommend, $num, $pageD=1) {
	global $maindb;
	global $config;
	$proArray=array();
	$linkurl = $_SERVER ["PHP_SELF"] . "?";
	if ($IsCommend == 1) {
		$where = "WHERE IsShow=1 AND IsCommend=1 AND Language='$language'";		
	} else {
		$where = "WHERE IsShow=1 AND Language='$language'";
	}
	
	$sqlPara = array ();
	$page=isset($pageD)?$pageD:1;	
	$pageCounts=$num;
	$proArray=array();
	$mainType = "$productName";
	$typeid ="$typeId";
	
	if ($mainType != "") {
		$rd = $maindb->Execute ( "SELECT * FROM t_protype WHERE Called=? AND Language='$language'", array ($mainType ));
		if ($rd->RecordCount () == 1) {
			$typeid = $rd->fields ['id'];
		}
	}
	if (isset ( $_REQUEST ['tid'] ) && $_REQUEST ['tid'] != "") {
		$typeid = $_REQUEST ['tid'];
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] > 0)
		$page = $_REQUEST ['page'];
		
		
	if ($typeid != ""&&$typeid>=0) {
		$tid = GetTypeId ( $maindb, $typeid, $language );
		$where .= "";
		$linkurl .= "&tid=" . $typeid;
	}
	if (isset ( $_REQUEST ['keyword'] ) && $_REQUEST ['keyword'] != "") {
	
		$where .= " AND (ProName like ? OR Memo like ?)";
		$sqlPara [] = "%" . $_REQUEST ['keyword'] . "%";
		$sqlPara [] = "%" . $_REQUEST ['keyword'] . "%";
		$linkurl .= "&keyword=" . $_REQUEST ['keyword'];
	}
	$sql = "SELECT COUNT(*) FROM t_products " . $where;
	
	$proRs = $maindb->Execute ( $sql, $sqlPara );
	
	$counts = $proRs->fields [0];
	if (isset ( $config ['productorder'] ) && $config ['productorder'] ['value'] == true) {
		$sql = "SELECT * FROM t_products " . $where . " ORDER BY OrderBy LIMIT ?,?";
	} else {
		$sql = "SELECT * FROM t_products " . $where . " ORDER BY OrderBy DESC LIMIT ?,?";
	}
	$sqlPara [] = ($page - 1) * $pageCounts;
	$sqlPara [] = intval ( $pageCounts );
	$proRs = $maindb->Execute ( $sql, $sqlPara );
	?>
<?
			while (! $proRs->EOF) {
				$proArray[] = $proRs->FetchObject ();
				$proRs->MoveNext ();
			}

		
		 switch ($language) {
			case "cn" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->lanAll = "共有";
				$pager->lanItems = "条";
				break;
			case "en" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->setFirstText ( 'First' );
				$pager->setPrevText ( 'Prev' );
				$pager->setNextText ( 'Next' );
				$pager->setLastText ( 'Last' );
				$pager->lanAll = "Total:";
				$pager->lanItems = "";
				break;
		}
		$proArr=array("proArr"=>$proArray,"pagerShow"=>$pager);
		return $proArr;
		
		
		
		
        }
        ?>	
		
<?php
function protypelist($typesId,$language,$num){
  global $maindb;
  $protypeArray=array();
  $linkurl = $_SERVER['PHP_SELF']."?";
  $page = 1;
  $pageCounts = $num;
  $proTypeId =$typesId;
  
  $where = " WHERE IsShow=1 AND Language='$language'";
  
  if($proTypeId > 0){
  
   $where .= " AND PID='".$proTypeId."'";
   
  }
  
  if (isset($_REQUEST['page']) && $_REQUEST['page']>0)
 {
	$page = 1;
 }
  
  $protypeRs = $maindb->Execute("SELECT count(*) FROM t_protype ".$where);
  
  $counts = $protypeRs->fields[0];
  
  $start = ($page - 1) * $pageCounts;
  
  if (isset($config['protypeorder']) && $config['protypeorder']['value']=="true")
	$protypeRs = $maindb->Execute("SELECT * FROM t_protype $where ORDER BY OrderBy LIMIT $start,$pageCounts");
else
	$protypeRs = $maindb->Execute("SELECT * FROM t_protype $where ORDER BY OrderBy ASC LIMIT $start,$pageCounts");

  
  while (!$protypeRs->EOF) {
	$protypeArray[] = $protypeRs->FetchObject ();
	$protypeRs->MoveNext ();
 }
 
      switch ($language) {
			case "cn" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->lanAll = "共有";
				$pager->lanItems = "条";
				break;
			case "en" :
				$pager = new Pager ( $linkurl, $counts, $page, $pageCounts );
				$pager->setFirstText ( 'First' );
				$pager->setPrevText ( 'Prev' );
				$pager->setNextText ( 'Next' );
				$pager->setLastText ( 'Last' );
				$pager->lanAll = "Total:";
				$pager->lanItems = "";
				break;
		}
		$protypeArr=array("protypeArr"=>$protypeArray,"pagerShow"=>$pager);
		return $protypeArr;
}

?>

<?PHP
//字符串截取
//$string:字符 ;$length:截取的长度;$dot:后面所加的字符

function utf8substr($string, $length, $dot = '...') 
{ $charset='utf-8'; 
if(strlen($string) <=$length) 
{ 
$dot =""; 
return $string;
} 
$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string); 
$strcut = '';
if(strtolower($charset) == 'utf-8') 
{ $n = $tn = $noc = 0;
while($n < strlen($string))
{
	$t = ord($string[$n]); 
if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) 
{ 
	$tn = 1; $n++; $noc++; 
	} 
elseif(194 <= $t && $t <= 223) 
   { 
	$tn = 2; $n += 2; $noc += 2;
	}
elseif(224 <= $t && $t < 239)
	{ 
	$tn = 3; $n += 3; $noc += 2;
	} 
elseif(240 <= $t && $t <= 247)
	{ 
	$tn = 4; $n += 4; $noc += 2; 
	} 
elseif(248 <= $t && $t <= 251)
	{ 
	$tn = 5; $n += 5; $noc += 2;
	} 
elseif($t == 252 || $t == 253) 
	{ 
	$tn = 6; $n += 6; $noc += 2;
	} 
else 
	{
	$n++;
	} 
if($noc >= $length)
	{ 
	break;
	}
} 
if($noc > $length) 
	{ 
	$n -= $tn;
	} 
$strcut = substr($string, 0, $n);
}
else { 
	for($i = 0; $i < $length; $i++) 
	   { 
		$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	} 
	$strcut = str_replace(array('&', '"', '< ', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut); 
	return $strcut.$dot;
	} 
 
 ?>
<?php
 
 //$nid 新闻的当前前ID,$NewType 新闻所属分类的ID ,$num 新闻标题要截取的字数,$PrevOrNext 上一篇还是下一篇其中：0表示上一篇 1表示下一篇,$page 链接所要返回的页面,$IsShow 是不是要显示推荐的新闻, $Language 表示新闻分类的语言。
 
function PrevNext($nid,$PrevOrNext,$Called,$Language,$num,$page,$IsShow){
 global $maindb;
 $prev_next="";
 $NewType="";
if($Called!=""){
  $newsRs = $maindb->Execute("SELECT ID FROM t_newtype WHERE Language=? AND Called=?",array ($Language,$Called));
   if($newsRs->RecordCount() == 1){
   $NewType = $newsRs->fields[0];
   }
   }

if($IsShow==1){
$IsShow="IsShow=1 AND";
}else{
$IsShow="";
}
if($PrevOrNext==0){
$ID="id<?";
}else{
$ID="id>?";
}

 if (isset($nid) && $nid>0){
 $newsRs1 = $maindb->Execute("SELECT * FROM t_news WHERE  $IsShow  NewType=? AND $ID ORDER BY OrderBy LIMIT 0,1",array($NewType,$nid));
 if ($newsRs1->RecordCount() >0){
		$maindb->Execute("UPDATE t_news SET Hits=Hits+1 WHERE id=?",array($nid));
		$newsObj1 = $newsRs1->FetchObject();
		if($num==""){
		$prev_next=$newsObj1->TITLE;
		}else{
        $prev_next=utf8substr($newsObj1->TITLE,$num);
		
		}
	}
if($prev_next!=""){
if($page==""){
	$prev_next="<a href='newsd.php?nid=".$newsObj1->ID."'>".$prev_next."</a>";
	}else{
	$prev_next="<a href='$page?nid=".$newsObj1->ID."'>".$prev_next."</a>";
	}
	}else{
	$prev_next="没有了";
	}
		}
return $prev_next;
		}
?>
<?php
//单页面 $lan:语言版本  $name:名称 $page:单页面分页  空 表示不分页 1 表示分页
function signerPostWithPager($lan,$name,$page) {
	global $maindb;
	$content="";
	$where = "WHERE Language='$lan' AND Called='$name'";
	$contentRs = $maindb->Execute ( "SELECT * FROM t_content " . $where );
	if ($contentRs->RecordCount () > 0) {
		$contentObj = $contentRs->FetchObject ();
		if($page==""){
		echo $contentObj->CONTENT;
		}else{
		
		$content =$contentObj->CONTENT;

		$url = $_SERVER["PHP_SELF"]."?";
		
		$currentLink = $_REQUEST['more'];
		$contentArr =array();
		$contentArr = explode("{nextpage}",$content);
		$pageTotal = count($contentArr);
		if(!$currentLink||$currentLink<1)
		{
		$currentLink = 1;
		}
		if($currentLink>$pageTotal)
		{
		$currentLink = $pageTotal;
		}
		$prepage = $currentLink-1;
		$nextpage = $currentLink+1;
		
		$off_set = 3;  
		$intpage = 6; 
		if($pageTotal<$intpage)
		{
		  $minpage = 1;
		  $maxpage = $pageTotal;
		}
		elseif($pageTotal>$intpage)
		{
		if(($currentLink-$off_set)>=1) $minpage = $currentLink-$off_set;
		else $minpage = 1;
		
		if(($currentLink+$off_set)<=$pageTotal) $maxpage = $currentLink+$off_set;
		else $maxpage = $pageTotal;
		
		if(($currentLink + $off_set)<$intpage)
		{
		  $minpage = 1;
		  $maxpage = $intpage;
		}
		}
		
		if($currentLink>1)
		{
		$pageLink .= "<span class='multi_prelink'><a href='$url&more=$prepage'>上一页</a></span>"."||"."<span class='multi_firstlink'><a href='$url&more=1'>首页</a></span>";
		}
		else
		{
		 $pageLink .= "<span>上一页</span>"."||"."<span>首页</span>";
		}
		
		for($i=$minpage;$i<=$maxpage;$i++)
		{
		  $pageLink .= ($i==$currentLink)?"<span><a href='$url&more=$i'><b><font color=red>$i</font></b></a></span> ":"<span><a href='$url&more=$i'>$i</a></span> ";
		}
		
		
		if($currentLink<$pageTotal)
		{
		  $pageLink .= "<span class='multi_nextlink'><a href='$url&more=$nextpage'>下一页</a></span>"."||"."<span class='multi_lastlink'><a href='$url&more=$pageTotal'>尾页</a></span>";
		}
		else
		{
		  $pageLink .= "<span>下一页</span>"."||"."<span>尾页</span>";
		}
		
		
		
		if($pageTotal>=2)
		{
		echo $contentArr[$currentLink-1];
		echo "<div class='multi_page clear'>$pageLink</div>";
		}
		else
		{
		echo $content;
		}
				
		
		
		}
	}
}
?>
<?php

function titlename($qId,$language,$Table) {
   	global $maindb;
   $title="";
   $SubID="";
   $typeID="";
   $typeTable="";
   $Table_="";
   $SubID="";
   if($Table==""){
    $Table_="t_products";
    $typeID="TypeID";
    $typeTable="t_protype";
   }
   
   if($Table=="0"){
    $Table_="t_news";
    $typeID="NewType";
    $typeTable="t_newtype";
   }
    if($Table=="1"){
	$Table_="t_pic";
    $typeID="TypeID";
    $typeTable="t_pictype";
   }
   
  $proRs = $maindb->Execute("SELECT $typeID FROM $Table_ WHERE Language=? AND ID=?",array ($language,$qId));
   if($proRs->RecordCount() == 1){
   $SubID = $proRs->fields[0];
   }
  $protypeRs = $maindb->Execute("SELECT Called FROM $typeTable WHERE Language=? AND ID=?",array ($language,$SubID));
   if($protypeRs->RecordCount() == 1){
   $title = $protypeRs->fields[0];
   }  
   
   return  $title;
   
   }
?>



<?php

function protitle($bid,$language){
   global $maindb;
   $protype="";
 $protypetitle = $maindb->Execute("SELECT Called FROM t_protype WHERE Language=? AND ID=?",array ($language,$bid));
   if($protypetitle->RecordCount() == 1){
   $protype = $protypetitle->fields[0];
   }  
   
   return $protype;

}
?>


<?php

function promemo1($bid,$language){
   global $maindb;
   $promemo="";
 $protypetitle = $maindb->Execute("SELECT Memo FROM t_protype WHERE Language=? AND ID=?",array ($language,$bid));
   if($protypetitle->RecordCount() == 1){
   $promemo = $protypetitle->fields[0];
   }  
   
   return $promemo;

}
?>

<?php

function promemo($name,$language){
   global $maindb;
   $promemo="";
 $protypetitle = $maindb->Execute("SELECT Memo FROM t_protype WHERE Language=? AND Called=?",array ($language,$name));
   if($protypetitle->RecordCount() == 1){
   $promemo = $protypetitle->fields[0];
   }  
   
   return $promemo;

}
?>


<?php

function titleId($qId,$language){
   global $maindb;
   $proID="";
   $protypeID = $maindb->Execute("SELECT TypeID FROM t_products WHERE Language=? AND ID=?",array ($language,$qId));
   if($protypeID->RecordCount() == 1){
   $proID = $protypeID->fields[0];
   }  
   
   return $proID;

}
?>




 <?php
 
 function pregstring( $str ){  

 $strtemp = trim($str);  

 $search = array(  

 "|'|Uis",  

 "|<script[^>]*?>.*?</script>|Uis", // 去掉 javascript  

 "|<[\/\!]*?[^<>]*?>|Uis", // 去掉 HTML 标记  

 "'>(quot|#34);'i", // 替换 HTML 实体  

 "'>(amp|#38);'i",  

 "|,|Uis",  

 "|[\s]{2,}|is",  

 "[>nbsp;]isu",  

 "|[$]|Uis",  

 );  

 $replace = array(  

 "`",  

 "",  

 "",  

 "",  

 "",  

 "",  

" ",  

" ",  

 " dollar ",  

 );  

 $text = preg_replace($search, $replace, $strtemp);  

 return $text;  

 } 
?>









