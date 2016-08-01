<footer id="member" class="main-footer">

	<h3>Become a member</h3>
	<p>
		If you would like to sign up for Goldsmiths Bootcamp, please fill in the form below
		and someone will get back to you with payment options.
	</p>

	<form id="member-form" name="memberform" onsubmit="return formValidate();">
		<div class="form-group">
			<input type="text" name="name" placeholder="Your Name"/>
		</div>
		<div class="form-group">
			<input type="email" name="email" placeholder="Email Address"/>
		</div>
		<div class="form-group">
			<input type="tel" name="phonenumber" placeholder="Phone Number"/>
		</div>
		<span class="form-group" id="error"></span>
		<button type="submit" class="submit">
			Submit Membership Request
		</button>
	</form>

</footer>

</div>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>