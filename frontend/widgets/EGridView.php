<?php
namespace frontend\widgets;

use yii\grid\GridView;
use yii\Helpers\Html;
use yii\base\InvalidConfigException;

class EGridView extends GridView
{
	public $add_url = '';
	public $edit_url = '';
	public $delete_url = '';
	
	 /**
     * Renders the data models for the grid view.
     */
    public function renderItems()
    {
        $caption = $this->renderCaption();
        $columnGroup = $this->renderColumnGroup();
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
        $tableEditableRow = $this->renderEditableRow($this->add_url);
        $tableBody = $this->renderTableBody();
        $tableFooter = $this->showFooter ? $this->renderTableFooter() : false;
        $content = array_filter([
            $caption,
            $columnGroup,
            $tableHeader,
			$tableEditableRow,
            $tableFooter,
            $tableBody,
        ]);

        return Html::tag('table', implode("\n", $content), $this->tableOptions);
    }
	
	/**
     * Renders the table body.
     * @return string the rendering result.
     */
    public function renderTableBody()
    {
        $models = array_values($this->dataProvider->getModels());
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        foreach ($models as $index => $model) {
            $key = $keys[$index];
            if ($this->beforeRow !== null) {
                $row = call_user_func($this->beforeRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }

            $rows[] = $this->renderTableRow($model, $key, $index);

            if ($this->afterRow !== null) {
                $row = call_user_func($this->afterRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
        }

        if (empty($rows)) {
            $colspan = count($this->columns);

            return "<tbody class='editable-body'>\n<tr><td colspan=\"$colspan\">" . $this->renderEmpty() . "</td></tr>\n</tbody>";
        } else {
            return "<tbody class='editable-body'>\n" . implode("\n", $rows) . "\n</tbody>";
        }
    }
	
	/**
     * Renders a table row with the given data model and key.
     * @param mixed $model the data model to be rendered
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the model array returned by [[dataProvider]].
     * @return string the rendering result
     */
    public function renderTableRow($model, $key, $index)
    {
        $cells = [];
        /* @var $column Column */
        foreach ($this->columns as $column) {
			$name = $column->attribute;
            $cells[] = Html::tag('td', Html::input('text', $column->attribute, $model->$name, ['class'=>'editable-input','readonly'=>'readonly']));
        }
        if ($this->rowOptions instanceof Closure) {
            $options = call_user_func($this->rowOptions, $model, $key, $index, $this);
        } else {
            $options = $this->rowOptions;
        }
        $options['data-key'] = is_array($key) ? json_encode($key) : (string)$key;
		
        $options['data-url'] = $this->edit_url;
		
		//$eip = Html::tag('button', 'edit', ['class'=>'action-btn','data-url'=>$this->edit_url,'data-action'=>'edit']);
		
		$dip = Html::tag('button', 'delete', ['class'=>'action-btn','data-url'=>$this->delete_url,'data-action'=>'delete']);
		
		$cells[] = Html::tag('td',$dip);
		
		//$cells[] = Html::tag('td',$eip . $dip);
		
        return Html::tag('tr', implode('', $cells), $options);
    }
	
	/**
     * Renders the table header.
     * @return string the rendering result.
     */
    public function renderTableHeader()
    {
        $cells = [];
        foreach ($this->columns as $column) {
            /* @var $column Column */
            $cells[] = $column->renderHeaderCell();
        }
		$cells[] = Html::tag('th', 'Action');
        $content = Html::tag('tr', implode('', $cells), $this->headerRowOptions);
        if ($this->filterPosition == self::FILTER_POS_HEADER) {
            $content = $this->renderFilters() . $content;
        } elseif ($this->filterPosition == self::FILTER_POS_BODY) {
            $content .= $this->renderFilters();
        }

        return "<thead>\n" . $content . "\n</thead>";
    }
	
	/**
     * Renders the table editable row.
     * @return string the rendering result.
     */
    public function renderEditableRow()
    {
        $cells = [];
        foreach ($this->columns as $column) {
            /* @var $column Column */
            $cells[] = Html::tag('td', Html::input('text', $column->attribute));
        }
		$cells[] = Html::tag('td', Html::tag('button', 'add', ['class'=>'action-btn','data-url'=>$this->add_url,'data-action'=>'add']));
        $content = Html::tag('tr', implode('', $cells), ['class'=>'editable-row','data-del-url'=>$this->delete_url,'data-edit-url'=>$this->edit_url]);

        return "<thead>\n" . $content . "\n</thead>";
    }
}
