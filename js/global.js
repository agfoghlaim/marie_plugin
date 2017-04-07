
jQuery('input#name-submit').on('click', function(){
	alert(2);
	var arrive = jQuery('input#arrive').val();
	var depart = jQuery('input#depart').val();
	
	if(jQuery.trim(arrive) != ''){
		jQuery.post('http://localhost/designassociates/marie_plugin/wp-content/plugins/moh_guesthouse/ajax/ajax.php', {arrive:arrive, depart:depart }, function(data){
			jQuery('div#name-data').html(data);
		});

	}
});