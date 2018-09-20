<?php session_start(); ?>

<?php $title = 'Profil Administrateur'; ?>

<?php ob_start(); ?>

<h1>Profil Administrateur</h1>

<p><?= $_SESSION['pseudo'] ?></p>

<img src="public/images/univers.jpg" alt="Avatar" title="Avatar <?= $_SESSION['pseudo'] ?>" height="200" width="300">

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>