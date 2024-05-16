<?php

namespace common\models;

use common\models\base\baseUser;
use Yii;
use yii\base\Exception;
use yii\web\IdentityInterface;

/**
 * @property string $auth_key
 * @property-read null|string $accessToken
 * @property-read mixed $id
 * @property-read null|string $authKey
 * @property string $access_token
 */
class User extends baseUser implements IdentityInterface
{
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    public function getAccessToken(): ?string
    {
        return $this['access_token'];
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @throws Exception
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }
}
