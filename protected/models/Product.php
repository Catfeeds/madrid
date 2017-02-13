<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $name
 * @property string $eng
 * @property integer $cid
 * @property integer $xl
 * @property integer $ptpz
 * @property string $price
 * @property integer $age
 * @property string $image
 * @property string $country
 * @property string $area
 * @property integer $house
 * @property string $content
 * @property integer $sort
 * @property string $data_conf
 * @property integer $status
 * @property integer $deleted
 * @property integer $created
 * @property integer $updated
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created', 'required'),
			array('cid, xl, ptpz, age, house, sort, status, deleted, created, updated', 'numerical', 'integerOnly'=>true),
			array('name, eng, image', 'length', 'max'=>255),
			array('price', 'length', 'max'=>20),
			array('country, area', 'length', 'max'=>100),
			array('content, data_conf', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, eng, cid, xl, ptpz, price, age, image, country, area, house, content, sort, data_conf, status, deleted, created, updated', 'safe', 'on'=>'search'),
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
			'cid' => '类型',
			'xl' => '系列',
			'ptpz' => '葡萄品种',
			'price' => 'Price',
			'age' => 'Age',
			'image' => 'Image',
			'country' => '产地',
			'area' => '产地',
			'house' => '酒庄',
			'content' => 'Content',
			'sort' => 'Sort',
			'data_conf' => 'Data Conf',
			'status' => 'Status',
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
		$criteria->compare('eng',$this->eng,true);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('xl',$this->xl);
		$criteria->compare('ptpz',$this->ptpz);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('house',$this->house);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('data_conf',$this->data_conf,true);
		$criteria->compare('status',$this->status);
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
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
