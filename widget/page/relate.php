<?php

echo self::widget('page', [
    'query' => explode('-', $page->name ?? ""),
    'shake' => true,
    'title' => $title ?? i('Related %s', 'Posts')
]);