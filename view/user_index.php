<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<tr><td class="posttitle">
  Log in
</td></tr>

<!-- Forma za logiranje na stranicu  -->
<tr><td>
<form class="" action="<?php echo __SITE_URL; ?>/forum.php?rt=user/login" method="post">
  <br>
  Username:<br>  <input type="text" name="username"><br>
  Password:<br>  <input type="password" name="password"><br><br>
  <input type="submit" name="login" value="Log in!">

</form>
<br>
</td></tr>



<?php
//Ispisuje poruke iz controllera (npr. "Neuspješan login")
if(isset($message))
 echo "<tr><td class=\"posttitle\">".$message."</td></tr>"; ?> <br>



<tr><td class="posttitle">
  Niste ste još registrirali?
  <a class="nav" href="<?php echo __SITE_URL; ?>/forum.php?rt=user/register">| Register |</a>
</td></tr>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
