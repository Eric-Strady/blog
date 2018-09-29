<?php $titre = 'Blog de Jean Forteroche'; ?>

<?php ob_start() ?>

<?= $errorMessage ?>

<?php $contenu = ob_get_clean(); ?>

<?php require 'view/frontend/template.php'; ?>