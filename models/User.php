<?php

  namespace app\models;

  use yii\db\ActiveRecord;
  /**
   * This is the model class for table "user".
   *
   * @property int $id
   * @property string $username
   * @property string $auth_key
   * @property string $password_hash
   * @property string|null $password_reset_token
   * @property string|null $phone
   * @property int $status
   * @property int $group_id
   * @property string $created_at
   * @property string|null $updated_at
   *
   * @property UserGroups $group
   */
  class User extends ActiveRecord implements \yii\web\IdentityInterface
  {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
      return 'user';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
      return [
        [['username', 'auth_key', 'password_hash'], 'required'],
        [['status', 'group_id'], 'integer'],
        [['created_at', 'updated_at'], 'safe'],
        [['username', 'password_hash', 'password_reset_token', 'phone'], 'string', 'max' => 255],
        [['auth_key'], 'string', 'max' => 32],
        [['username'], 'unique'],
        [['phone'], 'unique'],
        [['password_reset_token'], 'unique'],
        [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserGroups::className(), 'targetAttribute' => ['group_id' => 'id']],
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
      return [
        'id' => 'ID',
        'username' => 'Username',
        'auth_key' => 'Auth Key',
        'password_hash' => 'Password Hash',
        'password_reset_token' => 'Password Reset Token',
        'phone' => 'Phone',
        'status' => 'Status',
        'group_id' => 'Group ID',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
      ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
      return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
      return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
      return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
      return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
      return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
      return \Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }
  }