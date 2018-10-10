<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Forum</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>

<table>
<tr class="toptitle" id="top">
	<th align="center">
		<h1>Forum</h1>
		<br><hr>
		<nav>

			<a class="nav" href="<?php echo __SITE_URL; ?>/forum.php?rt=subjects">Home</a>

			<!--Ako je user ulogiran onda ispisi logout inače ispisi register i login-->
			<?php if(isset($_SESSION['user'])) {  ?>

			| <a class="nav" href="<?php echo __SITE_URL; ?>/forum.php?rt=user/logout">Log out</a>

			<?php echo " ( ".$_SESSION['user']['username']." ) "; }

			else { if(explode('/', $_GET['rt'])[0] !== "user"){?>
							| <a class="nav" href="<?php echo __SITE_URL; ?>/forum.php?rt=user">Log in</a>
							| <a class="nav" href="<?php echo __SITE_URL; ?>/forum.php?rt=user/register">Register</a>

			<?php }} ?>

		</nav>
	</th>
</tr>
