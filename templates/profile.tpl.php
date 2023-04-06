
<?php function drawInfosProfile(User $user): void { ?>
    <article class = "user_info">
        <p>Name : <?= $user->getName()?></p>
        <p>Username : <?= $user->getUsername()?></p>
        <p>Email : <?= $user->getEmail()?></p>
        <p>Category : <?= $user->getCategory()?></p>
    </article>
<?php } ?>
