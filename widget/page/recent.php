<?php

$pages = [];
foreach (Pages::from(LOT . D . 'page' . ($route ?? $state->routeBlog ?? '/article'), 'page')->sort([-1, 'time'])->chunk($take ?? 5, 0) as $page) {
    $pages[$page->url] = $page->title;
}

$list = "";
if (count($pages) > 0) {
    $current = $url->current;
    $list .= '<ul>';
    foreach ($pages as $k => $v) {
        $list .= '<li>';
        $list .= '<a' . ($current === $k ? ' aria-current="page"' : "") . ' href="' . eat($k) . '">' . $v . '</a>';
        $list .= '</li>';
    }
    $list .= '</ul>';
} else {
    $list .= '<p>' . i('No %s yet.', 'posts') . '</p>';
}

echo self::widget([
    'content' => $content ?? $list,
    'title' => $title ?? i('Recent %s', 'Posts')
]);