<?php

$host_mapping = [
    'production'  => [
        'default'             => 'www.autohello.com',

        'agent.autohello.com' => 'agent.autohello.com',
        'api.autohello.com'   => 'api.autohello.com',
        'api.i.autohello.com' => 'api.autohello.com',
        'api.o.autohello.com' => 'api.autohello.com',
        'cms.autohello.com'   => 'cms.autohello.com',
        'mapi.autohello.com'  => 'mapi.autohello.com',
        'm.autohello.com'     => 'm.autohello.com',
        'ms.autohello.com'    => 'ms.autohello.com',
        'www.autohello.com'   => 'www.autohello.com',

        'wenda.chemayi.com'   => 'www.autohello.com',
    ],
    'development' => [
        'm.autohello.*'         => 'm.autohello.com',
        'm.*.autohello.*'       => 'm.autohello.com',

        'api.autohello.*'       => 'api.autohello.com',
        'api.*.autohello.*'     => 'api.autohello.com',

        'mapi.autohello.*'      => 'mapi.autohello.com',
        'mapi.*.autohello.*'    => 'mapi.autohello.com',

        'cms.*dev.autohello.cn' => 'cms.autohello.com',
        'cms.autohello.*'       => 'cms.autohello.com',

        'ms.autohello.*'        => 'ms.autohello.com',
        'ms.*.autohello.*'      => 'ms.autohello.com',

        'agent.autohello.*'     => 'agent.autohello.com',
        'agent.*.autohello.*'   => 'agent.autohello.com',

        'test.*dev.autohello.*' => 'test.autohello.com',

        'default'               => 'www.autohello.com',
    ],
];

return $host_mapping;