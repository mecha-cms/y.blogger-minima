<aside>
  <?= self::widget('form/search'); ?>
  <?php if ($site->is('home')): ?>
    <?= self::widget('page/random'); ?>
  <?php elseif ($site->is('page')): ?>
    <?= self::widget('page/relate'); ?>
  <?php else: ?>
    <?= self::widget('page/recent'); ?>
  <?php endif; ?>
  <?= self::widget('page/popular'); ?>
  <?= self::widget('tag'); ?>
  <?= self::widget('archive'); ?>
</aside>