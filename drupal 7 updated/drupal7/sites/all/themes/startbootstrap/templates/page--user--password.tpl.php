<?php drupal_add_css(path_to_theme() . 'css/login.css') ?> 
<div class="container">
    <div class="row">
        <?php print ($messages) ?>
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Forgot password</h1>
            <div class="account-wall">
                <form class="form-signin" action="/user/password" method="post" id="user-pass--2" accept-charset="UTF-8">
                    <label>Username or E-mail address:</label>
                    <input type="text" class="form-control" class="form-text required"  name="name"></br>
                    <?php print drupal_render(drupal_get_form('user_pass')['form_build_id']) ?>
                    <?php print drupal_render(drupal_get_form('user_pass')['form_id']) ?>
                    <button id="edit-submit--3" class="btn btn-lg btn-primary btn-block" type="submit" value="E-mail new password" name="op">
                        E-mail new password</button>

                </form>
                <a href="<?php print $GLOBALS['base_url'] ?>" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take me home</a>
            </div>
        </div>
    </div>
</div>