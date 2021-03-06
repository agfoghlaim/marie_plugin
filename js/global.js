jQuery(document).ready(function($){
/*================================================================================*/ 
/*===============================  CHECK AVAILABITY  ==============================*/
/*================================================================================*/

 var arrive, depart, numNights, theError,arrMsg;
 $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });


 $('input#date-submit').on('click', function(e){
		e.preventDefault();
		arrive = $('input#arrive').val();
		depart = $('input#depart').val();
		var submission = document.getElementById('xyz').value;
		
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
			$.ajax({
				type: 'POST',
				datatype: 'json',
				url: myAjax.ajaxurl,
				data: {action:'moh_ajax_action', arrive:arrive, depart:depart,submission:submission, security: myAjax.security },
				success: function(response){
					//empty div#show-rooms-info for more than one search
					console.log(response.length );
					$('div#show-rooms-info').html('');
					
						for(i in response){ 
						
							$('div#show-rooms-info').append(
															response[i].room_type,
															response[i].room_number,
															response[i].room_thumbnail,
															response[i].room_rate, 
															response[i].room_description,
															response[i].room_book_button,
															response[i].room_remove_button,
															response[i].room_show_booking_form,
															response[i].room_div_close
															);
						}
					
				},
				error: function(){
					console.log("this is an error");
				} 
			});
		

		}else{
			arrMsg = $('p#arr-err'); 
			arrMsg.html("Please enter a valid arrival and departure date.");
		}
	});

/*================================================================================*/ 
/*===============================  SELECT ROOMS  ==============================*/
/*================================================================================*/
//room object for localStorage
		var roomObj = {
			    	ids: []
			    };

	$(document).on("click", ".get-the-room", function(e) {
		roomObj.ids.push($(this).val());
	    var selectedRooms = [];
	    selectedRooms.push(roomObj);
	   $(this).text('Room Selected').fadeOut(1000);
	   $('button#remove-'+$(this).val()).text('Remove Room').fadeIn(1000);
	   
	  
	    localStorage.setItem('selected_rooms', JSON.stringify(selectedRooms));
	    localStorage.setItem('rm_no', JSON.stringify($(this).val()));
  		$('input.show-booking-button').show();
	  });

	//to remove selected room from localStorage
	$(document).on('click', '.remove-the-room', function(e){
		var selectedRooms = [];
		
		for(j=0;j< roomObj.ids.length;j++){
		 		if(roomObj.ids[j] === $(this).val()){
					//console.log("remove " + $(this).val());
					var index = roomObj.ids.indexOf($(this).val());
					roomObj.ids.splice(index, 1);
					 selectedRooms.push(roomObj);
					localStorage.setItem('selected_rooms', JSON.stringify(selectedRooms));
					$(this).text('Room Removed').fadeOut(1000);
					$('button#add-'+$(this).val()).text('Select Room').fadeIn(1000);
			 	}
			} 
	});

	//**NEW show booking form and get ids of rooms selected
	$(document).on('click', '.show-booking-button', function(e){
		e.preventDefault();
		//e.stopPropagation() 
		var roomsArray = [];
		var rm_nums = JSON.parse(localStorage.getItem("selected_rooms"));
		for(i=0;i<rm_nums[0].ids.length;i++){
			roomsArray.push(rm_nums[0].ids[i]);
		}
		var arr = JSON.parse(localStorage.getItem("arrDate"));
		var dep = JSON.parse(localStorage.getItem("depDate"));
	    var bookingData = {arr:arr, dep:dep, rm_nums:roomsArray};
	   
	    
	    mohGetForm();
	    //bookingAjaxRequest(bookingData, moh_booking_data_action);
	    $.ajax({
					type:'POST',
					dataType: 'json',
					url: myAjax.ajaxurl,
					data: {
						action: 'moh_booking_data_action',
						data: bookingData,
						//submission: document.getElementById('xyz').value,
						security: myAjax.checkAvail_security
					},
					success: function(response){
						if(response.success){
							$('div#booking-details').html(response.data);
							alert("aj ok");
							alert(response.data);

						}else{
							alert("aj not ok");
						}
					},
					error: function(response){
						alert("error" + response);
					}
				});
	   

	});

	/////////////////////////////////////////////////
	// window.onload = function(){
	// 		function bookingAjaxRequest(bookingData, action){
	// 			$.ajax({
	// 				type:'POST',
	// 				dataType: 'json',
	// 				url: myAjax.ajaxurl,
	// 				data: {
	// 					action: action,
	// 					data: bookingData,
	// 					security: myAjax.checkAvail_security
	// 				},
	// 				success: function(response){
	// 					if(response.success){
	// 						alert("aj ok");
	// 						alert(response.data);
	// 					}else{
	// 						alert("aj not ok");
	// 					}
	// 				},
	// 				error: function(response){
	// 					alert(response);
	// 				}
	// 			});
	// 		};
	// }
	
/*================================================================================*/ 
/*=================================  BOOKING FORM   ==============================*/
/*================================================================================*/


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
		var roomsArray = [];
		var rm_nums = JSON.parse(localStorage.getItem("selected_rooms"));
		for(i=0;i<rm_nums[0].ids.length;i++){
			console.log(rm_nums[0].ids[i]);
			roomsArray.push(rm_nums[0].ids[i]);
		}
	    // console.log(fn, ln, em, ad, country, phone, postcode, adults, children, arr_time);
	    // console.log("this is line 46");

		$.post(myAjax.ajaxurl, {
	    	action:'moh_ajax_action_guest_info',
	    	security_info: myAjax.security,
	    	checkin: arr,
	    	checkout: dep,
	    	rm_num: rm_num,
	    	rm_nums: roomsArray,
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
		

	}//END formGuestInfo
 
/*================================================================================*/ 
/*=================================  MISC FUNCTIONS   ==============================*/
/*================================================================================*/
//GET BOOKING FORM 
//TODO: check status, errors etc.
function mohGetForm(){
	 	var xhr = new XMLHttpRequest();
		xhr.open('GET', 'wp-content/plugins/moh_guesthouse/templates/moh-booking-form.php', true);
		xhr.send(null); //we're not passing any paramaters eg search paramater
		xhr.onload = function(){
			var el = document.getElementById('moh-booking-div');
			el.innerHTML = xhr.responseText;
			location.href = "#theBookingForm"; //this is probably not right
			el.show();
		
		}
	}


//CHECK AVAIL FORM VALIDATION
function arrivalInFuture(){
	arrive = document.getElementById('arrive').value;
	depart = document.getElementById('depart').value;
	var arr = new Date(arrive);
	var dep = new Date(depart);
	var now = new Date();
	arrMsg = $('p#arr-err');
	arrMsg.html("");
	var sixMonths = now.setMonth(now.getMonth() + 6);
	console.log(arr);
	
	if( checkDateFormat(arrive) && checkDateFormat(depart) ){
		if(arr > new Date() && arr < new Date(sixMonths)){
			//console.log("pass 6 months");
			//if it passes above check before dept
			if(arr<dep){
				//console.log("arrival is before dept");
				//if arr passes before dept check 2 weeks
				if(dep-arr <=1209600000){
					return true;
					//console.log("less than 2 weeks");
				}else{
					arrMsg.html('Sorry we only accept bookings for a maximum of 14 days.');
				}
				
			}else{
				arrMsg.html('Please check Arrival Date is before Departure Date');
			}
		}else{
			//console.log("fail");
			arrMsg.html('Please enter a valid Arrival Date, date must be in the future and within 6 months');
		}
	}//end check dateformat()
	else{
		//console.log("date format fail");
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

/*================================================================================*/ 
/*=================================  TO EVENTUALLY DELETE   ==============================*/
/*================================================================================*/
// window.onload = function(){
// 	var dateSubmit = document.getElementById('test-submit');

// 	function availAjaxRequest(formData, action){
// 		$.ajax({
// 			type:'POST',
// 			dataType: 'json',
// 			url: myAjax.ajaxurl,
// 			data: {
// 				action: action,
// 				data: formData,
// 				submission: document.getElementById('xyz').value,
// 				security: myAjax.checkAvail_security
// 			},
// 			success: function(response){
// 				if(response.success){
// 					alert("aj ok");
// 					alert(response.data);
// 				}else{
// 					alert("aj not ok");
// 				}
// 			}
// 		});
// 	};


// 	dateSubmit.addEventListener('click', function(e){
// 		e.preventDefault();
// 		e.stopPropagation() 
// 		var formData = {
// 			moh_test_arrive: document.getElementById('arrive').value,
// 			moh_test_depart: document.getElementById('depart').value

// 		}
// 		console.log("hiya");
// 		availAjaxRequest(formData, 'moh_test_ajax_action');
// 	});
// }//end window onload function

	


	








	//send selected arrival and departure dates to page-book-room-***
	var arr = JSON.parse(localStorage.getItem("arrDate"));
	var dep = JSON.parse(localStorage.getItem("depDate"));
	var rm_num = JSON.parse(localStorage.getItem("rm_no"));


	var security_rm;
	$('div#booking-details').html("<h3>You are booking from "  + arr + " until " + dep + "</h3>");
	$.post(myAjax.ajaxurl, {action:'moh_ajax_action_get_details', arr:arr, dep:dep, rm_no:rm_num,  security_rm: myAjax.security }, function(data2){
				$('div#booking-data').html(data2);
			
			});

	

	//send selected arrival and departure dates to page-book-room-***
	
	//var rm_nums = JSON.parse(localStorage.getItem("rm_no"));


	



	/////


	// handle booking form
	// $('input#guest-info').on('click', function(){	
	//     var fn=$('input#fn').val();
	//     var ln=$('input#ln').val();
	//     var em=$('input#email').val();
	//    	var ad=$('input#address').val();
	//     var country=$('input#country').val();
	//     var phone=$('input#phone').val();
	//     var postcode=$('input#postcode').val();
	//     var adults=$('input#no-adults').val();
	//     var children =$('input#no-children').val();
	//     var arr_time=$('input#arr-time').val();
	// 	var arr = JSON.parse(localStorage.getItem("arrDate"));
	// 	var dep = JSON.parse(localStorage.getItem("depDate"));
	// 	var rm_num = JSON.parse(localStorage.getItem("rm_no"));
	// 	var security_info;
	//     console.log(fn, ln, em, ad, country, phone, postcode, adults, children, arr_time);




	

	//     $.post(myAjax.ajaxurl, {
	//     	action:'moh_ajax_action_guest_info',
	//     	security_info: myAjax.security,
	//     	checkin: arr,
	//     	checkout: dep,
	//     	rm_num: rm_num,
	//     	fname:fn, 
	//     	lname:ln, 
	//     	email:em,
	//     	address:ad,
	//     	country:country, 
	//     	phone:phone,
	//     	postcode:postcode,
	//     	no_adults:adults,
	//     	no_children:children, 
	//     	arr_time:arr_time

	//     }, function(data4){
	// 				$('div#info-success').html(data4);
				
				
	// 			});
		

	// });


	


});