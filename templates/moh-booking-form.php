<!--<div class="booking-form" style="display:none;">form goes here -->
<div class="booking-form">
<h1>Book Rooms</h1>

							<div id="booking-details">
								<h3>You are booking: </h3>
							</div>
							<div id="booking-data"></div>
							<div id="room-no"></div>

						<div id="info-success"></div>
<form action="" id="theForm"
 method="post">
	
	
<p>First Name: <input id="fn" type="text" name="fname" size="15" maxlength="20" value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>" /></p>
								<p>Last Name: <input id="ln" type="text" name="lname" size="15" maxlength="40" value="<?php if (isset($_POST['name'])) echo $_POST['lname']; ?>" /></p>
								<p>Email: <input id="email" type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
								<p>Address: <input id="address" type="text" name="address" size="20" maxlength="200" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>"  /> </p>
								<p>Country: <input id="country" type="text" name="country" size="20" maxlength="200" value="<?php if (isset($_POST['country'])) echo $_POST['country']; ?>"  /> </p>
								<p>Eircode: <input id="postcode" type="text" name="postcode" size="20" maxlength="200" value="<?php if (isset($_POST['postcode'])) echo $_POST['postcode']; ?>"  /> </p>
								<p>Phone: <input id="phone" type="text" name="phone" size="20" maxlength="200" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>"  /> </p>
								<p>Number of Adults: <input id="no-adults" type="number" name="no_adults" max="4" value="<?php if (isset($_POST['no_adults'])) echo $_POST['no_adults']; ?>"  /> </p>
								<p>Number of Children: <input id="no-children" type="number" name="no_children" max="4" value="<?php if (isset($_POST['no_children'])) echo $_POST['no_children']; ?>"  /> </p>
								<p>Arrival Time: <input id="arr-time" type="time" name="arr_time"value="<?php if (isset($_POST['arr_time'])) echo $_POST['arr_time']; ?>"  /> </p>
	<p><input type="button" id="guest-info-form"  name="submit"  value="Register" /></p>
							
</form>



<div>




