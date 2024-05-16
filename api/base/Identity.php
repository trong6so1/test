<?php


namespace api\base;

use common\models\User;
use yii\web\IdentityInterface as IdentityInterface;

/**
 * Class Identity
 * @package api\base
 */
class Identity extends User implements IdentityInterface
{

}