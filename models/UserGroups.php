<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_groups".
 *
 * @property int $id
 * @property string $name
 * @property string|null $desc
 */
class UserGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
        ];
    }
}
