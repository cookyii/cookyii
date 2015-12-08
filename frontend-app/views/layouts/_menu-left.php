<?php
/**
 * _menu-left.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

return [
    [
        'label' => 'Link',
        'url' => ['/'],
        'icon' => 'home',
        'visible' => true,
        'selected' => true,
    ],
    [
        'label' => 'Link',
        'url' => ['/'],
        'icon' => null,
        'visible' => true,
        'selected' => false,
    ],
    [
        'label' => 'Dropdown',
        'url' => ['/'],
        'icon' => null,
        'visible' => true,
        'selected' => false,
        'items' => [
            [
                'label' => 'Action',
                'url' => ['/'],
                'icon' => null,
                'visible' => true,
                'selected' => false,
            ],
            [
                'label' => 'Another action',
                'url' => ['/'],
                'icon' => null,
                'visible' => true,
                'selected' => false,
            ],
            [
                'label' => 'Something else here',
                'url' => ['/'],
                'icon' => null,
                'visible' => true,
                'selected' => false,
            ],
            '|',
            [
                'label' => 'Separated link',
                'url' => ['/'],
                'icon' => null,
                'visible' => true,
                'selected' => false,
            ],
            '|',
            [
                'label' => 'One more separated link',
                'url' => ['/'],
                'icon' => 'list',
                'visible' => true,
                'selected' => false,
            ],
        ],
    ],
];