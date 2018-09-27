<?php session_start(); ?>

<?php $title = 'Interface d\'administration'; ?>

<?php ob_start(); ?>
<div class="container">
	<?php
		if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	 	{
	?>
			<div class="row">
				<?php
					while ($data = $req->fetch())
					{
				?>
					    <div class="col-lg-4 col-sm-6 portfolio-item">
					      	<div class="card mt-4">
					        	<a href="index.php?read=<?= $data['id'] ?>"><img class="card-img-top" src="public/images/header.jpg" alt="En-tête billet"/></a>
					        	<div class="card-body">
					      			<h4 class="card-title">
					        			<a href="index.php?read=<?= $data['id'] ?>"><?= strip_tags($data['title']) ?></a>
					      			</h4>
					      			<em> le <?= $data['creation_date_fr'] ?></em>
					      			<em><a href="index.php?read=<?= $data['id'] ?>">Lire</a></em>
					     			- <em><a href="index.php?update=<?= $data['id'] ?>">Mettre à jour</a></em>
					     			- <em><a href="index.php?delete=<?= $data['id'] ?>">Supprimer</a></em></p>
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
				echo '<p>Page: ';
				for ($i = 1; $i <= $nb_page; $i++)
				{
					echo '<a href="index.php?show=' . $i . '">' . $i . '</a> > ';
				}
				echo '</p>';
			?>
	<?php
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
		}
	?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>