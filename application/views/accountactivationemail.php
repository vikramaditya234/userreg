<html>
<head>
<title>Activation Mail</title>
</head>
<body>

Hi <?php echo $names['firstname'].' '.$names['lastname']; ?>
Welcome to the user regiration site. Please click on this link to activate your account<br>

Please click the <a href="<?php echo $link; ?>">link</a> to activate the account.<br>

Otherwise you can copy paste the following link on the brower.<br>
<a href="<?php echo $link; ?>"><?php echo $link; ?></a>

</body>
</html>