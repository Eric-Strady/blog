<?php

	require_once('model/Warning.php');
	require_once('model/WarningManager.php');

	use \Eric\Blog\Model\Warning\Warning;
	use \Eric\Blog\Model\Warning\WarningManager;

												//DEFINE ACTION

	if (isset($_GET['action']) AND !empty($_GET['action']))
	{
		$action = strip_tags($_GET['action']);
		switch ($action)
		{
			case '#':
				
			break;

			default:
				throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			break;
		}
	}
	else
	{
		require 'view/backend/warningCommentsView.php';
	}

												//FUNCTIONS
