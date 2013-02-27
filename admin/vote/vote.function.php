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
function GetSubVoteType($db)
{
	
$rd = $db->Execute("SELECT * FROM t_vote ORDER BY id");

while(!$rd->EOF)
{
	$obj = $rd->FetchObject();
	$typeArr[$obj->ID] = utf8substr($obj->SUBJECT,22,"...");
	$rd->MoveNext();
}

	return $typeArr;
}
?>