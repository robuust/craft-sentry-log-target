<?php

namespace robuust\sentrylogtarget\models;

use craft\base\Model;
use yii\log\Logger;

/**
 * Settings model.
 */
class Settings extends Model
{
    /**
     * @var string
     */
    public $dsn;

    /**
     * @var array
     */
    public $sentrySettings = [];

    /**
     * @var array|string
     */
    public $levels = Logger::LEVEL_ERROR | Logger::LEVEL_WARNING;

    /**
     * @var array
     */
    public $except = ['yii\web\HttpException:40*'];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dsn'], 'required'],
        ];
    }
}
