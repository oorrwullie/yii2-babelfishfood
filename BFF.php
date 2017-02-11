<?php

namespace oorrwullie\babelfishfood;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use oorrwullie\babelfishfood\models\Languages;


class BFF extends Widget {
    
	/**
	 * Custom title for the drop down menu
	 **/
    public $title;

    public function init() {

	parent::init();
	if ($this->title === null) {
	    $this->title = Yii::t('global', 'Language') . ': ';
	}
    }

    /**
     * @return string
     */
    public function run() {

	$languages = Languages::getSwitcherLanguages();
	$current_language = Languages::getCurrentLanguage(Yii::$app->language);

	$url = Url::current();
	// comment these out if you don't have aliases set for site and index
	if (strpos($url,'site')) {
	    $url = str_replace('/site', '', $url);
	}
	if (strpos($url,'index')) {
	    $url = str_replace('/index', '', $url);
	}

	return $this->render('_langpicker', [
	    'title' => $this->title,
	    'languages' => $languages,
	    'current_language' => $current_language,
	    'url' => $url,
	]);
    }
}
