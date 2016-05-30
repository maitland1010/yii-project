<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

class AutoCompleteInput extends Widget
{
	public $name;
	public $ajaxUrl;
	public $labelInput = '';
	public $items = [];
	public $options = [];

    public function init()
    {
        parent::init();
		if ($this->name === null) {
            throw InvalidConfigException("a name is required");
        }
		if ($this->ajaxUrl === null) {
            throw InvalidConfigException("a ajaxUrl is required");
        }
    }

    public function run()
    {
        return 	$this->autoCompleteInput($this->name, $this->ajaxUrl, $this->labelInput, $this->items, $this->options);
    }
	
	public static function autoCompleteInput($name, $ajaxUrl, $labelInput = '', $items = [], $options = []){
		if(!empty($labelInput)){
			$labelInput = Html::tag('label', $labelInput);
		}
		if(isset($options['class']) && strpos($options['class'], 'editable-dropdown') === FALSE){
			$options['class'] .= ' autocomplete-box ';
		}elseif(!isset($options['class'])){
			$options['class'] = ' autocomplete-box ';
		}
		$renderInputs = static::renderInputs($name, $items);
		$json = file_get_contents($ajaxUrl);
		$data_items = json_decode($json);
		$autoCompleteOptions = static::renderAutoCompleteOptions($data_items);
		return Html::tag('div', $labelInput . ' ' . Html::tag('div', $renderInputs . ' ' . Html::input('text','','',['class'=>'at-input','data-name'=>$name,'autocomplete'=>'off']) . ' ' . Html::tag('ul', "\n" . $autoCompleteOptions . "\n", ['style'=>'display:none;','data-name'=>$name])), $options);
	}
	
	public static function renderInputs($name, $items)
    {
        $lines = [];

        foreach ($items as $key => $item) {
			$id = (isset($item['id'])) ? $item['id'] : 0;
			$val = (isset($item['value'])) ? $item['value'] : '';
			$color = (isset($item['color'])) ? $item['color'] : '33CCFF';
			$lines[$key] = Html::tag('div', Html::input('text', $name.'['.$id.']', $val,['readonly'=>'readonly','style'=>'width:'.(strlen($val)*10).'px']) . '<span>&times;</span>', ['class'=>'tag','style'=>'background-color:#'.$color.';width:'.(strlen($val)*10+25).'px']);
        }

        return implode("\n", $lines);
    }
	
	public static function renderAutoCompleteOptions($items)
    {
        $lines = [];

        foreach ($items as $key => $item) {
			$lines[$key] = Html::tag('li', $item->value, ['id'=> 'tag-'.$item->id,'data-id'=>$item->id,'data-color'=>$item->color]);
        }

        return implode("\n", $lines);
    }
}
