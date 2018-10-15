<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>
<div class="container">
	<div id="transparency">
		<div class="row">
			<?php
				foreach ($posts as $onePost)
				{
			?>
				    <div class="col-lg-4 col-sm-6 portfolio-item">
				      	<div class="card mb-4">
				        	<a href="index.php?link=post&amp;action=read&amp;id=<?= $onePost->getId() ?>"><img class="card-img-top" src="public/images/cover/<?= $onePost->getId() ?>.<?= $onePost->getImgExt() ?>" alt="<?= $onePost->getImgDesc() ?>"/></a>
				        	<div class="card-body">
				      			<h4 class="card-title" id="post-title">
				        			<a href="index.php?link=post&amp;action=read&amp;id=<?= $onePost->getId() ?>" title="Page du billet"><?= $onePost->getTitle() ?></a>
				      			</h4>
				      			<em> le <?= $onePost->getCreationDate() ?></em>
				      			<p class="card-text"><?= substr($onePost->getContent(), 0, 45) . '...' ?></p>
				      			<div class="card-footer">
				      				<a class="btn btn-dark" href="index.php?link=post&amp;action=read&amp;id=<?= $onePost->getId() ?>" title="Lecture du billet">Lire la suite</a>
				      			</div>
				        	</div>
				      	</div>
				    </div>
			<?php
				}
			?>
		</div>

		<nav id="pagination" class="mt-4">
			<ul class="pagination pagination-lg">
				<?php
					for ($i = 1; $i <= $nb_page; $i++)
					{
						echo '<li class="page-item"><a class="page-link" href="index.php?page=' . $i . '" title="Liens vers la page ' . $i . '">' . $i . '</a></li>';
					}
				?>
			</ul>
		</nav>
	</div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>