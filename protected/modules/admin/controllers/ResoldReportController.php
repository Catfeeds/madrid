<?php

/**
 * User: fanqi
 * Date: 2016/8/29
 * Time: 10:15
 * 房源举报列表
 */
class ResoldReportController extends AdminController
{
    public function ActionList($time = "",  $deal = "", $type = "")
    {
        $criteria = new CDbCriteria([
            'order' => 'created desc'
        ]);
        //添加时间、刷新时间筛选
        if( $time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition("created>=:beginTime");
            $criteria->addCondition("created<:endTime");
            $criteria->params[':beginTime'] = TimeTools::getDayBeginTime($beginTime);
            $criteria->params[':endTime'] = TimeTools::getDayEndTime($endTime);

        }
        //处理状态
        if ($deal != "") {
            $criteria->addCondition("deal=:deal");
            $criteria->params[':deal'] = $deal;
        }
        //房源类型
        if ($type != "") {
            $criteria->addCondition("type=:type");
            $criteria->params[':type'] = $type;
        }
        $dataProvider = ResoldReportExt::model()->getList($criteria);
        $this->render('list', [
            'models' => $dataProvider->data,
            'pager' => $dataProvider->pagination,
            'time' => $time,
            // 'end_time' => $end_time,
            'deal' => $deal,
            'type' => $type
        ]);
    }

    /**
     * 删除举报
     */
    public function ActionAjaxDel()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getPost('id', 0);
            $list = ResoldReportExt::model()->findByPk($id);
            if ($list && $list->delete()) {
                $this->setMessage('删除成功！', 'success');
            } else {
                $this->setMessage('删除失败！', 'error');
            }
        }
    }

    /**
     * 房源举报处理页面展示
     */
    public function ActionHandle($id = 0)
    {
        if ($id) {
            $report = ResoldReportExt::model()->findByPk($id);
            $source = $report->getSource();
            $this->render("handle", [
                'report' => $report,
                'source' => $source
            ]);
        }
    }

    /**
     * 房源举报处理
     */
    public function ActionAjax()
    {
        if (Yii::app()->request->isPostRequest) {
            //获取举报信息ID
            $id = Yii::app()->request->getPost('id', 0);
            //获取信息处理方式
            $way = Yii::app()->request->getPost('way', 0);
            if ($id) {
                $report = ResoldReportExt::model()->findByPk($id);
                $source = $report->getSource();
                $flag = 0;
                if ($source) {
                    if ($way == "sold_out") {
                        $saleStatus = Yii::app()->params['saleStatus'];
                        $saleStatus = array_flip($saleStatus);
                        if($report->type==1 || $report->type==3)
                            $source->sale_status = $saleStatus["下架"];
                    } elseif ($way == "delete") {
                        $source->deleted = 1;
                    }
                }
                if ($source->save()) {
                    $flag = 1;
                    $report->deal = 1;
                }
            }
            if ($flag && $report->save()) {
                $this->setMessage('操作成功', 'success');
            } else {
                $this->setMessage('操作失败', 'error');
            }
        }
    }
}