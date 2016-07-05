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

For demo install advanced yii https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md#installing-using-composer
Create database and run initial migrations

Apply migrations, run in console:

```
php yii migrate --migrationPath=@vendor/podtserkovsky/yii2-user-db-log/migrations
```

Add in your app config:
```
'modules' => [
        'user-db-log' => [
            'class' => 'podtserkovsky\userdblog\Module',
        ],
    ],
```
Simply use it in your code by in any ActiveRecord class :

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

```

You can then access Log through the following URL:

```
http://localhost/path/to/index.php?r=user-db-log
```

or if you have enabled pretty URLs, you may use the following URL:

```
http://localhost/path/to/index.php/user-db-log
```
