<?php

	require_once('model/PostsManager.php');
	require_once('model/CommentsManager.php');
	require_once('model/UsersManager.php');
	require_once('model/AdminManager.php');
	require_once('model/WarningManager.php');
	require_once('model/BannedManager.php');

	use \Eric\Blog\Model\Posts\PostsManager;
	use \Eric\Blog\Model\Comments\CommentsManager;
	use \Eric\Blog\Model\Users\UsersManager;
	use \Eric\Blog\Model\Admin\AdminManager;
	use \Eric\Blog\Model\Warning\WarningManager;
	use \Eric\Blog\Model\Banned\BannedManager;

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
	function confirmLink()
	{
		require('view/frontend/confirmedRegistrationView.php');
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

	//Vérifications pour l'insciption d'un utilisateur + inscription et confirmation par e-mail
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

		$length = 10;
		$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$maxLength = strlen($string);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
		$randomString.= $string[rand(0, $maxLength - 1)];
		}
		$registration_key = $randomString;

		$to = $email;
		$subject = 'Confirmation d\'inscription';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Bienvenue parmi les membres du blog de Jean Forteroche !</h3>
						<p>Pour pouvoir vous connecter, merci de bien vouloir finaliser votre inscription en cliquant sur le lien ci-dessous:</p>
						<p><a href="127.0.0.1/blog/index.php?key=' . $registration_key . '" target="_blank">Confirmer mon inscription</a></p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		$confirm = 0;
		$registration->addUser($pseudo, $pass_hash, $email, $registration_key, $confirm);
	}

	//Vérifications pour la connexion d'un utilisateur + envoi nouveau mot de passe
	function verifyConnect($id_connect)
	{
		$verifyConnect = new UsersManager();
		$verifyId = $verifyConnect->checkConnect($id_connect);

		return $verifyId;
	}

	function verifyRegistrationKey($registration_key)
	{
		$verifyRegistrationKey = new UsersManager();
		$isKeyExist = $verifyRegistrationKey->checkRegistrationKey($registration_key);

		return $isKeyExist;
	}

	function changeConfirm($registration_key)
	{
		$changeConfirm = new UsersManager();
		$changeConfirm->updateConfirm($registration_key);
	}

	function verifyConfirm($id_connect)
	{
		$verifyConfirm = new UsersManager();
		$isConfirm = $verifyConfirm->checkConfirm($id_connect);

		return $isConfirm;
	}

	function sendNewPassword($email)
	{
		$usersManager = new UsersManager();

		$length = 10;
		$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$maxLength = strlen($string);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
		$randomString.= $string[rand(0, $maxLength - 1)];
		}

		$newPassword = $randomString;

		$to = 'strady60@gmail.com';
		$subject = 'Réinitialisation du mot de passe';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Réinitialisation de votre mot de passe</h3>
						<p>Vous êtes actuellement sur le point de changer votre mot de passe !<br/>
						Voici votre nouveau mot de passe : ' . $newPassword . '</p>
						<p>Pour des raisons de sécurité, il est impératif que vous changiez ce mot de passe lors de votre prochaine connexion.<br/>
						Pour le personnaliser, allez dans votre page "Profil".</p>
						<p>Accéder au <a href="127.0.0.1/blog/index.php?link=connexion" target="_blank">blog de Jean Forteroche</a></p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		$password = password_hash($newPassword, PASSWORD_DEFAULT);
		$usersManager->forgottenPassword($password, $email);

		signinLink();
	}

	//Lien vers la page du profil administrateur + paramétrage du profil
	function confirmDeleteAccount($id)
	{
		$confirmDeleteAccount = new UsersManager();
		$confirmDeleteAccount->deleteAccount($id);
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

	//Lien vers la page du profil administrateur + paramétrage du profil
	function adminAccountLink()
	{
		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/adminAccountView.php');
	}

	function newPseudo($new_pseudo, $pseudo)
	{
		$newPseudo = new AdminManager();
		$newPseudo->changePseudo($new_pseudo, $pseudo);
	}

	function newEmail($new_email, $pseudo)
	{
		$newEmail = new AdminManager();

		$to = 'strady60@gmail.com';
		$subject = 'Changement d\'adresse e-mail';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Un petit pas pour l\'homme mais un grand pas pour le numérique !</h3>
						<p>Bravo ! La modification de votre adresse e-mail a bien été prise en compte.</p>
						<p>Lors de votre prochaine connexion vous pourrez renseigner cette adresse e-mail comme identifiant ;)</p>
						<p>A bientôt sur le <a href="127.0.0.1/blog/index.php?link=connexion" target="_blank">blog de Jean Forteroche</a></p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		$newEmail->changeEmail($new_email, $pseudo);
	}

	function newPassword($pass_hash, $pseudo)
	{
		$newPassword = new AdminManager();
		$newPassword->changePassword($pass_hash, $pseudo);
	}

	function selectEmail($pseudo)
	{
		$selectEmail = new AdminManager();
		$user_email = $selectEmail->getEmail($pseudo);

		return $user_email;
	}

	function bannedUser($pseudo, $email, $reasons)
	{
		$bannedUser = new BannedManager();
		$deleteUser = new AdminManager();

		$bannedUser->addBanned($pseudo, $email, $reasons);

		$to = 'strady60@gmail.com';
		$subject = 'Suppression de votre compte utilisateur';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Suppression de votre compte !</h3>
						<p>Bonjour,<br/>
						Votre compte utilisateur sur le blog de Jean Forteroche a fait l\'objet d\'une suppression par l\'administrateur.</p>
						<p>En voici les raisons:<br/>
						"' . $reasons . '"</p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		$deleteUser->deleteUser($pseudo);
	}