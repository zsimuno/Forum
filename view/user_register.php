<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<tr><td class="posttitle">
  Registracija
</td></tr>
<tr><td class="posttitle">
<?php
//Ispisuje poruke iz controllera (npr. "Već postoji username")
echo $messagereg."<br>"; ?>
</td></tr>
<tr><td>
  <!-- Forma za registriranje na stranicu  -->
<form class="" action="<?php echo __SITE_URL; ?>/forum.php?rt=user/registerNew" method="post">
  <br>
  E-mail:<br>    <input type="text" name="email"><br>
  Username:<br>  <input type="text" name="username"><br>
  Password:<br>  <input type="password" name="password"><br><br>
  <input type="submit" name="login" value="Register!">

</form>
<br>
</td></tr>



<tr><td class="posttitle">
  Već ste korisnik? <a class="nav" href="<?php echo __SITE_URL; ?>/forum.php?rt=user">| Log in |</a>
</td></tr>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
