<?php

$list = "";

if (isset($state->x->archive)) {
    $archives = [];
    $route_archive = $state->x->archive->route ?? '/archive';
    $route_blog = $route ?? $state->routeBlog;
    foreach (g(LOT . D . 'page' . $route_blog, 'page') as $k => $v) {
        $p = new Page($k);
        $v = $p->time;
        if ($v) {
            $v = explode('-', $v);
            $archives[$v[0]][$v[1]][] = 1;
        }
    }
    $dates = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];
    if ($site->is('archives')) {
        $current = $archive->format('Y-m');
    } else if ($site->is('page')) {
        $current = $page->time->format('Y-m');
    }
    krsort($archives);
    foreach ($archives as $k => $v) {
        $k = (string) $k;
        if (!isset($current)) {
            $current = $k;
        }
        $list .= '<details' . (($open = $k === explode('-', $current)[0]) ? ' open' : "") . ' role="tree">';
        $list .= '<summary aria-level="1" role="treeitem">';
        $list .= '<a' . ($open ? ' aria-current="page"' : "") . ' href="' . eat($url . $route_blog . $route_archive . '/' . $k . '/1') . '">';
        $list .= $k . ' <span aria-label="' . eat(i('%d archive' . (1 === ($i = count($v)) ? "" : 's'), [$i])) . '" role="status">' . $i . '</span>';
        $list .= '</a>';
        $list .= '</summary>';
        if (is_array($v)) {
            krsort($v);
            $list .= '<ul role="group">';
            foreach ($v as $kk => $vv) {
                $list .= '<li aria-level="2" role="treeitem">';
                $list .= '<a' . ($k . '-' . $kk === $current ? ' aria-current="page"' : "") . ' href="' . eat($url . $route_blog . $route_archive . '/' . $k . '-' . $kk . '/1') . '">';
                $list .= $k . ' ' . i($dates[((int) $kk) - 1]) . ' <span aria-label="' . eat(i('%d post' . (1 === ($ii = count($vv)) ? "" : 's'), [$ii])) . '" role="status">' . $ii . '</span>';
                $list .= '</a>';
                $list .= '</li>';
            }
            $list .= '</ul>';
        }
        $list .= '</details>';
    }
} else {
    $list .= '<p role="status">' . i('Missing %s extension.', ['<a href="https://mecha-cms.com/store/extension/archive" target="_blank">archive</a>']) . '</p>';
}

echo self::widget([
    'content' => $content ?? ($list ?: '<p role="status">' . i('No %s yet.', ['posts']) . '</p>'),
    'title' => $title ?? i('Archives')
]);