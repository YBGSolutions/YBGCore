<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plugins".
 *
 * @property int $id
 * @property string $plugin_name
 * @property string|null $desc
 * @property string|null $author
 * @property int|null $state
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Plugins extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plugins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plugin_name'], 'required'],
            [['desc'], 'string'],
            [['state'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['plugin_name', 'author'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plugin_name' => 'Plugin Name',
            'desc' => 'Desc',
            'author' => 'Author',
            'state' => 'State',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
