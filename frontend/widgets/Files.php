<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

class Files extends Widget
{
	public $title = "";
	public $imageNumber = 10;
	public $containerClass = 'landing-widget';
	public $restApiLink;

    public function init()
    {
        parent::init();
		if ($this->restApiLink === null) {
            throw InvalidConfigException("a restApiLink is required");
        }
    }

    public function run()
    {
		$json = file_get_contents($this->restApiLink);
		$image_datas = json_decode($json);
		
        return $this->render('files', [ 'title' => $this->title, 
										'num_of_images' => $this->imageNumber,
										'container_class' => $this->containerClass,
										'image_datas' => $image_datas,
									]
							);
    }
}
