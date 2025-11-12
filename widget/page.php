<?php

$current = $current ?? $page->url ?? $url->current;
$folder = LOT . D . 'page' . ($route ?? $state->routeBlog ?? '/article');
if ($file = exist([
    $folder . '.archive',
    $folder . '.page'
], 1)) {
    $deep = (new Page($file))->deep ?? 0;
}

$pages = Pages::from($folder, 'page', $deep ?? 0)->sort([$sort[0] ?? -1, $sort[1] ?? 'time']);

if ($query = array_filter((array) ($query ?? []))) {
    $pages = $pages->is(function ($v) use ($current, $query) {
        if ($current === $v->url) {
            return false;
        }
        $name = '-' . $v->name . '-';
        foreach ($query as $q) {
            if (false !== strpos($name, '-' . $q . '-')) {
                return true;
            }
        }
        return false;
    });
}

if (!empty($shake)) {
    $pages = $pages->shake();
}

$pages = $pages->chunk($take ?? 5, 0);

$content = "";
if (count($pages) > 0) {
    $content .= '<ul>';
    foreach ($pages as $page) {
        $content .= '<li>';
        $content .= '<a' . ($current === ($k = $page->url) ? ' aria-current="page"' : "") . ' href="' . eat($k) . '">' . $page->title . '</a>';
        $content .= '</li>';
    }
    $content .= '</ul>';
} else {
    $content .= '<p role="status">' . i('No' . (!empty($query) ? ' related' : "") . ' %s yet.', 'posts') . '</p>';
}

echo self::widget([
    'content' => $content,
    'title' => $title ?? null
]);