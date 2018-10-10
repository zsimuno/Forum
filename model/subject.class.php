<?php

class Subject
{
	protected $id, $username, $title, $post, $upvotes, $downvotes, $post_date;

	function __construct( $id, $username, $title, $post, $upvotes, $downvotes, $post_date )
	{
		$this->id = $id;
    $this->username = $username;
    $this->title = $title;
    $this->post = $post;
    $this->upvotes = $upvotes;
    $this->downvotes = $downvotes;
    $this->post_date = $post_date;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
?>
