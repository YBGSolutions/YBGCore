<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "routes".
 *
 * @property int $id
 * @property string $route_url
 * @property int $is_active 0: disable, 1:enable
 * @property string $created_at
 * @property string|null $updated_at
 */
class Routes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'routes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route_url'], 'required'],
            [['is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['route_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route_url' => 'Route Url',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
