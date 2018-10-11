<?php session_start(); ?>

<?php $title = 'Interface d\'administration'; ?>

<?php ob_start(); ?>

	<?php
		if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	 	{
	?>
			<div class="container">
				<div id="transparency">
					<div class="row">
						<?php
							while ($data = $req->fetch())
							{
						?>
							    <div class="col-lg-4 col-sm-6 portfolio-item">
							      	<div class="card mb-4">
							        	<a href="index.php?read=<?= $data['id'] ?>"><img class="card-img-top" src="public/images/cover/<?= $data['id'] ?>.<?= $data['image_extension'] ?>" alt="<?= $data['image_description'] ?>"/></a>
							        	<div class="card-body">
							      			<h4 class="card-title" id="post-title">
							        			<a href="index.php?read=<?= $data['id'] ?>" title="Page du billet"><?= strip_tags($data['title']) ?></a>
							      			</h4>
							      			<em> le <?= $data['creation_date_fr'] ?></em>
							      			<em><a href="index.php?read=<?= $data['id'] ?>" title="Lecture du billet">Lire</a></em>
							     			- <em><a href="index.php?update=<?= $data['id'] ?>" title="Modification du billet">Mettre à jour</a></em>
							     			- <em><a href="index.php?delete=<?= $data['id'] ?>&amp;pic=<?= $data['image_extension'] ?>" title="Suppression du billet">Supprimer</a></em></p>
							      			<p class="card-text"><?= substr($data['content'], 0, 45) . '...' ?></p>
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
									echo '<li class="page-item"><a class="page-link" href="index.php?show=' . $i . '" title="Liens vers la page ' . $i . '">' . $i . '</a></li>';
								}
							?>
						</ul>
					</nav>
				</div>
			</div>

	<?php
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
		}
	?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>