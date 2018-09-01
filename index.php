<?php
	require ('controller/controller.php');

	if (isset($_GET['post']) AND $_GET['post']!= '')
	{
		post();
	}
	elseif (isset($_POST['pseudo']) AND isset($_POST['comment']))
	{
		if ($_POST['pseudo']!='' AND $_POST['comment']!='')
		{
			insertComment();
		}
	}
	else
	{
		listPosts();
	}