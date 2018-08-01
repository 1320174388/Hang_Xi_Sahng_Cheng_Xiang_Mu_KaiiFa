<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/21 10:52
 *  文件描述 :  商品数据处理逻辑
 *  历史记录 :  -----------------------
 */
namespace app\collect_module\working_version\v1\dao;
use think\Db;
use app\collect_module\working_version\v1\model\CollectModel;
use app\collect_module\working_version\v1\model\GoodModel;
use app\collect_module\working_version\v1\model\PictureModel;
use app\collect_module\working_version\v1\model\StyleModel;

class CollectDao implements CollectInterface
{
    /**
     * 名  称 : collectCreate()
     * 功  能 : 添加个人收藏信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['userToken'] => '用户标识';
     * 输  入 : (String) $post['goodIndex'] => '商品标识';
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/08/01 10:14
     */
    public function collectCreate($post)
    {
        // 实例化收藏表数据模型
        $collectModel = new CollectModel();
        // 处理数据
        $collectModel->collect_index = md5(uniqid().mt_rand(1,999999999));
        $collectModel->user_token    = $post['userToken'];
        $collectModel->good_index    = $post['goodIndex'];
        $collectModel->collect_time  = time();
        // 保存数据
        $data = $collectModel->save();
        // 验证数据
        if(!$data) return returnData(
            'error',
            '添加失败'
        );
        // 返回正确数据
        return returnData('success','添加成功');
    }

    /**
     * 名  称 : collectGoodSelect()
     * 功  能 : 获取个人收藏商品数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['userToken'] => '用户标识';
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/08/01 11:35
     */
    public function collectGoodSelect($get)
    {
        // 获取表明
        $collectTable = config('v1_tableName.CollectTable');
        $goodTable    = config('v1_tableName.GoodTable');
        // 获取数据
        $list = CollectModel::where(
            'user_token',
            $get['userToken']
        )->leftJoin(
            $goodTable,
            "{$collectTable}.good_index = {$goodTable}.good_index"
        )->select()->toArray();
        // 判断是否有数据
        if(!$list) return returnData(
            'error',
            '当前没有收藏'
        );


        // 返回正确数据
        return returnData('success',$list);

    }

    /**
     * 名  称 : collectSelect()
     * 功  能 : 获取收藏信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['userToken'] => '用户标识';
     * 输  入 : (String) $get['goodIndex'] => '商品标识';
     * 输  出 : ['msg'=>'success','data'=>'返回信息']
     * 创  建 : 2018/08/01 10:53
     */
    public function collectSelect($get)
    {
        // 获取数据
        $res = CollectModel::where(
            'user_token',
            $get['userToken']
        )->where(
            'good_index',
            $get['goodIndex']
        )->select()->toArray();
        // 判断是否有数据
        if(!$res) return returnData(
            'error',
            '未收藏'
        );
        // 返回数据
        return returnData('success','已收藏');
    }
}