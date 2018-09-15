<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<h2>Billet:</h2>
<h4><?= strip_tags($post['title']) ?></h4>
<em>le <?= $post['creation_date_fr'] ?></em>
<p><?= nl2br(strip_tags($post['content'])) ?></p>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>