<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\exception\UploadException;
use app\common\library\Upload;
use think\Config;

class Index extends Frontend {

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function my() {
        $uid = \think\Cookie::get("uid");
        $nes_list = \app\admin\model\mao\Info::order("create_time desc")->where("uid", $uid)->limit(10)->select();
        $this->view->assign("nes_list", $nes_list);
        return $this->view->fetch();
    }

    public function index() {
        $count = number_format(\app\admin\model\mao\Info::count());
        $city_list = \app\admin\model\mao\Info::group("city_id")->field("count(*) count,city,city_id")->order("count desc")->limit(12)->select();
        $nes_list = \app\admin\model\mao\Info::order("create_time desc")->limit(10)->select();
        $this->view->assign("count", $count);
        $this->view->assign("city_list", $city_list);
        $this->view->assign("nes_list", $nes_list);
        return $this->view->fetch();
    }

    public function edit() {
        $uid = \think\Cookie::get("uid");
        $sn = $this->request->param("sn");
        $info = \app\admin\model\mao\Info::where("sn", $sn)->where("uid", $uid)->find();
        if ($this->request->isPost()) {
            $params = $this->request->post();
            $mao_pic = $this->request->file('mao_pic');
            if (!empty($mao_pic)) {
                $upload = new Upload($mao_pic);
                $mao_attachment = $upload->upload();
                $params['mao_pic'] = $mao_attachment->url;
            }
            $wx_pic = $this->request->file('wx_pic');
            if (!empty($wx_pic)) {

                $upload = new Upload($wx_pic);
                $wx_attachment = $upload->upload();
                $params['wx_pic'] = $wx_attachment->url;
            }
            $params['uid'] = $uid;
            $params['sn'] = md5(uniqid(time(), true));
            try {
                $model = $info;
                $model->validateFailException(true)->validate(\app\admin\validate\mao\Info::class);
                $result = $model->allowField(true)->save($params);
            } catch (\Exception $exc) {
                $this->error($exc->getMessage());
            }
            if ($result !== false) {
                $this->success("提交成功", url('cat', ['sn' => $model->sn]));
            } else {
                $this->error(__('No rows were inserted'));
            }
            exit;
        }
        $this->view->assign("info", $info);
        return $this->view->fetch();
    }

    public function cat() {
        \think\Lang::load(APP_PATH . 'admin/lang/zh-cn/mao/info.php');
        $sn = $this->request->param("sn");
        $info = \app\admin\model\mao\Info::where("sn", $sn)->find();
        $this->view->assign("info", $info);
        return $this->view->fetch();
    }

    public function post() {
        $uid = \think\Cookie::get("uid");
        if (empty($uid)) {
            $uid = md5(uniqid(time(), true));
            \think\Cookie::set("uid", $uid, 3600 * 24);
        }
        if ($this->request->isPost()) {
            $params = $this->request->post();
            $mao_pic = $this->request->file('mao_pic');
            $upload = new Upload($mao_pic);
            $mao_attachment = $upload->upload();
            $params['mao_pic'] = $mao_attachment->url;
            $wx_pic = $this->request->file('wx_pic');
            $upload = new Upload($wx_pic);
            $wx_attachment = $upload->upload();
            $params['wx_pic'] = $wx_attachment->url;
            $params['uid'] = $uid;
            $params['sn'] = md5(uniqid(time(), true));
            try {
                $model = new \app\admin\model\mao\Info();
                $model->validateFailException(true)->validate(\app\admin\validate\mao\Info::class);
                $result = $model->allowField(true)->save($params);
            } catch (\Exception $exc) {
                $this->error($exc->getMessage());
            }
            if ($result !== false) {
                $this->success("提交成功", url('cat', ['sn' => $model->sn]));
            } else {
                $this->error(__('No rows were inserted'));
            }
            exit;
        }
        return $this->view->fetch();
    }

}
