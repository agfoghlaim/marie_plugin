jQuery(document).ready(function($){



	$('input#date-submit').on('click', function(){
		var arrive = $('input#arrive').val();
		var depart = $('input#depart').val();
		var arrDate = 'arrDate';
		var depDate = 'depDate';
		localStorage.setItem(arrDate, JSON.stringify(arrive));
		localStorage.setItem(depDate, JSON.stringify(depart));

		
		
		if($.trim(arrive) != ''){
			$.post(myAjax.ajaxurl, {action:'moh_ajax_action', arrive:arrive, depart:depart }, function(data){
				$('div#date-data').html(data);
			});

		}
	});

	//send selected arrival and departure dates to page-book-room-***
	var arr = JSON.parse(localStorage.getItem("arrDate"));
	var dep = JSON.parse(localStorage.getItem("depDate"));
	$('div#booking-details').html("You are booking from " + arr + " until " + dep);
	$.post(myAjax.ajaxurl, {action:'moh_ajax_action_booking', arr:arr, dep:dep }, function(data2){
				$('div#booking-data').html(data2);
			
			});

var rm_num = JSON.parse(localStorage.getItem("rm_no"));
$.post(myAjax.ajaxurl, {action:'moh_ajax_action_room', rm_no:rm_num}, function(data3){
				$('div#room-no').html(data3);
			
			
			});


$(document).on("click", ".get-the-room", function(e) {
    console.log("clicked: %o",  this);
    console.log($(this).val());
    var rmNo = $(this).val();
    var rm_no = 'rm_no';
    localStorage.setItem(rm_no, JSON.stringify(rmNo));
  });
	




	


});

