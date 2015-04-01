function setLogin(){
	var login = $('.login');
	login.val('Login');
	login.css({'color':'#888'});
	login.one( "focus", function() {
		login.css({'color':'black'});
		login.val('');
	});

}
function setPassword(){
	var password = $('.password');
	password.css({'color':'#888'});
	password.val('Password');
	password.attr('type','text');
	password.one( "focus", function() {
		password.css({'color':'black'});
		password.val('');
		password.attr('type','password');
	});

}
function initWindow(){
	var width = $(window).width();
	var height = $(window).height();
	if (height === 0) {
     height = window.innerHeight;
	}
	if (width < 320){
		width -= 20;
		height = Math.ceil(width*0.79);
		$('.logo').css({'width': width+'px','height':height+'px'});
		$('.logo>img').css({'width': width+'px','height':height+'px'});
		$('.title').css({'font-size':Math.ceil(width/7)+'px'});
		$('.content').css({'width': (width-30)+'px','padding':'14px'});
	}else if(width < 352){
		$('.content').css({'width': (width-30)+'px','padding':'14px'});
	}
	setLogin();
	setPassword();
	$('.login').focusout(function(){
		if($('.login').val()==''){
			setLogin();
		}
	});
	$('.password').focusout(function(){
		if($('.password').val()==''){
			setPassword();
		}
	});
}

$(document).ready(initWindow);
