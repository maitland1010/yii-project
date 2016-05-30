<?php
use frontend\widgets\Files;
use frontend\widgets\EGridView;
use frontend\widgets\AutoCompleteInput;
use frontend\widgets\MDropDownList;
use frontend\widgets\EDropDownList;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\Helpers\Html;
use yii\Helpers\Url;
use yii\widgets\Pjax;

?>
<?= Files::widget([
					'restApiLink' => 'http://yii2.dahuasoft2008.com/frontend/web/index.php/site/fake-api',
					'title' => 'Test title',
				]) ?>
<?php $form = ActiveForm::begin(['id' => 'my-form']); ?>
<?= MDropDownList::widget(['name'=>'mdrop_down','labelDropdown'=>'Multiple Dropdown','selection'=>['a'],'items'=>['b' => '123','a' => 'a123'],'options'=>['class'=>'multiple-dropdown']]) ?>
<?= EDropDownList::widget(['name'=>'edrop_down','labelDropdown'=>'Editable Dropdown','selection'=>'','items'=>['children', 'child', 'chicken']]) ?>
<?= AutoCompleteInput::widget(['name'=>'auto_complete','ajaxUrl'=>'http://yii2.dahuasoft2008.com/frontend/web/index.php/site/fake-api-bis','labelInput'=>'Auto Complete Tags:','items'=>[['id'=>123,'value'=>'abc','color'=>'33CCFF'],['id'=>124,'value'=>'abc12','color'=>'66CCFF']]]) ?>
<br />
<?= Html::submitButton(); ?>
<?php ActiveForm::end(); ?>
<?= Breadcrumbs::widget([
    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
    'links' => [
        ['label' => '123', 'url' => ['controller/action']],
        ['label' => '123', 'url' => ['controller/action']],
        ['label' => '456', 'url' => ['controller/action']],
        ['label' => '456', 'url' => ['controller/action']],
    ],
]);
?>
<?= Breadcrumbs::widget([
    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
    'links' => [
        ['label' => 'test', 'url' => ['controller/action']],
        ['label' => 'test', 'url' => ['controller/action']],
        ['label' => 'thing', 'url' => ['controller/action']],
        ['label' => 'thing', 'url' => ['controller/action']],
    ],
]);
?>
<?php //$form_add = ActiveForm::begin(['id' => 'add-form','action' => ['index.php/test/add'],'method' => 'post']); ?>
<?php Pjax::begin(); ?>
<?php
echo EGridView::widget([
	'id' => 'egridview',
    'dataProvider' => $dataProvider,
	'add_url' => Url::toRoute('index.php/test/add'),
	'edit_url' => Url::toRoute('index.php/test/edit'),
	'delete_url' => Url::toRoute('index.php/test/delete'),
]);
?>
<?php Pjax::end(); ?>
<?php //ActiveForm::end(); ?>