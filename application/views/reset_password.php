<html>
<head>
<title>Password reset Form</title>
</head>
<body>
<h3> Reset password </h3>
<?php 
    echo validation_errors();
?>

<?php 
if (isset($key))
    echo form_open('login/resetPassword/'.$key); 
else
    echo form_open('login/resetPassword'); 
?>

<h5>Password</h5>
<input type="password" name="password" size="50" />

<h5>Confirm Password</h5>
<input type="password" name="passconf" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>