<?php

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