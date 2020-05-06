<?php

namespace robuust\sentrylogtarget;

use Craft;
use OlegTsvetkov\Yii2\Sentry\Component;
use OlegTsvetkov\Yii2\Sentry\LogTarget;
use robuust\sentrylogtarget\models\Settings;
use Sentry\State\Scope;
use yii\log\Dispatcher;

/**
 * Sentry Log Target Plugin.
 *
 * @author    Bob Olde Hampsink <bob@robuust.digital>
 * @copyright Copyright (c) 2020, Robuust
 * @license   MIT
 *
 * @see       https://robuust.digital
 */
class Plugin extends \craft\base\Plugin
{
    /**
     * Initializes the plugin.
     */
    public function init()
    {
        parent::init();

        // Set Sentry Component
        $this->setComponents([
            'sentry' => [
                'class' => Component::class,
                'dsn' => Craft::parseEnv($this->settings->dsn),
                'sentrySettings' => $this->settings->sentrySettings,
            ],
        ]);

        // Set Sentry Craft Scope
        $this->sentry->getHub()->configureScope(function (Scope $scope) {
            $user = Craft::$app->getUser()->getIdentity();
            if ($user) {
                $scope->setUser([
                    'ID' => $user->id,
                    'Username' => $user->username,
                    'Email' => $user->email,
                    'Admin' => $user->admin ? 'Yes' : 'No',
                ]);
            }

            $scope->setExtra('App Type', 'Craft CMS');
            $scope->setExtra('App Name', Craft::$app->getInfo()->name);
            $scope->setExtra('App Edition (licensed)', Craft::$app->getLicensedEditionName());
            $scope->setExtra('App Edition (running)', Craft::$app->getEditionName());
            $scope->setExtra('App Version', Craft::$app->getInfo()->version);
            $scope->setExtra('App Version (schema)', Craft::$app->getInfo()->schemaVersion);
        });

        // Set Sentry Log Target
        $dispatcher = Craft::getLogger()->dispatcher;
        if ($dispatcher instanceof Dispatcher) {
            $dispatcher->targets[] = new LogTarget([
                'component' => $this->sentry,
                'levels' => $this->settings->levels,
                'except' => $this->settings->except,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }
}
