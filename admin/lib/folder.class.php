<?
//文件夹操作
//Date:08-05-05
//zjb
//需要系统权限支持

/*************************************************
$folder = new Folder();
**************************************************/

class Folder
{
	private $size = 0;

	//新建文件夹
	//$dir 文件夹全路径
	function create($dir)
	{
		if (is_dir($dir))
		{
			return false;
		}

		return mkdir($dir,0777);
	}

	//删除文件夹
	//$dir 文件夹全路径
	function delete($dir)
	{
		if (!is_dir($dir))
		{
			return true;
		}

		return rmdir($dir);
	}

	//删除文件夹及其子文件及目录
	//$dir 文件夹全路径
	function deleteAll($dir)
	{
		if (!is_dir($dir))
		{
			return true;
		}

		if (substr($dir,-1) != "/")
			$dir = $dir."/";

		$h = opendir($dir);
		while(($f = readdir($h)) !== false)
		{
			if (is_dir($dir.$f) && $f != "." && $f != "..")
			{
				$this->deleteAll($dir.$f);
			}
			else
			{
				if ($f != ".." && $f != ".")
					unlink($dir.$f);
			}
		}
		closedir($h);
		rmdir($dir);
	}

	//计算文件夹大小,单位MB
	function calc($dir)
	{
		if (!is_dir($dir))
		{
			return $this->size;
		}

		if (substr($dir,-1) != "/")
			$dir = $dir."/";

		$h = opendir($dir);
		while(($f = readdir($h)) !== false)
		{
			if (is_dir($dir.$f) && $f != "." && $f != "..")
			{
				$this->calc($dir.$f);
			}
			else
			{
				$this->size += round(filesize($dir.$f)/1024,2);
			}
		}
		closedir($h);

		return round($this->size/1024,2);
	}

	//复制文件夹
	//$source	源目录
	//$dest		目标目录
	function copyFolder($source,$dest)
	{
		if (!is_dir($source))
		{
			return;
		}

		if (!is_dir($dest) || file_exists($dest))
		{
			$this->create($dest);
		}

		if (substr($source,-1) != "/")
			$source = $source."/";
		if (substr($dest,-1) != "/")
			$dest = $dest."/";

		$sourceFolder = opendir($source);
		while (($f = readdir($sourceFolder)) !== false)
		{
			if (is_dir($source.$f) && $f != "." && $f != "..")
			{
				$this->copyFolder($source.$f,$dest.$f);
			}
			else
			{
				if ($f != "." && $f != "..")
					copy($source.$f,$dest.$f);
			}
		}
		closedir($sourceFolder);
	}

	//读取文件夹内容
	//$dir			目录地址
	//返回数组		下标０为目录，下标１为文件
	function readFolder($dir)
	{
		if (!is_dir($dir))
		{
			return;
		}
		if (substr($dir,-1) != "/")
			$dir .= "/";

		$folder = opendir($dir);
		$folderList = array();
		$fileList = array();
		while (($f = readdir($folder)) !== false)
		{
			if (is_dir($dir.$f) && $f != "." && $f != "..")
			{
				$folderList[] = $f;
			}
			elseif ($f != "." && $f != "..")
			{
				$fileList[] = $f;
			}
		}
		closedir($folder);

		$result = array($folderList,$fileList);
		return $result;
	}
}
?>