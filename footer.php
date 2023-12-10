<?php if (0 === strpos($url->path . '/', $route = ($state->routeBlog ?? '/article') . '/')): ?>
  <p>
    <?= i('Subscribe to %s', ['<a href="' . eat($url . ($state->routeBlog ?? '/article') . '/feed.xml') . '" rel="alternate" target="_blank">' . i('Posts') . ' (Atom)</a>']); ?>
  </p>
<?php endif; ?>