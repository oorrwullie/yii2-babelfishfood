<?php

use yii\db\Schema;
use yii\db\Migration;

class m160202_004833_create_language_table extends Migration {

    public function up() {

	$tableSchema = Yii::$app->db->schema->getTableSchema('languages');

	if ($tableSchema !== null) {
	    $this->dropTable('languages');
	}

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

	$this->createTable('{{%languages}}', [
	    'lang_id' => Schema::TYPE_PK,
	    'lang_name' => Schema::TYPE_STRING . ' NOT NULL',
	    'native_name' => Schema::TYPE_STRING . ' NOT NULL',
	    'lang_code' => Schema::TYPE_STRING . ' NOT NULL',
	    'active' => Schema::TYPE_BOOLEAN,
	]);

	$this->batchInsert('{{%languages}}', ['lang_name', 'native_name', 'lang_code', 'active'], [
	    ['Afrikaans', 'Afrikaans', 'af', 0],
	    ['Albanian', 'Shqiptar', 'sq', 0],
	    ['Amharic', 'አማርኛ', 'am', 0],
	    ['Arabic', 'عربى', 'ar', 1],
	    ['Armenian', 'հայերեն', 'hy', 0],
	    ['Azerbaijani', 'Azərbaycan', 'az', 0],
	    ['Basque', 'Euskal', 'eu', 0],
	    ['Belarusian', 'беларускі', 'be', 0],
	    ['Bengali', 'বাঙালি', 'bn', 0],
	    ['Bosnian', 'Bosanski', 'bs', 0],
	    ['Bulgarian', 'български', 'bg', 0],
	    ['Catalan', 'Català', 'ca', 0],
	    ['Cebuano', 'Cebuano', 'ceb', 0],
	    ['Chichewa', 'Chichewa', 'ny', 0],
	    ['Chinese (simplified)', '简体中文', 'zh-hans', 1],
	    ['Chinese (traditional)', '中國傳統的', 'zh-hant', 1],
	    ['Corsican', 'Corsu', 'co', 0],
	    ['Cree', 'ᓀᐦᐃᔭᐍᐏᐣ', 'cr', 0],
	    ['Croatian', 'Hrvat', 'hr', 0],
	    ['Czech', 'Čeština', 'cz', 0],
	    ['Danish', 'Dansk', 'da', 0],
	    ['Divehi', 'ދިވެހި', 'dv', 0],
	    ['Dutch', 'Nederlands', 'nl', 0],
	    ['Dzongkha', 'རྫོང་ཁ', 'dz', 0],
	    ['English', 'English', 'en', 1],
	    ['Esperanto', 'Esperanto', 'eo', 0],
	    ['Estonian', 'Eesti Keel', 'et', 0],
	    ['Ewe', 'Eʋegbe', 'ee', 0],
	    ['Faroese', 'Føroyskt', 'fo', 0],
	    ['Filippino', 'Tagalog', 'tl', 0],
	    ['Finnish', 'Suomalainen', 'fi', 0],
	    ['French', 'Français', 'fr', 1],
	    ['Frisian', 'Frysk', 'fy', 0],
	    ['Galician', 'Galego', 'gl', 0],
	    ['Georgian', 'ქართული', 'ka', 0],
	    ['German', 'Deutsch', 'de', 0],
	    ['Greek', 'Ελληνικά', 'el', 0],
	    ['Gujarati', 'ગુજરાતી', 'gu', 0],
	    ['Haitian Creole', 'Kreyòl ayisyen', 'ht', 0],
	    ['Hausa', 'هَوُسَ', 'ha', 0],
	    ['Hawaiian', 'ʻŌlelo Hawaiʻi', 'haw', 0],
	    ['Hebrew', 'עִברִית', 'he', 0],
	    ['Hindi', 'हिंदी', 'hi', 0],
	    ['Hmong', 'Hmong', 'hmn', 0],
	    ['Hungarian', 'Magyar', 'hu', 0],
	    ['Icelandic', 'Íslenska', 'is', 0],
	    ['Igbo', 'Asụsụ Igbo', 'ig', 0],
	    ['Indonesian', 'Bahasa Indonesia', 'id', 0],
	    ['Interlingue', 'Occidental', 'ie', 0],
	    ['Inupiaq', 'Iñupiaq', 'ik', 0],
	    ['Inuktitut', 'ᐃᓄᒃᑎᑐᑦ', 'iu', 0],
	    ['Italian', 'Italiano', 'it', 0],
	    ['Irish', 'Gaeilge', 'ig', 0],
	    ['Japanese', '日本語', 'ja', 0],
	    ['Javanese', 'Jawa', 'jv', 0],
	    ['Kannada', 'ಕನ್ನಡ', 'kn', 0],
	    ['Kashmiri', 'कश्मीरीಡ','ks', 0],
	    ['Khmer', 'ភាសាខ្មែរ', 'km', 0],
	    ['Korean', '한국어', 'ko', 0],
	    ['Kurdish', 'Kurdî', 'ku', 0],
	    ['Kyrgyz', 'Кыргызча', 'ky', 0],
	    ['Lao', 'ລາວ', 'lo', 0],
	    ['Latvian', 'Latvijas', 'lv', 0],
	    ['Lithuanian', 'Lietuvių Kalba', 'lt', 0],
	    ['Luxembourgish', 'Lëtzebuergesch', 'lb', 0],
	    ['Macedonian', 'Македонски', 'mk', 0],
	    ['Malagasy', 'Malagasy', 'mg', 0],
	    ['Malay', 'Melayu', 'ms', 0],
	    ['Malayalam', 'മലയാളം', 'ml', 0],
	    ['Maltese', 'Malti', 'mt', 0],
	    ['Maori', 'te reo Māor', 'mi', 0],
	    ['Marathi', 'मराठी', 'mr', 0],
	    ['Mongolian', 'Монгол', 'mn', 0],
	    ['Burmese', 'မြန်မာ', 'my', 0],
	    ['Nepali', 'नेपाली', 'ne', 0],
	    ['Norwgian', 'Norsk', 'no', 0],
	    ['Pashto', 'پښتو', 'ps', 0],
	    ['Persian', 'فارسی', 'fa', 0],
	    ['Polish', 'Polski', 'pl', 0],
	    ['Portugese', 'Português', 'pt', 0],
	    ['Punjabi', 'Pendżabski', 'pa', 0],
	    ['Romanian', 'Romanian', 'ro', 0],
	    ['Russian', 'Русский', 'ru', 1],
	    ['Russian/Kazak', 'Қазақ Тілі', 'kk', 0],
	    ['Samoan', "gagana fa'a Samoa", 'sm', 0],
	    ['Sanskrit', 'संस्कृत', 'sa', 0],
	    ['Scots Gaelic', 'Gàidhlig', 'gd', 0],
	    ['Serbian', 'Srpski', 'sr', 0],
	    ['Sesotho', 'Sesotho', 'st', 0],
	    ['Shona', 'chiShona', 'sn', 0],
	    ['Sindhi', 'سنڌي', 'sd', 0],
	    ['Sinhala', 'සිංහල', 'si', 0],
	    ['Slovak', 'Slovenčina', 'sk', 0],
	    ['Slovenian', 'Slovenščina', 'sl', 0],
	    ['Somali', 'Soomaali', 'so', 0],
	    ['Spanish', 'Español', 'es', 1],
	    ['Sudanese', 'Sunda', 'su', 0],
	    ['Swahili', 'Kiswahili', 'sw', 0],
	    ['Swedish', 'Svenska', 'sv', 0],
	    ['Tajik', 'Тоҷикистон', 'tg', 0],
	    ['Tamil', 'தமிழ்', 'ta', 0],
	    ['Telugu', 'తెలుగు', 'te', 0],
	    ['Thai', 'ภาษาไทย', 'th', 0],
	    ['Turkish', 'Türkçe', 'tk', 0],
	    ['Ukrainian', 'Український', 'uk', 0],
	    ['Urdu', 'اردو', 'ur', 0],
	    ['Uzbek', "O'zbekiston", 'uz', 0],
	    ['Vietnamese', 'Tiếng Việt', 'vi', 0],
	    ['Walloon', 'Walon', 'wa', 0],
	    ['Welsh', 'Cymraeg', 'cy', 0],
	    ['Wolof', 'Wollof', 'wo', 0],
	    ['Xhosa', 'isiXhosa', 'xh', 0],
	    ['Yiddish', 'ייִדיש', 'yi', 0],
	    ['Yoruba', 'Yorùbá', 'yo', 0],
	    ['Zulu', 'isiZulu', 'zu', 0],
	    ['American Sign Language', 'ASL', 'sgn', 0],
	], $tableOptions);
    }

    public function down() {

	$this->dropTable('{{%languages}}');
    }

}
