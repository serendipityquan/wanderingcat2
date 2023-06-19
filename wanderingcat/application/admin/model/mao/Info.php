<?php

namespace app\admin\model\mao;

use think\Model;


class Info extends Model
{

    

    

    // 表名
    protected $name = 'mao_info';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = "create_time";
    protected $updateTime = "update_time";
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'mao_sex_text',
        'mao_jy_text',
        'mao_ym_text',
        'create_time_text',
        'update_time_text'
    ];
    

    
    public function getMaoSexList()
    {
        return ['1' => __('Mao_sex 1'), '2' => __('Mao_sex 2'), '3' => __('Mao_sex 3')];
    }

    public function getMaoJyList()
    {
        return ['0' => __('Mao_jy 0'), '1' => __('Mao_jy 1')];
    }

    public function getMaoYmList()
    {
        return ['0' => __('Mao_ym 0'), '1' => __('Mao_ym 1')];
    }


    public function getMaoSexTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['mao_sex']) ? $data['mao_sex'] : '');
        $list = $this->getMaoSexList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getMaoJyTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['mao_jy']) ? $data['mao_jy'] : '');
        $list = $this->getMaoJyList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getMaoYmTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['mao_ym']) ? $data['mao_ym'] : '');
        $list = $this->getMaoYmList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getUpdateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['update_time']) ? $data['update_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setUpdateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
