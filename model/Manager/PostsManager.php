<?php
	namespace Eric\Blog\Model\Manager\Posts;
	require_once("model/Manager/Manager.php");
    use \Eric\Blog\Model\Posts\Post;

	class PostsManager extends \Eric\Blog\Model\Manager\Manager
	{
		public function count()
  		{
    		$req = $this->_db->query('SELECT COUNT(*) FROM posts');
    		return $req->fetchColumn();
  		}

        public function listPosts($first_post, $max_nb_post)
        {
            $posts = [];
            $req = $this->_db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr, image_description, image_extension FROM posts ORDER BY id DESC LIMIT ' . $first_post . ', ' . $max_nb_post);
            
            while ($data = $req->fetch(\PDO::FETCH_ASSOC))
            {
                $posts[] = new Post($data);
            }
            
            return $posts;
        }

        public function isExist($infos)
        {
        	$req = $this->_db->prepare('SELECT COUNT(*) FROM posts WHERE id = :infos');
			$req->execute(array('infos' => $infos));
			
			return (bool) $req->fetchcolumn();
        }
        
        public function findPost(Post $post)
        {          
            $req = $this->_db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr, image_description, image_extension FROM posts WHERE id = :id');
            $req->execute(array('id' => $post->getId()));
            
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            return new Post($data);
        }

        public function addPost(Post $post)
        {
            $req = $this->_db->prepare('INSERT INTO posts(title, content, creation_date, image_description, image_extension) VALUES( :title, :content , NOW(), :description, :extension)');
			$req->execute(array(
				'title' => $post->getTitle(),
				'content' => $post->getContent(),
				'description' => $post->getImgDesc(),
				'extension' => $post->getImgExt()
			));
            
            $post->hydrate([
                'id' => $this->_db->lastInsertId()
            ]);
        }

        public function updateImage(Post $post)
        {
            $req = $this->_db->prepare('UPDATE posts SET image_description = :description, image_extension = :extension WHERE id = :id');
			$req->execute(array(
				'description' => $post->getImgDesc(),
				'extension' => $post->getImgExt(),
				'id' => $post->getId()
			));
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

        public function deletePost(Post $post)
        {
        	$req = $this->_db->prepare('DELETE FROM posts WHERE id = :id');
			$req->execute(array('id' => $post->getId()));
        }
	}