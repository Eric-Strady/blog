<?php
	require_once ('model.php');

	if (isset($_POST['pseudo']) AND isset($_POST['comment']))
	{
		if ($_POST['pseudo']!='' AND $_POST['comment']!='')
		{
			addComment($_POST['postId'], $_POST['pseudo'], $_POST['comment']);

		}
	}

	require_once ('comments.php');