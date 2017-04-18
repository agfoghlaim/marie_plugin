<!DOCTYPE html>
<html>
	<head>
		<title>ajaxing</title>
	</head>
	<body>
		<?php wp_nonce_field( basename(__FILE__), 'moh_check_availabity')?>
		<label>Arrive:</label> 
		<input class="d" type="date" id="arrive" name="arrive">
		<label>Depart:</label> 
		<input class="datepicker" type="date" id="depart" name="depart">
		<label>Nights:</label> 
		<input type="number" min="1" max="14" id="num-nights" name="num-nights">
		<input type="submit" id="date-submit" value="Check Dates">
		<input type="text" id="xyz" style="display:none" name="<?php echo apply_filters( 'honey', 'date-submitted'); ?>" value="">
		<input type="submit" id="test-submit" value="Test Check Dates">

		<div id="date-data"></div>
		<p id="arr-err"></p>
		<p id="dep-err"></p>
		<p id="nights-err"></p>	
		<p id="show-nights"></p>
		
		<!--<script type="text/javascript" src="http://localhost/designassociates/marie_plugin/wp-content/plugins/moh_guesthouse/js/global.js"></script>-->
		
	</body>

</html>

