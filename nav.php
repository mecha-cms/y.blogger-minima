<nav>
  <ul>
    <li>
      <a<?= $site->is('home') ? ' aria-current="page"' : ""; ?> href="<?= eat($url); ?>">
        <?= i('Home'); ?>
      </a>
    </li>
    <?php foreach ($links as $link): ?>
      <li>
        <a<?= $link->current ? ' aria-current="page"' : ""; ?> href="<?= eat($link->link ?: ($link->url . (q($link->children) ? '/1' : ""))); ?>">
          <?= $link->title; ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>