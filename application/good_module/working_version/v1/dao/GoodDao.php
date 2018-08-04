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
use app\good_module\working_version\v1\model\PictureModel;
use app\good_module\working_version\v1\model\CriticModel;
use app\assortment_module\working_version\v1\model\GoodsClassModel;

class GoodDao implements GoodInterface
{
    /**
     * 名  称 : goodCreate()
     * 功  能 : 添加商品信息到数据库
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['goodName']  => '商品名称'
     * 输  入 : (String) $post['classIndex']=> '分类标识'
     * 输  入 : (String) $post['goodPrice'] => '商品价格'
     * 输  入 : (String) $post['goodSales'] => '商品销量'
     * 输  入 : (String) $post['goodStyle'] => '{
     *              "{"styleName":"规格名称","stylePrice":"规格价格"}"
     *          }'
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/07/31 10:11
     */
    public function goodCreate($post)
    {
        // 启动事务
        Db::startTrans();
        try{
            // 获取商品数据
            $G = GoodModel::where('good_name',$post['goodName'])->find();
            // 判断是否存在，如果存在返回错误信息
            if($G) return returnData('error','商品已存在');

            // 实例化商品表数据模型
            $goodModel = new GoodModel();
            // 生成主键
            $goodindex = md5(uniqid().mt_rand(1,999999999));
            // 处理数据
            $goodModel->good_index = $goodindex;
            $goodModel->good_name  = $post['goodName'];
            $goodModel->class_index= $post['classIndex'];
            $goodModel->good_price = $post['goodPrice'];
            $goodModel->good_sales = $post['goodSales'];
            $goodModel->good_img_master  = md5(uniqid().mt_rand(1,9999999));
            $goodModel->good_img_details = md5(uniqid().mt_rand(1,9999999));
            $goodModel->good_time  = time();
            // 写入数据
            $S = $goodModel->save();
            // 判断是否写入成功
            if(!$S) return returnData('error','商品添加失败');

            // 获取JSON数据
            $styleArr = json_decode($post['goodStyle'],true);

            // 实例化规格表模型
            $styleModel = new StyleModel();
            // 处理数据
            $list = [];
            foreach($styleArr as $k=>$v)
            {
                foreach($styleArr as $i=>$j){
                    if(($k!=$i)&&($v['styleName']==$j['styleName']))
                    {
                        return returnData('error','商品规格信息重复');
                    }
                    if(!is_numeric($j['stylePrice']))
                    {
                        return returnData('error','商品价格输入错误');
                    }
                }

                $list[] = [
                    'style_index' => $k.md5(uniqid().mt_rand(1,99999999)),
                    'good_index'  => $goodindex,
                    'style_name'  => $v['styleName'],
                    'style_price' => $v['stylePrice'],
                ];
            }
            // 保存到数据库
            $D = $styleModel->saveAll($list,false);
            // 判断是否写入成功
            if(!$D) return returnData('error','商品规格信息错误');

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

    /**
     * 名  称 : goodImageCreate()
     * 功  能 : 添加商品图片到数据库
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['goodIndex'] = '商品主键';
     * 输  入 : (String) $post['imageType'] = '图片类信';  master / son
     * 输  入 : (String) $post['imageSort'] = '图片排序';
     * 输  入 : (String) $post['imageFile'] = '图片数据';
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/07/31 10:11
     */
    public function goodImageCreate($post)
    {
        // 获取商品信息
        $good = GoodModel::get($post['goodIndex']);
        // 获取图片主键
        if($post['imageType']=='master'){
            $fileIndex = $good['good_img_master'];
        }
        if($post['imageType']=='son'){
            $fileIndex = $good['good_img_details'];
        }

        // 判断图片排序是否是1
        if($post['imageSort']==1){
            // 获取原主键图片
            $data = PictureModel::where(
                'gdimg_index',
                $fileIndex
            );
            $list = $data->select();
            // 判断是否有图片
            if($list){
                foreach($list as $k=>$v){
                    if(unlink('.'.$v['picture_url']));
                }
            }
            $data->delete();
        }

        // 实例化数据库模型
        $pictureModel = new PictureModel();
        // 处理数据
        $pictureModel->picture_index = md5(uniqid().mt_rand(1,999999999));
        $pictureModel->gdimg_index   = $fileIndex;
        $pictureModel->picture_url   = $post['imageFile'];
        $pictureModel->picture_sort  = $post['imageSort'];
        // 保存数据
        $save = $pictureModel->save();

        // 验证数据
        if(!$save) return returnData(
            'error',
            '上传失败'
        );
        // 返回正确数据
        return returnData('success','上传成功');
    }

    /**
     * 名  称 : goodUpdate()
     * 功  能 : 修改商品信息接口
     * 变  量 : --------------------------------------
     * 输  入 : (String) $put['goodIndex'] => '商品主键'
     * 输  入 : (String) $put['goodName']  => '商品名称'
     * 输  入 : (String) $put['classIndex']=> '分类标识'
     * 输  入 : (String) $put['goodPrice'] => '商品价格'
     * 输  入 : (String) $put['goodSales'] => '商品销量'
     * 输  入 : (String) $put['goodStyle'] => '{
     *              "{"styleName":"规格名称","stylePrice":"规格价格"}"
     *          }'
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/07/31 23:12
     */
    public function goodUpdate($put)
    {
        // 启动事务
        Db::startTrans();
        try{
            // 获取商品信息
            $good = GoodModel::get($put['goodIndex']);
            // 判断是否有数据
            if(!$good) return returnData(
                'error',
                '没有此商品'
            );
            // 处理数据
            $good->good_name   = $put['goodName'];
            $good->class_index = $put['classIndex'];
            $good->good_price  = $put['goodPrice'];
            $good->good_sales  = $put['goodSales'];
            // 写入数据
            $good->save();

            // 获取JSON数据
            $styleArr = json_decode($put['goodStyle'],true);

            // 获取原规格数据
            StyleModel::where(
                'good_index',
                $put['goodIndex']
            )->delete();

            // 实例化规格表模型
            $styleModel = new StyleModel();
            // 处理数据
            $list = [];
            foreach($styleArr as $k=>$v)
            {
                foreach($styleArr as $i=>$j){
                    if(($k!=$i)&&($v['styleName']==$j['styleName']))
                    {
                        return returnData('error','商品规格信息重复');
                    }
                    if(!is_numeric($j['stylePrice']))
                    {
                        return returnData('error','商品价格输入错误');
                    }
                }

                $list[] = [
                    'style_index' => $k.md5(uniqid().mt_rand(1,99999999)),
                    'good_index'  => $put['goodIndex'],
                    'style_name'  => $v['styleName'],
                    'style_price' => $v['stylePrice'],
                ];
            }
            // 保存到数据库
            $D = $styleModel->saveAll($list,false);
            // 判断是否写入成功
            if(!$D) return returnData('error','商品规格信息错误');

            // 提交事务
            Db::commit();
            // 返回正确数据
            return returnData('success','修改成功');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            // 返回正确数据
            return returnData('error','修改失败');
        }
    }

    /**
     * 名  称 : goodUpdate()
     * 功  能 : 获取商品详情数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['goodIndex'] => '商品主键'
     * 输  出 : ['msg'=>'success','data'=>[
     *              "goodData"=>"商品详情数据","msgList"=>"评论信息"
     *          ]]
     * 创  建 : 2018/08/01 17:11
     */
    public function goodSelect($get)
    {
        // 获取商品详情数据
        $goodData = GoodModel::get($get['goodIndex'])->toArray();
        // 判断商品是否存在
        if(!$goodData) return returnData('error', '商品已被删除');

        // 获取商品规格数据
        $styleData = StyleModel::where(
            'good_index',
            $get['goodIndex']
        )->select()->toArray();
        // 判断商品规格是否存在
        if(!$goodData) return returnData('error','商品规格错误');
        // 载入商品规格信息
        $goodData['style_data'] = $styleData;

        // 获取商品主图片信息
        $pictureMaster = PictureModel::where(
            'gdimg_index',
            $goodData['good_img_master']
        )->select()->toArray();
        // 判断商品猪图片是否存在
        if(!$goodData) return returnData('error','商品主图片获取失败');
        // 载入商品规格信息
        $goodData['good_img_master'] = $pictureMaster;

        // 获取商品详情图片信息
        $pictureDetails = PictureModel::where(
            'gdimg_index',
            $goodData['good_img_details']
        )->select()->toArray();
        // 载入商品规格信息
        $goodData['good_img_details'] = $pictureDetails;

        // 获取商品评论信息
        $criticList = CriticModel::where(
            'good_index',
            $get['goodIndex']
        )->order(
            'critic_sort',
            'asc'
        )->limit(0,12)->select()->toArray();
        // 返回正确数据
        return returnData('success',[
            "goodData"   => $goodData,
            "criticList" => $criticList
        ]);
    }

    /**
     * 名  称 : criticSelect()
     * 功  能 : 获取商品评论信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['goodIndex'] => '商品主键'
     * 输  出 : ['msg'=>'success','data'=>[
     *              "msgList"=>"评论信息"
     *          ]]
     * 创  建 : 2018/08/02 15:18
     */
    public function criticSelect($get)
    {
        // 获取商品评论信息
        $criticList = CriticModel::where(
            'good_index',
            $get['goodIndex']
        )->order(
            'critic_sort',
            'asc'
        )->limit(0,12)->select()->toArray();
        // 返回正确数据
        return returnData('success',[
            "criticList" => $criticList
        ]);
    }

    /**
     * 名  称 : criticDelete()
     * 功  能 : 删除商品评论信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['criticIndex'] => '评论主键'
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/02 18:30
     */
    public function criticDelete($delete)
    {
        // 获取商品评论信息
        $criticList = CriticModel::get($delete['criticIndex']);

        // 判断是否评论信息
        if(!$criticList) return returnData(
            'error',
            '没有这条评论'
        );

        // 执行删除评论信息
        $res = $criticList->delete();

        // 判断是否删除成功
        if(!$res) return returnData(
            'error',
            '删除失败'
        );

        // 返回正确数据
        return returnData('success','删除成功');
    }

    /**
     * 名  称 : goodDelete()
     * 功  能 : 删除商品数据信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['goodIndex'] => '商品主键'
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/02 18:30
     */
    public function goodDelete($delete)
    {

        // 启动事务
        Db::startTrans();
        try{
            // 获取商品信息数据
            $goodModelList = GoodModel::get($delete['goodIndex']);

            // 删除商品规格数据
            StyleModel::where(
                'good_index',
                $delete['goodIndex']
            )->delete();

            // 配置主图片数据条件
            $picrureMaster = PictureModel::where(
                'gdimg_index',
                $goodModelList['good_img_master']
            );
            // 获取商品图片信息
            $maserData = $picrureMaster->select()->toArray();
            // 删除主图片文件数据信息
            foreach($maserData as $k=>$v)
            {
                if(unlink('.'.$v['picture_url']));
            }
            // 删除商品图片信息
            $picrureMaster->delete();

            // 配置商品详情图片数据
            $picrureDetails = PictureModel::where(
                'gdimg_index',
                $goodModelList['good_img_details']
            );
            // 获取商品详情图片数据
            $detailData = $picrureDetails->select()->toArray();
            // 删除商品详情图片数据
            foreach($detailData as $k=>$v)
            {
                if(unlink('.'.$v['picture_url']));
            }
            // 删除商品图片信息
            $picrureDetails->delete();

            CriticModel::where(
                'good_index',
                $delete['goodIndex']
            )->delete();

            // 删除商品数据
            $goodModelList->delete();

            // 提交事务
            Db::commit();
            // 返回正确数据
            return returnData('success','删除成功');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            // 返回正确数据
            return returnData('error','删除失败');
        }
    }

    /**
     * 名  称 : goodSelectList()
     * 功  能 : 获取商品列表数据信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['classIndex'] => '分类主键';
     * 输  入 : (String) $get['goodLimit']  => '商品页码';
     * 输  入 : (String) $get['orderType']  => '排序类型'; no/asc/desc/sale
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/04 16:00
     */
    public function goodSelectList($get)
    {
        // 获取分类信息
        $classData = GoodsClassModel::get($get['classIndex']);
        // 判断是否有这个分类
        if(!$classData) return returnData('error','没有这个类别');

        // 判断分类是不是顶级分类
        if($classData['class_parent']!==0) {
            // 处理查询条件
            $goodModel = GoodModel::where(
                'class_index',
                $get['classIndex']
            );
        }else{
            // 获取子类商品
            $classList = GoodsClassModel::where(
                'class_parent',
                $classData['class_index']
            )->select()->toArray();
            // 拼接子类信息
            $classString = '';
            foreach($classList as $k=>$v)
            {
                $classString .= $v['class_index'].',';
            }
            // 处理查询条件
            $goodModel = GoodModel::where(
                'class_index',
                'in',
                rtrim($classString,',')
            );
        }

        // 判断价格排序类型
        if($get['orderType']=='asc')
        {
            $goodModel = $goodModel->order('good_price', 'asc');
        }

        // 判断价格排序类型
        if($get['orderType']=='desc')
        {
            $goodModel = $goodModel->order('good_price', 'desc');
        }

        // 判断销量排序类型
        if($get['orderType']=='sale')
        {
            $goodModel = $goodModel->order('good_sales', 'asc');
        }

        // 分页
        $goodModel = $goodModel->limit($get['goodLimit'],12);

        // 获取商品数据
        $goodList = $goodModel->select()->toArray();

        // 返回正确数据
        return returnData('success',$goodList);
    }
}