<?php
/******************************
//文件上传
' Author:	xw
' Update:	2010/05/28
******************************/
class upload{
	var $error = "";
	var $uploadFile = "";
	var $mimeType = "text/plain";
	var $filterType = array();
	var $Filter = array();
	var $fileSize = 3145728;	//3MB
	var $path = "html";
	var $rename = true;
	var $root = ""; 
	var $result = "";
	var $ext = "";
	var $stat = false;
	
	function __construct($files,$path="html",$root,$rename=true,$filter){
		$this->path = $path;
		$this->filterType();
		$this->root = $root;
		$this->Filter = $filter;
		$this->uploadFile = $files;
		$this->rename = $rename;
		$this->uploadFile();
	}
	function uploadFile(){
		$file = $this->uploadFile;
		if(isset($file["tmp_name"]) and file_exists($file["tmp_name"])){
			$tmp = $file["tmp_name"];
			$name = $file["name"];
			$dir = $this->path;
			//$this->makedir($dir);
			$refolder = $this->checkfolder($dir);
			if($refolder !=""){
				$this->error .= $refolder;
				return false;
				exit();
			}
			if($this->checkFileType($name,$tmp)==false){
				return false;
				exit();
			}
			if($this->checkFileSize($tmp)==false){
				return false;
				exit();
			}
			if($this->rename == true){
				$filename = $this->newName().".".$this->ext;
			}else{
				$filename = $file["name"];
			}
			if(move_uploaded_file($tmp,$this->root.$dir."/".$filename)){
				$this->stat = true;
				$this->result = $filename;
				return true;
			}else{
				$this->stat = false;
				$this->error .= "文件上传失败！<br>";
				return false;
			}
		}else{
			$this->error .= "上传文件不存在！<br>";
			return false;
		}
	}
	function newName(){
		return  date("Ymdhis",time()).substr(microtime(),2,8);
	}
	function setFileSize($size){
		$this->fileSize = $size;
	}
	function checkFileSize($file){
		$filesize = filesize($file);
		if($filesize <= $this->fileSize){
			return true;
		}else{
			$this->error .= "上传文件大于设置文件大小！";
			return false;
		}
	}
	
	function checkfolder($_file){
		$er = "";
		$tmp = "";
		$ext = substr($_file,0,strrpos($_file,"/"));
		if(strlen($ext) == strlen($_file)-1)
			$dir = @explode("/",$ext);
		else
			$dir = @explode("/",$_file);
		$num = @count($dir);
		for($i=0;$i<$num;$i++){
			$tmp .= $dir[$i];
			if(!file_exists($this->root.$tmp))
			{
				$er .="the [ ".$this->root.$tmp." ]is not a valid folder";
			}
			$tmp .= "/";
		}
		return $er;
	}

	
	function makedir($_file) {
		$dir = @ explode("/", $_file);
		$num = @ count($dir);
		$tmp = './';
		for ($i = 0; $i < $num; $i++) {
			$tmp .= $dir[$i];
			if (!file_exists($tmp)) {
				@ mkdir($tmp);
				@ chmod($tmp, 0777);
			}
			$tmp .= '/';
		}
	}
	function checkFileType($filename,$file){
		$ext = strtolower(end(explode(".",$filename)));
		$this->ext = $ext;
		if(in_array($ext,$this->Filter)){
			if(function_exists("mime_content_type")){
				$this->mimeType = mime_content_type($file);
			}else{
				if(isset($this->filterType[$ext])){
					$this->mimeType = $this->filterType[$ext];
				}
			}
			if(empty($this->mimeType)){
				$this->error .= "获取文件类型出错";
				return false;
			}else{
				return true;
			}
		}else{
			$this->error .= "此文件类型不允许上传！<br>";
			return false;
		}
	}
	
	function saveUpload(){
		//文件上传统计函数
	}
	function getError(){
		return $this->error;
	}
	
	function filterType(){
	    $this->filterType['chm']='application/octet-stream';
	    $this->filterType['ppt']='application/vnd.ms-powerpoint';
	    $this->filterType['xls']='application/vnd.ms-excel';
	    $this->filterType['doc']='application/msword';
	    $this->filterType['exe']='application/octet-stream';
	    $this->filterType['rar']='application/octet-stream';
	    $this->filterType['js']="javascript/js";
	    $this->filterType['css']="text/css";
	    $this->filterType['hqx']="application/mac-binhex40";
	    $this->filterType['bin']="application/octet-stream";
	    $this->filterType['oda']="application/oda";
	    $this->filterType['pdf']="application/pdf";
	    $this->filterType['ai']="application/postsrcipt";
	    $this->filterType['eps']="application/postsrcipt";
	    $this->filterType['es']="application/postsrcipt";
	    $this->filterType['rtf']="application/rtf";
	    $this->filterType['mif']="application/x-mif";
	    $this->filterType['csh']="application/x-csh";
	    $this->filterType['dvi']="application/x-dvi";
	    $this->filterType['hdf']="application/x-hdf";
	    $this->filterType['nc']="application/x-netcdf";
	    $this->filterType['cdf']="application/x-netcdf";
	    $this->filterType['latex']="application/x-latex";
	    $this->filterType['ts']="application/x-troll-ts";
	    $this->filterType['src']="application/x-wais-source";
	    $this->filterType['zip']="application/zip";
	    $this->filterType['bcpio']="application/x-bcpio";
	    $this->filterType['cpio']="application/x-cpio";
	    $this->filterType['gtar']="application/x-gtar";
	    $this->filterType['shar']="application/x-shar";
	    $this->filterType['sv4cpio']="application/x-sv4cpio";
	    $this->filterType['sv4crc']="application/x-sv4crc";
	    $this->filterType['tar']="application/x-tar";
	    $this->filterType['ustar']="application/x-ustar";
	    $this->filterType['man']="application/x-troff-man";
	    $this->filterType['sh']="application/x-sh";
	    $this->filterType['tcl']="application/x-tcl";
	    $this->filterType['tex']="application/x-tex";
	    $this->filterType['texi']="application/x-texinfo";
	    $this->filterType['texinfo']="application/x-texinfo";
	    $this->filterType['t']="application/x-troff";
	    $this->filterType['tr']="application/x-troff";
	    $this->filterType['roff']="application/x-troff";
	    $this->filterType['shar']="application/x-shar";
	    $this->filterType['me']="application/x-troll-me";
	    $this->filterType['ts']="application/x-troll-ts";
	    $this->filterType['gif']="image/gif";
	    $this->filterType['jpeg']="image/pjpeg";
	    $this->filterType['jpg']="image/pjpeg";
	    $this->filterType['jpe']="image/pjpeg";
	    $this->filterType['ras']="image/x-cmu-raster";
	    $this->filterType['pbm']="image/x-portable-bitmap";
	    $this->filterType['ppm']="image/x-portable-pixmap";
	    $this->filterType['xbm']="image/x-xbitmap";
	    $this->filterType['xwd']="image/x-xwindowdump";
	    $this->filterType['ief']="image/ief";
	    $this->filterType['tif']="image/tiff";
	    $this->filterType['tiff']="image/tiff";
	    $this->filterType['pnm']="image/x-portable-anymap";
	    $this->filterType['pgm']="image/x-portable-graymap";
	    $this->filterType['rgb']="image/x-rgb";
	    $this->filterType['xpm']="image/x-xpixmap";
	    $this->filterType['txt']="text/plain";
	    $this->filterType['c']="text/plain";
	    $this->filterType['cc']="text/plain";
	    $this->filterType['h']="text/plain";
	    $this->filterType['html']="text/html";
	    $this->filterType['htm']="text/html";
	    $this->filterType['htl']="text/html";
	    $this->filterType['rtx']="text/richtext";
	    $this->filterType['etx']="text/x-setext";
	    $this->filterType['tsv']="text/tab-separated-values";
	    $this->filterType['mpeg']="video/mpeg";
	    $this->filterType['mpg']="video/mpeg";
	    $this->filterType['mpe']="video/mpeg";
	    $this->filterType['avi']="video/x-msvideo";
	    $this->filterType['qt']="video/quicktime";
	    $this->filterType['mov']="video/quicktime";
	    $this->filterType['moov']="video/quicktime";
	    $this->filterType['movie']="video/x-sgi-movie";
	    $this->filterType['au']="audio/basic";
	    $this->filterType['snd']="audio/basic";
	    $this->filterType['wav']="audio/x-wav";
	    $this->filterType['aif']="audio/x-aiff";
	    $this->filterType['aiff']="audio/x-aiff";
	    $this->filterType['aifc']="audio/x-aiff";
		$this->filterType['swf']="application/x-shockwave-flash";
	}
}
?>
