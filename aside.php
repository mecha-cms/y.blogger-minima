<aside>
  <?php if (isset($state->x->search)): ?>
    <div>
      <h3>
        <?= i('Search'); ?>
      </h3>
      <?= self::form('search', ['route' => $state->routeBlog ?? '/article']); ?>
    </div>
  <?php endif; ?>
  <div>
    <h3>
      <?= i($site->is('home') ? 'Random %s' : 'Recent %s', 'Posts'); ?>
    </h3>
    <?php

    $links = [];
    $pages = Pages::from(LOT . D . 'page' . ($state->routeBlog ?? '/article'), 'page');

    if ($site->is('home')) {
        $pages->shake();
    } else {
        $pages->sort([-1, 'time']);
    }

    foreach ($pages->chunk(5, 0) as $page) {
        $links[$page->url] = $page->title;
    }

    $list = "";

    if (count($links) > 0) {
        $current = $url->current;
        $list .= '<ul>';
        foreach ($links as $k => $v) {
            $list .= '<li>';
            $list .= '<a' . ($current === $k ? ' aria-current="page"' : "") . ' href="' . eat($k) . '">' . $v . '</a>';
            $list .= '</li>';
        }
        $list .= '</ul>';
    } else {
        $list .= '<p>' . i('No %s yet.', 'posts') . '</p>';
    }

    echo $list;

    ?>
  </div>
  <?php if (isset($state->x->tag)): ?>
    <div>
      <h3>
        <?= i('Tags'); ?>
      </h3>
      <?php

      $links = [];
      $pages = Pages::from(LOT . D . 'page' . ($state->routeBlog ?? '/article'), 'page');
      $references = [];

      foreach ($pages as $page) {
          $references = array_merge($references, (array) $page->kind);
      }

      if (count($references) > 0) {
          $current = $site->is('tags') && isset($tag) ? $tag->name : "";
          foreach (array_count_values($references) as $k => $v) {
              if (!$k = To::tag($k)) {
                  continue;
              }
              $tag = Tag::from(LOT  . D . 'tag' . D . $k . '.page');
              if (!$tag->exist) {
                  continue;
              }
              $links[strip_tags($tag->title . '@' . $tag->name)] = [$current === $k, $tag->link, $tag->title, $v];
          }
      }

      $list = "";

      if (count($links) > 0) {
          ksort($links);
          $list .= '<ul>';
          foreach ($links as $k => $v) {
              $list .= '<li>';
              $list .= '<a' . ($v[0] ? ' aria-current="page"' : "") . ' href="' . eat($v[1]) . '" rel="tag">' . $v[2] . ' <span role="status">' . $v[3] . '</span></a>';
              $list .= '</li>';
          }
          $list .= '</ul>';
      } else {
          $list .= '<p>' . i('No %s yet.', 'tags') . '</p>';
      }

      echo $list;

      ?>
    </div>
  <?php endif; ?>
</aside>