Yii2 User DB modifications logger
=================================
Yii2 User DB modifications logger. Save modifications your tables.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist podtserkovsky/yii2-user-db-log "*"
```

or add

```
"podtserkovsky/yii2-user-db-log": "*"
```

to the require section of your `composer.json` file.


Usage
-----

0. For demo install advanced yii https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md#installing-using-composer

1. Apply migrations, run in console:

```
php yii migrate --migrationPath=@vendor/podtserkovsky/yii2-user-db-log/migrations
```

2. Add in your app config:
```
'modules' => [
        'user-db-log' => [
            'class' => 'podtserkovsky\userdblog\Module',
        ],
    ],
```
3. Simply use it in your code by  :

```
public function behaviors()
    {
        return [
            [
                'class' => UserDbLogBehavior::className()
            ],
        ];
    }

``

