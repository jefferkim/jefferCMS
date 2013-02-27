//一些参数定义
//进度条参数
var progressSetting = {
	boxImage:rooturl + 'js/images/progressbar.gif',
	barImage:rooturl + 'js/images/progressbg_green.gif'
};

//swf upload 参数
var swfSetting = {
	flash_url : rooturl + "js/swfupload/swfupload_f9.swf",
	upload_url : "webadmin/upload.php",
	file_size_limit : "2MB",
	file_types : "*.jpg;*.gif",
	file_types_description : "images files",
	file_upload_limit : "0",
	debug :false,

	file_queued_handler : fileQueued,
	file_queue_error_handler : fileQueueError,
	file_dialog_complete_handler : fileDialogComplete,
	upload_start_handler : uploadStart,
	upload_progress_handler : uploadProgress,
	upload_error_handler : uploadError,
	upload_complete_handler : uploadComplete
};

//swf upload 事件函数
function fileQueued(file)
{}

function fileQueueError(file,errorCode,message)
{
	alert(message);
}

function fileDialogComplete(numberOfFileSelected, numberOfFileQueued)
{
	if (numberOfFileSelected > 0)
		this.startUpload();
}

function uploadStart(file)
{
	$("#message").fadeIn();
	$("#progressbars").progressBar(0,progressSetting);
	currentFile = file;
	return true;
}

function uploadProgress(file, complete, all)
{
	var percent = Math.ceil((complete/all)*100);
	$("#progressbars").progressBar(percent,progressSetting);
}

function uploadError(file, errorCode, message)
{
	//alert(errorCode);
	alert(message);
}

function uploadComplete(file)
{
	$("#message").fadeOut();
	if (this.getStats().files_queued > 0)
		this.startUpload();
	$("#progressbars").progressBar(0,progressSetting);
}
//swf upload 事件函数定义结束