<?php

use \app\models\Permission;

?>

<h4><?= $title;?></h4>

<form id="form-user-update" method="post">

    <p>
        <label for="active">Active: </label>
        <?php if ($user['active'] == 1) : ?>
            <input name="active" type="checkbox" checked>
        <?php else : ?>
            <input name="active" type="checkbox">
        <?php endif; ?>
    </p>

    <p>
        <label for="blocked">Blocked: </label>
        <?php if ($user['blocked'] === true) : ?>
            <input name="blocked" type="checkbox" checked>
        <?php else : ?>
            <input name="blocked" type="checkbox">
        <?php endif; ?>
    </p>


    <p>
        <label for="name">Name: </label>
        <input name="name" type="text" value="<?= $user['name'];?>" required="required">
    </p>

    <input name="id" type="hidden" value="<?= $user['id'];?>">

    <h4>Permissions:</h4>

    <?php foreach (Permission::getPermissions() as $permission) : ?>

        <p>
            <label for="permission-<?= $permission['id'];?>"><?= $permission['permission']?>: </label>
            <?php if (in_array($permission['id'], explode(',', $user['permissions']))) : ?>
                <input name="permission-<?= $permission['id'];?>" type="checkbox" checked>
            <?php else : ?>
                <input name="permission-<?= $permission['id'];?>" type="checkbox">
            <?php endif; ?>
        </p>

    <?php endforeach; ?>

    <button type="submit">Сохранить</button>
</form>
