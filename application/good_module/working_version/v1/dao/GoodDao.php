<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/21 10:52
 *  文件描述 :  商品数据处理逻辑
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\dao;
use think\Db;
use app\good_module\working_version\v1\model\GoodModel;
use app\good_module\working_version\v1\model\StyleModel;

class GoodDao implements GoodInterface
{
    /**
     * 名  称 : goodCreate()
     * 功  能 : 添加商品信息到数据库
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['goodName']  => '商品名称'
     * 输  入 : (String) $post['goodPrice'] => '商品价格'
     * 输  入 : (String) $post['goodSales'] => '商品销量'
     * 输  入 : (String) $post['goodStyle'] => '{
     *              {"styleName":"规格名称","stylePrice":"规格价格"}
     *          }'
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/07/31 10:11
     */
    public function goodCreate($post)
    {
        // 启动事务
        Db::startTrans();
        try{
            // 实例化商品表数据模型
            $goodModel = new GoodModel();
            // 生成主键
            $goodindex = md5(uniqid().mt_rand(1,999999999));
            // 处理数据
            $goodModel->good_index = $goodindex;
            $goodModel->good_name  = $post['goodName'];
            $goodModel->good_seale = $post['goodSales'];
            // 写入数据
            $goodModel->save();

            return returnData('error','123');

            // 获取JSON数据
            $styleArr = json_decode($post['goodStyle'],true);

            // 实例化规格表模型
            $styleModel = new StyleModel();
            // 处理数据
            $list = [];
            foreach($styleArr as $k=>$v)
            {
                $list[] = [
                    'style_index' => $k.md5(uniqid().mt_rand(1,99999999)),
                    'good_index'  => $goodindex,
                    'style_name'  => $v['styleName'],
                    'style_price' => $v['stylePrice'],
                ];
            }
            // 保存到数据库
            $styleModel->saveAll($list);

            // 提交事务
            Db::commit();
            // 返回正确数据
            return returnData('success',$goodindex);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            // 返回正确数据
            return returnData('error','添加失败');
        }
    }
}