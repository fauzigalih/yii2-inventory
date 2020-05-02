<?php
namespace app\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\StringHelper;

class ToolbarFilterButton extends Widget
{
    public $model;
    public $modalId = "#search-modal";
    public $btnSize;

    /**
     * {@inheritdoc}
     */
    
    public function run()
    {
        $isFiltered = false;
        if ($this->model->getDirtyAttributes()) {
            $modelName = StringHelper::basename(get_class($this->model));
            $filterModelData = Yii::$app->request->get($modelName);
            if ($filterModelData) {
                foreach ($filterModelData as $key => $value) {
                    if (!empty($value)) {
                        $isFiltered = true;
                    }
                }
            }
        }
        if ($isFiltered) {
            $filterBadge = '<span class="filter-badge" style="color: red">&#9728</span>';
        } else {
            $filterBadge = "";
        }

        if (!isset($this->options['class']))
        {
            $this->options['class'] = '';
        }
        
        $this->options['class'] .= " btn $this->btnSize btn-default";
        
        return Html::a('<i class="glyphicon glyphicon-filter"></i>' . $filterBadge, '#', array_merge([
            'title' => 'Filter',
            'data-toggle' => 'modal',
            'data-target' => $this->modalId
        ], $this->options));
    }
}
