<?php
 
$missing = array();
$errors = array();
if (isset($_POST['register'])) {
	require_once __DIR__ . '/../includes/process.php';
}
?>

<footer id="member" class="main-footer">

	<h3>Become a member</h3>
	<p>
		If you would like to sign up for Goldsmiths Bootcamp, please fill in the form below
		and someone will get back to you with payment options.
	</p>
	
	<!-- Start form --> 
	<form id="member-form" name="memberform" method="post">
		<!-- Name --> 
		<div class="form-group">
			<input type="text" name="name" placeholder="Your Name"
			<?php
			if ($errors || $missing) {
				echo 'value="' . htmlentities($_POST['name']) . '"';
			} ?>
			/>
		</div>
		<?php if ($missing && in_array('name', $missing)) : ?>
		<span class="error">Please enter your name</span>
		<?php endif; ?>
		<!-- Email -->
		<div class="form-group">
			<input type="email" name="email" placeholder="Email Address" autocomplete="off"
			<?php
				if (!isset($errors['email']) && ($errors || $missing)) {
					echo 'value="' . htmlentities($_POST['email']) . '"';
				} ?>
			/>
		</div>
		<?php if ($missing && in_array('email', $missing)) : ?>
            <span class="error">Please enter your email address</span>
            <?php elseif (isset($errors['email'])) : ?>
            <span class="error"><?= $errors['email']; ?></span>
            <?php endif; ?>
         <!-- Phone number  -->     
		<div class="form-group">
			<input type="tel" name="phonenumber" placeholder="Phone Number"
			<?php
			if ($errors || $missing) {
				echo 'value="' . htmlentities($_POST['phonenumber']) . '"';
			} ?>
			/>
		</div>
		<?php if ($missing && in_array('phonenumber', $missing)) : ?>
		<span class="error">Please enter your phone number</span>
		<?php endif; ?>
		
		<span class="form-group" class="error"></span>
		<button type="submit" name="register" class="submit">
			Submit Membership Request
		</button>
	</form>
	<!-- End Form -->
</footer>

</div>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>