jQuery.fn.dragresize = function () {
	var el = $(this);
	var element = elements[el.parent().parent().attr('id')];
	var pic = el.parent().parent().find(".picture");
	var rot = el.parent().find(".rotate");
    this.bind('mousedown', function (e) {
        var pageX = e.pageX;
        var pageY = e.pageY;
		var startX = el.position().left;
		var startY = el.position().top;
		var startW = pic.width();
		var startH = pic.height();
        $(document).bind('mousemove', function (e) {
            var diffX = e.pageX - pageX + startX;
            var diffY = e.pageY - pageY + startY;
			var ratio = Math.min(diffX / startX, diffY / startY);
			if(freeScale == false){
				diffX = startX * ratio;
				diffY = startY * ratio;
			}
			var width = diffX - startX + startW;
			var height = diffY - startY + startH;
            el.css('left', diffX + 'px').css('top', diffY + 'px');
            rot.css('left', diffX + 'px');
			pic.css({'width': width+'px','height':height+'px'});
			element.width = width / zoom;
			element.height = height / zoom;
			return false;
        });
		$(document).bind('mouseup', function (e) {
			$(document).unbind('mousemove');
			$(document).unbind('mouseup');
			sendJSON({
				"id":el.parent().parent().attr('id'),
				"width":element.width,
				"height":element.height
			});
		});
		return false;
    });
    return this;
};

jQuery.fn.dragrotate = function () {
	var el = $(this);
	var parent = el.parent().parent();
	var element = null;
	var pic = null;
	if(parent.hasClass('piccontainer')){
		pic = parent.find(".picture");
		element = elements[parent.attr('id')];
	}else if(parent.hasClass('textcontainer')){
		pic = parent.find(".text");
		element = textElements[parent.attr('id')];
	}
    this.bind('mousedown', function (e) {
        var pageX = e.pageX;
        var pageY = e.pageY;
		var startR = parseFloat(pic.getRotateAngle());
		if(isNaN(startR)){
			startR = 0;
		}
        $(document).bind('mousemove', function (e) {
			var dR = e.pageX - pageX + e.pageY - pageY;
			var diffR = 0;
			if(parent.hasClass('piccontainer')){
				diffR = dR*0.25 + startR;
				pic.rotate(diffR);
			}else if(parent.hasClass('textcontainer')){
				diffR = -dR*0.25 + startR;
				pic.rotate({
					angle: diffR,
					center: ["0%", "0%"]
				});
			}
			element.rotate = diffR;
			return false;
        });
		$(document).bind('mouseup', function (e) {
			$(document).unbind('mousemove');
			$(document).unbind('mouseup');
			sendJSON({
				"id":el.parent().parent().attr('id'),
				"rotate":element.rotate
			});
		});
		return false;
    });
    return this;
};