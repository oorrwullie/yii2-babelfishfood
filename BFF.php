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
    public $upperCase = TRUE;


    protected $languages;
    protected $current_language;

    public function init() {

	if ($this->label === NULL) {
	    $label = Yii::t('global', 'Language') . ': ';
	    if ($this->upperCase === TRUE) {
		$label = mb_strtoupper($label, 'UTF-8');
	    }
	    $this->label = $label;
	}

	$current_language = Languages::getCurrentLanguage(Yii::$app->language);
	$languages = Languages::getSwitcherLanguages();
	if ($this->upperCase === TRUE) {
	    $current_language = mb_strtoupper($current_language, 'UTF-8');

	    for($i=0; $i < count($languages); $i++) {
		$languages[$i]['name'] = mb_strtoupper($languages[$i]['name'], 'UTF-8');
		$languages[$i]['id'] = $languages[$i]['id'];
	    }
	}
	$this->languages = $languages;
	$this->current_language = $current_language;
	
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
	    'url' => Url::current(),
	]);
    }
}
