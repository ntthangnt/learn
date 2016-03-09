<?php global $user ?>
<?php drupal_add_css(path_to_theme() . 'css/404.css') ?> 
<?php $site_frontpage = variable_get('site_frontpage', '') ?>
<br><br>
<div class="container-fluid well span6">
    <div class="row-fluid">
        <div class="span8">
            <h3>Hi <?php print $title ?></h3>
            <h6>Email: <?php print $user->mail ?></h6>
            <a href="<?php print $GLOBALS['base_url'] ?>" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take me home</a>
        </div>
    </div>
</div>
