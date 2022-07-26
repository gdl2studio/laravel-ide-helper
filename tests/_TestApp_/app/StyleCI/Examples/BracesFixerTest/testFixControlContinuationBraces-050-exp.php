<?php $arr = [true, false]; ?>
<?php foreach ($arr as $index => $item) {
    if ($item): ?>
    <?php echo $index; ?>
<?php endif;
} ?>