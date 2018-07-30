<?php
/**
 *  版权声明 :  地老天荒科技有限公司
 *  文件名称 :  mysql_query_sql.php
 *  创 建 者 :  Shi Guang Yu
 *  创建日期 :  2018/06/12 15:10
 *  文件描述 :  数据库表迁移文件，删除/创建模块应用表
 *  历史记录 :  -----------------------
 */
    $config = [
        'host'      => 'gz-cdb-9yvp3vjn.sql.tencentcdb.com', // 数据库地址
        'port'      => '63119',                              // 数据库端口
        'database'  => 'langxue2nanfengmeilin',              // 数据库名称
        'charset'   => 'utf8',                               // 设置字符集
        'user'      => 'root',                               // 用户名称
        'password'  => 'CBBBBBEIMbc01z',                     // 用户密码
    ];

    $table = [
        'userList' => 'data_home_users' // 数据表名
    ];

	$date     =  date('Y-m-d H:i:s',time());

	// 连接数据库
    $server  = 'mysql:host='.$config['host'].';';

    $server .= 'port='.$config['port'].';';

    $server .= 'dbname='.$config['database'].';';

    $server .= 'charset='.$config['charset'].';';

    $pdo = new pdo($server,$config['user'],$config['password']);
	
	// 开启事务
	$pdo->beginTransaction();
	
	try{

	    // 删除用户身份标识表
	    $pdo->exec('drop table '.$table['userList'].';');
        
	    echo '
删除 '.$table['userList'].' 用户身份标识表
';      

        // 创建用户身份标识表
		$pdo->exec('create table '.$table['userList'].'(
			user_id int unsigned primary key auto_increment,
			user_openid varchar(50) unique,
			user_token varchar(50) unique,
			user_time varchar(50)
		);');

		echo '
创建 '.$table['userList'].' 用户身份标识表
';


		// 添加成功
		$pdo->commit();
		echo '
success
';

    }catch(PDOException $e){
    	// 添加失败
    	$pdo->rollback();
        echo $e->getMessage();
    }   
    