Альтернативный yii\grid\ActionColumn для yii2
=================================

[English readme](https://github.com/microinginer/yii2-dropdown-action-column/blob/master/README.md)

##Настройки по умолчанию

```php
echo \yii\grid\GridView::widget([
    ...
    'columns'      => [
        ...
        [
            'class' => \microinginer\dropDownActionColumn\DropDownActionColumn::className(),
        ],
    ],
]);
```

![аналог yii\grid\ActionColumn дефолтные настройки](https://raw.githubusercontent.com/microinginer/yii2-dropdown-action-column/master/screenshots/default-buttons.png "аналог yii\grid\ActionColumn дефолтные настройки")


##Переопределенные кнопки

```php
echo \yii\grid\GridView::widget([
    ...
    'columns'      => [
        ...
        [
            'class' => \microinginer\dropDownActionColumn\DropDownActionColumn::className(),
            'items' => [
                [
                    'label' => 'View',
                    'url'   => ['view'],
                ],
                [
                    'label' => 'Export',
                    'url'   => ['expert'],
                ],
                [
                    'label'   => 'Disable',
                    'url'     => ['disable'],
                    'linkOptions' => [
                        'data-method' => 'post'
                    ],
                ],
            ]
        ],
    ],
]);
```

![аналог yii\grid\ActionColumn](https://raw.githubusercontent.com/microinginer/yii2-dropdown-action-column/master/screenshots/custom-buttons.png "аналог yii\grid\ActionColumn")


##Install

Предпочтительный способ установки [composer](http://getcomposer.org/download/).

Запустите комманду

```
php composer.phar require --prefer-dist microinginer/yii2-dropdown-action-column "dev-master"
```

или добавте

```json
"microinginer/yii2-dropdown-action-column": "dev-master"
```

в раздел `require` в вашем composer.json файле.