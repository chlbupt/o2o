<?php
namespace app\bis\controller;
use app\common\model\BisAccount as BisAccountModel;
use app\common\model\BisLocation as BisLocationModel;
use app\extend\Map;
use app\extend\phpmailer\Email;
use think\Controller;
use app\common\model\City as CityModel;
use app\common\model\Category as CategoryModel;
use app\common\model\Bis as BisModel;

class Register extends Controller
{
    public function index(){
        $cities = CityModel::where([
            'status' => 1,
            'parent_id' => 0,
        ])->order('id', 'desc')->select();
        $categorys = CategoryModel::where([
            'status' => 1,
            'parent_id' => 0,
        ])->order('id', 'desc')->select();
        return view()->assign(compact('cities', 'categorys'));
    }

    public function  add(){
        if(!request()->isPost()){
            $this->error('请求错误');
        }
        $data = input('post.');
        file_put_contents('log.txt', json_encode($data), FILE_APPEND);
        $validate = validate('Bis');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $lngLat = Map::getLngLat($data['address']);
        if(!$lngLat || $lngLat['status'] != 0 || $lngLat['result']['precise'] != 1){
            $this->error('无法获取数据或者匹配的地址不精准');
        }

        $result = BisAccountModel::get(['username' => $data['username']]);
        if($result){
            $this->error('该用户已存在，请重新分配');
        }

        $bisData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id'] :  $data['city_id'].','.$data['se_city_id'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => empty($data['description']) ?  '' :  $data['description'],
            'bank_info' => $data['bank_info'],
            'bank_user' => $data['bank_user'],
            'bank_name' => $data['bank_name'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
            'email' => $data['email'],
        ];
        $BisInfo = BisModel::create($bisData);
        $bisId = $BisInfo->id;

        // 总店相关信息
        $data['cat'] = '';
        if(isset($data['se_category_id']) && $data['se_category_id']){
            $data['cat'] = implode('|', $data['se_category_id']);
        }
        $locationData = [
            'bis_id' => $bisId,
            'name' => $data['name'],
            'tel' => $data['tel'],
            'contact' => $data['contact'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'] . ',' . $data['cat'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id'] :  $data['city_id'].','.$data['se_city_id'],
            'api_address' => $data['address'],
            'open_time' => $data['open_time'],
            'content' => empty($data['content']) ? '' : $data['content'],
            'is_main' => 1,
            'xpoint' => empty($lngLat['result']['location']['lng']) ? '' : $lngLat['result']['location']['lng'],
            'ypoint' => empty($lngLat['result']['location']['lat']) ? '' : $lngLat['result']['location']['lat'],
        ];
        BisLocationModel::create($locationData);

        // 账户相关信息
        $data['code'] = mt_rand();
        $accountData = [
            'bis_id' => $bisId,
            'username' => $data['username'],
            'code' => $data['code'],
            'is_main' => 1,
            'password' => md5($data['password'].$data['code']),
        ];
        $info = BisAccountModel::create($accountData);
        if(!$info){
            $this->error('申请失败');
        }

        // 发送邮件
        $url = request()->domain().url('bis/register/waiting', ['id' => $bisId]);
        $title = 'o2o入驻申请通知';
        $content = '您提交的入驻申请需等待平台方审核，您可以通过点击<a href="'.$url.'" target="_blank">查看链接</a>查看审核状态';
        Email::send($data['email'], $title, $content);

        $this->success('申请成功', url('register/waiting', ['id' => $bisId]));
    }

    public function waiting($id){
        if(empty($id)){
            $this->error('error');
        }
        $detail = BisModel::get($id);
        return view()->assign(compact('detail'));
    }
}