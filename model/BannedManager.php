<?php
	namespace Eric\Blog\Model\Banned;
	require_once("model/Manager.php");

	class BannedManager extends \Eric\Blog\Model\Manager
	{
		public function checkBanned(Banned $banned)
		{
			$req = $this->_db->prepare('SELECT COUNT(*) FROM banned WHERE email = :email ');
			$req->execute(array('email' => $banned->getEmail()));
			
			return (bool) $req->fetchcolumn();
		}

		public function addBanned(Banned $banned)
		{
			$req = $this->_db->prepare('INSERT INTO banned(email, reasons, banned_date) VALUES(:email, :reasons , NOW())');
			$req->execute(array('email' => $banned->getEmail(), 'reasons' => $banned->getReasons()));
		}

		/*
		public function addBanned($pseudo, $email, $reasons)
		{
			$addBanned = $this->getDB()->prepare('INSERT INTO banned(pseudo, email, reasons, suppression_date) VALUES( :pseudo, :email, :reasons , NOW())');
			$addBanned->execute(array('pseudo' => $pseudo, 'email' => $email, 'reasons' => $reasons));
		}

		public function checkBanned($email)
		{
			$checkBanned= $this->getDB()->prepare('SELECT email FROM banned WHERE email = :email');
			$checkBanned->execute(array('email' => $email));
			$isBanned = $checkBanned->fetch();

			return $isBanned;
		}
		*/
	}