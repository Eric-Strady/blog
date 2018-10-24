<?php

	session_start();

	class Router
	{
		public function loadCtrl()
		{
			try
			{
				if (isset($_GET['link']) AND !empty($_GET['link']))
				{
					$link = strip_tags($_GET['link']);
					switch ($link)
					{
						case 'account';
						case 'admin';
						case 'contact';
						case 'crud';
						case 'moderate';
						case 'post';
						case 'registration';
						case 'signin';
						case 'signout';
						case 'warning';
							require  $link . 'Controller.php';
						break;

						default:
							throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
						break;
					}
				}
				else
				{
					require 'homeController.php';
				}
			}
			catch(Exception $e)
			{
		    	$errorMessage =  $e->getMessage();

		    	require ('view/frontend/errorView.php');
			}
		}
	}