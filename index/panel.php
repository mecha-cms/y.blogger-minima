<?php

Hook::set('_', function ($_) use ($state, $url) {
    if ('.state' === $_['path']) {
        $lot = [];
        foreach (Pages::from(LOT . D . 'page', 'archive,page')->sort([1, 'title']) as $v) {
            $lot[strtr($v->url, [
                $url . '/' => '/'
            ])] = $v->title;
        }
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['blog']['lot']['fields'] = [
            'lot' => [],
            'type' => 'fields'
        ];
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['blog']['lot']['fields']['lot']['banner'] = [
            'description' => 'Specify a background image for the header.',
            'hint' => $url . '/lot/asset/banner.jpg',
            'name' => 'state[y][blogger-minima][banner]',
            'stack' => 10,
            'type' => 'u-r-l',
            'value' => $state->y->{'blogger-minima'}->banner,
            'width' => true
        ];
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['blog']['lot']['fields']['lot']['banner-title'] = [
            'description' => 'Title color when banner is set.',
            'name' => 'state[y][blogger-minima][color][title]',
            'stack' => 10.2,
            'title' => 'Title',
            'type' => 'color',
            'value' => $state->y->{'blogger-minima'}->color->title ?? '#ffffff'
        ];
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['blog']['lot']['fields']['lot']['banner-description'] = [
            'description' => 'Description color when banner is set.',
            'name' => 'state[y][blogger-minima][color][description]',
            'stack' => 10.2,
            'title' => 'Description',
            'type' => 'color',
            'value' => $state->y->{'blogger-minima'}->color->description ?? '#cccccc'
        ];
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['blog']['lot']['fields']['lot']['route-blog'] = [
            'description' => 'Choose default page for the blog route.',
            'lot' => $lot,
            'name' => 'state[route-blog]',
            'stack' => 20,
            'title' => 'Route',
            'type' => 'option',
            'value' => $state->routeBlog
        ];
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['blog']['lot']['fields']['lot']['skin'] = [
            'lot' => [
                'black' => 'Black',
                'blue' => 'Blue',
                'brick' => 'Brick',
                'ochre' => 'Ochre',
                'white' => 'White'
            ],
            'name' => 'state[y][blogger-minima][skin][name]',
            'stack' => 30,
            'title' => 'Skin',
            'type' => 'item',
            'value' => $state->y->{'blogger-minima'}->skin->name ?? 'white'
        ];
    }
    return $_;
}, 0);