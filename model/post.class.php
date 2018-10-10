<?php

class Post
{
	protected $id, $username, $id_subject, $post, $upvotes, $downvotes, $post_date;

	function __construct( $id, $username, $id_subject, $post, $upvotes, $downvotes, $post_date )
	{
		$this->id = $id;
		$this->username = $username;
    $this->id_subject = $id_subject;
    $this->post = $post;
    $this->upvotes = $upvotes;
    $this->downvotes = $downvotes;
    $this->post_date = $post_date;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
