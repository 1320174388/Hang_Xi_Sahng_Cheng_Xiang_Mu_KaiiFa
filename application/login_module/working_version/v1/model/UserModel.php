<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  UserModel.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/12 21:54
 *  文件描述 :  用户身份标识列表模型
 *  历史记录 :  -----------------------
 */
namespace app\login_module\working_version\v1\model;
use think\Model;

class UserModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '';

    // 设置当前模型对应数据表的主键
    protected $pk = 'user_id';

    // 加载配置数据表名
    public function userInit()
    {
        $this->table = config('tableName.UserTable');
        return $this;
    }
}