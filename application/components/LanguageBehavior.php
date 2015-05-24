<?

namespace app\components;

use Yii;
use \yii\web\Cookie;

class LanguageBehavior
{
    static  function handleLanguageBehavior()
    {
        $app = Yii::$app;
        $preferredLanguage = $app->request->getPreferredLanguage();

        if (isset($_GET['lang'])) {
            $lang = $_GET['lang'];
            if (!in_array($lang, array('en', 'ru')))
                $lang = 'ru';

            $app->language = $lang;
            $app->session->set('_lang', $lang);

            $cookie = new Cookie([
                'name' => '_lang',
                'value' => $lang,
                'expire' => time() + (3600 * 24 * 365), // (1 year)
                'domain' => '.' . $app->params['domain']
            ]);

            $app->response->cookies->add($cookie);
            $app->response->redirect($app->request->referrer ? $app->request->referrer : $app->homeUrl);

        } else if ($app->session->has('_lang'))
            $app->language = $app->session->get('_lang');

        else if (isset($app->request->cookies['_lang']))
            $app->language = $app->request->cookies['_lang']->value;

        else if (!in_array($preferredLanguage, array('', 'ru_ru', 'ru', 'be_by', 'uk_ua'))) {
            $app->language = 'en';
        }
    }
}