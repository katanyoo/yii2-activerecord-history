ActiveRecord History
====================
This extension for keep track what your users are doing within your application is to log their activities related to database modifications.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist katanyoo/yii2-activerecord-history "*"
```

or add

```
"katanyoo/yii2-activerecord-history": "*"
```

to the require section of your `composer.json` file.

If you are using DBManager as Manager, you need to run

```
php yii migrate/up --migrationPath=@vendor/katanyoo/yii2-activerecord-history/migrations
```
or if you want to use another DB, you can add

```
--db=db2
```


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php

```
