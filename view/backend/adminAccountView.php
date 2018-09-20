<?php session_start(); ?>

<?php $title = 'Profil Administrateur'; ?>

<?php ob_start(); ?>



<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>