<?php

/**
 * This is the model class for table "house".
 *
 * The followings are the available columns in table 'house':
 * @property integer $id
 * @property string $name
 * @property string $eng
 * @property integer $place
 * @property string $level
 * @property string $image
 * @property string $data_conf
 * @property string $content
 * @property integer $sort
 * @property integer $created
 * @property integer $updated
 */
class House extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'house';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, created', 'required'),
			array('place, sort, created, updated', 'numerical', 'integerOnly'=>true),
			array('name, eng, image', 'length', 'max'=>255),
			array('level', 'length', 'max'=>100),
			array('data_conf, content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, eng, place, level, image, data_conf, content, sort, created, updated', 'safe', 'on'=>'search'),
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
			'eng' => 'Eng',
			'place' => '地区',
			'level' => 'Level',
			'image' => 'Image',
			'data_conf' => 'Data Conf',
			'content' => 'Content',
			'sort' => 'Sort',
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
		$criteria->compare('eng',$this->eng,true);
		$criteria->compare('place',$this->place);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('data_conf',$this->data_conf,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('sort',$this->sort);
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
	 * @return House the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
