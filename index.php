<?php namespace y\blogger_minima;

\lot('links', new \Anemone(\fire(function ($r) use ($state) {
    $route_current = $this->path . '/';
    $route_r = '/' . \trim($state->route ?? 'index', '/');
    foreach (\g(\LOT . \D . 'page', 'page') as $k => $v) {
        $v = new \Page($k);
        // Exclude home page
        if ($route_r === ($route = $v->route)) {
            continue;
        }
        // Add current state
        $v->current = 0 === \strpos($route_current, $route . '/');
        $r[$v->title . \P . $k] = $v;
    }
    \ksort($r);
    return \array_values($r);
}, [[]], $url)));

function page__content($content) {
    if (null === $content) {
        return $content;
    }
    \extract(\lot(), \EXTR_SKIP);
    if (!$state->is('page')) {
        return $content;
    }
    return \strtr($content, ["\f" => '<hr id="next:' . $this->id . '" role="doc-pagebreak">']);
}

function route__archive() {
    \extract(\lot());
    if ($state->is('error')) {
        return;
    }
    if (!isset($archive)) {
        return;
    }
    $t = \State::get('[x].query.archive') ?? "";
    $format = (false === \strpos($t, '-') ? "" : '%B ') . '%Y';
    if ($q = \State::get('[x].query.search')) {
        \Alert::info('Showing %s published in %s and matched with query %s.', ['posts', '<b>' . $archive->i($format) . '</b>', '&#x201c;' . $q . '&#x201d;']);
    } else {
        \Alert::info('Showing %s published in %s.', ['posts', '<b>' . $archive->i($format) . '</b>']);
    }
}

function route__author() {
    \extract(\lot());
    if (!$site->has('part') || $site->is('error') || !isset($author)) {
        return;
    }
    if ($q = \State::get('[x].query.search')) {
        \Alert::info('Showing all %s written by %s and matched with query %s.', ['posts', '<b>' . $author->title . '</b>', '&#x201c;' . $q . '&#x201d;']);
    } else {
        if ($q = \State::get('[x].query.author')) {
            if ($page instanceof \Author) {
                \Alert::info('Showing all %s written by %s.', ['posts', '<b>' . $page->title . '</b>']);
            } else {
                \Alert::info('Showing all %s of %s written by %s.', ['posts', '<b>' . $page->title . '</b>', '<b>' . $author->title . '</b>']);
            }
        } else {
            if ($page->path) {
                \Alert::info('Showing all %s of %s.', ['authors', '<b>' . $page->title . '</b>']);
            } else {
                \Alert::info('Showing all %s.', ['authors']);
            }
        }
    }
}

function route__search() {
    \extract(\lot());
    if ($state->is('error')) {
        return;
    }
    if (!$q = \State::get('[x].query.search')) {
        return;
    }
    if (!$state->is('archives') && !$state->is('tags')) {
        \Alert::info('Showing %s matched with query %s.', ['posts', '&#x201c;' . $q . '&#x201d;']);
    }
}

function route__tag() {
    \extract(\lot());
    if (!$site->has('part') || $site->is('error') || !isset($tag)) {
        return;
    }
    if ($q = \State::get('[x].query.search')) {
        \Alert::info('Showing all %s tagged in %s and matched with query %s.', ['posts', '<b>' . $tag->title . '</b>', '&#x201c;' . $q . '&#x201d;']);
    } else {
        if ($q = \State::get('[x].query.tag')) {
            if ($page instanceof \Tag) {
                \Alert::info('Showing all %s tagged in %s.', ['posts', '<b>' . $page->title . '</b>']);
            } else {
                \Alert::info('Showing all %s of %s tagged in %s.', ['posts', '<b>' . $page->title . '</b>', '<b>' . $tag->title . '</b>']);
            }
        } else {
            if ($page->path) {
                \Alert::info('Showing all %s of %s.', ['tags', '<b>' . $page->title . '</b>']);
            } else {
                \Alert::info('Showing all %s.', ['tags']);
            }
        }
    }
}

\Asset::set(__DIR__ . D . 'index' . (\defined("\\TEST") && \TEST ? '.' : '.min.') . 'css', 20);

if ($banner = $state->y->{'blogger-minima'}->banner ?? "") {
    $style = 'body>div>header{background-image:url(' . $banner . ')}';
    $style .= 'body>div>header>h1{color:' . ($state->y->{'blogger-minima'}->color->title ?? '#ffffff') . '}';
    $style .= 'body>div>header>p{color:' . ($state->y->{'blogger-minima'}->color->description ?? '#cccccc') . '}';
    \Asset::set('data:text/css;base64,' . To::base64($style), 20.1);
}

if (isset($state->x->alert)) {
    \Hook::set('route.archive', __NAMESPACE__ . "\\route__archive", 100.1);
    \Hook::set('route.author', __NAMESPACE__ . "\\route__author", 100.1);
    \Hook::set('route.search', __NAMESPACE__ . "\\route__search", 100.1);
    \Hook::set('route.tag', __NAMESPACE__ . "\\route__tag", 100.1);
}

if (isset($state->x->excerpt)) {
    \Hook::set('page.content', __NAMESPACE__ . "\\page__content");
}

$states = [
    'route-blog' => '/article',
    'x.comment.page.type' => isset($state->x->comment) ? 'Markdown' : null,
    'x.page.page.type' => isset($state->x->page) ? 'Markdown' : null
];

foreach ($states as $k => $v) {
    !\State::get($k) && null !== $v && \State::set($k, $v);
}

if ($skin = $state->y->{'blogger-minima'}->skin->name ?? "") {
    \State::set('[y].state.skin-' . $skin, true);
}