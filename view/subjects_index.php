<?php require_once __SITE_PATH . '/view/_header.php'; ?>

		<?php
		//Ispisuje "Uspješna registracija" ako je se korisnik taman registrirao
	if(isset($messagereg))
		{
			echo "<tr><td class=\"posttitle\">".$messagereg."</td></tr><br>";
		}

	//Ispiši popis tema
  foreach ($subjectList as $subject)
	{
    echo "<tr><th class=\"posttitle\"><a href=\"".__SITE_URL."/forum.php?rt=post&id=".$subject->id."\">".
					$subject->title."</a> <br></th></tr>".
				 "<tr><td class=\"username\">".
         $subject->username." ".$subject->post_date."<br>";

				 //provjerava je li korisnik ulogiran pa ako je dopušta da radi upvote i downvote a inače ne
	 if(isset($_SESSION['user']))
		 echo $subject->upvotes." <a href=\"".__SITE_URL."/forum.php?rt=subjects/upvote&id=".$subject->id.
					"\" class=\"arrow\"> <div class=\"up\"></div></a> -  ".
					$subject->downvotes." <a href=\"".__SITE_URL."/forum.php?rt=subjects/downvote&id=".$subject->id.
					"\" class=\"arrow\"> <div class=\"down\"></div></a> ";
	 else
		 echo $subject->upvotes." <div class=\"up\"></div> -  ".
					$subject->downvotes." <div class=\"down\"></div> ";

    echo "</td></tr><tr><td class=\"post\">".$subject->post."</td>".
				 "</td></tr>";

   }
	 
	 //Ako user nije ulogiran onda ne dopuštaj dodavanje nove teme
	if(isset($_SESSION['user']))
 	{
 	?>
 	<tr class="username">
 		<td>
 			<form class="" action="<?php echo __SITE_URL; ?>/forum.php?rt=subjects/newSubject" method="post">
 				Dodaj temu: <br>
 				Naslov: <input type="text" name="title"><br>
 				Post: <br><textarea name="post" rows="8" cols="80"></textarea><br>
				<input type="submit" name="submit" value="Dodaj">
 			</form>
 		</td>
 	</tr>


 <?php }
require_once __SITE_PATH . '/view/_footer.php';
?>
