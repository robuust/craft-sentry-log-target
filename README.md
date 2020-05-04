Sentry Log Target plugin for Craft
=================

Catches exceptions natively with Yii2's log component and sends them to [Sentry](https://getsentry.com/).

Uses Sentry PHP SDK v2 via [olegtsvetkov/yii2-sentry](https://github.com/olegtsvetkov/yii2-sentry).

## Requirements

This plugin requires Craft CMS 3.1.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require robuust/craft-sentry-log-target

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Sentry Log Target.

## Configuration

Create a `config/sentry-log-target.php` config file with the following contents:

```php
<?php

return [
    '*' => [
        'dsn'    => '$SENTRY_DSN' ?: 'https://example@sentry.io/123456789', // Set as string or use environment variable.
        'levels' => ['error', 'warning'],
        'except' => ['yii\web\HttpException:40*'],
    ],
];
```
