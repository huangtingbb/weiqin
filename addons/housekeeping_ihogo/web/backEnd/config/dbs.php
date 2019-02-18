<?php
/**
 * 分库分表的自定义数据库路由配置
 *
 * @license     http://www.phalapi.net/license GPL 协议
 * @link        http://www.phalapi.net/
 * @author: dogstar <chanzonghuang@gmail.com> 2015-02-09
 */

// 微擎访问
define('IN_IA', true);

// 读取微擎数据库配置
$config = call_user_func(function () {
    $config = [];
    require __DIR__ . '/../../../../../data/config.php';
    return $config['db']['master'];
});

return array(

//  微擎服务器
    'servers' => array(
        'db_master' => array( //服务器标记
            // 'type' => $config['cache'], //数据库类型，暂时只支持：mysql, sqlserver
            'host' => $config['host'], //数据库域名
            'name' => $config['database'], //数据库名字
            'user' => $config['username'], //数据库用户名
            'password' => $config['password'], //数据库密码
            'port' => $config['port'], //数据库端口
            'charset' => $config['charset'], //数据库字符集
        ),
    ),

    /**
     * DB数据库服务器集群
     */

    // 'servers' => array(
    //     'db_master' => array( //服务器标记
    //         'type' => 'mysql', //数据库类型，暂时只支持：mysql, sqlserver
    //         'host' => '127.0.0.1', //数据库域名
    //         'name' => 'ihogo_housekeeping', //数据库名字
    //         'user' => 'root', //数据库用户名
    //         'password' => 'root', //数据库密码
    //         'port' => 3306, //数据库端口
    //         'charset' => 'UTF8', //数据库字符集
    //     ),
    // ),

    /**
     * 自定义路由表
     */
    'tables' => array(
        //通用路由
        '__default__' => array(
            // 表前缀
            'prefix' => '',
            'key' => 'id',
            'map' => array(
                array('db' => 'db_master'),
            ),
        ),

        /**
        'demo' => array(                                                //表名
        'prefix' => 'tbl_',                                         //表名前缀
        'key' => 'id',                                              //表主键名
        'map' => array(                                             //表路由配置
        array('db' => 'db_master'),                               //单表配置：array('db' => 服务器标记)
        array('start' => 0, 'end' => 2, 'db' => 'db_master'),     //分表配置：array('start' => 开始下标, 'end' => 结束下标, 'db' => 服务器标记)
        ),
        ),
         */
    ),
);
