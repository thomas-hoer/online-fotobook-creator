function setLogin(){
	var login = $('.login');
	login.val('Login');
	login.css({'color':'#888'});
	login.one( 'focus', function() {
		login.css({'color':'black','background-color':'white'});
		login.val('');
	});
}
function setEmail(){
	var mail = $('.mail');
	mail.val('E-Mail');
	mail.css({'color':'#888'});
	mail.one( 'focus', function() {
		mail.css({'color':'black','background-color':'white'});
		mail.val('');
	});
}
function setPassword(){
	var password = $('.password');
	password.css({'color':'#888'});
	password.val('Password');
	password.attr('type','text');
	password.one( 'focus', function() {
		password.css({'color':'black','background-color':'white'});
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
		password.css({'color':'black','background-color':'white'});
		password.val('');
		password.attr('type','password');
	});
}
function checkForm(){
	var result = true;
	if($('.password').val() != $('.password2').val()){
		result = false;
		$('.password').css({'background-color':'#FBB'});
		$('.password2').css({'background-color':'#FBB'});
	}
	if($('.login').val() == '' || $('.login').val()=='Login'){
		result = false;
		$('.login').css({'background-color':'#FBB'});
	}
	if($('.password').val() == '' || $('.password').val()=='Password'){
		result = false;
		$('.password').css({'background-color':'#FBB'});
	}
	if($('.password2').val() == '' || $('.password2').val()=='Repeat Password'){
		result = false;
		$('.password2').css({'background-color':'#FBB'});
	}
	return result;
}
function initWindow(){
	setLogin();
	setEmail();
	setPassword();
	setPassword2();
	$('.login').focusout(function(){
		if($('.login').val()==''){
			setLogin();
		}
	});
	$('.mail').focusout(function(){
		if($('.mail').val()==''){
			setEmail();
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
	$('.content').on("submit",checkForm);
}

$(document).ready(initWindow);
