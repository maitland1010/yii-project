<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="<?=$container_class?>">
	<h2><?= Html::encode($title) ?></h2>
	<div class="images-box">
	<?php for($i = 0; $i < count($image_datas) && $i < $num_of_images; $i++){ ?>
		<img src="<?= Url::to(['index.php/site/fake-api-2','id'=>$image_datas[$i]->id]); ?>" alt="image" />
	<?php } ?>
	</div>
</div>