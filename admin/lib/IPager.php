<?php
//分页接口

interface IPager
{
	//page参数名称
	function setParamName($name);
	//当前页数
	function setCurrentPage($page);
	//总记录数
	function setItems($items);
	//每页记录数
	function setLines($lines);
	//计算总页数
	function getTotalPager();
	//输出结果
	function render();
}
?>