<footer>
  <?php

  $author = $page->author;

  if (isset($state->x->user) && $author instanceof User) {
      $author = '<a href="' . eat($author->url) . '" rel="author">' . $author . '</a>';
  }

  $time = '<time datetime="' . $page->time->format('c') . '">' . $page->time('%I:%M %p') . '</time>';

  echo '<p>';

  echo i('Posted by %s at %s', [$author ?? '<span role="status">' . i('Anonymous') . '</span>', $time]);

  if (isset($state->x->tag) && ($tags = $page->tags ?? [])) {
      echo '<br>';
      echo i('Tag' . (1 === ($count = $tags->count) ? "" : 's')) . ': ';
      if ($count) {
          $r = [];
          foreach ($tags->sort([1, 'title']) as $tag) {
              $r[] = '<a href="' . eat($tag->url) . '" rel="tag">' . $tag->title . '</a>';
          }
          echo implode(', ', $r);
      } else {
          echo '<span role="status">' . i('Untagged') . '</span>';
      }
  }

  echo '</p>';

  ?>
</footer>