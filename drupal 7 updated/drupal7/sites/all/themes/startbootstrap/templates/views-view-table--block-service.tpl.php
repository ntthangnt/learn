<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">At Your Service</h2>
                <hr class="primary">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
<?php foreach ($rows as $row): ?>
                <?php $icon = 'fa fa-4x ' . $row['field_icon'] . ' wow bounceIn text-primary' ?>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="<?php print $icon ?>"></i>
                        <h3><?php print $row['title'] ?></h3>
                        <p class="text-muted"><?php print $row['body'] ?></p>
                    </div>
                </div> 
<?php endforeach; ?>
        </div>
    </div>
</section>