<?php

namespace robuust\sentrylogtarget\models;

use craft\base\Model;

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
     * @var array
     */
    public $levels = ['error', 'warning'];

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
            ['levels', 'in', 'allowArray' => true, 'range' => ['error', 'warning', 'info']],
        ];
    }
}
