<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use app\index\model\News as NewsModel;
use app\index\model\Banners as BannerModel;

class Info extends Controller
{
    public function __construct(){
        header("Access-Control-Allow-Origin:*");
    }
    public function news(){
        $page = input('page', '');
        $page_size = input('page_size', '');
        $content = input('content', 1);

        if(!is_numeric($page) || !is_numeric($page_size) || !is_numeric($content)) return json(['success' => 0, 'err_msg' => '参数格式错误']);

        $field = $content ? 'news_id, title, time, content' : 'news_id, title, time';
        $page_num = ceil(Db::table('news')->where('status', 1)->count('news_id') / $page_size);
        $result = Db::table('news')->where('status', 1)->order('time desc')->page($page, $page_size)->field($field)->select();

        return json([
            'success' => 1,
            'page' => $page,
            'page_size' => $page_size,
            'page_num' => $page_num,
            'news' => $result,
        ]);
    }

    public function anews(){
        $news_id = input('news_id/a', '');
        if($news_id == '' || !is_array($news_id)) return json(['success' => 0, 'err_msg' => '参数格式错误']);
        $result = array();
        foreach($news_id as $value){
            if(!is_numeric($value)) return ['success' => 0, 'err_msg' => '参数格式错误'];
            $a = Db::table('news')->where('status', 1)->where('news_id', $value)->field('news_id, title, time, content')->select();
            array_push($result, $a[0]);
        }

        return json([
            'success' => 1,
            'news' => $result,
        ]);
    }

    public function banners(){
        $result = Db::table('banners')->where('status', 1)->order('zdex desc')->field('banner_id, title, time, zdex, content, jump_url, img_url')->select();
        return json([
            'success' => 1,
            'banners' => $result,
            'banner_num' => count($result),
        ]);
    }
}
