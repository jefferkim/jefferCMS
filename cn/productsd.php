<?include_once("../config.php")?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cs/base.css">
<link rel="stylesheet" type="text/css" href="cs/layout.css">
<link rel="stylesheet" type="text/css" href="cs/typography.css">
<script src="js/jquery.js"></script>
<script>
$(function(){
	$(".one_left ul li").hover(
		function(){
			$(this).addClass("current");
			$(this).find("div").show();
			
			},
		function(){
			$(this).removeClass("current");
			$(this).find("div").hide();
			})
	})
</script>
<LINK rel="stylesheet" type="text/css" href="js/nivo-slider.css" media="screen">
<SCRIPT type="text/javascript" src="js/jquery-1.7.1.min.js"></SCRIPT>
<SCRIPT type="text/javascript" src="js/jquery.preloader.min.js"></SCRIPT>
<SCRIPT type="text/javascript" src="js/jquery.nivo.slider.pack.js"></SCRIPT>
<SCRIPT type="text/javascript" src="js/custom.js"></SCRIPT>
</head>

<body>

<div id="main">

<? require_once('header.php');?>

<div id="center">
<div class="ny_pro">
  <div class="ny_pro_one">
      <div class="one_left">
        <ul>
        	<? 
			
			  $protypeObj=protypelist("0","cn","50");
              $protypeArr=$protypeObj['protypeArr'];
              foreach($protypeArr as $protypeList){ 
			  ?>
			  
	  <li><a href="products.php?tid=<?=$protypeList->ID?>"><?=$protypeList->CALLED?></a>
        <div class="two_type">
         <dl>
         <span></span>
         <? 
			  $protypeObj=protypelist($protypeList->ID,"cn","50");
              $protypeArr=$protypeObj['protypeArr'];
              foreach($protypeArr as $protypeList){ 
			  ?>
          <dt><a href="products.php?tid=<?=$protypeList->ID?>"><?=$protypeList->CALLED?></a></dt>
          <dd class="clearfix">
          
           <? 
			  $protypeObj=protypelist($protypeList->ID,"cn","50");
              $protypeArr=$protypeObj['protypeArr'];
              foreach($protypeArr as $protypeList){ 
			  ?>
              
              <a href="products.php?tid=<?=$protypeList->ID?>"><?=$protypeList->CALLED?></a>
                 <?
		   }

		   ?>
          
          </dd>
          
           <?
		   }

		   ?>
         </dl>
         </div>
        </li>
	   
	       <?
		   }

		   ?>
        
        
        </ul>
        
        <img src="images/p_one_left_foot.jpg" width="219" height="7" style="display:block" />
       </div>
      
      <div class="one_right"><!--<img src="images/flash.jpg" width="716" height="434" />-->
	  <div class="main-slider bottom-50"  width="716" height="434">
		<div id=slider class=nivoSlider>
			<IMG title=#htmlcaption alt="" src="js/image-0.jpg">
			<IMG title=#htmlcaption1 alt="" src="js/image-1.jpg">
			<IMG title=#htmlcaption2 alt="" src="js/image-2.jpg">
			<IMG title=#htmlcaption3 alt="" src="js/image-3.jpg">
		</div>
	  <div id=htmlcaption class=nivo-html-caption><SPAN>精致设计的卧室家具。</SPAN><A href="#"></A> </div>
	  <div id=htmlcaption1 class=nivo-html-caption><SPAN>精致大气的索菲亚书柜。</SPAN><A href="#"></A> </div>
	  <div id=htmlcaption2 class=nivo-html-caption><SPAN>精致设计的和谐家庭。</SPAN><A href="#"></A></div>
	  <div id=htmlcaption3 class=nivo-html-caption><SPAN>精致设计的和谐家庭。</SPAN><A href="#"></A> </div>
	  <div id=preloader></div>
	</div>
	  </div>
  </div>
  
  <div class="ny_pro_two">
   <div class="title"><img src="images/p_title.jpg" width="948" height="82" /></div>
  
   <div style="padding:15px;">
   
		   <?
        if (isset($_REQUEST['pid']) && $_REQUEST['pid']>0)
        {
            $pid = $_REQUEST['pid'];
            $proDetailRs = $maindb->Execute("SELECT * FROM t_products WHERE IsShow=1 AND id=?",array($pid));
            if ($proDetailRs->RecordCount() >0)
            {
                $proObj = $proDetailRs->FetchObject();
                ?>
        <div class="clear">
          <?=$proObj->CONTENT?>
        </div>
        
        <?
            }
        }
        ?>

   
   </div>
   
  </div>
 
  
 </div>
</div>





</div>

<? require_once('footer.php');?>

</body>
</html>
<?include_once("bottom.php")?>