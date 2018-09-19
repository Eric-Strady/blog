<?php

	require_once('model/PostsManager.php');
	require_once('model/CommentsManager.php');
	require_once('model/UsersManager.php');
	require_once('model/AdminManager.php');
	require_once('model/WarningManager.php');

	use \Eric\Blog\Model\Posts\PostsManager;
	use \Eric\Blog\Model\Comments\CommentsManager;
	use \Eric\Blog\Model\Users\UsersManager;
	use \Eric\Blog\Model\Admin\AdminManager;
	use \Eric\Blog\Model\Warning\WarningManager;

//FRONTEND :

	//Affichage des posts + pagination pour listPostsView
	function listPosts()
	{
		$count = new PostsManager();
		$postManager = new PostsManager();

		$max_nb_post = 5;
		$req = $count->countPosts();
		$total_post = $req->fetch();
		$req->closeCursor();
		$nb_post = $total_post['nb_post'];
		$nb_page = ceil($nb_post/$max_nb_post);

		if (isset($_GET['page']))
		{
			strip_tags($_GET['page']);
			$_GET['page'] = (int)$_GET['page'];
			$current_page = $_GET['page'];
			if ($current_page == 0)
			{
				$current_page = 1;
			}
			elseif ($current_page > $nb_page)
			{
				$current_page = $nb_page;
			}
		}
		else
		{
			$current_page = 1;
		}

		$first_post = ($current_page-1)*$max_nb_post;

		$req = $postManager->getPosts($first_post, $max_nb_post);

		require('view/frontend/listPostsView.php');
	}

	//Liens vers les pages du menu

	function registrationLink()
	{
		require('view/frontend/registrationView.php');
	}
	function signinLink()
	{
		require('view/frontend/signInView.php');
	}
	function newPasswordLink()
	{
		require('view/frontend/newPasswordView.php');
	}
	function signoutLink()
	{
		require('view/frontend/signOutView.php');
	}

	//Affichage du post selectionné et de ses commentaires + ajout de commentaire + modification de commentaire
	function post($postId)
	{
		$postsManager = new PostsManager();
		$commentsManager = new CommentsManager();

		$post = $postsManager->getPost($postId);

		if (!empty($postId))
		{
			$comments = $commentsManager->getComments($postId);
			require('view/frontend/postView.php');
		}
		else
		{
			throw new Exception('Le billet auquel vous souhaitez accéder n\'existe pas !');
		}
	}

	function insertComment($postId, $pseudo, $comment)
	{
		$commentsManager = new CommentsManager();
		$commentsManager->addComment($postId, $pseudo, $comment);
	}

	function reComment($comment, $commentId, $id_post)
	{
		$commentsManager = new CommentsManager();
		$commentsManager->updateComment($comment, $commentId, $id_post);
	}

	//Vérifications pour l'insciption d'un utilisateur + inscription
	function verifyPseudo($pseudo)
	{
		$verifyPseudo = new UsersManager();
		$avaiblePseudo = $verifyPseudo->checkPseudo($pseudo);

		return $avaiblePseudo;
	}

	function verifyEmail($email)
	{
		$verifyEmail = new UsersManager();
		$avaibleEmail = $verifyEmail->checkEmail($email);

		return $avaibleEmail;
	}

	function registration($pseudo, $pass_hash, $email)
	{
		$registration = new UsersManager();
		$registration->addMembers($pseudo, $pass_hash, $email);
	}

	//Vérifications pour la connexion d'un utilisateur + envoi nouveau mot de passe
	function verifyConnect($id_connect)
	{
		$verifyConnect = new UsersManager();
		$verifyId = $verifyConnect->checkConnect($id_connect);

		return $verifyId;
	}

	function sendNewPassword($email)
	{

		$to = 'strady60@gmail.com';
		$subject = 'Test d\'envoi d\'e-mail';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Réinitialisation de votre mot de passe</h3>
						<p>Vous êtes actuellement sur le point de changer votre mot de passe !<br/>
						Voici votre nouveau mot de passe : ...</p>
						<p>Votre prochaine étape est de vous connecter avec ce nouveau mot de passe et ensuite, si vous le désirez (conseillé), le personnaliser dans votre page "Profil".</p>
						<p>Accéder au <a href="127.0.0.1/blog/index.php?link=connexion" target="_blank">blog de Jean Forteroche</a></p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Blog de Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Blog de Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		signinLink();
	}

//BACKEND :

	//Affichage liste des posts + pagination pour adminView.php
	function listPostsAdmin()
	{
		$count = new PostsManager();
		$postManager = new PostsManager();

		$max_nb_post = 5;
		$req = $count->countPosts();
		$total_post = $req->fetch();
		$req->closeCursor();
		$nb_post = $total_post['nb_post'];
		$nb_page = ceil($nb_post/$max_nb_post);

		if (isset($_GET['show']))
		{
			strip_tags($_GET['show']);
			$_GET['show'] = (int)$_GET['show'];
			$current_page = $_GET['show'];
			if ($current_page == 0)
			{
				$current_page = 1;
			}
			elseif ($current_page > $nb_page)
			{
				$current_page = $nb_page;
			}
		}
		else
		{
			$current_page = 1;
		}

		$first_post = ($current_page-1)*$max_nb_post;

		$req = $postManager->getPosts($first_post, $max_nb_post);

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/adminView.php');
	}

	//Lien vers la création d'un post + insertion d'un post
	function newPost()
	{
		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/addPostView.php');
	}

	function addPost($title, $content)
	{
		$adminManager = new AdminManager();
		$adminManager->createPost($title, $content);
	}

	//Affichage d'un post + modification d'un post
	function readPost($postId)
	{
		$postsManager = new PostsManager();
		$post = $postsManager->getPost($postId);

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/updatePostView.php');
	}

	function rePost($title, $content, $id)
	{
		$adminManager = new AdminManager();
		$adminManager->updatePost($title, $content, $id);
	}

	//Affichage du formulaire de suppression + suppression d'un post
	function deleteForm()
	{
		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/deletePostView.php');
	}

	function erasePost($id)
	{
		$adminManager = new AdminManager();
		$adminManager->deletePost($id);
	}

	//Commentaires signalés
	function addWarnedComments($id)
	{
		$commentsManager = new CommentsManager();
		$warningManager = new WarningManager();

		$careComment = $commentsManager->getComment($id);
		$warnedComment = $careComment->fetch();

		$warningManager->insertWarnedComment($warnedComment['id'], $warnedComment['author'], $warnedComment['comment'], $warnedComment['id_post']);
	}

	function verifyWarning($id)
	{
		$warningManager = new WarningManager();
		$verifyWarning = $warningManager->checkWarning($id);

		return $verifyWarning;
	}

	function listWarnedComments()
	{
		$warningManager = new WarningManager();
		$listWarnedComments = $warningManager->getWarningComments();

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/warningCommentsView.php');
	}

	function eraseWarnedComment($id_comment, $id)
	{
		$commentsManager = new CommentsManager();
		$warningManager = new WarningManager();

		$commentsManager->deleteComment($id_comment);
		$warningManager->deleteWarning($id);

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();
	}

	function justDeleteWarning($id)
	{
		$warningManager = new WarningManager();
		$warningManager->deleteWarning($id);

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();
	}