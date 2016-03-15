
<?php drupal_add_css(path_to_theme() . 'css/login.css') ?> 

<div class="container">
    <div class="row">
        <?php print ($messages) ?>
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Login</h1>
            <div class="account-wall">
                <form class="form-signin" action="/user/login" method="post" id="user-login--2" accept-charset="UTF-8">
                    <input type="text" class="form-control" class="form-text required" placeholder="User name" name="name">
                    </br>
                    <input type="password" class="form-control" class="form-text required" placeholder="Password" name="pass"></br>                
                    <?php print drupal_render(drupal_get_form('user_login')['form_id']) ?>
                    <?php print drupal_render(drupal_get_form('user_login')['form_build_id']) ?>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="op">
                        Sign in</button>
                </form>
            </div><br>
            <a href="<?php print $GLOBALS['base_url'] ?>" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take me home</a>
        </div>
    </div>
</div>