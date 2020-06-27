<h1>Users</h1>
<?php
$link = Route::instance()->generate('user.edit', ['token' => md5('my.token')]);
?>
<a href="<?= $link ?>">User edit</a>
<div>TOKEN FROM URL : <?= $token ?></div>
