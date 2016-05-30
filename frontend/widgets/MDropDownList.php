<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

class MDropDownList extends Widget
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
        return 	$this->mDropDownList($this->name, $this->labelDropdown, $this->selection, $this->items, $this->options);
    }
	
	public static function mDropDownList($name, $labelDropdown = '',$selection = null, $items = [], $options = [])
    {
		if(isset($options['dropdown_type']) && $options['dropdown_type'] == 'normal'){
			return Html::DropDownList($name,$selection,$items,$options);
		}
        $selectOptions = static::renderMSelectOptions($name, $selection, $items);
		if(isset($options['class']) && strpos($options['class'], 'multiple-dropdown') === FALSE){
			$options['class'] .= ' multiple-dropdown ';
		}elseif(!isset($options['class'])){
			$options['class'] = ' multiple-dropdown ';
		}
		if(!empty($labelDropdown)){
			$labelDropdown = Html::tag('label', $labelDropdown);
		}
        return Html::tag('div', $labelDropdown . ' ' . Html::tag('ul', "\n" . $selectOptions . "\n"), $options);
    }
	
	public static function renderMSelectOptions($name, $selection, $items)
    {
        $lines = [];

        foreach ($items as $key => $value) {
			if(in_array($key,$selection)){
				$options['checked'] = true;
			} else { 
				$options['checked'] = false;
			}
			$lines[$key] = Html::tag('li', Html::input('checkbox', $name.'[]', $value, $options) . ' ' . $value);
        }

        return implode("\n", $lines);
    }
}
