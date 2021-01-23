<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menus".
 *
 * @property int $id
 * @property string|null $icon
 * @property string $menu_name
 * @property int $parent_id 0: Root
 * @property string $route_url
 * @property int $is_active
 * @property int $sort
 * @property string $created_at
 * @property string|null $updated_at
 */
class Menus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'is_active', 'sort'], 'integer'],
            [['route_url'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['icon', 'menu_name', 'route_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icon' => 'Icon',
            'menu_name' => 'Menu Name',
            'parent_id' => 'Parent ID',
            'route_url' => 'Route Url',
            'is_active' => 'Is Active',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
