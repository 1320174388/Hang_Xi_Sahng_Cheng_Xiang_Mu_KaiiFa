<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  v1_tableName.php
 *  创 建 者 :  Qi Yun Hai
 *  创建日期 :  2018/06/30 22:13
 *  文件描述 :  模块数据表配置文件
 *  历史记录 :  -----------------------
 */

// +---------------------------------
// : v1_版本:数据库表模型对应表名配置
// +---------------------------------
return [
	// 留言表
    'LeavingTable'  => 'data_session_leavings',
    // 留言信息表
    'MessageTable'  => 'data_session_messages',
    // 留言人信息表
    'PeopleTable'	=> 'data_session_peoples',
    // 自动回复信息表
    'ReplyTable'	=> 'data_session_replys',
    // FormId表
    'FormTable'     => 'data_admin_formid'
];