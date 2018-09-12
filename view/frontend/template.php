<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php if (isset($script)){echo $script;} ?>
        <title><?= $title ?></title>
        
    </head>
        
    <body>
    	
    	<?php require('menu.php');?>

        <?= $content ?>

    </body>
</html>