<?php
namespace App\Api;

use PhalApi\Api;

/**
 * 统一访问入口
 *
 * @author Qin Haoleiq@gmail.com
 */
class Base extends Api
{
    protected $error_arr;

    /**
     * 验证请求合法性方法
     * @desc 根据状态筛选列表数据，支持分页
     * @return array    data   []
     * @return string   msg    "非法请求：wrong sign"
     * @return int      ret     401
     */
    public function __construct()
    {
        // 构造方法
    }
}
