<?php
	require_once ('model.php');

	$post = getPost($_GET['post']);

	if (isset($_GET['post']) AND $_GET['post']!= '')
	{
		if (!empty($post))
		{
		$comments = getComments($_GET['post']);
		require ('comments.php');
		}
		else
		{
			echo '<h2>Erreur:</h2><p>Le billet auquel vous souhaitez accéder n\'existe pas !</p>';
		}
	}