var accountMenuActive = false;
function setPassword(classname, text){
	var dsptext = text;
	var password = $(classname);
	password.css({'color':'#888'});
	password.val(text);
	password.attr('type','text');
	password.one( 'focus', function() {
		password.css({'color':'black','background-color':'white'});
		password.val('');
		password.attr('type','password');
	});
	password.focusout(function(){
		if($(classname).val()==''){
			setPassword(classname, text);
		}
	});

}
function checkForm(){
	var result = true;
	if($('.pw1').val() != $('.pw2').val()){
		result = false;
		$('.pw1').css({'background-color':'#FBB'});
		$('.pw2').css({'background-color':'#FBB'});
	}
	if($('.pw').val() == '' || $('.pw').val()=='Old Password'){
		result = false;
		$('.pw').css({'background-color':'#FBB'});
	}
	if($('.pw1').val() == '' || $('.pw1').val()=='New Password'){
		result = false;
		$('.pw1').css({'background-color':'#FBB'});
	}
	if($('.pw2').val() == '' || $('.pw2').val()=='Repeat New Password'){
		result = false;
		$('.pw2').css({'background-color':'#FBB'});
	}
	return result;
}

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
	setPassword('.pw','Old Password');
	setPassword('.pw1','New Password');
	setPassword('.pw2','Repeat New Password');
	$('.pwform').on("submit",checkForm);
	$('.menuicon').click(function(){
		$('.menu').slideToggle();
	});
}

$(document).ready(initWindow);
