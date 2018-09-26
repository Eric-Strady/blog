<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<div class="row">
	<?php
		while ($data = $req->fetch())
		{
	?>
		    <div class="col-lg-4 col-sm-6 portfolio-item">
		      	<div class="card h-100">
		        	<a href="#"><img class="card-img-top" src="public/images/header.jpg" alt="En-tête billet"></a>
		        	<div class="card-body">
		      			<h4 class="card-title">
		        			<a href="#"><?= strip_tags($data['title']) ?></a>
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

	echo '<p>Page: ';
	for ($i = 1; $i <= $nb_page; $i++)
	{
		echo '<a href="index.php?page=' . $i . '">' . $i . '</a> > ';
	}
	echo '</p>';
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>