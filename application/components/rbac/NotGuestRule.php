<?php
namespace app\components\rbac;

use yii\rbac\Rule;

class NotGuestRule extends Rule
{
    public $name = 'notGuestRule';

    public function execute($user, $item, $params)
    {
        return !\Yii::$app->user->isGuest;
    }
}