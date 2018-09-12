<?php
	namespace Eric\Blog\Model;
	require_once("model/Manager.php");

	class UsersManager extends Manager
	{
		public function verifyPseudo($pseudo)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT pseudo FROM users WHERE pseudo = :pseudo');
			$req->execute(array('pseudo' => $pseudo);
			$verifyPseudo = $req->fetch();

			return $verifyPseudo;
		}
	}