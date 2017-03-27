Babel Fish Food
===============
Language switching companion of the Yii2 Babelfish symbiote. It can also be used as a complete stand alone solution to get i18n support up and running quickly for any site built using the standard Yii2 advanced template.


Key Features
------------

* Pre-populated database of 115 languages and dialects to get started quickly. (You can add more using the CRUD or with migrations.) Simply change the active property of the language to add or drop support for the language.
* Configured to use GetText po files out of the box. (Can be switched to add support for database based translations.)
* Detects preferred language based on browser preferences.
* Language switching widget displays languages in native format with native alphabet.
* Widget saves language as a cookie for guests and in the User table for logged in users.
* Complete CRUD implementation for administration of languages.


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```json
php composer.phar require --prefer-dist oorrwullie/yii2-babelfishfood "*"
```

or add

```json
"oorrwullie/yii2-babelfishfood": "*"
```

to the require section of your `composer.json` file.


Configuration
-------------

Once the extension is installed :


Create the languages table and add language column to your database:

```bash
php yii migrate --migrationPath=@vendor/oorrwullie/yii2-babelfishfood/migrations
```

You select supported languages using the active column for that language in the database. We recommend writing a migration to update your active languages, and turn off any of the default that you are not using.


Configure the component in common/config/main.php:

```php

'components' => [
    'babelfishfood' => [
	'class' => 'oorrwullie\babelfishfood\components\BFFComponent',
	'cookieName' => 'language',                     // Name of the cookie.
	'expireDays' => 64,                             // The expiration time of the cookie is 64 days.
	'callback' => function() {
	    if (!\Yii::$app->user->isGuest) {
		$user = \Yii::$app->user->identity;
		$user->language = \Yii::$app->language;
		$user->save();
	    }
	}
    ]
]
```


You need to bootstrap the component for each app you would like translations to work like so:
In frontend/config/main.php

```php
'language' => 'en',
'bootstrap' => ['babelfishfood'],
```


Do the same in the backend if you would like to have the switcher there too.


Configure translation extraction:

The i18n section needs to be filled in similarly to this:
in common/config/main.php

```php
'i18n' => [
    'translations' => [
	'menu*' => [
	    'class' => 'yii\i18n\GettextMessageSource',
	    'useMoFile' => false,
	    'basePath' => '@common/messages',
	],
	'home*' => [
	    'class' => 'yii\i18n\GettextMessageSource',
	    'useMoFile' => false,
	    'basePath' => '@common/messages',
	],
	'base*' => [
	    'class' => 'yii\i18n\GettextMessageSource',
	    'useMoFile' => false,
	    'basePath' => '@common/messages',
	],
	'global*' => [
	    'class' => 'yii\i18n\GettextMessageSource',
	    'useMoFile' => false,
	    'basePath' => '@common/messages',
	],
    ],
],
```


To use the built-in CRUD to administrate languages, add the following to backend/config/main.php:

```php
'modules' => [
    'bff' => [
	'class' => 'oorrwullie\babelfishfood\BabelFishFood',
    ],
],
```


Implementation
--------------


Designating text to be translated

Wrap text to be translated like so:

```php
echo \Yii::t('app', 'This is a string to translate!');
```


To compile translations into po files, navigate to your project toot and run:

```bash
./yii message/extract @oorrwullie/babelfishfood/config/i18n.php
```

The above command is a bit long. There is a bash script in oorrwullie/yii2-babelfishfood named i18n. You can copy that to your project root and update translations by running:

```bash
./i18n
```


To use the widget in a view:

```php
<?= \oorrwullie\babelfishfood\BFF::widget(); ?>
```

You can change the label of the dropdown widget (defaults to "Languages: ") and languages can either be normal or uppercase (defaults to uppercase).
For example:

```php
<?= \oorrwullie\babelfishfood\BFF::widget([
    'upperCase' => FALSE,
    'label' => '<i class="fa fa-language"></i>',
]); ?>
```


To use the CRUD:

Navigate to your backend url + bff like so:
www.example.com/backend/bff


