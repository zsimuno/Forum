<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<!-- ispiši naslov teme i prvi post -->
	<tr><th class="posttitle"> Tema:
		<?php echo $subject->title."<br></th></tr><tr class=\"username\"><td>".
							 $subject->username." ".$subject->post_date."<br>";

					//provjerava je li korisnik ulogiran pa ako je dopušta da radi upvote i downvote a inače ne
					if(isset($_SESSION['user']))
						echo $subject->upvotes." <a href=\"".__SITE_URL."/forum.php?rt=post/upvoteSubject&id=".$subject->id.
								 "\" class=\"arrow\"> <div class=\"up\"></div></a> -  ".
								 $subject->downvotes." <a href=\"".__SITE_URL."/forum.php?rt=post/downvoteSubject&id=".$subject->id.
								 "\" class=\"arrow\"> <div class=\"down\"></div></a>";
					else
						echo $subject->upvotes." <div class=\"up\"></div> -  ".
								 $subject->downvotes." <div class=\"down\"></div>";

					echo "</td></tr><tr><td class=\"post\">".
							 $subject->post; ?>
	</td></tr>

	<?php
		//Ispiši sve postove
		foreach( $postList as $post )
		{
			echo "<tr class=\"username\"><td >".
					 $post->username." ".$post->post_date."<br>";

			if(isset($_SESSION['user']))
				echo $post->upvotes." <a href=\"".__SITE_URL."/forum.php?rt=post/upvotePost&id=".$post->id.
						 "\" class=\"arrow\"> <div class=\"up\"></div></a> -  ".
						 $post->downvotes." <a href=\"".__SITE_URL."/forum.php?rt=post/downvotePost&id=".$post->id.
						 "\" class=\"arrow\"> <div class=\"down\"></div></a>";
			else
				echo $post->upvotes." <div class=\"up\"></div> -  ".
						 $post->downvotes." <div class=\"down\"></div> ";

			echo "<br></td></tr><tr><td class=\"post\">".$post->post."</td></tr>";
		}

	//ne dozvoljava dodavanje posta ako nema ulogiranog usera
	if(isset($_SESSION['user']))
	{
	?>
	<tr class="username">
		<td>
			<form class="" action="<?php echo __SITE_URL; ?>/forum.php?rt=post/newPost&id=<?php echo $subject->id; ?>" method="post">
				Dodaj post: <br><textarea name="post" rows="8" cols="80"></textarea><br>
				<input type="submit" name="submit" value="Dodaj">
			</form>
		</td>
	</tr>


<?php } require_once __SITE_PATH . '/view/_footer.php'; ?>
