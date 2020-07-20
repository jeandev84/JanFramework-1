<?php if(! empty($link)) : ?>
    <a href="<?= $link ?>"><?= $title ?></a>
<?php else: ?>
    <span style="color: #bbb;"><?= $title ?></span>
<?php endif; ?>
