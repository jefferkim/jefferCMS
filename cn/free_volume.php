<?include_once("../config.php")?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://www.czsuofeiya.com/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">

</head>

<body>

<div id="main">

<? require_once('header.php');?>


<div id="center">


<div class="ny_cont">

<div class="ny_left">
 
 <div class="title"><img src="images/ny_left_a.jpg" width="239" height="121" /></div>
 
 <ul>
 <li><a href="about.php?gid=0">公司简介</a></li>
 <li><a href="about.php?gid=1">荣誉资质</a></li>
 <li><a href="about.php?gid=2">联系我们</a></li>
 </ul>
</div>


  <?
 $linkurl = $_SERVER["PHP_SELF"]."?";
 $typename="";
 $typeID=$_REQUEST['gid']?$_REQUEST['gid']:0;
 
switch($typeID){
 case 0:
	  $typename="公司简介";
	  break;
 case 1:
	  $typename="荣誉资质";
  break;
 case 2:
	  $typename="联系我们";
  break;
}
 ?>  

<style>
label{ padding-right:16px; padding-left:5px;}
.table_td_b{ line-height:24px;}
.table_td_a{ line-height:24px;}

</style>

<div class="ny_right">
 
 <div class="title"><img src="images/pic.jpg" width="706" height="113" /></div>
 
 <div class="cont">
  

  <?
if (isset($_POST['submit']))
{
	$content = "";
	while(list($key,$val) = each($_POST))
	{
		if ($key == "submit" || $key == "reset")
			continue;
		$content .= $key.":".$val."<br />";
	}
	$r = array(
		'Name' => date("Y-m-d H:i:s"),
		'Content' => $content,
		'NoteTime' => date("Y-m-d H:i:s"),
		'Ip' => GetIPAddr(),
		'Language' => "cn"
	);
	$maindb->AutoExecute("t_feedback",$r,"INSERT");
	echo "<script>alert('提交成功');</script>";
}
?>
  <script language="JavaScript" type="text/JavaScript">
function check(){ 
var obj = document.form; 
var checknum=/^(-|+)?d+$/; 
var checkemail=/^w+((-w+)|(.w+))*@[A-Za-z0-9]+((.|-)[A-Za-z0-9]+)*.[A-Za-z0-9]+$/; 
if (obj.姓名.value == "") 
{ 
alert("请填写姓名！"); 
return false; 
} 
if (obj.电话.value == "") 
{ 
alert("请填写电话！");  
return false;
}
 }
    </script>
 

<table width="100%" border="0" cellpadding="0" cellspacing="1" style="background-color:#f2e5cd;">
         <form action="<?=$_SERVER["PHP_SELF"]?>" method="post" name="form" onsubmit="return check();">
          <tr>
            <td colspan="2"  class="table_t">注：带 <span>*</span> 为必填项<span></span></td>
          </tr>
          <tr>
            <td width="21%" class="table_td_a">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</td>
            <td width="79%" class="table_td_a"><input type="text" name="姓名" id="GuestName" class="form_textfield" style="width:200px;"/>
            <span>* </span></td>
          </tr>
          <tr>
            <td class="table_td_b">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别： </td>
            <td class="table_td_b"> <input type="radio" name="性别" value="男" id="sex_0" />男&nbsp;&nbsp;&nbsp;<input type="radio" name="性别" value="女" id="sex_1" />女 &nbsp;&nbsp;&nbsp;<span>* </span></td>
          </tr>
          <tr>
            <td width="21%" class="table_td_a">联系电话：</td>
            <td width="79%" class="table_td_a">
              <input type="text" name="联系电话" id="Tel" class="form_textfield" style="width:200px;"/>
              <span>* </span></td>
          </tr>
          <tr>
            <td class="table_td_b">电子邮箱： </td>
            <td class="table_td_b"><input type="text" name="电子邮箱" id="Email" class="form_textfield" style="width:200px;"/><span>* </span></td>
          </tr>
          <tr>
            <td width="21%" class="table_td_a">QQ 号码：</td>
            <td width="79%" class="table_td_a"><input type="text" name="QQ号码" id="QQ" class="form_textfield" style="width:200px;"/></td>
          </tr>
          <tr>
            <td class="table_td_b">地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址： </td>
            <td class="table_td_b"><input type="text" name="地址" id="Address" class="form_textfield" style="width:200px;"/>
              <span>* </span></td>
          </tr>
          <tr>
            <td colspan="2"  class="table_t"><span style="font-size:14px;"><strong>定制需求</strong></span>
              </td>
          </tr>
          <tr>
            <td width="21%" class="table_td_a"> 希望量尺时间 ：</td>
            <td width="79%" class="table_td_a"><input type="radio" name="希望量尺时间" value="一周内" id="week_0" /><label for="week_0">一周内</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="希望量尺时间" value="两周内" id="week_1" /><label for="week_1">两周内</label>&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td class="table_td_b" style="height:78px;">量尺房间： </td>
            <td class="table_td_b"> <p>
<!--              <input id="f_dz_2_0" type="checkbox" name="f_dz_2:0">
              <label for="f_dz_2_0">全部</label>
              &nbsp;&nbsp;<input id="f_dz_2_1" type="checkbox" name="f_dz_2:1">
              <label for="f_dz_2_1">主人房</label>
              &nbsp;&nbsp;<input id="f_dz_2_2" type="checkbox" name="f_dz_2:2">
              <label for="f_dz_2_2">客人房</label>
              &nbsp;&nbsp;<input id="f_dz_2_3" type="checkbox" name="f_dz_2:3">
              <label for="f_dz_2_3">儿童房</label>
              &nbsp;&nbsp;<input id="f_dz_2_4" type="checkbox" name="f_dz_2:4">
              <label for="f_dz_2_4">书房</label>
              &nbsp;&nbsp;
              <label for="f_dz_2"></label>
              &nbsp;&nbsp;</p>
              <p>
                <input id="f_dz_2_5" type="checkbox" name="f_dz_2:5">
                <label for="f_dz_2_5">客厅</label>
                &nbsp;&nbsp;<input id="f_dz_2_6" type="checkbox" name="f_dz_2:6">
                <label for="f_dz_2_6">玄关</label>
                &nbsp;&nbsp;<input id="f_dz_2_7" type="checkbox" name="f_dz_2:7">
                <label for="f_dz_2_7">其它</label>
-->
              <input id="Rooms_0" type="checkbox" name="量尺房间" value="全部">
              <label for="Rooms_0">全部</label>
              &nbsp;&nbsp;<input id="Rooms_1" type="checkbox" name="量尺房间" value="主人房">
              <label for="Rooms_1">主人房</label>
              &nbsp;&nbsp;<input id="Rooms_2" type="checkbox" name="量尺房间" value="客人房">
              <label for="Rooms_2">客人房</label>
              &nbsp;&nbsp;<input id="Rooms_3" type="checkbox" name="量尺房间" value="儿童房">
              <label for="Rooms_3">儿童房</label>
              &nbsp;&nbsp;<input id="Rooms_4" type="checkbox" name="量尺房间" value="书房">
              <label for="Rooms_4">书房</label>
              &nbsp;</p>
              <p>
                <input id="Rooms_5" type="checkbox" name="量尺房间" value="客厅">
                <label for="Rooms_5">客厅</label>
                &nbsp;&nbsp;<input id="Rooms_6" type="checkbox" name="量尺房间" value="玄关">
                <label for="Rooms_6">玄关</label>
                &nbsp;&nbsp;<input id="Rooms_7" type="checkbox" name="量尺房间" value="其它">
                <label for="Rooms_7">其它</label>
              </p></td>
          </tr>
          <tr>
            <td width="21%" class="table_td_a"> 装修阶段：</td>
            <td width="79%" class="table_td_a"><input id="Part_0" type="radio" name="装修阶段" value="准备装修"><label for="Part_0">准备装修</label>
              &nbsp;
              <input id="Part_1" type="radio" name="装修阶段" value="正在装修"><label for="Part_1">正在装修</label>
              <input id="Part_2" type="radio" name="装修阶段" value="已经装修完"><label for="Part_2">已经装修完</label></td>
          </tr>
          <tr>
            <td class="table_td_b"> 装修类型： </td>
            <td class="table_td_b"><input id="RoomType_0" type="radio" name="装修类型" value="毛坯房"><label for="RoomType_0">毛坯房</label>
              &nbsp; &nbsp;&nbsp;&nbsp;
              <input id="RoomType_1" type="radio" name="装修类型" value="精修房"><label for="RoomType_1">精修房</label>
&nbsp;&nbsp;&nbsp;
<input id="RoomType_2" type="radio" name="装修类型" value="二次装修"><label for="RoomType_2">二次装修</label>&nbsp;</td>
          </tr>
          <tr>
            <td width="21%" class="table_td_a"> 户  &nbsp;&nbsp;  型： </td>
            <td width="79%" class="table_td_a"><input id="HuType_0" type="radio" name="户型" value="洋房"><label for="HuType_0">洋房</label>&nbsp;&nbsp;<input id="HuType_1" type="radio" name="户型" value="复式"><label for="HuType_1">复式</label>&nbsp;&nbsp;<input id="HuType_2" type="radio" name="户型" value="别墅"><label for="HuType_2">别墅</label></td>
          </tr>
          <tr>
            <td class="table_td_b" style="height:78px;"> 面&nbsp;&nbsp;    积： </td>
            <td class="table_td_b"><p>
              <input id="area_0" type="radio" name="面积" value="80平米以下">
              <label for="area_0">80平米以下</label>
              &nbsp;&nbsp;&nbsp;<input id="area_1" type="radio" name="面积" value="80-100平米">
              <label for="area_1">80-100平米</label>
              &nbsp;&nbsp;&nbsp;<input id="area_2" type="radio" name="面积" value="100-120平米">
              <label for="area_2">100-120平米</label>
              &nbsp;&nbsp;&nbsp;</p>
              <p>
                <input id="area_3" type="radio" name="面积" value="120-150平米">
                <label for="area_3">120-150平米</label>
                &nbsp;&nbsp;&nbsp;<input id="area_4" type="radio" name="面积" value="150平米以上">
                <label for="area_4">150平米以上</label>
              </p></td>
          </tr>
          <tr>
            <td width="21%" class="table_td_a"> 计划入住时间：</td>
            <td width="79%" class="table_td_a"><input id="LiveInTime_0" type="radio" name="计划入住时间" value="2周内"><label for="LiveInTime_0">2周内</label>&nbsp;&nbsp;<input id="LiveInTime_1" type="radio" name="计划入住时间" value="1个月内"><label for="LiveInTime_1">1个月内</label>&nbsp;&nbsp;<input id="LiveInTime_2" type="radio" name="计划入住时间" value="2个月内"><label for="LiveInTime_2">2个月内</label>&nbsp;&nbsp;<input id="LiveInTime_3" type="radio" name="计划入住时间" value="3个月内"><label for="LiveInTime_3">3个月内</label>&nbsp;&nbsp;<input id="LiveInTime_4" type="radio" name="计划入住时间" value="3个月后"><label for="LiveInTime_4">3个月后</label></td>
          </tr>
          <tr>
            <td class="table_td_b" style="height:128px;">准备购买产品： </td>
            <td class="table_td_b"><p>
              <input id="Products_0" type="checkbox" name="准备购买产品" value="衣柜">
              <label for="Products_0">衣柜</label>
              &nbsp;&nbsp;<input id="Products_1" type="checkbox" name="准备购买产品" value="衣帽间">
              <label for="Products_1">衣帽间</label>
              &nbsp;&nbsp;<input id="Products_2" type="checkbox" name="准备购买产品" value="梳妆台">
              <label for="Products_2">梳妆台</label>
              &nbsp;&nbsp;<input id="Products_3" type="checkbox" name="准备购买产品" value="床头柜">
              <label for="Products_3">床头柜</label>
              &nbsp;&nbsp;<input id="Products_4" type="checkbox" name="准备购买产品" value="斗柜">
              <label for="Products_4">斗柜</label>
              &nbsp;&nbsp;</p>
              <p>
                <input id="Products_5" type="checkbox" name="准备购买产品" value="床">
                <label for="Products_5">床</label>
                &nbsp;&nbsp;<input id="Products_6" type="checkbox" name="准备购买产品" value="饰物柜">
                <label for="Products_6">饰物柜</label>
                &nbsp;&nbsp;<input id="Products_7" type="checkbox" name="准备购买产品" value="书柜">
                <label for="Products_7">书柜</label>
                &nbsp;&nbsp;<input id="Products_8" type="checkbox" name="准备购买产品" value="电脑台">
                <label for="Products_8">电脑台</label>
                &nbsp;&nbsp;<input id="Products_9" type="checkbox" name="准备购买产品" value="电视柜">
                <label for="Products_9">电视柜</label>
                &nbsp;&nbsp;</p>
              <p>
                <input id="Products_10" type="checkbox" name="准备购买产品" value="酒柜">
                <label for="Products_10">酒柜</label>
                &nbsp;&nbsp;<input id="Products_11" type="checkbox" name="准备购买产品" value="餐边柜">
                <label for="Products_11">餐边柜</label>
                &nbsp;&nbsp;<input id="Products_12" type="checkbox" name="准备购买产品" value="入户柜">
                <label for="Products_12">入户柜</label>
                &nbsp;&nbsp;<input id="Products_13" type="checkbox" name="准备购买产品" value="玄关柜">
                <label for="Products_13">玄关柜</label>
                &nbsp;&nbsp;<input id="Products_14" type="checkbox" name="准备购买产品" value="鞋柜">
                <label for="Products_14">鞋柜</label>
              </p>
              <p>其它:<input type="text" name="准备购买产品" id="Products1" class="form_textfield" style="width:200px;"/></p></td>
          </tr>
          <tr>
            <td width="21%" class="table_td_a" style="height:78px;"> 定制总预算： </td>
            <td width="79%" class="table_td_a"><p>
              <input id="Budget_0" type="radio" name="定制总预算" value="5千元以下">
              <label for="Budget_0">5千元以下</label>
              &nbsp;&nbsp;<input id="Budget_1" type="radio" name="定制总预算" value="5千-1万元">
              <label for="Budget_1">5千-1万元</label>
              &nbsp;&nbsp;<input id="Budget_2" type="radio" name="定制总预算" value="1万-2万元">
              <label for="Budget_2">1万-2万元</label>
              &nbsp;&nbsp;</p>
              <p>
                <input id="Budget_3" type="radio" name="定制总预算" value="2万元-3万元">
                <label for="Budget_3">2万元-3万元</label>
                &nbsp;&nbsp;<input id="Budget_4" type="radio" name="定制总预算" value="3万元以上">
                <label for="Budget_4">3万元以上</label>
              </p></td>
          </tr>
          <tr>
            <td class="table_td_b">&nbsp;</td>
            <td class="table_td_b">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="table_f" style="height:108px;"><div class="form_bottom">
            <input type="submit" name="submit" value="提交" class="btn" />
            
             <input type="button" name="submit" value="返回" class="btn" onclick="window.location.href='index.php'" />
           
            </a></div></td>
          </tr>
          </form>
        </table>

 
 </div>

<style>
.btn{ background-color:#CCCCCC;font-size: 14px;line-height: 24px;padding:4px 20px; border:none; margin-right:10px; cursor:pointer}
</style>

</div>

</div>



</div>





</div>

<? require_once('footer.php');?>

</body>
</html>
<?include_once("bottom.php")?>