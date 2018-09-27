<?php session_start(); ?>

<?php $title = 'Blog de Jean Forteroche'; ?>

<?php ob_start(); ?>

<?php
	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
 	{
?>
		<h2>Création d'un billet:</h2>

		<form action="index.php" method="POST">
			<p><label for="add_title">Titre du billet:</label></p>
			<p><input type="text" name="add_title" id="add_title" maxlength="255" size="50" placeholder="Ex: Episode ..." required autofocus/></p>
			<p><label for="add_content">Contenu du billet:</label></p>
		    <p><textarea name="add_content" id="add_content" required>Vous pouvez effectuer diverses actions syntaxiques (mise en gras, alignement, etc) à l'aide de cet éditeur de texte.</textarea></p>
		    <input type="submit" value="Ajouter ce billet"/>
		</form>
<?php
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
	}
?>

<?php $content = ob_get_clean(); ?>

<?php require('view/backend/templateAdmin.php'); ?>