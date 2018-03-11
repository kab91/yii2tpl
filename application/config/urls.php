<?php
return [

    'page/<slug:[_\-a-zA-Z0-9]+>' => 'page/view',
    'image/<id:\d+>-<size:\w+>-<rev:\d+>.jpg' => 'image/get',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',

];