jQuery(document).ready(function($){
 














//show booking form book room page
 $(document).on("click", "#moh-show-form", function(e){
 		alert(678);
 		mohGetForm();
 });
 function mohGetForm(){
 		var xhr = new XMLHttpRequest();

http://localhost/designassociates/marie_plugin/wp-admin/admin-ajax.php"
xhr.open('GET', 'wp-content/plugins/moh_guesthouse/templates/moh-booking-form.php', true);
xhr.send(null); //we're not passing any paramaters eg search paramater
xhr.onload = function(){
	var el = document.getElementById('moh-booking-div');
	el.innerHTML = xhr.responseText;
	$('div#booking-details').html("(AJAX says: ) You are booking from " + rm_num + " " + arr + " until " + dep);
	$.post(myAjax.ajaxurl, {action:'moh_ajax_action_get_details', arr:arr, dep:dep, rm_no:rm_num, security_rm: myAjax.security }, function(data2){
				$('div#booking-data').html(data2);
			
			});
}
 }
 	$(document).on("click", "input#guest-info-form", function(e){
 		formGuestInfo();
 	});
	function formGuestInfo(){
	    var fn=$('input#fn').val();
	    var ln=$('input#ln').val();
	    var em=$('input#email').val();
	   	var ad=$('input#address').val();
	    var country=$('input#country').val();
	    var phone=$('input#phone').val();
	    var postcode=$('input#postcode').val();
	    var adults=$('input#no-adults').val();
	    var children =$('input#no-children').val();
	    var arr_time=$('input#arr-time').val();
		var arr = JSON.parse(localStorage.getItem("arrDate"));
		var dep = JSON.parse(localStorage.getItem("depDate"));
		var rm_num = JSON.parse(localStorage.getItem("rm_no"));
		var security_info;
	    console.log(fn, ln, em, ad, country, phone, postcode, adults, children, arr_time);




	

	    $.post(myAjax.ajaxurl, {
	    	action:'moh_ajax_action_guest_info',
	    	security_info: myAjax.security,
	    	checkin: arr,
	    	checkout: dep,
	    	rm_num: rm_num,
	    	fname:fn, 
	    	lname:ln, 
	    	email:em,
	    	address:ad,
	    	country:country, 
	    	phone:phone,
	    	postcode:postcode,
	    	no_adults:adults,
	    	no_children:children, 
	    	arr_time:arr_time

	    }, function(data4){
					$('div#info-success').html(data4);
				
				
				});
		

	}
 
//js for check availabity 
 //button form exp
 var arrive, depart, numNights, theError,arrMsg;
 $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });

function arrivalInFuture(){
	arrive = $('input#arrive').val();
	depart = $('input#depart').val();
	var arr = new Date(arrive);
	var dep = new Date(depart);
	var now = new Date();
	arrMsg = $('p#arr-err');
	arrMsg.html("");
	var sixMonths = now.setMonth(now.getMonth() + 6);
	console.log(arr);
	
	if( checkDateFormat(arrive) && checkDateFormat(depart) ){
		if(arr > new Date() && arr < new Date(sixMonths)){
			console.log("pass 6 months");
			//if it passes above check before dept
			if(arr<dep){
				console.log("arrival is before dept");
				//if arr passes before dept check 2 weeks
				if(dep-arr <=1209600000){
					return true;
					console.log("less than 2 weeks");
				}else{
					arrMsg.html('book for max 2 weeks');
				}
				
			}else{
				arrMsg.html('Arrival should be before dep');
			}
		}else{
			console.log("fail");
			arrMsg.html('Arrival must be less than 6 months');
		}
	}//end check dateformat()
	else{
		console.log("date format fail");
		arrMsg.html('Please enter date in format yyyy-mm-dd.');
	}
}




function checkDateFormat(theDt){
	var yr = theDt.substring(0,4);
	var mt= theDt.substring(5,7);
	var dt=theDt.substring(8,10); 
	var hyp = theDt.substring(4,5) + theDt.substring(7,8);
		if(hyp == '--' && !isNaN(yr) && !isNaN(mt) && !isNaN(dt)){
			return true;
		}else{
			return false;
		}
}



	$('input#date-submit').on('click', function(){
	
		arrive = $('input#arrive').val();
		depart = $('input#depart').val();
		
		var arrDate = 'arrDate';
		var depDate = 'depDate';
		numNights= $('input#num-nights');
		var security;
		localStorage.setItem(arrDate, JSON.stringify(arrive));
		localStorage.setItem(depDate, JSON.stringify(depart));
		//get number of nights
		var diff = Math.round(Math.abs(new Date(depart.replace(/-/g,'/')) - new Date(arrive.replace(/-/g,'/')))/(1000*60*60*24));
		
		numNights.val(diff);
		
		
		if($.trim(arrive) != '' && $.trim(depart) != '' && arrivalInFuture()){
			$.post(myAjax.ajaxurl, {action:'moh_ajax_action', arrive:arrive, depart:depart, security: myAjax.security }, function(data){
				$('div#date-data').html(data);
				numNights.val(diff);
				console.log(numNights);
				console.log(diff);
			});

		}
	});
	

	//send selected arrival and departure dates to page-book-room-***
	var arr = JSON.parse(localStorage.getItem("arrDate"));
	var dep = JSON.parse(localStorage.getItem("depDate"));
	var rm_num = JSON.parse(localStorage.getItem("rm_no"));
	var security_rm;
	$('div#booking-details').html("<h3>You are booking from "  + arr + " until " + dep + "</h3>");
	$.post(myAjax.ajaxurl, {action:'moh_ajax_action_get_details', arr:arr, dep:dep, rm_no:rm_num, security_rm: myAjax.security }, function(data2){
				$('div#booking-data').html(data2);
			
			});

	
	// $.post(myAjax.ajaxurl, {action:'moh_ajax_get_details', rm_no:rm_num}, function(data3){
	// 				$('div#room-no').html(data3);
				
				
	// 			});


	$(document).on("click", ".get-the-room", function(e) {
	    console.log("clicked: %o",  this);
	    console.log($(this).val());
	    var rmNo = $(this).val();
	    var rm_no = 'rm_no';
	    $('.get-the-room').text('Room Selected');
	    localStorage.setItem(rm_no, JSON.stringify(rmNo));
	    //display button link to booking page
	    $('input#show-booking-button').show();
	  });

	//handle booking form
	$('input#guest-info').on('click', function(){	
	    var fn=$('input#fn').val();
	    var ln=$('input#ln').val();
	    var em=$('input#email').val();
	   	var ad=$('input#address').val();
	    var country=$('input#country').val();
	    var phone=$('input#phone').val();
	    var postcode=$('input#postcode').val();
	    var adults=$('input#no-adults').val();
	    var children =$('input#no-children').val();
	    var arr_time=$('input#arr-time').val();
		var arr = JSON.parse(localStorage.getItem("arrDate"));
		var dep = JSON.parse(localStorage.getItem("depDate"));
		var rm_num = JSON.parse(localStorage.getItem("rm_no"));
		var security_info;
	    console.log(fn, ln, em, ad, country, phone, postcode, adults, children, arr_time);




	

	    $.post(myAjax.ajaxurl, {
	    	action:'moh_ajax_action_guest_info',
	    	security_info: myAjax.security,
	    	checkin: arr,
	    	checkout: dep,
	    	rm_num: rm_num,
	    	fname:fn, 
	    	lname:ln, 
	    	email:em,
	    	address:ad,
	    	country:country, 
	    	phone:phone,
	    	postcode:postcode,
	    	no_adults:adults,
	    	no_children:children, 
	    	arr_time:arr_time

	    }, function(data4){
					$('div#info-success').html(data4);
				
				
				});
		

	});


	


});

