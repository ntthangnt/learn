<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section class="bg-primary" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
<?php foreach ($rows as $row): ?>
                    <h2 class="section-heading"><?php print $row['title'] ?>!</h2>
                    <hr class="light">
                    <p class="text-faded"><?php print $row['body'] ?></p>
<?php endforeach; ?>
                <a href="#" class="btn btn-default btn-xl">Get Started!</a>
            </div>
        </div>
    </div>
</section>