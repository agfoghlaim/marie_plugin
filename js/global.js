jQuery(document).ready(function($){
 
 //$('.datepicker').datepicker();

 //button form exp




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
 

 //button form exp
 $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });



	$('input#date-submit').on('click', function(){
		var arrive = $('input#arrive').val();
		var depart = $('input#depart').val();
		var arrDate = 'arrDate';
		var depDate = 'depDate';
		var security;
		localStorage.setItem(arrDate, JSON.stringify(arrive));
		localStorage.setItem(depDate, JSON.stringify(depart));

		
		
		if($.trim(arrive) != ''){
			$.post(myAjax.ajaxurl, {action:'moh_ajax_action', arrive:arrive, depart:depart, security: myAjax.security }, function(data){
				$('div#date-data').html(data);
			});

		}
	});

	//send selected arrival and departure dates to page-book-room-***
	var arr = JSON.parse(localStorage.getItem("arrDate"));
	var dep = JSON.parse(localStorage.getItem("depDate"));
	var rm_num = JSON.parse(localStorage.getItem("rm_no"));
	var security_rm;
	$('div#booking-details').html("(AJAX says: ) You are booking from " + rm_num + " " + arr + " until " + dep);
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

