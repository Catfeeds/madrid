<?php

/**
 * This is the model class for table "plot_user".
 *
 * The followings are the available columns in table 'plot_user':
 * @property integer $id
 * @property string $name
 * @property string $pwd
 * @property string $url
 * @property string $token
 * @property integer $type
 * @property integer $expire
 * @property integer $deleted
 * @property integer $created
 * @property integer $updated
 */
class PlotUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plot_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, pwd, created', 'required'),
			array('type, expire, deleted, created, updated', 'numerical', 'integerOnly'=>true),
			array('name, pwd, url, token', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, pwd, url, token, type, expire, deleted, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'pwd' => 'Pwd',
			'url' => 'Url',
			'token' => 'Token',
			'type' => 'Type',
			'expire' => 'Expire',
			'deleted' => 'Deleted',
			'created' => 'Created',
			'updated' => 'Updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('pwd',$this->pwd,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('expire',$this->expire);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlotUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
