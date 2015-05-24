<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use app\components\Utils;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "{{images}}".
 *
 * The followings are the available columns in table '{{images}}':
 * @property integer $id
 * @property string $name
 * @property string $author
 * @property integer $size
 * @property string $mimetype
 * @property integer $revision
 * @property string $created_at
 * @property string $updated_at
 */
class Image extends ActiveRecord
{
    const CACHE_TTL = 2678400;

    const defaultWidth = 100;
    static $allowedMimes = array('image/jpeg','image/pjpeg', 'image/jpg', 'image/gif','image/png');
    static $sizes = [
        'small' => 100,
        'large' => 480,
        'full' => 1024,
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    public function checkMimeType($attribute, $params) {
        if (!in_array($this->{$attribute}, self::$allowedMimes))
            $this->addError($attribute, 'Неподдерживаемый тип изображения');
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'author' => 'Автор',
			'filesize' => 'Размер',
			'mimetype' => 'Mime-тип',
			'revision' => 'Версия',
			'created_at' => 'Дата создания',
		);
	}

    public function getFileName() {
		$levelsDir = Utils::getLevelsDirABC(Yii::$app->params['images']['storagePath'].'/images', $this->id);
		return $levelsDir.'/'.$this->id;
	}

    public function beforeDelete() {
        if(parent::beforeDelete()) {
            @unlink($this->getFileName());
        }
        return true;
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord)
            {
                $this->created_at=date('Y-m-d H:i:s');
            } else {
                $this->updated_at=date('Y-m-d H:i:s');
            }

            return true;
        }
        else
            return false;
    }

    public static function upload($id, $file, $name = null) {

        if (!$file) return null;

        $model = null !== $id ? Image::findOne($id) : null;

        if (null == $model) {
            $model = new Image();
        }

        if ($file instanceof UploadedFile) {
            /* @var $file UploadedFile */
            $model->name = $name ? $name : $file->name;
            $model->mimetype = $file->type;
            $model->size = $file->size;
        } else {
            $model->name = $name ? $name : $file;
            $model->mimetype = FileHelper::getMimeType($file);
            $model->size = filesize($file);
        }

        $model->revision++;
        if($model->save()) {
            if ($file instanceof UploadedFile) {
                $file->saveAs($model->getFileName());
            } else {
                rename($file, $model->getFileName());
            }
            return $model->id;
        }
        return false;
    }

    public static function url($id, $params = [], $default = '/i/empty.gif')
    {
        if (!$id) {
            return Yii::$app->params['staticUrl'] . $default;
        }

        if (isset($params['rev'])) {
            $rev = $params['rev'];
        } else {
            $img = Image::findOne($id); /* @var $img Image */
            $rev = $img->revision;
        }

        if (isset($params['size'])) {
            $size = $params['size'];
        } else {
            $size = 'small';
        }

        $url = Yii::$app->request->getBaseUrl() . '/image/' . $id;

        $url .= '-' . $size . '-' . $rev . '.jpg';

        if (isset(Yii::$app->params['images']['secret']))
            $url .= '?k=' . self::getKey($url);

        return $url;
    }

    static public function getKey($url) {
        return hash_hmac('md5', $url, Yii::$app->params['images']['secret']);
    }

    public function getWidth($size) {

        if(isset(Image::$sizes[$size])) {
            return Image::$sizes[$size];
        }

        return static::defaultWidth;
    }

    public function resize($params=array())
    {
        if (isset($params['size'])) {
            $width = $this->getWidth($params['size']);
        } else {
            $width = static::defaultWidth;
        }

        $filename = $this->getFileName();

        if (false === ($imagesize = @getimagesize($filename))) {
            throw new NotFoundHttpException('picture source file not found');
        }

        list ($image_x, $image_y, $image_type, $image_x_y_string) = $imagesize;

        ob_start();

        switch ($image_type) {
            case IMAGETYPE_JPEG:
                $im = ImageCreateFromJPEG($filename);
                break;
            case IMAGETYPE_PNG:
                $im = ImageCreateFromPNG($filename);
                break;
            case IMAGETYPE_GIF:
                $im = ImageCreateFromGIF($filename);
                break;
        }

        if (isset($params['longestside'])) {
            if ($image_x > $image_y) {
                $image_small_x = $width;
                $image_small_y = round($image_small_x * $image_y / $image_x);
            } else {
                $image_small_y = $width;
                $image_small_x = round($image_small_y * $image_x / $image_y);
            }
        } else {
            $image_small_x = $width;
            $image_small_y = $image_small_x * $image_y / $image_x;
        }

        if (isset($params['crop'])) { //кропнем кватрат по центру
            if ($image_x > $image_y) {
                $crop_size = $image_y;
            } else {
                $crop_size = $image_x;
            }

            $tlx = floor($image_x / 2) - floor($crop_size / 2);
            $tly = floor($image_y / 2) - floor($crop_size / 2);

            $im_croped = imagecreatetruecolor($crop_size, $crop_size);
            $this->_saveAlpha($im_croped);

            imagecopy($im_croped, $im, 0, 0, $tlx, $tly, $crop_size, $crop_size);
            $im_new = ImageCreateTrueColor($width, $width);
            $this->_saveAlpha($im_new);
            imagecopyresampled($im_new, $im_croped, 0, 0, 0, 0, $width, $width, imagesx($im_croped), imagesy($im_croped));
        } else {
            $im_new = ImageCreateTrueColor($image_small_x, $image_small_y);
            $this->_saveAlpha($im_new);
            imagecopyresampled($im_new, $im, 0, 0, 0, 0, $image_small_x, $image_small_y, $image_x, $image_y);
        }

        //watermark
        //if($width>200)
        //    $im_new = $this->_watermark($im_new, $image_small_x, $image_small_y);

        imagejpeg($im_new, null, 90);

        $content_type = 'image/jpeg';

        $final_image = ob_get_contents();

        ob_end_clean();

        return array('image' => $final_image, 'content_type' => $content_type);
    }

    private function _saveAlpha($img)
    {
        imagesavealpha($img, true);
        imagealphablending($img, true);
        $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0, 0, $transparent);
    }

    private function _watermark($im_new, $x, $y) {
        $text = 'xxx';
        $marge_right = 0;
        $marge_bottom = 10;
        $sx = 180;
        $sy = 20;

        $stamp = imagecreatetruecolor($sx, $sy);

        imagesavealpha($stamp, true);
        $white = imagecolorallocate($stamp, 255, 255, 255);
        $grey = imagecolorallocate($stamp, 128, 128, 128);
        $trans_colour = imagecolortransparent($stamp, $white);
        imagefill($stamp, 0, 0, $trans_colour);
        imagestring($stamp, 5, 0, 0, $text, $grey);
        imagecopymerge($im_new, $stamp, $x - $sx - $marge_right, $y - $sy - $marge_bottom, 0, 0, $sx, $sy, 60);

        return $im_new;
    }
}