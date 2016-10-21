<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section id="contact">
    <div class="container">
        <div class="row">
<?php foreach ($rows as $row): ?>
    <?php
    $iconPhone = 'fa ' . $row['field_icon_phone'] . ' fa-3x wow bounceIn';
    $iconEmail = 'fa ' . $row['field_icon_email'] . ' fa-3x wow bounceIn';
    ?>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading"><?php print $row['title'] ?></h2>
                    <hr class="primary">
                    <p><?php print $row['body'] ?></p>
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="<?php print $iconPhone ?>"></i>
                    <p><?php print $row['field_phone'] ?></p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="<?php print $iconEmail ?>" data-wow-delay=".1s"></i>
                    <p><a href="mailto:your-email@your-domain.com"><?php print $row['field_email'] ?></a></p>
                </div>

<?php endforeach; ?>
        </div>
    </div>
</section>