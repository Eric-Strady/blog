<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>
<div class="container">
	<div id="transparency">
		<div class="row">
			<?php
				while ($data = $req->fetch())
				{
			?>
				    <div class="col-lg-4 col-sm-6 portfolio-item">
				      	<div class="card mb-4">
				        	<a href="index.php?post=<?= $data['id'] ?>"><img class="card-img-top" src="public/images/header.jpg" alt="En-tête billet"/></a>
				        	<div class="card-body">
				      			<h4 class="card-title" id="post-title">
				        			<a href="index.php?post=<?= $data['id'] ?>"><?= strip_tags($data['title']) ?></a>
				      			</h4>
				      			<em> le <?= $data['creation_date_fr'] ?></em>
				      			<p class="card-text"><?= substr($data['content'], 0, 45) . '...' ?></p>
				      			<div class="card-footer">
				      				<a class="btn btn-primary" href="index.php?post=<?= $data['id'] ?>">Lire la suite</a>
				      			</div>
				        	</div>
				      	</div>
				    </div>
			<?php
				}
			?>
		</div>

		<?php
			$req->closeCursor();
		?>
		<nav id="pagination" class="mt-4">
			<ul class="pagination pagination-lg">
				<?php
					for ($i = 1; $i <= $nb_page; $i++)
					{
						echo '<li class="page-item"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a></li>';
					}
				?>
			</ul>
		</nav>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>