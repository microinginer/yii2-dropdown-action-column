<?php
/**
 * Created by PhpStorm.
 * User: inginer
 * Date: 03.09.15
 * Time: 17:55
 */

namespace microinginer\dropDownActionColumn;


use Yii;
use yii\grid\Column;
use yii\helpers\Html;

/**
 * Class DropDownActionColumn
 * @package app\components
 */
class DropDownActionColumn extends Column
{
    /**
     * @var string the ID of the controller that should handle the actions specified here.
     * If not set, it will use the currently active controller. This property is mainly used by
     * [[urlCreator]] to create URLs for different actions. The value of this property will be prefixed
     * to each action name to form the route of the action.
     */
    public $controller;

    /**
     * @var string the template used for composing each cell in the action column.
     * Tokens enclosed within curly brackets are treated as controller action IDs (also called *button names*
     * in the context of action column). They will be replaced by the corresponding button rendering callbacks
     * specified in [[buttons]]. For example, the token `{view}` will be replaced by the result of
     * the callback `buttons['view']`. If a callback cannot be found, the token will be replaced with an empty string.
     *
     * As an example, to only have the view, and update button you can add the ActionColumn to your GridView columns as follows:
     *
     * ```
     * ['class' => 'microinginer\yii2-dropdown-action-column', 'items' => ['label' => 'view', 'url' => ['update']]],
     * ```
     *
     */
    public $items = [

    ];

    public $visibleButtons = [];


    /**
     * @var bool
     */
    private $defaultItems = true;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init ()
    {
        $this->defaultItems = !$this->items;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent ($model, $key, $index)
    {
        $result = '';

        if ($this->defaultItems) {
            $this->items = [
                [
                    'label' => Yii::t('yii', 'Update'),
                    'url'   => ['update']
                ],
                [
                    'label' => Yii::t('yii', 'View'),
                    'url'   => ['view']
                ],
                [
                    'label' => Yii::t('yii', 'Delete'),
                    'url'   => ['delete'],
                    'linkOptions' => [
                        'data-method' => 'post'
                    ],
                ],
            ];
        }

        $firstKey = current(array_keys($this->items));
        $mainBtn = $this->items[ $firstKey ];

        $result .= Html::a($mainBtn['label'], array_merge($mainBtn['url'], [$model->primaryKey()[0] => $key]), array_merge(
                ['class' => 'btn btn-default btn-sm'],
                isset($mainBtn['linkOptions']) ? $mainBtn['linkOptions'] : [])
        );

        if (count($this->items) != 1) {
            $result .= Html::button(
                Html::tag('span', '', ['class' => 'caret']) .
                Html::tag('span', 'Toggle Dropdown', ['class' => 'sr-only']), [
                    'class'         => 'btn btn-default btn-sm dropdown-toggle',
                    'data-toggle'   => 'dropdown',
                    'aria-haspopup' => 'true',
                    'aria-expanded' => 'false',
                ]
            );

            $items = '';
            $firstElement = true;

            foreach ($this->items as $itemIndex => $item) {

                if (isset($this->visibleButtons[$itemIndex])) {
                    $isVisible = $this->visibleButtons[$itemIndex] instanceof \Closure
                        ? call_user_func($this->visibleButtons[$itemIndex], $model, $key, $index)
                        : $this->visibleButtons[$itemIndex];
                } else {
                    $isVisible = true;
                }
                if($isVisible){

                    if ($firstElement) {
                        $firstElement = false;
                        continue;
                    }

                    $items .= Html::tag(
                        'li',
                        Html::a(
                            $item['label'],
                            array_merge($item['url'], [$model->primaryKey()[0] => $key]),
                            (isset($item['linkOptions']) ? $item['linkOptions'] : [])
                        ),
                        (isset($item['options']) ? $item['options'] : []));
                }
            }
            $result .= Html::tag('ul', $items, ['class' => 'dropdown-menu dropdown-menu-right']);
        }

        return Html::tag('div', $result, ['class' => 'btn-group pull-right', 'style' => 'display: flex']);
    }
}
