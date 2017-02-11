<?php

namespace oorrwullie\babelfishfood\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * Languages model
 *
 * @property integer $lang_id
 * @property string $lang_name
 * @property string $native_name
 * @property string $lang_code
 * @property boolean $active
 */
class Languages extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {

	return '{{%languages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {

	return [
	    [['lang_name', 'native_name', 'lang_code'], 'required'],
	    [['active'], 'boolean'],
	    [['lang_name', 'native_name', 'lang_code'], 'string', 'max' => 255],
	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

	return [
	    'lang_id' => Yii::t('global', 'ID'),
	    'lang_name' => Yii::t('global', 'Name'),
	    'native_name' => Yii::t('global', 'Native Name'),
	    'lang_code' => Yii::t('global', 'ISO Code'),
	    'active' => Yii::t('global', 'Active'),
	];
    }

    /**
     * @inheritdoc
     */
    public function getActiveLanguages()
    {
	return $this->findAll(['active' => 1]);
    }

    /**
     * @inheritdoc
     */
    public function getTranslatorLanguages()
    {
	$langObjects = $this->findAll(['active' => 1]);
	$langs;

	foreach($langObjects as $lo) {
	    $langs[$lo->lang_id] = $lo->lang_name;
	}

	return $langs;
    }

    public static function getSwitcherLanguages() {
	$languages = array();
	$query[] = (new Query())
	    ->select('native_name `name`, lang_code `id`')
	    ->from('languages')
	    ->where(['active' => '1'])
	    ->orderBy('id')
	    ->all();
	$languages = $query[0];

	return $languages;
    }

    public static function getCurrentLanguage($current_id) {
	$query[] = (new Query())
	    ->select('native_name `name`')
	    ->from('languages')
	    ->where(['lang_code' => $current_id])
	    ->one();
	$language = $query[0]['name'];

	return $language;
    }

    public static function getI18n() {
	$query[] = (new Query())
	    ->select('lang_code `id`')
	    ->from('languages')
	    ->where(['active' => '1'])
	    ->all();
	foreach ($query[0] as $q) {
	    $languages[] = $q['id'];
	}

	return $languages;
    }

    public static function getLPL() {
	$query[] = (new Query())
	    ->select('lang_code `id`, native_name `name`')
	    ->from('languages')
	    ->where(['active' => '1'])
	    ->orderBy('id')
	    ->all();
	foreach ($query[0] as $q) {
	    $languages[$q['id']] = mb_strtoupper($q['name'], "UTF-8");
	}

	return $languages;
    }

}
