<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php print $head; ?>
        <title><?php print $head_title; ?></title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
        <?php print $styles; ?>

    </head>

    <body id="page-top">
        <?php if ($page_top): ?> 
            <?php //print render($page_top); ?>
        <?php endif; ?>
        <?php print render($page); ?>
        <?php print render($page_bottom) ?>
        <?php print $scripts; ?>
    </body>
</html>