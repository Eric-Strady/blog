<?php
	namespace Eric\Blog\Model\Users;
	require_once("model/Manager.php");

	class UsersManager extends \Eric\Blog\Model\Manager
	{
		public function checkPseudo($pseudo)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT pseudo FROM users WHERE pseudo = :pseudo ');
			$req->execute(array('pseudo' => $pseudo));
			$checkPseudo = $req->fetch();

			return $checkPseudo;
		}

		public function checkEmail($email)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT email FROM users WHERE email = :email ');
			$req->execute(array('email' => $email));
			$checkEmail = $req->fetch();

			return $checkEmail;
		}

		public function addMembers($pseudo, $pass_hash, $email)
		{
			$db = $this->dbConnect();

			$addMembers = $db->prepare('INSERT INTO users( pseudo, password, email, registration_date) VALUES (:pseudo, :password, :email, NOW())');
			$addMembers->execute(array('pseudo' => $pseudo, 'password' => $pass_hash, 'email' => $email));
		}

		public function checkConnect($id_connect)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT id, pseudo, password FROM users WHERE pseudo = :pseudo OR email = :email');
			$req->execute(array('pseudo' => $id_connect, 'email' => $id_connect));
			$checkConnect = $req->fetch();

			return $checkConnect;
		}
	}