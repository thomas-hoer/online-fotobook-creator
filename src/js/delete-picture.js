function send(data){
	sendInProgress = true;
	$.ajax({
		type: "POST",
		url: "ajax/delete-picture.php",
		data: data,
		dataType: 'json'
	});
}
function deletePicture(){
	send({'id':$(this).attr('pid')});
	$(this).prev().remove();
	$(this).remove();
}
function initLinks()
{
	$.each($('.boxicon'),function(key,value){
		var button = $(value);
		button.removeAttr('href');
		button.click(deletePicture);
	});
}

$(document).ready(initLinks);