<?php

// Manualno inicijaliziramo bazu ako već nije.
require_once '../../model/db.class.php';

$db = DB::getConnection();

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS users (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'username varchar(20) NOT NULL,' .
		'password varchar(255) NOT NULL,' .
		'reg_string varchar(30) NOT NULL,' .
		'reg INT)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #1: " . $e->getMessage() ); }

echo "Napravio tablicu users.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS subjects (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'username VARCHAR(50) NOT NULL,' .
		'title varchar(255) NOT NULL,'.
		'post varchar(1000) NOT NULL,'.
		'upvotes INT,' .
		'downvotes INT,'.
		'post_date datetime NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #2: " . $e->getMessage() ); }

echo "Napravio tablicu subjects.<br />";


try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS posts (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'username VARCHAR(50) NOT NULL,' .
		'id_subject INT NOT NULL,' .
		'post varchar(1000) NOT NULL,'.
		'upvotes INT,' .
		'downvotes INT,'.
		'post_date datetime NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error #3: " . $e->getMessage() ); }

echo "Napravio tablicu posts.<br />";

try
{
	$st = $db->prepare( 'INSERT INTO users(username, password , reg_string, reg) VALUES (:username, :password, :reg_string, 1)' );

	$st->execute( array( 'username' => 'Pero', 'password' => password_hash( 'perinasifra', PASSWORD_DEFAULT ) ,
	 											'reg_string' => 'fpalsmfaofsafwawskfs') );
	$st->execute( array( 'username' => 'Mirko', 'password' => password_hash( 'mirkovasifra', PASSWORD_DEFAULT ) ,
	 											'reg_string' => 'rhrheshsebergeskrufk' ) );
	$st->execute( array( 'username' => 'Slavko', 'password' => password_hash( 'slavkovasifra', PASSWORD_DEFAULT ) ,
	 											'reg_string' => 'zbweurkjpgjwwfwothsm' ) );
	$st->execute( array( 'username' => 'Ana', 'password' => password_hash( 'aninasifra', PASSWORD_DEFAULT ) ,
	 											'reg_string' => 'dawihoiawawumoritosn' ) );
	$st->execute( array( 'username' => 'Maja', 'password' => password_hash( 'majinasifra', PASSWORD_DEFAULT ) ,
	 											'reg_string' => 'wavfajgioegsheprhfks' ) );
}
catch( PDOException $e ) { exit( "PDO error #4: " . $e->getMessage() ); }

echo "Ubacio korisnike u tablicu users.<br />";


try
{
	$st = $db->prepare( 'INSERT INTO subjects(username, title, post, upvotes, downvotes, post_date) '.
																		'VALUES (:username, :title, :post, :upvotes, :downvotes, :post_date)' );

	$st->execute( array( 'username' =>'Pero', 'title' => 'Pomoć oko zagonetke' ,
											 'post' => 'Zagonetka je: Ako izgovoris moje ime vise me neće biti. Sto sam ja? ',
											 'upvotes' => 1, 'downvotes' => 6,
											 'post_date' => '2017-01-01 18:12:53' ) );
	$st->execute( array( 'username' => 'Pero', 'title' => 'Pomoc sa grafickom',
											 'post' => 'Kupio sam novu graficku i kada sam je stavio windows 10 je ne prepoznaje. Graficka je GeForce 840m.',
											 'upvotes' => 1, 'downvotes' => 0,
											 'post_date' => '2017-01-15 06:08:23' ));
	$st->execute( array( 'username' => 'Mirko', 'title' => 'Rasprava/serija: Westworld' ,
											 'post' => 'Ovdje raspravljajte o seriji Westworld prva sezona.',
											 'upvotes' => 10, 'downvotes' => 0,
											 'post_date' => '2017-01-22 21:23:01' ) );
	$st->execute( array( 'username' => 'Ana', 'title' => 'Kako iskljuciti Windows update?' ,
											 'post' => 'Zelim manualno raditi update kada meni odgovara pa kako da iskljucim automatski na windows 10?',
											 'upvotes' => 2, 'downvotes' => 3,
											 'post_date' => '2017-02-12 23:48:34' ) );
	$st->execute( array( 'username' => 'Maja', 'title' => 'Rasprava/igra: Rocket League' ,
											 'post' => 'Ovdje raspravljajte o igri Rocket League.',
											 'upvotes' => 3, 'downvotes' => 1,
										   'post_date' => '2017-03-22 22:16:25' ) );
}
catch( PDOException $e ) { exit( "PDO error #5: " . $e->getMessage() ); }

echo "Ubacio teme u tablicu subjects.<br />";


try
{
	$st = $db->prepare( 'INSERT INTO posts(username, id_subject, post, upvotes, downvotes, post_date)'.
											' VALUES (:username, :id_subject, :post, :upvotes, :downvotes, :post_date)' );

	$st->execute( array( 'username' => 'Pero', 'id_subject' => 3, 'post' => 'Meni je osobno serija odlicna i pogotovo mi se svida gluma.',
 											'upvotes' => 5, 'downvotes' => 1, 'post_date' => '2017-01-15 15:26:31' ));
	$st->execute( array( 'username' => 'Ana', 'id_subject' => 2, 'post' => 'Jesi pokusao kontaktirati nvidia podrsku?',
											'upvotes' => 0, 'downvotes' => 0, 'post_date' => '2017-03-22 21:15:56'));
	$st->execute( array( 'username' => 'Maja', 'id_subject' => 1, 'post' => 'Tisina',
											'upvotes' => 15, 'downvotes' => 3, 'post_date' => '2017-05-02 13:26:12'));
	$st->execute( array( 'username' => 'Mirko', 'id_subject' => 5, 'post' => 'Ma koga briga za tu glupu igru',
											'upvotes' => 1, 'downvotes' => 20, 'post_date' => '2017-05-03 09:53:47'));
}
catch( PDOException $e ) { exit( "PDO error #5: " . $e->getMessage() ); }

echo "Ubacio postove u tablicu posts.<br />";

?>
