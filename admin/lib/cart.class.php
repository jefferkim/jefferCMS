<?
//cart
//zjb
//080818
//把每一条订购记录保存在一个数值中
/***************************************
单条记录为一个hash表，结构如下：
$item = array(
	'ProductId' => 1,			//产品ID
	'ProductName' => 'xxxxx',	//产品名称
	'Nums' => 5,				//单个产品数量
	'Price' => 44.4,			//产品单价
	'Memo' => 'afadfadfsasfd'	//购买备注
);
****************************************/

class Cart
{
	var $cart = array();

	function Add($productId,$productName,$picurl,$nums,$price,$memo)
	{
		$len = count($this->cart);
		for ($i=0; $i<$len; $i++)
		{
			if ($this->cart[$i]['ProductId'] == $productId)
			{
				$this->cart[$i]['ProductName'] = $productName;
				$this->cart[$i]['Picurl'] = $picurl;
				$this->cart[$i]['Nums'] = $nums;
				$this->cart[$i]['Price'] = $price;
				$this->cart[$i]['Memo'] = $memo;
				return;
			}
		}

		$item = array(
			'ProductId' => $productId,
			'ProductName' => $productName,
			'Picurl' => $picurl,
			'Nums' => $nums,
			'Price' => $price,
			'Memo' => $memo
		);
		$this->cart[] = $item;
	}

	function Remove($productId)
	{
		$newCart = array();

		foreach($this->cart as $item)
		{
			if ($productId != $item['ProductId'])
			{
				$newCart[] = $item;
			}
		}

		$this->cart = $newCart;
	}

	function GetCart()
	{
		return $this->cart;
	}
}
?>