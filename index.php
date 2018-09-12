<?php
	require ('controller/controller.php');

	try
	{
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
		elseif (isset($_GET['pseudo']) AND $_GET['pseudo']!='')
		{
			checkPseudo();
		}
		else
		{
			listPosts();
		}
	}
	catch(Exception $e)
	{
    	$errorMessage =  $e->getMessage();

    	require ('view/frontend/errorView.php');
	}