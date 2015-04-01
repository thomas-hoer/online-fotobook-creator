function setLogin(){
	var login = $('.login');
	login.val('Login');
	login.css({'color':'#888'});
	login.one( 'focus', function() {
		login.css({'color':'black'});
		login.val('');
	});

}
function setPassword(){
	var password = $('.password');
	password.css({'color':'#888'});
	password.val('Password');
	password.attr('type','text');
	password.one( 'focus', function() {
		password.css({'color':'black'});
		password.val('');
		password.attr('type','password');
	});

}
function setPassword2(){
	var password = $('.password2');
	password.css({'color':'#888'});
	password.val('Repeat Password');
	password.attr('type','text');
	password.one( 'focus', function() {
		password.css({'color':'black'});
		password.val('');
		password.attr('type','password');
	});

}
function initWindow(){
	setLogin();
	setPassword();
	setPassword2();
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
	$('.password2').focusout(function(){
		if($('.password2').val()==''){
			setPassword2();
		}
	});
}

$(document).ready(initWindow);
