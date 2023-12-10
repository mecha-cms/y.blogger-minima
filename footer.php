<footer>
  <?php if (0 === strpos($url->path . '/', $route = ($state->routeBlog ?? '/article') . '/')): ?>
    <p>
      <?= i('Subscribe to %s', ['<a href="' . eat($url . ($state->routeBlog ?? '/article') . '/feed.xml') . '" rel="alternate" target="_blank">' . i('Posts') . ' (Atom)</a>']); ?>
    </p>
    <p>
      <?= i('Powered by %s', ['<a href="https://mecha-cms.com">Mecha ' . VERSION . '</a>']); ?>
    </p>
  <?php endif; ?>
</footer>