<?php session_start(); ?>

<?php $title = 'Inscription finalisée'; ?>

<?php ob_start(); ?>

<h1>Inscription finalisée</h1>

<p>Félicitation !<br/>
Votre inscription est désormais finalisée. Vous pouvez dès à présent vous <a href="index.php?link=connexion">connecter</a> ;)</p>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>