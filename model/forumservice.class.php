<?php
/**
 *
 */
class ForumService
{
  function getAllUsers( )
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT id, username, password, reg_string, reg FROM users ORDER BY username' );
      $st->execute();
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $arr = array();
    while( $row = $st->fetch() )
    {
      $arr[] = new User( $row['id'], $row['username'], $row['password'], $row['reg_string'], $row['reg'] );
    }

    return $arr;
  }
  //-------------------------------------------------------------------------------------------------------------------
  function getAllSubjects()
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT id, username, title, post, upvotes, downvotes, post_date FROM subjects ORDER BY id DESC' );
      $st->execute();
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $arr = array();
    while( $row = $st->fetch() )
    {
      $arr[] = new Subject( $row['id'], $row['username'], $row['title'], $row['post'], $row['upvotes'],
                            $row['downvotes'], $row['post_date']);
    }

    return $arr;
  }
  //-------------------------------------------------------------------------------------------------------------------
  function getSubjectById($id)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT id, username, title, post, upvotes, downvotes, post_date FROM subjects WHERE id = :id' );
      $st->execute(array( 'id' => $id ));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }


    while( $row = $st->fetch() )
    {
      $arr = new Subject( $row['id'], $row['username'], $row['title'], $row['post'],
                            $row['upvotes'], $row['downvotes'], $row['post_date']);
    }

    return $arr;
  }

  //-------------------------------------------------------------------------------------------------------------------
  function getAllPosts()
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT id, username, id_subject, post, upvotes, downvotes, post_date FROM posts ORDER BY id ASC' );
      $st->execute();
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $arr = array();
    while( $row = $st->fetch() )
    {
      $arr[] = new Post( $row['id'], $row['username'], $row['id_subject'], $row['post'], $row['upvotes'],
                            $row['downvotes'], $row['post_date']);
    }

    return $arr;
  }

  //-------------------------------------------------------------------------------------------------------------------
  function getPostBySubjectId($id)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT id, username, id_subject, post, upvotes, downvotes, post_date FROM posts '.
                          'WHERE id_subject = :id ORDER BY id ASC' );
      $st->execute(array('id' => $id));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $arr = array();
    while( $row = $st->fetch() )
    {
      $arr[] = new Post( $row['id'], $row['username'], $row['id_subject'], $row['post'], $row['upvotes'],
                            $row['downvotes'], $row['post_date']);
    }

    return $arr;
  }

  //-------------------------------------------------------------------------------------------------------------------
  function upvoteSubject($id)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT upvotes FROM subjects WHERE id = :id' );
      $st->execute(array( 'id' => $id ));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $row = $st->fetch();
    $vote = $row['upvotes'] + 1;
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'UPDATE subjects SET upvotes = :upvotes WHERE id = :id' );
      $st->execute(array('upvotes' => $vote, 'id' => $id ));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
  }

  //-------------------------------------------------------------------------------------------------------------------
  function downvoteSubject($id)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT downvotes FROM subjects WHERE id = :id' );
      $st->execute(array( 'id' => $id ));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $row = $st->fetch();
    $vote = $row['downvotes'] + 1;
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'UPDATE subjects SET downvotes = :downvotes WHERE id = :id' );
      $st->execute(array('downvotes' => $vote, 'id' => $id ));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
  }

  //-------------------------------------------------------------------------------------------------------------------
  function upvotePost($id)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT id_subject, upvotes FROM posts WHERE id = :id' );
      $st->execute(array('id' => $id));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $row = $st->fetch();
    $vote = $row['upvotes'] + 1;
    $idSubject = $row['id_subject'];

    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'UPDATE posts SET upvotes = :upvotes WHERE id = :id' );
      $st->execute(array('upvotes' => $vote, 'id' => $id ));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    return $idSubject;
  }

  //-------------------------------------------------------------------------------------------------------------------
  function downvotePost($id)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT id_subject, downvotes FROM posts WHERE id = :id' );
      $st->execute(array('id' => $id));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $row = $st->fetch();
    $vote = $row['downvotes'] + 1;
    $idSubject = $row['id_subject'];
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'UPDATE posts SET downvotes = :downvotes WHERE id = :id' );
      $st->execute(array('downvotes' => $vote, 'id' => $id ));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    return $idSubject;
  }

  //-------------------------------------------------------------------------------------------------------------------
  function addNewSubject($username, $title, $post, $post_date)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'INSERT INTO subjects(username, title, post, upvotes, downvotes, post_date) '.
    																		'VALUES (:username, :title, :post, :upvotes, :downvotes, :post_date)' );
      $st->execute(array('username' => $username, 'title' => htmlentities($title, ENT_QUOTES),
                         'post' => htmlentities($post, ENT_QUOTES),
                         'upvotes' => 0, 'downvotes' => 0, 'post_date' => $post_date));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
  }

  function addNewPost( $username, $id_subject, $post, $post_date)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'INSERT INTO posts(username, id_subject, post, upvotes, downvotes, post_date)'.
    											' VALUES (:username, :id_subject, :post, :upvotes, :downvotes, :post_date)' );
      $st->execute(array('username' => $username, 'id_subject' => $id_subject, 'post' => htmlentities($post, ENT_QUOTES),
                         'upvotes' => 0, 'downvotes' => 0, 'post_date' => $post_date));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
  }

  //-------------------------------------------------------------------------------------------------------------------
  function newUser($username, $password, $reg_seq)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT username FROM users WHERE username = :username' );
      $st->execute(array('username' => $username));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    if($st->rowCount() >= 1)
      return 1;

    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'INSERT INTO users(username, password, reg_string, reg)'.
    											' VALUES (:username, :password, :reg_string, 0)' );
      $st->execute(array('username' => $username, 'password' => $password, 'reg_string' => $reg_seq));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    return 0;
  }

  //-------------------------------------------------------------------------------------------------------------------
  function regLink($reg_string)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT id, username FROM users WHERE reg_string = :reg_string' );
      $st->execute(array('reg_string' => $reg_string));
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    if($st->rowCount() !== 1)
      return array('0' , '0', ""); //prva nula oznacava da user ne postoji ili ih ima vise sa istim nizom

    $row = $st->fetch();

      try
      {
        $db = DB::getConnection();
        $st = $db->prepare( 'UPDATE users SET reg = 1 WHERE reg_string = :reg_string' );
        $st->execute(array('reg_string' => $reg_string));
      }
      catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }


      return array( '1', $row['id'], $row['username']);

  }
};


 ?>
