<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<aside class="bg-dark">
    <div class="container text-center">
        <div class="call-to-action">
<?php foreach ($rows as $row): ?>
                <h2><?php print $row['title'] ?></h2>
                <a href="<?php print $row['field_url'] ?>" class="btn btn-default btn-xl wow tada"><?php print $row['field_button_content'] ?></a>
<?php endforeach; ?>
        </div>
    </div>
</aside>