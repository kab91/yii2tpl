<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use app\components\Controller;
use app\models\Image;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\Request;

class ImageController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['upload'],
                'rules' => [
                    [
                        'actions' => ['upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        $this->layout = false;
        $this->request = Yii::$app->request;
    }

    public function actionGet($id)
    {
        if (isset(Yii::$app->params['images']['secret'])) {

            $key = $this->request->getQueryParam('k');
            if (!$key)
                throw new NotFoundHttpException('key required');

            $url = $this->request->getPathInfo();
            $url = '/'.$url;
            if (Image::getKey($url)!=$key)
                throw new BadRequestHttpException('bad key');
        }

        $img = Image::findOne($id); /* @var $img Image */

        if ($img) {
            $this->Process($img);
        } else {
            throw new BadRequestHttpException('bad image id');
        }
    }

    public function Process($image)
    {
        /* @var $image Image */
        $params=[];
        if($size = Yii::$app->request->getQueryParam('size'))
            $params['size']=$size;

        //TODO: other params

        if (isset(Yii::$app->imagesCache)) {
            $cache = Yii::$app->imagesCache;

            $rev = Yii::$app->request->getQueryParam('rev');
            $key = $this->request->getPathInfo() . '_rev_' . ($rev ? $rev : '0');

            if (false === ($result = $cache->get($key))) {
                $result = $image->resize($params);
                $cache->set($key, $result, Image::CACHE_TTL); //1 month
            }
        } else {
            $result = $image->resize($params);
        }

        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + Image::CACHE_TTL) . ' GMT');
        header('Pragma: ', '');
        header('Cache-Control: max-age=' . Image::CACHE_TTL . ', public');

        header('Content-Type: ' . $result['content_type'], true);
        echo $result['image'];
    }

    public function actionUpload() {
        $uploadImage = UploadedFile::getInstanceByName('file');

        if ($uploadImage && in_array($uploadImage->type, Image::$allowedMimes)) {
            $id = Image::upload(null, $uploadImage);

            echo Json::encode([
                'filelink' => Image::url($id, ['size' => 'large'])
            ]);
        } else {
            echo Json::encode([
                'error' => 'Wrong image type'
            ]);
        }
    }
}

