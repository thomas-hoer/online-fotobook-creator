function initFileUpload()
{
	var obj = $(document);
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
		$('.no-pictures').css({'display':'none'});
		handleFileUpload(files);
	});
}

function handleFileUpload(files)
{
   for (var i = 0; i < files.length; i++) 
   {
        var fd = new FormData();
        fd.append('file', files[i]);
		fd.append('id', galleryID);
        var status = new createStatusbar($('.piccontainer'),files[i]); //Using this we can set progress.
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
			$('.piccontainer').append('<img src="thumb/'+data+'.jpg" picid="'+data+'"/>&#32;');
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
	this.progressBar = $("<div class='progressBar'><div>0%</div></div>").appendTo(this.statusbar);
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

$(document).ready(initFileUpload);