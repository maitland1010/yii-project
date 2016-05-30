<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

class EDropDownList extends Widget
{
	public $name;
	public $labelDropdown = '';
	public $selection = null;
	public $items = [];
	public $options = [];

    public function init()
    {
        parent::init();
		if ($this->name === null) {
            throw InvalidConfigException("a name is required");
        }
    }

    public function run()
    {
        return 	$this->eDropDownList($this->name, $this->labelDropdown, $this->selection, $this->items, $this->options);
    }
	
	public static function eDropDownList($name, $labelDropdown = '', $selection = null, $items = [], $options = [])
    {
        $selectOptions = static::renderESelectOptions($items);
		if(isset($options['class']) && strpos($options['class'], 'editable-dropdown') === FALSE){
			$options['class'] .= ' editable-dropdown ';
		}elseif(!isset($options['class'])){
			$options['class'] = ' editable-dropdown ';
		}
		if(!empty($labelDropdown)){
			$labelDropdown = Html::tag('label', $labelDropdown);
		}
        return Html::tag('div', $labelDropdown . ' ' . Html::tag('div', '<span class="select-arrow"></span> ' . Html::input('text', $name, $selection,['autocomplete'=>'off']) . ' ' . Html::tag('ul', "\n" . $selectOptions . "\n", ['style'=>'display:none;']),['class'=>'selection-list']), $options);
    }
	
	public static function renderESelectOptions($items)
    {
        $lines = [];

        foreach ($items as $key => $value) {
			$lines[$key] = Html::tag('li', $value);
        }

        return implode("\n", $lines);
    }
}
