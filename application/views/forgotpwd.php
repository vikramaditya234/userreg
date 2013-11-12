<html>
<head>
<title>Forgot password</title>
</head>
<body>

<?php echo validation_errors(); ?>

<a href="/login/doSignup">Signup</a>
<?php
    if (isset($err))
        echo '<br>'.$err;
    else if (isset($success))
        echo '<br>'.$success;
?>
<?php echo form_open('login/forgotPassword'); ?>

<h5>Email Address</h5>
<input type="text" name="email" value="" size="50" />
<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>