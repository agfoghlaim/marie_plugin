
jQuery('input#name-submit').on('click', function(){
	//alert(7);
	var arrive = jQuery('input#arrive').val();
	var depart = jQuery('input#depart').val();
	//alert(arrive);
	//alert(depart);
	
	if(jQuery.trim(arrive) != ''){
		//alert(ajaxurl);
		//alert(34);
		jQuery.post(myAjax.ajaxurl, {action:'moh_ajax_action', arrive:arrive, depart:depart }, function(data){
			jQuery('div#name-data').html(data);
			//alert(data);
		});

	}
});

