<?php
namespace App\Api;

use App\Domain\SliderImg as DomainCURD;
use PhalApi\Api;

/**
 * 轮播图
 * 
 * @author Qin Haoleiq@gmail.com
 */

class SliderImg extends Base
{

    public function getRules()
    {
        return array(
            'insert' => array(
                'sort' => array('name' => 'sort', 'require' => false, 'type' => 'int', 'min' => 1, 'desc' => '排序'),
                'url' => array('name' => 'url', 'require' => true, 'type' => 'string', 'default' =>'', 'desc' => '要打开的文章连接'),
                'img' => array('name' => 'img', 'require' => false, 'type' => 'string', 'default' =>'', 'desc' => '图片'),
                'id' => array('name' => 'id', 'require' => false, 'min' => 1, 'desc' => 'ID'),
            ),
            'update' => array(
                'id' => array('name' => 'id', 'require' => true, 'min' => 1, 'desc' => 'ID'),
                'sort' => array('name' => 'sort', 'require' => false, 'type' => 'int', 'min' => 1, 'desc' => '排序'),
                'url' => array('name' => 'url', 'require' => true, 'type' => 'string', 'default' =>'', 'desc' => '要打开的文章连接'),
                'img' => array('name' => 'img', 'require' => false, 'type' => 'string', 'default' =>'', 'desc' => '图片'),
            ),
            'get' => array(
                'id' => array('name' => 'id', 'require' => false, 'min' => 1, 'desc' => 'ID'),
            ),
            'delete' => array(
                'id' => array('name' => 'id', 'require' => true, 'min' => 1, 'desc' => 'ID'),
            ),
            'getAllData' => array(
                'skip' => array('name' => 'skip', 'require' => false, 'desc' => 'ID'),
                'limit' => array('name' => 'limit', 'require' => false, 'desc' => 'ID'),
            ),
            'getList' => array(
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                'perpage' => array('name' => 'perpage', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量'),
                'state' => array('name' => 'state', 'type' => 'int', 'default' => 0, 'desc' => '状态'),
            ),
        );
    }

    /**
     * 插入数据
     * @desc 向数据库插入一条纪录数据
     * @return int id 新增的ID
     */
    public function insert()
    {
        $rs = array();
        $newData = array(
            'url' => $this->url,
            'sort' => $this->sort,
            'img' => $this->img,
        );

        $domain = new DomainCURD();
        $domain->insert($newData);
    }

    /**
     * 更新数据
     * @desc 根据ID更新数据库中的一条纪录数据
     * @return int code 更新的结果，1表示成功，0表示无更新，false表示失败
     */
    public function update()
    {
        $rs = array();
        $newData = array(
            'url' => $this->url,
            'sort' => $this->sort,
            'img' => $this->img,
        );

        $domain = new DomainCURD();
        $code = $domain->update($this->id, $newData);

        $rs['code'] = $code;
        return $rs;
    }

    /**
     * 获取所有数据
     */
    public function getAllData()
    {
        $domain = new DomainCURD();
        $data = $domain->getAllData();
        return $data;
    }

    /**
     * 删除数据
     * @desc 根据ID删除数据库中的一条纪录数据
     * @return int code 删除的结果，1表示成功，0表示失败
     */
    public function delete()
    {
        $rs = array();

        $domain = new DomainCURD();
        $code = $domain->delete($this->id);

        $rs['code'] = $code;
        return $rs;
    }

    /**
     * 获取分页列表数据
     * @desc 根据状态筛选列表数据，支持分页
     * @return array    items   列表数据
     * @return int      total   总数量
     * @return int      page    当前第几页
     * @return int      perpage 每页数量
     */
    public function getList()
    {
        $rs = array();

        $domain = new DomainCURD();
        $list = $domain->getList($this->state, $this->page, $this->perpage);

        $rs['items'] = $list['items'];
        $rs['total'] = $list['total'];
        $rs['page'] = $this->page;
        $rs['perpage'] = $this->perpage;

        return $rs;
    }
}
