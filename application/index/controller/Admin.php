<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Admin extends Controller{
    private function checkLogin(){
        if(session('userid') != 'kunmingchi') $this->error('尚未登陆','Admin/login');
    }

    public function login(){
        return view('login');
    }

    public function logout(){
        session('userid', '');
        $this->success('注销成功');
    }

    public function loginSubmit(){
        if(!(input('username') == 'kunmingchi' && input('password') == 'kunmingchi'))
            $this->error('用户名或密码错误');
        session('userid', 'kunmingchi');
        $this->success('登陆成功', 'Admin/index');
    }

    public function index(){
        $this->checkLogin();
        $this->assign('active', 1);
        return $this->fetch('header').$this->fetch('left').$this->fetch('message');
    }

    public function banner(){
        $this->checkLogin();
        $this->assign('active', 2);
        return $this->fetch('header').$this->fetch('left').$this->fetch('banner');
    }

    public function changeNews(){
        $this->checkLogin();
        $id = input('news_id', 0);
        $data['title'] = input('title', '');
        $data['content'] = input('content', '');
        if($data['title'] == '' || $data['content'] == null) return json(['success' => 0, 'err_msg' => '缺少必要参数！']);
        $data['status'] = 1;
        $data['time'] = date("Y-m-d",time());
        if($id == 0){
            Db::table('news')->insert($data);
        }
        else{
            Db::table('news')->where('news_id',$id)->update($data);
        }
        return json(['success' => 1]);
    }

    public function deleteNews(){
        $this->checkLogin();
        $id = input('news_id', '');
        if(!is_numeric($id)) return json(['success' => 0, 'err_msg' => '参数格式错误！']);
        Db::table('news')->where('news_id',$id)->update(['status' => 0]);
        return json(['success' => 1]);
    }

    public function changeBanner(){
        $this->checkLogin();
        $id = input('banner_id', 0);
        $data['title'] = input('title', '');
        $data['content'] = input('content', '');
        $data['zdex'] = input('zdex', '');
        if($data['title'] == '' || $data['content'] == null || $data['zdex'] == 'null') return json(['success' => 0, 'err_msg' => '缺少必要参数！']);
        $data['jump_url'] = input('jump_url', '');
        $data['status'] = 1;
        $data['time'] = date("Y-m-d",time());
        $file = request()->file('image');
        if($file != null){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $data['img_url'] = DS.'public' . DS . 'uploads'. DS .date("Ymd",time()).DS.$info->getFilename();
            }else{
                return ['success' => 0, 'err_msg' => '上传失败！'];
            }    
        }  
        if($id == 0){
            Db::table('banners')->insert($data);
        }
        else{
            Db::table('banners')->where('banner_id',$id)->update($data);
        }
        return json(['success' => 1]);
    }

    public function deleteBanner(){
        $this->checkLogin();
        $id = input('banner_id', '');
        if(!is_numeric($id)) return ['success' => 0, 'err_msg' => '参数格式错误！'];
        Db::table('banners')->where('banner_id',$id)->update(['status' => 0]);
        return json(['success' => 1]);
    }
}
