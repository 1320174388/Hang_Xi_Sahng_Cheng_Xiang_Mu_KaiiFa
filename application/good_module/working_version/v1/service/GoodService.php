<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  GoodService.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/07/30 10:17
 *  文件描述 :  商品管理业务逻辑层
 *  历史记录 :  -----------------------
 */
namespace app\good_module\working_version\v1\service;
use app\good_module\working_version\v1\dao\GoodDao;
use app\good_module\working_version\v1\validator\GoodValidate;
use app\good_module\working_version\v1\validator\ImageValidate;
use app\good_module\working_version\v1\validator\GoodGetValidate;

class GoodService
{
    /**
     * 名  称 : goodAdd()
     * 功  能 : 处理商品信息数据
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
    public function goodAdd($post)
    {
        // 实例化验证器，验证数据是否正确
        $goodValidate = new GoodValidate();
        // 判断数据是否正确,返回错误数据
        if(!$goodValidate->check($post))
        {
            return returnData(
                'error',
                $goodValidate->getError()
            );
        }

        // 实例化Dao数据操作类，写入数据
        $goodDao = new GoodDao();
        // 执行写入数据操作函数
        $res =  $goodDao->goodCreate($post);
        // 判断数据是否写入成功，返回错误数据
        if($res['msg']=='error')
        {
            return returnData(
                'error',
                $res['data']
            );
        }

        // 返回正确数据
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : goodImageAdd()
     * 功  能 : 处理商品信息数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $post['goodIndex'] = '商品主键';
     * 输  入 : (String) $post['imageType'] = '图片类信';  master / son
     * 输  入 : (String) $post['imageSort'] = '图片排序';
     * 输  入 : (String) $file['imageFile'] = '图片数据';
     * 输  出 : ['msg'=>'success','data'=>'商品主键']
     * 创  建 : 2018/07/31 10:11
     */
    public function goodImageAdd($post)
    {
        // 实例化验证器，验证数据是否正确
        $imageValidate = new ImageValidate();
        // 判断数据是否正确,返回错误数据
        if(!$imageValidate->check($post))
        {
            return returnData(
                'error',
                $imageValidate->getError()
            );
        }

        if(($post['imageType']!='master')&&($post['imageType']!='son'))
            return returnData(
                'error',
                '图片状态不存在'
            );

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('imageFile');
        // 判断是否上传图片
        if(!$file) return returnData('error','没有上传图片');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( './uploads/goods');
        if(!$info) {
            // 返回上传失败获取错误信息
            return returnData('error', $file->getError());
        }

        // 获取 20160820/42a79759f284b767dfcb2a0197904287.jpg
        $post['imageFile'] = '/uploads/goods/'.$info->getSaveName();

        // 实例化Dao数据操作类，写入数据
        $goodDao = new GoodDao();
        // 执行写入数据操作函数
        $res =  $goodDao->goodImageCreate($post);
        // 判断数据是否写入成功，返回错误数据
        if($res['msg']=='error')
        {
            return returnData(
                'error',
                $res['data']
            );
        }
        // 返回正确数据
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : goodEdit()
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
     * 创  建 : 2018/07/31 22:58
     */
    public function goodEdit($put)
    {
        // 实例化验证器，验证数据是否正确
        $goodValidate = new GoodValidate();
        // 判断数据是否正确,返回错误数据
        if(!$goodValidate->check($put))
        {
            return returnData(
                'error',
                $goodValidate->getError()
            );
        }
        // 判断商品主键是否发送
        if(empty($put['goodIndex'])) return returnData(
            'error',
            '请发送商品标识'
        );

        // 实例化Dao数据操作类，写入数据
        $goodDao = new GoodDao();
        // 执行写入数据操作函数
        $res =  $goodDao->goodUpdate($put);
        // 判断数据是否写入成功，返回错误数据
        if($res['msg']=='error')
        {
            return returnData(
                'error',
                $res['data']
            );
        }

        // 返回正确数据
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : goodGet()
     * 功  能 : 获取商品详情数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['goodIndex'] => '商品主键'
     * 输  出 : ['msg'=>'success','data'=>[
     *              "goodData"=>"商品详情数据","msgList"=>"评论信息"
     *          ]]
     * 创  建 : 2018/08/01 17:11
     */
    public function goodGet($get)
    {
        // 判断 $get['goodIndex'] 是否有值
        if(empty($get['goodIndex'])) return returnData(
            'error',
            '请发送商品主键'
        );

        // 实例化Dao数据操作类，写入数据
        $goodDao = new GoodDao();
        // 执行写入数据操作函数
        $res =  $goodDao->goodSelect($get);
        // 判断数据是否请求成功，返回错误数据
        if($res['msg']=='error')
        {
            return returnData(
                'error',
                $res['data']
            );
        }

        // 返回正确数据
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : criticGet()
     * 功  能 : 获取商品评论信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['goodIndex'] => '商品主键'
     * 输  出 : ['msg'=>'success','data'=>[
     *              "msgList"=>"评论信息"
     *          ]]
     * 创  建 : 2018/08/02 15:18
     */
    public function criticGet($get)
    {
        // 判断 $get['goodIndex'] 是否有值
        if(empty($get['goodIndex'])) return returnData(
            'error',
            '请发送商品主键'
        );

        // 实例化Dao数据操作类，写入数据
        $goodDao = new GoodDao();
        // 执行写入数据操作函数
        $res =  $goodDao->criticSelect($get);
        // 判断数据是否请求成功，返回错误数据
        if($res['msg']=='error')
        {
            return returnData(
                'error',
                $res['data']
            );
        }

        // 返回正确数据
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : criticDel()
     * 功  能 : 删除商品评论信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['criticIndex'] => '评论主键'
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/02 18:30
     */
    public function criticDel($delete)
    {
        // 判断 $delete['criticIndex'] 是否有值
        if(empty($delete['criticIndex'])) return returnData(
            'error',
            '请发送评论主键'
        );

        // 实例化Dao数据操作类，写入数据
        $goodDao = new GoodDao();
        // 执行写入数据操作函数
        $res =  $goodDao->criticDelete($delete);
        // 判断数据是否请求成功，返回错误数据
        if($res['msg']=='error')
        {
            return returnData(
                'error',
                $res['data']
            );
        }

        // 返回正确数据
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : goodDel()
     * 功  能 : 删除商品数据信息
     * 变  量 : --------------------------------------
     * 输  入 : (String) $delete['goodIndex'] => '商品主键'
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/02 18:30
     */
    public function goodDel($delete)
    {
        // 判断 $delete['goodIndex'] 是否有值
        if(empty($delete['goodIndex'])) return returnData(
            'error',
            '请发送商品主键'
        );

        // 实例化Dao数据操作类，写入数据
        $goodDao = new GoodDao();
        // 执行写入数据操作函数
        $res =  $goodDao->goodDelete($delete);
        // 判断数据是否请求成功，返回错误数据
        if($res['msg']=='error')
        {
            return returnData(
                'error',
                $res['data']
            );
        }

        // 返回正确数据
        return returnData('success',$res['data']);
    }

    /**
     * 名  称 : goodList()
     * 功  能 : 获取商品列表数据
     * 变  量 : --------------------------------------
     * 输  入 : (String) $get['classIndex'] => '分类主键';
     * 输  入 : (String) $get['goodLimit']  => '商品页码';
     * 输  入 : (String) $get['orderType']  => '排序类型'; no/asc/desc/sale
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/04 14:24
     */
    public function goodList($get)
    {
        // 实例化验证器，验证数据是否正确
        $goodGetValidate = new GoodGetValidate();
        // 判断数据是否正确,返回错误数据
        if(!$goodGetValidate->check($get))
        {
            return returnData(
                'error',
                $goodGetValidate->getError()
            );
        }

        // 实例化Dao数据操作类，写入数据
        $goodDao = new GoodDao();
        // 执行获取数据操作函数
        $res =  $goodDao->goodSelectList($get);
        // 判断数据是否请求成功，返回错误数据
        if($res['msg']=='error')
        {
            return returnData(
                'error',
                $res['data']
            );
        }

        // 返回正确数据
        return returnData('success',$res['data']);
    }
}