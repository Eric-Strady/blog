<?php
	namespace Eric\Blog\Model;
	require_once("model/Manager.php");

	class UsersManager extends Manager
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
	}