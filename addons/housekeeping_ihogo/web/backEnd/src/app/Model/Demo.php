<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

// 这里来操作数据库
class Demo extends NotORM
{

    protected function getTableName($id)
    {
        return 'ihogo_wdd_post';
    }

    // 获取所有数据
    public function getAllData()
    {
        $user = $this->getORM();
        return $user->select('*');
    }


    // 获取数据列表列表
    public function getListItems($state, $page, $perpage)
    {
        return $this->getORM()
            ->select('*')
            ->where('state', $state)
            ->order('post_date DESC')
            ->limit($page, $perpage)
            ->fetchAll();
    }

    public function getListTotal($state)
    {
        $total = $this->getORM()
            ->where('state', $state)
            ->count('id');

        return intval($total);
    }
 
}
