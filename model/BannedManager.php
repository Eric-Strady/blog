<?php
	namespace Eric\Blog\Model\Banned;
	require_once("model/Manager.php");

	class BannedManager extends \Eric\Blog\Model\Manager
	{
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
	}