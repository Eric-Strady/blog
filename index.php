<?php
	require ('model.php');

	$req = getPosts($_GET['page']);

	require('listPostsView.php');