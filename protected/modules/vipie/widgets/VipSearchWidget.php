<?php

/**
 * User: fanqi
 * Date: 2016/9/6
 * Time: 16:06
 * 搜索器UI组件
 */
class VipSearchWidget extends CWidget
{
    private $type;
    private $value;
    private $time;
    private $time_type;
    private $hid;
    private $sort;
    private $staff;
    private $category;    

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $staff
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @param mixed $time_type
     */
    public function setTime_type($time_type)
    {
        $this->time_type = $time_type;
    }

    /**
     * @param mixed $hid
     */
    public function setHid($hid)
    {
        $this->hid = $hid;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }
    private $plots;

    /**
     * @param mixed $plots
     */
    public function setPlots($plots)
    {
        $this->plots = $plots;
    }

    /**
     * @param mixed $SearchForm
     */

    public function run()
    {
        $this->render('search', [
            'type' => $this->type,
            'value' => $this->value,
            'time' => $this->time,
            'time_type' => $this->time_type,
            'hid' => $this->hid,
            'plots' => $this->plots,
            'sort' => $this->sort,
            'staff' => $this->staff,
            'category' => $this->category,

        ]);
    }
}