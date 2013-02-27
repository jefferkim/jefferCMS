<?
//分页条
//Date:08-05-04
//zjb

/****************************************************

$pager = new Pager("xx.php?",10);
$result = $pager->render();
echo $result;

*****************************************************/


class Pager
{
	var $style = 1;			//显示风格(1：文字，2：数字)
	var $css = "";			//链接CSS
	var $innercss = "";		//内置CSS
	var $paramName = "page";//分页参数名称，默认page
	var $current = 1;		//当前页
	var $first = "首页";	//首页链接文字
	var $last = "尾页";		//尾页链接文字
	var $prev = "上一页";	//上一页链接文字
	var $next = "下一页";	//下一页链接文字
	var $items = 0;			//总记录数
	var $lines = 9;		//每页显示条数，默认10条
	var $totalPagers = 0;	//总页数
	var $linker = "";		//连接页
	var $numCounts = 3;		//数字方式显示时，前后显示的连接个数
	var $selectedCss = "";	//数字方式显示时，当前页的CSS
	var $prevCss = "";		//数字方式显示时，前一页的CSS
	var $nextCss = "";		//数字方式显示时，后一页的CSS
	var $lanAll = "共有";
	var $lanItems = "条";
	var $useRewrite = false;
	var $addbase = true;

	//初始化，设置链接及总记录数
	function Pager($link,$items,$currentPage=1,$lines=9)
	{
		$tmpArr = explode('?',$link);
		if (count($tmpArr) <= 1)
			$link = $link."?";
		if (substr($link,-1) != '?')
			$link = $link."&";
		$this->linker = $link;
		$this->items = $items;
		$this->lines = $lines;
		$this->current = $currentPage;

		$this->totalPagers = $this->getTotalPager($items,$this->lines);
	}

	//设置分页参数名称
	function setParamName($name)
	{
		$this->paramName = $name;
	}

	//设置当前页
	function setCurrentPage($page)
	{
		$this->current = $page;
	}

	//设置显示风格
	function setStyle($style)
	{
		$this->style = $style;
	}

	//设置CSS
	function setCss($css)
	{
		$this->css = $css;
	}

	//设置内置CSS
	function setInnerCss($css)
	{
		$this->innercss = $css;
	}

	function setSelectedCss($css)
	{
		$this->selectedCss = $css;
	}

	function setPrevCss($css)
	{
		$this->prevCss = $css;
	}

	function setNextCss($css)
	{
		$this->nextCss = $css;
	}

	//设置首页文字
	function setFirstText($text)
	{
		$this->first = $text;
	}

	//设置尾页文字
	function setLastText($text)
	{
		$this->last = $text;
	}

	//设置上一页文字
	function setPrevText($text)
	{
		$this->prev = $text;
	}

	//设置下一页文字
	function setNextText($text)
	{
		$this->next = $text;
	}

	//设置总记录数
	function setItems($items)
	{
		$this->items = $items;

		$this->totalPagers = $this->getTotalPager($items,$this->lines);
	}

	//设置每页显示条数
	function setLines($lines)
	{
		$this->lines = $lines;

		$this->totalPagers = $this->getTotalPager($this->items,$lines);
	}

	//计算总页数
	private function getTotalPager($items,$lines)
	{
		$total = intval($items/$lines);
		if ($items % $lines != 0)
			$total++;

		return $total;
	}

	private function buildUrl($page)
	{
		$url_tmparr = explode("?",$this->linker);
		$url = $this->linker;
		$paras = array();
		if (count($url_tmparr) >= 1)
			$url = $url_tmparr[0];
		
		if (isset($url_tmparr[1]))
		{
			$para_tmparr = explode("&",$url_tmparr[1]);
			foreach($para_tmparr as $para_tmp){
				if ($para_tmp == "")
					continue;
				$tmp = explode("=",$para_tmp);
				if (count($tmp) > 0){
					$paras[$tmp[0]] = isset($tmp[1]) ? $tmp[1] : "";
				}
			}
		}
		$paras[$this->paramName] = $page;

		if ($this->useRewrite !== false)
			return RewriteUrl($this->useRewrite, $paras,$this->addbase);
		else
			return UnRewriteUrl($url, $paras);
	}

	/*private function rewriteUrl($str, $paras)
	{
		$retUrl = str_replace("-","_",$str);
		$retUrl = str_replace(" ","_",$str);
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

		return $retUrl;
	}

	private function unRewriteUrl($url, $paras)
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
	}*/

	//生成文字分页
	private function renderText()
	{
		$css = "";
		if ($this->css != "")
			$css = ' class="'.$this->css.'"';
		$style = "";
		if ($this->innercss != "")
			$style = ' style="'.$this->innercss.'"';

		$linker = $this->linker.$this->paramName.'=';

		$prev = $this->current - 1;
		if ($prev < 1)
			$prev = 1;
		$next = $this->current + 1;
		if ($next > $this->totalPagers)
			$next = $this->totalPagers;

		$pref = "<span class='total'>".$this->lanAll.$this->items.$this->lanItems."&nbsp;&nbsp;</span><span".$css.$style.">".$this->current."/".$this->totalPagers."</span>";

		if ($this->current <= 1)
		{
			$firstLink = "<span>".$this->first."</span>";
			$prevLink = "<span>".$this->prev."</span>";
		}
		if ($this->current == $this->totalPagers || $this->totalPagers <= 0)
		{
			$lastLink = "<span>".$this->last."</span>";
			$nextLink = "<span>".$this->next."</span>";
		}
		if ($this->totalPagers > 1)
		{
			if ($this->current <= 1)
			{
				$firstLink == "<span>".$this->first."</span>";
				$prevLink = "<span>".$this->prev."</span>";
			}
			else
			{
				$firstLink = '<span><a href="'.$this->buildUrl(1).'"'.$css.$style.'>'.$this->first.'</a></span>';
				$prevLink = '<span><a href="'.$this->buildUrl($prev).'"'.$css.$style.'>'.$this->prev.'</a></span>';
			}
			if ($this->current >= $this->totalPagers)
			{
				$lastLink = "<span>".$this->last."</span>";
				$nextLink = "<span>".$this->next."</span>";
			}
			else
			{
				$lastLink = '<span><a href="'.$this->buildUrl($this->totalPagers).'"'.$css.$style.'>'.$this->last.'</a></span>';
				$nextLink = '<span><a href="'.$this->buildUrl($next).'"'.$css.$style.'>'.$this->next.'</a></span>';
			}
		}

		$selectJs = "location.href=this.value";
		$select = '<span><select onchange="'.$selectJs.'">';
		for ($iPager = 1; $iPager<=$this->totalPagers; $iPager++)
		{
			if ($iPager == $this->current)
				$select .= '<option value="'.$this->buildUrl($iPager).'" selected>'.$iPager.'</option>';
			else
				$select .= '<option value="'.$this->buildUrl($iPager).'">'.$iPager.'</option>';
		}
		$select .= '</select></span>';

		$result = $pref.$firstLink.$prevLink.$nextLink.$lastLink.$select;
		return $result;
	}

	//生成数字分页
	private function renderNum()
	{
		$css = "";
		if ($this->css != "")
			$css = ' class="'.$this->css.'"';
		$style = "";
		if ($this->innercss != "")
			$style = ' style="'.$this->innercss.'"';
		$prevCss = "";
		if ($this->prevCss != "")
			$prevCss = ' class="'.$this->prevCss.'"';
		$nextCss = "";
		if ($this->nextCss != "")
			$nextCss = ' class="'.$this->nextCss.'"';
		$selectedCss = "";
		if ($this->selectedCss != "")
			$selectedCss = ' class="'.$this->selectedCss.'"';

		$linker = $this->linker.$this->paramName.'=';
		$prev = $this->current - 1;
		if ($prev < 1)
			$prev = 1;
		$next = $this->current + 1;
		if ($next > $this->totalPagers)
			$next = $this->totalPagers;

		if ($prevCss == "")
			$prevCss = $css;
		if ($nextCss == "")
			$nextCss = $css;
		if ($this->current > 1)
			$prevLink = '<span><a href="'.$this->buildUrl($prev).'"'.$prevCss.'>'.$this->prev.'</a></span>';
		else
			$prevLink = '<span><a href="#">'.$this->prev.'</a></span>';
		if ($this->current < $this->totalPagers)
			$nextLink = '<span><a href="'.$this->buildUrl($next).'"'.$nextCss.'>'.$this->next.'</a></span>';
		else
			$nextLink = '<span><a href="#">'.$this->next.'</a></span>';

		if ($this->numCounts > $this->totalPagers)
			$this->numCounts = $this->totalPagers;
		$prevLinks = '';
		for ($iPager = 1; $iPager<=$this->numCounts; $iPager++)
		{
			if ($iPager == $this->current)
				$thisCss = $selectedCss;
			else
				$thisCss = $css;
			$prevLinks .= '<span><a href="'.$this->buildUrl($iPager).'"'.$thisCss.$style.'>'.$iPager.'</a></span>';
		}

		$nextStart = $this->totalPagers - 2;
		if ($nextStart < 4)
			$nextStart = 4;
		$nextLinks = '';
		for ($iPager = $nextStart; $iPager <= $this->totalPagers; $iPager++)
		{
			if ($iPager == $this->current)
				$thisCss = $selectedCss;
			else
				$thisCss = $css;
			$nextLinks .= '<span '.$thisCss.$style.'><a href="'.$this->buildUrl($iPager).'">'.$iPager.'</a></span>';
		}

		$middleStart = $this->current - 2;
		if ($middleStart < 4)
			$middleStart = 4;
		$middleEnd = $this->current + 2;
		if ($middleEnd > ($nextStart - 1))
			$middleEnd = $nextStart - 1;

		$middleLinks = '';
		if ($middleStart > 4)
			$middleLinks .= '<span><a href="'.$this->buildUrl($middleStart-1).'"'.$css.$style.'>...</a></span>';
		for ($iPager = $middleStart; $iPager <= $middleEnd; $iPager++)
		{
			if ($iPager == $this->current)
				$thisCss = $selectedCss;
			else
				$thisCss = $css;
			$middleLinks .= '<span><a href="'.$this->buildUrl($iPager).'"'.$thisCss.$style.'>'.$iPager.'</a></span>';
		}
		if ($middleEnd < $nextStart-1)
			$middleLinks .= '<span><a href="'.$this->buildUrl($middleEnd+1).'"'.$css.$style.'>...</a></span>';

		$result = $prevLink.$prevLinks.$middleLinks.$nextLinks.$nextLink;
		return $result;
	}

	function renderPrevNext()
	{
		$css = "";
		if ($this->css != "")
			$css = ' class="'.$this->css.'"';
		$style = "";
		if ($this->innercss != "")
			$style = ' style="'.$this->innercss.'"';

		$linker = $this->linker.$this->paramName.'=';

		$prev = $this->current - 1;
		if ($prev < 1)
			$prev = 1;
		$next = $this->current + 1;
		if ($next > $this->totalPagers)
			$next = $this->totalPagers;

		$pref = "<span class='total'>".$this->lanAll.$this->items.$this->lanItems."&nbsp;&nbsp;</span><span".$css.$style.">".$this->current."/".$this->totalPagers."</span>";

		if ($this->current <= 1)
		{
			$firstLink = "<span>".$this->first."</span>";
			$prevLink = "<span>".$this->prev."</span>";
		}
		if ($this->current == $this->totalPagers || $this->totalPagers <= 0)
		{
			$lastLink = "<span>".$this->last."</span>";
			$nextLink = "<span>".$this->next."</span>";
		}
		if ($this->totalPagers > 1)
		{
			if ($this->current <= 1)
			{
				$firstLink == "<span>".$this->first."</span>";
				$prevLink = "<span>".$this->prev."</span>";
			}
			else
			{
				$firstLink = '<span><a href="'.$this->buildUrl(1).'"'.$css.$style.'>'.$this->first.'</a></span>';
				$prevLink = '<span><a href="'.$this->buildUrl($prev).'"'.$css.$style.'>'.$this->prev.'</a></span>';
			}
			if ($this->current >= $this->totalPagers)
			{
				$lastLink = "<span>".$this->last."</span>";
				$nextLink = "<span>".$this->next."</span>";
			}
			else
			{
				$lastLink = '<span><a href="'.$this->buildUrl($this->totalPagers).'"'.$css.$style.'>'.$this->last.'</a></span>';
				$nextLink = '<span><a href="'.$this->buildUrl($next).'"'.$css.$style.'>'.$this->next.'</a></span>';
			}
		}

		$selectJs = "location.href=this.value";
		$select = '<span><select onchange="'.$selectJs.'">';
		for ($iPager = 1; $iPager<=$this->totalPagers; $iPager++)
		{
			if ($iPager == $this->current)
				$select .= '<option value="'.$this->buildUrl($iPager).'" selected>'.$iPager.'</option>';
			else
				$select .= '<option value="'.$this->buildUrl($iPager).'">'.$iPager.'</option>';
		}
		$select .= '</select></span>';

		$result = $prevLink.$nextLink;
		return $result;
	}

	function renderFPNL()
	{
		$css = "";
		if ($this->css != "")
			$css = ' class="'.$this->css.'"';
		$style = "";
		if ($this->innercss != "")
			$style = ' style="'.$this->innercss.'"';

		$linker = $this->linker.$this->paramName.'=';

		$prev = $this->current - 1;
		if ($prev < 1)
			$prev = 1;
		$next = $this->current + 1;
		if ($next > $this->totalPagers)
			$next = $this->totalPagers;

		$pref = "<span class='total'>".$this->lanAll.$this->items.$this->lanItems."&nbsp;&nbsp;</span><span".$css.$style.">".$this->current."/".$this->totalPagers."</span>";

		if ($this->current <= 1)
		{
			$firstLink = "<span>".$this->first."</span>";
			$prevLink = "<span>".$this->prev."</span>";
		}
		if ($this->current == $this->totalPagers || $this->totalPagers <= 0)
		{
			$lastLink = "<span>".$this->last."</span>";
			$nextLink = "<span>".$this->next."</span>";
		}
		if ($this->totalPagers > 1)
		{
			if ($this->current <= 1)
			{
				$firstLink == "<span>".$this->first."</span>";
				$prevLink = "<span>".$this->prev."</span>";
			}
			else
			{
				$firstLink = '<span><a href="'.$this->buildUrl(1).'"'.$css.$style.'>'.$this->first.'</a></span>';
				$prevLink = '<span><a href="'.$this->buildUrl($prev).'"'.$css.$style.'>'.$this->prev.'</a></span>';
			}
			if ($this->current >= $this->totalPagers)
			{
				$lastLink = "<span>".$this->last."</span>";
				$nextLink = "<span>".$this->next."</span>";
			}
			else
			{
				$lastLink = '<span><a href="'.$this->buildUrl($this->totalPagers).'"'.$css.$style.'>'.$this->last.'</a></span>';
				$nextLink = '<span><a href="'.$this->buildUrl($next).'"'.$css.$style.'>'.$this->next.'</a></span>';
			}
		}

		$selectJs = "location.href=this.value";
		$select = '<span><select onchange="'.$selectJs.'">';
		for ($iPager = 1; $iPager<=$this->totalPagers; $iPager++)
		{
			if ($iPager == $this->current)
				$select .= '<option value="'.$this->buildUrl($iPager).'" selected>'.$iPager.'</option>';
			else
				$select .= '<option value="'.$this->buildUrl($iPager).'">'.$iPager.'</option>';
		}
		$select .= '</select></span>';

		$result = $pref.$firstLink.$prevLink.$nextLink.$lastLink;
		return $result;
	}

	function renderText1()
	{
		$css = "";
		if ($this->css != "")
			$css = ' class="'.$this->css.'"';
		$style = "";
		if ($this->innercss != "")
			$style = ' style="'.$this->innercss.'"';

		$linker = $this->linker.$this->paramName.'=';

		$prev = $this->current - 1;
		if ($prev < 1)
			$prev = 1;
		$next = $this->current + 1;
		if ($next > $this->totalPagers)
			$next = $this->totalPagers;

		$pref = "<span class='total'>".$this->lanAll.$this->items.$this->lanItems."&nbsp;&nbsp;</span><span".$css.$style.">".$this->current."/".$this->totalPagers."</span>";

		if ($this->current <= 1)
		{
			$firstLink = "<span>".$this->first."</span>";
			$prevLink = "<span>".$this->prev."</span>";
		}
		if ($this->current == $this->totalPagers || $this->totalPagers <= 0)
		{
			$lastLink = "<span>".$this->last."</span>";
			$nextLink = "<span>".$this->next."</span>";
		}
		if ($this->totalPagers > 1)
		{
			if ($this->current <= 1)
			{
				$firstLink == "<span>".$this->first."</span>";
				$prevLink = "<span>".$this->prev."</span>";
			}
			else
			{
				$firstLink = '<span><a href="'.$this->buildUrl(1).'"'.$css.$style.'>'.$this->first.'</a></span>';
				$prevLink = '<span><a href="'.$this->buildUrl($prev).'"'.$css.$style.'>'.$this->prev.'</a></span>';
			}
			if ($this->current >= $this->totalPagers)
			{
				$lastLink = "<span>".$this->last."</span>";
				$nextLink = "<span>".$this->next."</span>";
			}
			else
			{
				$lastLink = '<span><a href="'.$this->buildUrl($this->totalPagers).'"'.$css.$style.'>'.$this->last.'</a></span>';
				$nextLink = '<span><a href="'.$this->buildUrl($next).'"'.$css.$style.'>'.$this->next.'</a></span>';
			}
		}

		$selectJs = "location.href=this.value";
		$select = '<span><select onchange="'.$selectJs.'">';
		for ($iPager = 1; $iPager<=$this->totalPagers; $iPager++)
		{
			if ($iPager == $this->current)
				$select .= '<option value="'.$this->buildUrl($iPager).'" selected>'.$iPager.'</option>';
			else
				$select .= '<option value="'.$this->buildUrl($iPager).'">'.$iPager.'</option>';
		}
		$select .= '</select></span>';

		$result = $firstLink.$prevLink.$nextLink.$lastLink;
		return $result;
	}

	//返回生成的分页链接
	function render()
	{
		$text = "";
		switch($this->style)
		{
			case 1:
				$text = $this->renderText();
				break;
			case 2:
				$text = $this->renderNum();
				break;
			case 3:
				$text = $this->renderPrevNext();
				break;
			case 4:
				$text = $this->renderFPNL();
				break;
			case 5:
				$text = $this->renderText1();
				break;
			default:
				$text = $this->renderText();
				break;
		}

		return $text;
	}
}
?>
