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
						case 'account':
							require  $link . 'Controller.php';
						break;
						
						case 'admin':
							require  $link . 'Controller.php';
						break;

						case 'contact':
							require  $link . 'Controller.php';
						break;

						case 'crud':
							require  $link . 'Controller.php';
						break;

						case 'post':
							require  $link . 'Controller.php';
						break;

						case 'registration':
							require  $link . 'Controller.php';
						break;

						case 'signin':
							require  $link . 'Controller.php';
						break;

						case 'signout':
							require  $link . 'Controller.php';
						break;

						case 'warning':
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

	/*
	//Liens vers les pages du menu

	function registrationLink()
	{
		require('view/frontend/registrationView.php');
	}
	function signinLink()
	{
		require('view/frontend/signInView.php');
	}
	function contactLink()
	{
		require('view/frontend/contactView.php');
	}
	function newPasswordLink()
	{
		require('view/frontend/newPasswordView.php');
	}
	function changePasswordLink()
	{
		require('view/frontend/changePasswordView.php');
	}
	function signoutLink()
	{
		require('view/frontend/signOutView.php');
	}
	function confirmLink()
	{
		require('view/frontend/confirmedRegistrationView.php');
	}
	*/