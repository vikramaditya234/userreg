<html>
<head>
<title>Login Form</title>
</head>
<body>

<?php echo validation_errors(); ?>

<a href="/login/doSignup">Signup</a>
<?php
    if (isset($err))
        echo '<br>'.$err;
?>
<?php echo form_open('login/index'); ?>

<h5>Email Address</h5>
<input type="text" name="email" value="" size="50" />

<h5>Password</h5>
<input type="text" name="password" value="" size="50" />

<a href="/login/forgotPassword">Forgot Password</a>
<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>