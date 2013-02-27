<?php
//分布条
//文本型

class TextPager implements IPager
{
	var $linker = "";
	var $items = 0;
	var $current = 1;
	var $lines = 9;
	var $paramName = "page";
	var $template = "";

	var $firstLabel = "首页";
	var $prevLabel = "上一页";
	var $nextLabel = "下一页";
	var $lastLabel = "尾页";

	function __construct($linker,$items,$currentPage=1,$lines=9)
	{
		$this->linker = $linker;
		$this->items = $items;
		$this->current = $currentPage;
		$this->lines = $lines;
	}

	//page参数名称
	function setParamName($name)
	{
		$this->paramName = $name;
	}

	//当前页数
	function setCurrentPage($page)
	{
		$this->current = $page;
	}

	//总记录数
	function setItems($items)
	{
		$this->items = $items;
	}

	//每页记录数
	function setLines($lines)
	{
		$this->lines = $lines;
	}

	//计算总页数
	function getTotalPager()
	{
		$result = intval($this->items/$this->lines);
		if ($this->items % $this->lines != 0)
			$result++;
		return $result;
	}

	function setTemplate($template)
	{
		$this->template = $template;
	}

	function setFirstText($text)
	{
		$this->firstLabel = $text;
	}

	function setPrevText($text)
	{
		$this->prevLabel = $text;
	}

	function setNextText($text)
	{
		$this->nextLabel = $text;
	}

	function setLastText($text)
	{
		$this->lastLabel = $text;
	}

	function getFirstLink()
	{
		if ($this->current <= 1)
			return $this->firstLabel;
		else
			return '<a href="'.$this->linker.$this->paramName.'=1">'.$this->firstLabel.'</a>';
	}

	function getPrevLink()
	{
		$prev = $this->current - 1;
		if ($this->current <= 1)
			return $this->prevLabel;
		else
			return '<a href="'.$this->linker.$this->paramName.'='.$prev.'">'.$this->prevLabel.'</a>';
	}

	function getNextLink()
	{
		$next = $this->current + 1;
		if ($this->current >= $this->getTotalPager())
			return $this->nextLabel;
		else
			return '<a href="'.$this->linker.$this->paramName.'='.$next.'">'.$this->nextLabel.'</a>';
	}

	function getLastLink()
	{
		if ($this->current >= $this->getTotalPager())
			return $this->lastLabel;
		else
			return '<a href="'.$this->linker.$this->paramName.'='.$this->getTotalPager().'">'.$this->lastLabel.'</a>';
	}

	function getSelection()
	{
		$result = "<select name='pager' onchange='location.href=\"".$this->linker.$this->paramName."=\"+this.value'>";
		for($index = 1; $index <= $this->getTotalPager(); $index++)
		{
			$selected = "";
			if ($index == $this->current)
				$selected = " selected=true";
			$result .= "<option value='".$index."'".$selected.">".$index."</option>";
		}
		$result .= "</select>";

		return $result;
	}

	function getNumLink()
	{
		$result = "";
		
		$result = $this->getFirstNumLink().$this->getMiddleNumLink().$this->getLastNumLink();

		return $result;
	}

	function getFirstNumLink()
	{
		if ($this->current <= 1)
			return '<span class="selected">1</span>';
		else
			return '<span><a href="'.$this->linker.$this->paramName.'=1">1</span>';
	}

	function getLastNumLink()
	{
		if ($this->getTotalPager() <= 1)
			return "";
		if ($this->current == $this->getTotalPager())
			return '<span class="selected">'.$this->getTotalPager().'</span>';
		else
			return '<span><a href="'.$this->linker.$this->paramName.'='.$this->getTotalPager().'">'.$this->getTotalPager().'</span>';
	}

	function getMiddleNumLink()
	{
		if ($this->getTotalPager() <= 2)
			return "";
		$start = $this->current - 2;
		$end = $this->current + 2;
		if ($start < 2)
			$start = 2;
		if ($end >= $this->getTotalPager())
			$end = $this->getTotalPager() - 1;

		if ($start > $end)
			return "";
		if ($start == $end)
		{
			return '<span class="selected">'.$this->current.'</span>';
		}

		$result = '<span><a href="'.$this->linker.$this->paramName.'='.$start.'">...</span>';
		for($index=$start+1;$index<$end;$index++)
		{
			if ($this->current == $index)
				$result .= '<span class="selected">'.$index.'</span>';
			else
				$result .= '<span><a href="'.$this->linker.$this->paramName.'='.$index.'">'.$index.'</a></span>';
		}
		$result .= '<span><a href="'.$this->linker.$this->paramName.'='.$end.'">...</span>';

		return $result;
	}

	//输出结果
	function render()
	{
		if ($this->template == "")
			$this->setTemplate("<span>共有{current}/{totalPage}页，每页显示{lines}条</span><span class='first'>{first}</span><span class='prev'>{prev}</span><span class='next'>{next}</span><span class='last'>{last}</span>");

		$template = str_replace("{current}",$this->current,$this->template);
		$template = str_replace("{totalPage}",$this->getTotalPager(),$template);
		$template = str_replace("{lines}",$this->lines,$template);
		$template = str_replace("{items}",$this->items,$template);
		$template = str_replace("{first}",$this->getFirstLink(),$template);
		$template = str_replace("{prev}",$this->getPrevLink(),$template);
		$template = str_replace("{next}",$this->getNextLink(),$template);
		$template = str_replace("{last}",$this->getLastLink(),$template);
		$template = str_replace("{select}",$this->getSelection(),$template);
		$template = str_replace("{numlink}",$this->getNumLink(),$template);
		return $template;
	}
}
?>