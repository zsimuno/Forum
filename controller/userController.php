<?php

class userController extends BaseController
{
  public function index()
	{
    $this->registry->template->show( 'user_index' );
  }

  function login()
  {

    if( ! ( isset($_POST['username']) && isset($_POST['password'])
            && !empty($_POST['username']) && !empty($_POST['password']) ) )
       {
         $this->registry->template->message = "Neuspješan login";
         $this->registry->template->show( 'user_index' );
         return;
       }

    $fs = new ForumService();
    $users = $fs -> getAllUsers();

    foreach ($users as $user) {
      if($user->username === $_POST['username'] && password_verify( $_POST['password' ], $user->password ))
      {
        if($user->reg === '0')
        {
          $this->registry->template->message = "Molimo prvo potvrdite registraciju na mailu";
          $this->registry->template->show( 'user_index' );
          return;
        }
        $_SESSION['user'] = array('id' => $user->id,'username' => $user->username);
        break;
      }
    }

    if(!isset($_SESSION['user']))
    {
      $this->registry->template->message = "Neuspješan login";
      $this->registry->template->show( 'user_index' );
      return;
    }
    header( 'Location: ' . __SITE_URL . '/forum.php' );
  }

  function logout()
  {
    session_unset();
    session_destroy();
    header( 'Location: ' . __SITE_URL . '/forum.php' );
  }
  function register()
  {
    $this->registry->template->messagereg = "Korisničko ime treba imati između 3 i 10 slova.";
    $this->registry->template->show( 'user_register' );
  }
  function registerNew()
  {
    if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email'])
       || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']))
       {
         $this->registry->template->messagereg = "Unesite sve potrebne podatke";
         $this->registry->template->show( 'user_register' );
         return;
       }
    if( !preg_match( '/^[A-Za-z]{3,10}$/', $_POST['username'] ) )
    {
      $this->registry->template->messagereg = "Korisničko ime treba imati između 3 i 10 slova.";
      $this->registry->template->show( 'user_register' );
      return;
    }
    if( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
    {
      $this->registry->template->messagereg = "E-mail adresa nije ispravna.";
      $this->registry->template->show( 'user_register' );
      return;
    }

    $fs = new ForumService();

    $hash = password_hash( $_POST['password' ], PASSWORD_DEFAULT );

    //registracijski niz
    $reg_seq = '';
		for( $i = 0; $i < 20; ++$i )
			$reg_seq .= chr( rand(0, 25) + ord( 'a' ) );

    //newUser vraca postoji li vec korisnik

    $exists = $fs -> newUser($_POST['username'], $hash, $reg_seq);

    if( $exists )
    {
      $this->registry->template->messagereg = "Taj username već postoji";
      $this->registry->template->show( 'user_register' );
      return;
    }

    $to = $_POST['email'];
    $subject = 'Potvrda registracije (pritisnite link)' ;
    $body = 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) .
            '/forum.php?rt=user/reg_string&string='.$reg_seq;
    $header = "From: Forum\r\n";
    mail( $to, $subject, $body, $header );

    $this->registry->template->messagereg = "Molimo potvrdite registraciju na linku koji ste dobili u mailu";
    $this->registry->template->subjectList = $fs->getAllSubjects();
    $this->registry->template->show( 'subjects_index' );


  }

  function reg_string()
  {
    if (isset($_GET['string']) && preg_match('/^[a-z]+$/', $_GET['string'])) //provjerit da je dobrog oblika
    {
      $reg_string = $_GET['string'];
    }
    else {
      header('Location: ' . __SITE_URL . '/forum.php?rt=subjects' );
      exit();
    }


  $fs = new ForumService();

  $ex_id_user = array(); //prvi clan govori postoji li user a ako postoji 2. clan je id a treci username
  $ex_id_user = $fs ->regLink($reg_string);

  if($ex_id_user[0] === '0')
  {
    header('Location: ' . __SITE_URL . '/forum.php?rt=subjects' );
    exit();
  }

  $_SESSION['user'] = array('id' => $ex_id_user[1], 'username' => $ex_id_user[2]);
  $this->registry->template->messagereg = "Registracija uspješna!";
  $this->registry->template->subjectList = $fs->getAllSubjects();
  $this->registry->template->show( 'subjects_index' );
  }

};
