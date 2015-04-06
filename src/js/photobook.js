var originalW = 42;
var originalH = 28;
var zoom = 0;
var bookW = 0;
var bookH = 0;
var activeElement = null;
var focusElement = null;
var freeScale = false;
var arrowselected = true;
var edittext = false;
var page = 1;
function initWindow(){
	scaleWindow();
	scaleBook();
	$('.button_arrow').click(selectarrow);
	$('.button_text').click(selecttext);
	$('.button_zoom_in').click(zoomin);
	$('.button_zoom_out').click(zoomout);
	$('.button_layer_down').click(layerdown);
	$('.button_layer_up').click(layerup);
	$('.button_layer_top').click(layertop);
	$('.button_layer_bottom').click(layerbottom);
	$('.button_text_bold').click(function(){document.execCommand('bold',false,null);});
	$('.button_text_italic').click(function(){document.execCommand('italic',false,null);});
	$('.button_text_underline').click(function(){document.execCommand('underline',false,null);});
	$('.button_next_page').click(nextpage);
	$('.button_prev_page').click(prevpage);
	addPictures();
	addElements();
	selectarrow();
	setPicturesDraggable();
	$('.book').droppable({
      accept: ".pictures>img",
      activeClass: "custom-state-active",
      drop: addImage
    });
	initFileUpload();
	$(document).keydown(handleKeydown);
	$(document).keyup(handleKeyup);
	$('.book').click(addText);
	deactivateElement();
}
function addElements(){
	pe = [];
	$.each( elements, function( key, element ) {
		pe.push(element);
	});
	te = [];
	$.each( textElements, function( key, element ) {
		te.push(element);
	});
	te.sort(function(a,b){return a.Z-b.Z});
	pe.sort(function(a,b){return a.Z-b.Z});
	
	for(i=0,j=0;i<pe.length || j<te.length;){
		if(j==te.length || (i<pe.length && pe[i].Z < te[j].Z)){
			element = pe[i++];
			addElement(element.id,element.top*zoom,element.left*zoom,element.width*zoom,element.height*zoom,element.rotate,element.pid);
		}else{
			element = te[j++];
			addTextElement(element.id,element.top*zoom,element.left*zoom,element.rotate,element.text,element.size);
		}
	}
}
function addPictures(){
	var length = pictureids.length;   
	for (var i = 0; i < length; i++) {
		$('.pictures').append('<img src="thumb/'+pictureids[i]+'.jpg" picid="'+pictureids[i]+'"/>');
	}
}
function setPicturesDraggable(){
	$('.pictures>img').draggable({
      revert: "invalid",
      appendTo: "body",
      helper: "clone",
      cursor: "move"
    });
}
function addText(event){
	if(!arrowselected && !edittext){
		var posLeft = event.pageX - 241 +$('.content').scrollLeft();
		var posTop = event.pageY - 71 +$('.content').scrollTop();
		textID ++;
		var textName = 't'+bookid+'-'+textID;
		textElements[textName] = {
			'id':textName,
			'top' : (posTop/zoom),
			'left' : (posLeft/zoom),
			'size':20,
			'rotate':0,
			'text':""
		};
		addTextElement(textName,posTop,posLeft,0,"",20);
		sendJSON({
			'id':textName,
			'bid':bookid,
			'action':'addtext',
			'size':20,
			'top' : (posTop/zoom),
			'left' : (posLeft/zoom),
			'rotate' : 0,
			'page' : page
		});

	}
	edittext = false;
}
function addTextElement(tid,posTop,posLeft,rotate,text,size){
	var $newtext = $('<div class="textcontainer no-drag" id="'+tid+'" style="top:'+posTop+'px;left:'+posLeft+'px"><div contenteditable="true" class="text">'+text+'</div><div class="tools" style="display:none"><img class="rotate no-drag" src="gfx/icon_rotate.png"/></div></div>');
	$('.book').append($newtext);
	$newtext.draggable({
		cancel: ".no-drag",
		cursor: "move",
		drag: activate,
		stop: updatePosition
	});
	$newtext.click(activate);
	$newtext.find('.text').rotate({
		angle: rotate,
		center: ["0%", "0%"]
	});
	$newtext.find('.rotate').dragrotate();
	$newtext.find('.text').focus();
	$newtext.find('.text').css({'font-size':Math.ceil(zoom*size/10)+'%'});
	$newtext.find('.text').focus(function(event){
		focusElement = null;
		var element = textElements[$(event.target).parent().attr('id')];
		$('.fontsize').val(element.size);
		focusElement = $(event.target);
		edittext = true;
	});
	$newtext.find('.text').focusout(updateText);
}
function addImage(event, ui){
	selectarrow();
	//alert(ui.draggable.prop("tagName"));
	var picid = ui.draggable.attr('picid');
	var posLeft = ui.position.left - 241 +$('.content').scrollLeft();
	var posTop = ui.position.top - 71 +$('.content').scrollTop();
	var picWidth = ui.draggable.width();
	var picHeight = ui.draggable.height();
	elementID ++;
	var elementName = 'e'+bookid+'-'+elementID;
	elements[elementName] = {
		"id":elementName,
		"pid":picid,
		'width' : (picWidth/zoom),
		'height' : (picHeight/zoom),
		'top' : (posTop/zoom),
		'left' : (posLeft/zoom),
		'rotate' : 0
	};
	addElement(elementName,posTop,posLeft,picWidth,picHeight,0,picid);
	sendJSON({
		'id':elementName,
		'bid':bookid,
		'action':'addimg',
		'pid':picid,
		'width' : (picWidth/zoom),
		'height' : (picHeight/zoom),
		'top' : (posTop/zoom),
		'left' : (posLeft/zoom),
		'rotate' : 0,
		'page' : page
	});
}
function addElement(eid,posTop,posLeft,picWidth,picHeight,rotate,picid){
	var $newpic = $('<div class="piccontainer" id="'+eid+'" style="top:'+posTop+'px;left:'+posLeft+'px"><img class="picture" style="width:'+picWidth+'px;height:'+picHeight+'px" src="preview/'+picid+'.jpg" rotate="0" /><div class="tools" style="display:none"><img class="rotate no-drag" src="gfx/icon_rotate.png"/><img class="resize no-drag" src="gfx/icon_resize.png"/></div></div>');
	$('.book').append($newpic);
	$newpic.draggable({
		cancel: ".no-drag",
		cursor: "move",
		drag: activate,
		stop: updatePosition
	});
	$newpic.click(activate);
	$newpic.find('.picture').rotate(rotate);
	$newpic.find('.resize').dragresize();
	$newpic.find('.rotate').dragrotate();
	activateElement($newpic);
}
function removeActiveElement(){
	sendJSON({
		"id":activeElement.attr('id'),
		"bid":bookid,
		"action":"remove"
	});
	activeElement.remove();
	activeElement = null;

}
function handleKeydown(event) {
	if ( event.which == 46  && activeElement != null) {
		removeActiveElement()
	}else if( event.which == 17 ){
		freeScale = true;
	}
}
function handleKeyup(event) {
	if( event.which == 17 ){
		freeScale = false;
	}
}
function updatePosition(){
	if($(this).hasClass('piccontainer')){
		var element = elements[$(this).attr('id')];
		element.top = $(this).position().top/zoom;
		element.left = $(this).position().left/zoom;
		sendJSON({
			"id":$(this).attr('id'),
			"bid":bookid,
			"top":element.top,
			"left":element.left
		});
	}else if($(this).hasClass('textcontainer')){
		var element = textElements[$(this).attr('id')];
		element.top = $(this).position().top/zoom;
		element.left = $(this).position().left/zoom;
		sendJSON({
			"id":$(this).attr('id'),
			"bid":bookid,
			"top":element.top,
			"left":element.left
		});
	}
}
function updateText(){
	//alert($(this).html());
	var element = textElements[$(this).parent().attr('id')];
	element.text = $(this).html();
	sendJSON({
		"id":$(this).parent().attr('id'),
		"bid":bookid,
		"text":$(this).html()
	});
}
function activate(){
	if(arrowselected){
		var el = $(this);
		if(el.hasClass('piccontainer')){
			activateElement(el);
		}else if(el.hasClass('textcontainer')){
			deactivateElement();
			var element = textElements[el.attr('id')];
			$('.fontsize').val(element.size);
			activateTextElement(el);
		}
	}
}
function activateElement(el) {
	deactivateElement();
	activeElement = el;
	var top = activeElement.position().top-2;
	var left = activeElement.position().left-2;
	var width = activeElement.find('.picture').width()+4;
	var height = activeElement.find('.picture').height()+4;
	activeElement.css({'top':top+'px','left':left+'px'});
	activeElement.find('.picture').css({'border':'2px solid #39A'});
	activeElement.find('.tools').css({'display':'block'});
	activeElement.find('.rotate').css({'left':width+"px",'top':'-16px'});
	activeElement.find('.resize').css({'left':width+"px",'top':height+'px'});
}
function activateTextElement(el) {
	deactivateElement();
	activeElement = el;
	activeElement.find('.tools').css({'display':'block'});
}
function deactivateElement() {
	if(activeElement != null){
		if(activeElement.hasClass('piccontainer')){
			var top = activeElement.position().top+2;
			var left = activeElement.position().left+2;
			activeElement.css({'top':top+'px','left':left+'px'});
			activeElement.find('.picture').css({'border':'0px'});
		}else if(activeElement.hasClass('textcontainer')){
			
		}
		activeElement.find('.tools').css({'display':'none'});
		activeElement = null;
	}
}
function scaleWindow(){
	var width = $(window).width()-202;
	var height = $(window).height();
	if (height === 0) {
     height = window.innerHeight;
	}
	height -= 30;
	$('.menu').css({'width': width+'px'});
	$('.content').css({'width': width+'px','height':height+'px'});
}
function scaleBook() {
	var width = $(window).width();
	var height = $(window).height();
	if (height === 0) {
		height = window.innerHeight;
	}
	width -= 282;
	height -= 110;
	if(width * originalH / originalW > height){
		width = height * originalW / originalH;
	}else{
		height = width * originalH / originalW;
	}
	zoom = width / originalW;
	drawpage();
}
function zoomin(){
	zoom *= 1.2;
	drawpage();
}
function zoomout(){
	zoom /= 1.2;
	drawpage();
}
function drawpage(){
	deactivateElement();
	bookW = originalW * zoom;
	bookH = originalH * zoom;
	$('.book').css({'width': bookW+'px','height':bookH+'px'});
	$('.pageseparator').css({'left': (bookW/2+40)+'px','height':bookH+'px'});
	$('.book').children().each(function(){
		if($(this).hasClass('piccontainer')){
			var element = elements[$(this).attr('id')];
			$(this).find('.picture').css({'width': (element.width*zoom)+'px','height':(element.height*zoom)+'px'});
			$(this).css({'top': (element.top*zoom)+'px','left':(element.left*zoom)+'px'});
		}else if($(this).hasClass('textcontainer')){
			var element = textElements[$(this).attr('id')];
			$(this).find('.text').css({'font-size':Math.ceil(zoom*element.size/10)+'%'});
			$(this).css({'top': (element.top*zoom)+'px','left':(element.left*zoom)+'px'});
		}
	});
}
function layerdown(){
	if(activeElement != null){
		var idx = activeElement.index();
		if(idx>0){
			sendJSON({
				'id':activeElement.attr('id'),
				'bid':bookid,
				'action':'swapz',
				'swapid':activeElement.prev().attr('id')
			});
			activeElement.prev().before(activeElement);
		}
	}
}
function layerup(){
	if(activeElement != null){
		var idx = activeElement.index();
		if(idx<activeElement.siblings().length){
			sendJSON({
				'id':activeElement.attr('id'),
				'bid':bookid,
				'action':'swapz',
				'swapid':activeElement.next().attr('id')
			});
			activeElement.next().after(activeElement);
		}
	}
}
function layertop(){
	if(activeElement != null){
		activeElement.parent().append(activeElement);
		sendJSON({
			'id':activeElement.attr('id'),
			'bid':bookid,
			'action':'layertop'
		});
	}
}
function layerbottom(){
	if(activeElement != null){
		activeElement.parent().prepend(activeElement);
		sendJSON({
			'id':activeElement.attr('id'),
			'bid':bookid,
			'action':'layerbottom'
		});
	}
}

function selectarrow(){
	$('.button_arrow').addClass('selected');
	$('.button_text').removeClass('selected');
	arrowselected = true;
	$('.piccontainer').removeClass('no-drag');
	$('.textcontainer').removeClass('no-drag');
	$('.textcontainer>.text').attr('contenteditable',false);
	document.getSelection().removeAllRanges();
	focusElement = null;
}
function selecttext(){
	deactivateElement();
	$('.button_arrow').removeClass('selected');
	$('.button_text').addClass('selected');
	arrowselected = false;
	$('.piccontainer').addClass('no-drag');
	$('.textcontainer').addClass('no-drag');
	$('.textcontainer>.text').attr('contenteditable',true);
	document.getSelection().removeAllRanges();
}

function fontEditor(fontName) {
	document.execCommand("fontName", false, fontName);
}
function textSizeEditor(fontSize){
	if(activeElement != null && activeElement.hasClass('textcontainer')){
		var element = textElements[activeElement.attr('id')];
		element.size = fontSize;
		activeElement.find('.text').css({'font-size':Math.ceil(zoom*fontSize/10)+'%'});
		sendJSON({
			"id":activeElement.attr('id'),
			"bid":bookid,
			"size":fontSize
		});
	}
	if(focusElement != null){
		var element = textElements[focusElement.parent().attr('id')];
		element.size = fontSize;
		focusElement.css({'font-size':Math.ceil(zoom*fontSize/10)+'%'});
		sendJSON({
			"id":focusElement.parent().attr('id'),
			"bid":bookid,
			"size":fontSize
		});


	}
}
function nextpage(){
	if(page<32){
		page++;
		showpage();
	}
}
function prevpage(){
	if(page>1){
		page--;
		showpage();
	}
}
function showpage(){
	$('.pagetitle').html('Page '+page);
	$('.book').empty();
	var mypage = page
	$.get( "ajax/getPage.php?b="+bookid+"&p="+page,null, function( data ) {
		if(mypage == page){
			elements = data.elements;
			textElements = data.textElements;
			addElements();
			selectarrow();
			deactivateElement();
		}
	},'json');
}

//$(window).scroll(fixDiv);
$(document).ready(initWindow);
$(window).on('resize', scaleWindow);