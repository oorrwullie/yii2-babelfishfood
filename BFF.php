<?php

namespace oorrwullie\babelfishfood;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use oorrwullie\babelfishfood\models\Languages;


class BFF extends Widget {
    
    /**
     * @property string
     */
    public $label;

    /**
     * @property boolean
     */
    public $aliases = TRUE;

    /**
     * @property boolean
     */
    public $upperCase = TRUE;


    protected $languages;
    protected $current_language;
    protected $url;

    public function init() {

	$this->languages = Languages::getSwitcherLanguages();
	$this->current_language = Languages::getCurrentLanguage(Yii::$app->language);
	$this->url = Url::current();

	if ($this->label === null) {
	    $this->label = Yii::t('global', 'Language') . ': ';
	}

	if ($this->upperCase === TRUE) {
	    $this->label = mb_strtoupper($label, 'UTF-8');
	    $this->current_language = mb_strtoupper($this->current_language, 'UTF-8');

	    foreach ($this->languages as $language) {
		$language['name'] = mb_strtoupper($language['name'], 'UTF-8');
	    }
	}

	if ($this->aliases === TRUE) {
	    if (strpos($this->url,'site')) {
		$this->url = str_replace('/site', '', $this->url);
	    }
	    if (strpos($this->url,'index')) {
		$this->url = str_replace('/index', '', $this->url);
	    }
	}

	parent::init();
    }

    /**
     * @return string
     */
    public function run() {

	return $this->render('_langpicker', [
	    'label' => $this->label,
	    'languages' => $this->languages,
	    'current_language' => $this->current_language,
	    'url' => $this->url,
	]);
    }
}
