<html>
<head>
<title>Signup Form</title>
</head>
<body>
<h3> Signup </h3>
<?php echo validation_errors(); ?>

<?php echo form_open('login/doSignup'); ?>

<h5>First name</h5>
<input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>" size="50" />

<h5>Last name</h5>
<input type="text" name="lastname" value="<?php echo set_value('lastname'); ?>" size="50" />

<h5>Email Address</h5>
<input type="text" name="email" value="<?php echo set_value('email'); ?>" size="50" />

<h5>Password</h5>
<input type="password" name="password" size="50" />

<h5>Confirm Password</h5>
<input type="password" name="passconf" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>