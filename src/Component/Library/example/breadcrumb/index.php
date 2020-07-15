<?php
use App\Library\BreadCrumb;

require __DIR__.'/vendor/autoload.php';

$breadCrumb = new BreadCrumb();
$breadCrumb->setTemplate(__DIR__.'/templates/views/widgets/breadcrumb.php');
$breadCrumb->add('Главная', 'site/index.php');
$breadCrumb->add('Новости', 'site/new.php');
$breadCrumb->add('Документы', 'site/document.php');
$breadCrumb->add('Контакты', 'site/contact.php');

?>

<div>
    <?= $breadCrumb->build(); ?>
</div>
