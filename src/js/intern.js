var accountMenuActive = false;
function toogleAccountMenu(){
	if(accountMenuActive == true){
		$('.account-menu').slideUp(150);
		accountMenuActive = false;
	}else{
		var button = $('.username');
		var w = button.width();
		var w2 = Math.max(100,w);
		var h = button.height();
		var p = button.offset();
		$('.account-menu').css({'top':(p.top+h)+'px','left':(p.left-w2+w)+'px','width':w2+'px'});
		$('.account-menu').slideDown(150);
		accountMenuActive = true;
	}
}
function initWindow(){
	$('.username').on( "click", toogleAccountMenu);
	var width = $(window).width();
	
	var height = $(window).height();
	if (height === 0) {
     height = window.innerHeight;
	}
	if (width < 320){
		/*width -= 20;
		height = Math.ceil(width*0.79);
		$('.logo').css({'width': width+'px','height':height+'px'});
		$('.logo>img').css({'width': width+'px','height':height+'px'});
		$('.title').css({'font-size':Math.ceil(width/7)+'px'});
		$('.content').css({'width': (width-30)+'px','padding':'14px'});
	}else if(width < 352){
		$('.content').css({'width': (width-30)+'px','padding':'14px'});*/
	}

}

$(document).ready(initWindow);
