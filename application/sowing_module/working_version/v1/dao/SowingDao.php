<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  SowingDao.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/08/25 14:38
 *  文件描述 :  轮播图数据层
 *  历史记录 :  -----------------------
 */
namespace app\sowing_module\working_version\v1\dao;
use app\sowing_module\working_version\v1\model\SowingModel;

class SowingDao implements SowingInterface
{
    /**
     * 名  称 : sowingSelect()
     * 功  能 : 获取轮播图列表数据处理
     * 变  量 : --------------------------------------
     * 输  入 : --------------------------------------
     * 输  出 : ['msg'=>'success','data'=>'返回数据']
     * 创  建 : 2018/08/25 17:06
     */
    public function sowingSelect($get)
    {
        // TODO :  SowingModel 模型
        $sowingList = SowingModel::order(
            'sowing_sort','asc'
        )->select()->toArray();
        // TODO :  返回执行结果
        return \RSD::wxReponse($sowingList,'M',$sowingList,'还没有数据');
    }

    /**
     * 名  称 : sowingCreate()
     * 功  能 : 添加轮播图数据处理
     * 变  量 : --------------------------------------
     * 输  入 : $post['sowingFile']  => '轮播图文件资源';
     * 输  入 : $post['sowingSort']  => '轮播图排序数字';
     * 输  出 : ['msg'=>'success','data'=>'提示信息']
     * 创  建 : 2018/08/25 14:47
     */
    public function sowingCreate($post)
    {
        // TODO :  验证数据,如果排序为1删除员轮播图图片
        if($post['sowingSort'] == 1)
        {
            $sowingList = SowingModel::select()->toArray();
            $string = '';
            foreach ($sowingList as $k=>$v)
            {
                if(file_exists('.'.$v['sowing_url']))
                {
                    unlink('.'.$v['sowing_url']);
                }
                $string .= $v['sowing_index'].',';
            }
            SowingModel::where(
                'sowing_index',
                'in',
                rtrim($string)
            )->delete();
        }
        // TODO :  示例话 SowingModel 模型
        $sowingModel = new SowingModel();
        // TODO :  处理数据
        $sowingModel->sowing_index = uniqidToken();
        $sowingModel->sowing_url   = $post['sowingFile'];
        $sowingModel->sowing_sort  = $post['sowingSort'];
        // TODO :  保存数据
        $save = $sowingModel->save();
        // TODO :  返回执行结果
        return \RSD::wxReponse($save,'M','上传成功','上传失败');
    }
}
