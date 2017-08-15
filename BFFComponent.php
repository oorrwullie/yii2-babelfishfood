<?php

namespace oorrwullie\babelfishfood\components;

use Yii;
use yii\base\Component;
use yii\web\Cookie;
use oorrwullie\babelfishfood\models\Languages;

/**
 * Component.
 * 
 * Example:
 * 
 *
 * Complete example:
 * 
 * ~~~
 * in common/config/main.php:
 *
 * 'components' => [
 *      'babelfishfood' => [
 *          'class' => 'oorrwullie\babelfishfood\components\BFFComponent',
 *          'cookieName' => 'language',                     // Name of the cookie.
 *          'cookieDomain' => 'example.com',                // Domain of the cookie.
 *          'expireDays' => 64,                             // The expiration time of the cookie is 64 days.
 *          'callback' => function() {
 *              if (!\Yii::$app->user->isGuest) {
 *                  $user = \Yii::$app->user->identity;
 *                  $user->language = \Yii::$app->language;
 *                  $user->save();
 *              }
 *          }
 *      ]
 * ]
 * ~~~
 * 
 * ~~~
 * in frontend/config/main.php (minimum):
 * in backend/config/main.php (optional):
 *
 * 'language' => 'en',
 * 'bootstrap' => ['babelfishfood'],
 * ~~~
 *
 * @BFFComponent is a modified version of the yii2-languagepicker component by 
 * @Molnar <lajax.m@gmail.com>
 */
class BFFComponent extends Component {
    
    /**
     * @var function - function to execute after changing the language of the site.
     */
    public $callback;

    /**
     * @var integer expiration date of the cookie storing the language of the site.
     */
    public $expireDays = 30;

    /**
     * @var string Name of the cookie.
     */
    public $cookieName = 'language';

    /**
     * @var string The domain that the language cookie is available to.
     * For details see the $domain parameter description of PHP setcookie() function.
     */
    public $cookieDomain = '';

    /**
     * @var array List of available languages
     */
    public $languages;

    /**
     * @inheritdoc
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = array()) {

        if (empty($config['languages'])) {
            $config['languages'] = Languages::getLPL();
        } else if (is_callable($config['languages'])) {
            $config['languages'] = Languages::getLPL();
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init() {

        $this->initLanguage();

        parent::init();
    }

    /**
     * Setting the language of the site.
     */
    public function initLanguage() {

        if (isset($_GET['babelFishFood'])) {
            if ($this->_isValidLanguage($_GET['babelFishFood'])) {
                return $this->saveLanguage($_GET['babelFishFood']);
            } else if (!Yii::$app->request->isAjax) {
                return $this->_redirect();
            }
        } else if (Yii::$app->request->cookies->has($this->cookieName)) {
            if ($this->_isValidLanguage(Yii::$app->request->cookies->getValue($this->cookieName))) {
                Yii::$app->language = Yii::$app->request->cookies->getValue($this->cookieName);
                return;
            } else {
                Yii::$app->response->cookies->remove($this->cookieName);
            }
        }

        $this->detectLanguage();
    }

    /**
     * Saving language into cookie and database.
     * @param string $language - The language to save.
     * @return static
     */
    public function saveLanguage($language) {
        Yii::$app->language = $language;
        $this->saveLanguageIntoCookie($language);

        if (is_callable($this->callback)) {
            call_user_func($this->callback);
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->end();
        }

        return $this->_redirect();
    }

    /**
     * Determine language based on UserAgent.
     */
    public function detectLanguage() {

	if(!empty(Yii::$app->request->queryParams['lang'])) {
	    $userAgentLanguages[] = Yii::$app->request->queryParams['lang'];
	} else {
	    $userAgentLanguages = Yii::$app->getRequest()->getAcceptableLanguages();
	}

	if(empty($userAgentLanguages)){
		$userAgentLanguages[] = 'en';
	}

	foreach ($userAgentLanguages as $language) {
	    $lang = substr($language, 0, 2);    
	    if ($lang == 'zh') {
		$lang =  substr($language, 0, 5);
		if ($lang == "zh-CN") {
		    $lang = 'zh-hans';
		}
		elseif ($lang == "zh-SG") {
		    $lang = 'zh-hans';
		} else {
		    $lang = 'zh-hant';
		}
	    }
	    elseif ($lang == 'fi') {
		$lang = 'tl';
	    }

	    $acceptableLanguages[] = $lang;

	    if (empty($acceptableLanguages)) {
		$acceptableLanguages[] = 'en';
	    }
	}

        foreach ($acceptableLanguages as $language) {
            if ($this->_isValidLanguage($language)) {
                Yii::$app->language = $language;
                $this->saveLanguageIntoCookie($language);
                return;
            }
	}

        foreach ($acceptableLanguages as $language) {
            $pattern = preg_quote(substr($language, 0, 2), '/');
            foreach ($this->languages as $key => $value) {
                if (preg_match('/^' . $pattern . '/', $value) || preg_match('/^' . $pattern . '/', $key)) {
		    Yii::$app->language = $this->_isValidLanguage($key) ? $key : $value;
                    $this->saveLanguageIntoCookie(Yii::$app->language);
                    return;
                }
            }
        }
    }

    /**
     * Save language into cookie.
     * @param string $language
     */
    public function saveLanguageIntoCookie($language) {

        $cookie = new Cookie([
            'name' => $this->cookieName,
            'domain' => $this->cookieDomain,
            'value' => $language,
            'expire' => time() + 86400 * $this->expireDays
        ]);

        Yii::$app->response->cookies->add($cookie);
    }

    /**
     * Redirects the browser to the referer URL.
     * @return static
     */
    private function _redirect() {
        $redirect = Yii::$app->request->absoluteUrl == Yii::$app->request->referrer ? '/' : Yii::$app->request->referrer;
        return Yii::$app->response->redirect($redirect);
    }

    /**
     * Determines whether the language received as a parameter can be processed.
     * @param string $language
     * @return boolean
     */
    private function _isValidLanguage($language) {
        return is_string($language) && (isset($this->languages[$language]) || in_array($language, $this->languages));
    }

}
