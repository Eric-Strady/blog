<?php
	namespace Eric\Blog\Model\Posts;
	require_once("model/Manager.php");

	class PostsManager extends \Eric\Blog\Model\Manager
	{     
        public function listPosts()
        {
            $posts = [];
            $req = $this->_db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr FROM posts ORDER BY id DESC LIMIT 0, 6');
            
            while ($data = $req->fetch(\PDO::FETCH_ASSOC))
            {
                $posts[] = new Post($data);
            }
            
            return $posts;
        }
        
        public function findPost($id)
        {
            $id = (int) $id;
            
            $req = $this->_db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr FROM posts WHERE id =' .$id);
            
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            return new Post($data);
        }
        
        public function lastPost()
        {
            $req = $this->_db->query('SELECT MAX(id) AS last FROM posts');
            
            $data = $req->fetch(\PDO::FETCH_ASSOC);
			return new Post($data);
        }

        public function addPost(Post $post)
        {
            $req = $this->_db->prepare('INSERT INTO posts(title, content, creation_date, image_description, image_extension) VALUES( :title, :content , NOW(), :description, :extension)');
			$req->execute(array(
				'title' => $post->getTitle(),
				'content' => $post->getContent(),
				'description' => $post->getImage_description(),
				'extension' => $post->getImage_extension()
			));
            
            $post->hydrate([
                'id' => $this->_db->lastInsertId()
            ]);
        }
        
        public function updatePost(Post $post)
        {
            $req = $this->_db->prepare('UPDATE posts SET title = :title, content = :content, creation_date = NOW() WHERE id = :id');
			$req->execute(array(
				'title' => $post->getTitle(),
				'content' => $post->getContent(),
				'id' => $post->getId()
			));
        }
        
        public function updateImage(Post $post)
        {
            $req = $this->_db->prepare('UPDATE posts SET image_description = :description, image_extension = :extension WHERE id = :id');
			$req->execute(array(
				'description' => $post->getImage_description(),
				'extension' => $post->getImage_extension(),
				'id' => $post->getId()
			));
        }
        
        public function deletePost(Post $post)
        {
            $deletePost = $this->getDB()->prepare('DELETE FROM posts WHERE id =' . $post->getId());
        }

        /*
		public function countPosts()
		{
			$req = $this->getDb()->query('SELECT COUNT(*) AS nb_post FROM posts');

			return $req;
		}

		public function getPosts($first_post, $max_nb_post)
		{
			$req = $this->getDb()->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr, image_description, image_extension FROM posts ORDER BY id DESC LIMIT ' . $first_post . ', ' . $max_nb_post);

			return $req;
		}

		public function getPost($postId)
		{
			$req = $this->getDb()->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr, image_description, image_extension FROM posts WHERE id = :postId');
			$req->execute(array('postId' => $postId));
			if ($req->rowcount() == 1)
			{
				$post = $req->fetch();
				return $post;
			}
			else
			{
				throw new \Exception('Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}*/
	}