var sendArray = [];
var sendQueue = [];
var sendInProgress = false;
function sendJSON(json){
	sendQueue.push(json);
	sendData();
}
function sendData(){
	if(sendInProgress = true){
		sendArray = sendArray.concat(sendQueue);
		sendQueue = [];
		//$('.menu').append(JSON.stringify (sendArray));
		send(JSON.stringify (sendArray));
		$('.upload-status').css({'display':'block'});
		$('.upload-status').html('speichern...');
	}
}
function successHandler(data, textStatus ){
	sendArray = [];
	sendInProgress = false;
	$('.upload-status').css({'display':'none'});
	//$('.menu').append(JSON.stringify (data));
	if(sendQueue.length>0){
		sendData();
	}
}
function errorHandler(xhr, textStatus, errorThrown){
	sendInProgress = false;
	$('.upload-status').css({'display':'block'});
	$('.upload-status').html('speichern fehlgeschlagen');
}
function send(data){
	sendInProgress = true;
	$.ajax({
		type: "POST",
		url: "ajax/ajax.php",
		data: data,
		success: successHandler,
		error: errorHandler,
		dataType: 'json'
	});
}

function initFileUpload(){
	var obj = $(".pictures");
	obj.on('dragenter', function (e) 
	{
		e.stopPropagation();
		e.preventDefault();
	});
	obj.on('dragover', function (e) 
	{
		e.stopPropagation();
		e.preventDefault();
	});
	obj.on('drop', function (e) 
	{
		e.preventDefault();
		var files = e.originalEvent.dataTransfer.files;
		handleFileUpload(files,obj);
	});
	$(document).on('dragenter', function (e) 
	{
		e.stopPropagation();
		e.preventDefault();
	});
	$(document).on('dragover', function (e) 
	{
		e.stopPropagation();
		e.preventDefault();
	});
	$(document).on('drop', function (e) 
	{
		e.stopPropagation();
		e.preventDefault();
	});
}

function handleFileUpload(files,obj)
{
   for (var i = 0; i < files.length; i++) 
   {
        var fd = new FormData();
        fd.append('file', files[i]);
 
        var status = new createStatusbar(obj,files[i]); //Using this we can set progress.
        sendFileToServer(fd,status);
 
   }
}
function sendFileToServer(formData,status)
{
    var uploadURL ="ajax/upload.php"; //Upload URL
    var jqXHR=$.ajax({
            xhr: function() {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                    xhrobj.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //Set progress
                        status.setProgress(percent);
                    }, false);
                }
            return xhrobj;
        },
        url: uploadURL,
        type: "POST",
        contentType:false,
        processData: false,
        cache: false,
        data: formData,
        success: function(data){
			$('.pictures').append('<img src="thumb/'+data+'.jpg" picid="'+data+'"/>');
			setPicturesDraggable()
            status.setProgress(100);
        }
    }); 
 
    status.setAbort(jqXHR);
}

function createStatusbar(obj,file)
{
	//alert(obj.serialize());
	this.statusbar = $("<div class='statusbar'></div>");
	this.filename = $("<div class='filename'>"+file.name+"</div>").appendTo(this.statusbar);
	this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
	this.abort = $("<div class='abort'>Abbrechen</div>").appendTo(this.statusbar);
	obj.append(this.statusbar);
	obj.animate({
        scrollTop: this.statusbar.offset().top
    }, 20);
 

    this.setProgress = function(progress)
    {       
        var progressBarWidth =progress*this.progressBar.width()/ 100;  
        this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
        if(parseInt(progress) >= 100)
        {
            this.abort.hide();
			this.statusbar.remove();
        }
    }
    this.setAbort = function(jqxhr)
    {
        var sb = this.statusbar;
        this.abort.click(function()
        {
            jqxhr.abort();
            sb.hide();
        });
    }
}