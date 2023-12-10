<?php

if (isset($state->x->tag)) {
    $pages = [];
    $tags = [];
    foreach (Pages::from(LOT . D . 'page' . ($route ?? $state->routeBlog ?? '/article'), 'page') as $page) {
        $tags = array_merge($tags, (array) $page->kind);
    }
    if (count($tags) > 0) {
        $current = $site->is('tags') && isset($tag) ? $tag->name : "";
        foreach (array_count_values($tags) as $k => $v) {
            if (!$k = To::tag($k)) {
                continue;
            }
            $tag = Tag::from(LOT  . D . 'tag' . D . $k . '.page');
            if (!$tag->exist) {
                continue;
            }
            $pages[strip_tags($tag->title . '@' . $tag->name)] = [$current === $k, $tag->link, $tag->title, $v];
        }
    }
    $list = "";
    if (count($pages) > 0) {
        ksort($pages);
        $list .= '<ul>';
        foreach ($pages as $k => $v) {
            $list .= '<li>';
            $list .= '<a' . ($v[0] ? ' aria-current="page"' : "") . ' href="' . eat($v[1]) . '" rel="tag">' . $v[2] . ' <span role="status">' . $v[3] . '</span></a>';
            $list .= '</li>';
        }
        $list .= '</ul>';
    } else {
        $list .= '<p>' . i('No %s yet.', 'tags') . '</p>';
    }
    echo self::widget([
        'content' => $content ?? $list,
        'title' => $title ?? i('Tags')
    ]);
}