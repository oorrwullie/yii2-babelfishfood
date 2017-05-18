<?php

namespace oorrwullie\babelfishfood;

use Yii;
use yii\base\BootstrapInterface;

class I18nMerge extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'oorrwullie\babelfishfood\commands';

    public function init() {

	parent::init();

	$this->components = [
	    'poParser' => [
		'class' => 'oorrwullie\babelfishfood\components\poParser',
		'generatedPath' => Yii::getAlias('@console').'/messages/',
		'compiledPath' => Yii::getAlias('@common').'/messages/',
		'filename' => '/messages.po',
	    ],
	];

    }

    public function bootstrap($app) {

	if($app instanceof \yii\console\Application) {
	    $app->controllerMap[$this->id] = [
		'class' => 'oorrwullie\babelfishfood\commands\I18nMergeController',
		'module' => $this,
	    ];
	}
    }
}
