<?php

class PostController extends BaseController
{

	public function index()
	{
		$ls = new ForumService();

    if (isset($_GET['id']) && preg_match('/^[0-9]+$/', $_GET['id'])) //provjerit da je dobrog oblika
    {
      $id = $_GET['id'];
    }
    else {
      header('Location: ' . __SITE_URL . '/forum.php?rt=subjects' );
			exit();
    }

		// Popuni template potrebnim podacima
    $this->registry->template->subject = $ls->getSubjectById($id);
		$this->registry->template->postList = $ls->getPostBySubjectId($id);

    $this->registry->template->show( 'post_index' );
	}

	function upvotePost()
	{
		if (isset($_GET['id']) && preg_match('/^[0-9]+$/', $_GET['id'])) //provjerit da je dobrog oblika
    {
      $id = $_GET['id'];
    }
    else {
      header('Location: ' . __SITE_URL . '/forum.php?rt=subjects' );
			exit();
    }

		$ls = new ForumService();

		$idSubject = $ls->upvotePost($id);

		// Popuni template potrebnim podacima
    $this->registry->template->subject = $ls->getSubjectById($idSubject);
		$this->registry->template->postList = $ls->getPostBySubjectId($idSubject);

    $this->registry->template->show( 'post_index' );
	}

	function downvotePost()
	{
		if (isset($_GET['id']) && preg_match('/^[0-9]+$/', $_GET['id'])) //provjerit da je dobrog oblika
    {
      $id = $_GET['id'];
    }
    else {
      header('Location: ' . __SITE_URL . '/forum.php?rt=subjects' );
			exit();
    }

		$ls = new ForumService();

		$idSubject = $ls->downvotePost($id);

		// Popuni template potrebnim podacima
    $this->registry->template->subject = $ls->getSubjectById($idSubject);
		$this->registry->template->postList = $ls->getPostBySubjectId($idSubject);

    $this->registry->template->show( 'post_index' );
	}

	function upvoteSubject()
	{
		if (isset($_GET['id']) && preg_match('/^[0-9]+$/', $_GET['id'])) //provjerit da je dobrog oblika
    {
      $id = $_GET['id'];
    }
    else {
      header('Location: ' . __SITE_URL . '/forum.php?rt=subjects' );
			exit();
    }

		$ls = new ForumService();

		$ls->upvoteSubject($id);

		// Popuni template potrebnim podacima
    $this->registry->template->subject = $ls->getSubjectById($id);
		$this->registry->template->postList = $ls->getPostBySubjectId($id);

    $this->registry->template->show( 'post_index' );
	}

	function downvoteSubject()
	{
		if (isset($_GET['id']) && preg_match('/^[0-9]+$/', $_GET['id'])) //provjerit da je dobrog oblika
    {
      $id = $_GET['id'];
    }
    else {
      header('Location: ' . __SITE_URL . '/forum.php?rt=subjects' );
			exit();
    }

		$ls = new ForumService();

		$ls->downvoteSubject($id);

		// Popuni template potrebnim podacima
    $this->registry->template->subject = $ls->getSubjectById($id);
		$this->registry->template->postList = $ls->getPostBySubjectId($id);

    $this->registry->template->show( 'post_index' );
	}

	function newPost()
  {
    if (isset($_GET['id']) && preg_match('/^[0-9]+$/', $_GET['id'])) //provjerit da je dobrog oblika
    {
      $id = $_GET['id'];
    }
    else {
      header('location: '.__SITE_URL.'/forum.php');
			exit();
    }

    $fs = new ForumService();

    if(isset($_POST['post']) && !empty($_POST['post']))
      $fs->addNewPost( $_SESSION['user']['username'], $id, $_POST['post'], date("Y-m-d H:i:s"));

    header('location: '.__SITE_URL.'/forum.php?rt=post&id='.$id);
  }

};

?>
