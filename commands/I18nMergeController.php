<?php

namespace oorrwullie\babelfishfood\commands;

use Yii;
use yii\console\Controller;
use oorrwullie\babelfishfood\models\Languages;
use oorrwullie\components\PoParser;

class I18nMergeController extends Controller {

    public function actionIndex() {
	$languages = Languages::getI18n();
	$parser = Yii::$app->getModule('i18n-merge')->poParser;

	foreach($languages as $language) {
	    echo "\nMerging ".$language." po files...";
	    $generatedPo = $parser->getGeneratedPo($language);
	    $compiledPo = $parser->getCompiledPo($language);
	    $newCompiledPo = $parser->merge($generatedPo, $compiledPo);
	    $parser->save($language, $newCompiledPo);
	}
	echo "\n\nMerging complete. i18n update finished.\n\n";
    }
}
