<?php
return [

    'page/<slug:\w+>' => 'page/view',
    'image/<id:\d+>-<size:\w+>-<rev:\d+>.jpg' => 'image/get',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',

];