<?php
	namespace Eric\Blog\Model;

	class Manager
	{
		protected $_db;

		public function __CONSTRUCT()
		{
			$this->_db = new \PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
		}
	}