<?= self::enter(); ?>
<div>
  <main>
    <?= self::alert(); ?>
    <?php foreach ($pages as $page): ?>
      <article id="page:<?= eat($page->id); ?>">
        <header>
          <p>
            <time datetime="<?= eat($page->time->format('c')); ?>">
              <?= $page->time('%A, %B %d, %Y'); ?>
            </time>
          </p>
          <h3>
            <?php if ($link = $page->link): ?>
              <a href="<?= eat($link); ?>" rel="nofollow" target="_blank">
                <?= $page->title; ?>
              </a>
            <?php else: ?>
              <a href="<?= eat($page->url); ?>">
                <?= $page->title; ?>
              </a>
            <?php endif; ?>
          </h3>
        </header>
        <div>
          <?php if ($excerpt = $page->excerpt): ?>
            <?= $excerpt; ?>
          <?php else: ?>
            <p>
              <?= $page->description; ?>
            </p>
          <?php endif; ?>
        </div>
        <?= self::get('page.footer', ['page' => $page]); ?>
      </article>
    <?php endforeach; ?>
    <?php if (isset($state->x->pager)): ?>
      <?= self::pager('peek'); ?>
    <?php else: ?>
      <?= self::pager(); ?>
    <?php endif; ?>
  </main>
  <?= self::aside(); ?>
</div>
<?= self::exit(); ?>