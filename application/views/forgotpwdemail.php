<html>
<head>
<title>Forgot Password Mail</title>
</head>
<body>

Hi <?php echo $names['firstname'].' '.$names['lastname']; ?>
Please click the <a href="<?php echo $link; ?>">link</a> to reset the password.<br>

Otherwise you can copy paste the following link on the brower.<br>
<a href="<?php echo $link; ?>"><?php echo $link; ?></a>

</body>
</html>