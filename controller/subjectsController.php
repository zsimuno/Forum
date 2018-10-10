<?php

class SubjectsController extends BaseController
{
	public function index()
	{
		$ls = new ForumService();

		// Popuni template potrebnim podacima
		$this->registry->template->subjectList = $ls->getAllSubjects();

    $this->registry->template->show( 'subjects_index' );
	}

	function upvote()
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
		$this->registry->template->subjectList = $ls->getAllSubjects();

    $this->registry->template->show( 'subjects_index' );
	}

	function downvote()
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
		$this->registry->template->subjectList = $ls->getAllSubjects();

    $this->registry->template->show( 'subjects_index' );
	}

	function newSubject()
  {
    $fs = new ForumService();

    if(isset($_POST['title']) && isset($_POST['post'])
       && !empty($_POST['title']) && !empty($_POST['post']))
			 {
    			$fs->addNewSubject($_SESSION['user']['username'], $_POST['title'], $_POST['post'], date("Y-m-d H:i:s"));
			 }

    header( 'Location: ' . __SITE_URL . '/forum.php' );
  }
};

?>
