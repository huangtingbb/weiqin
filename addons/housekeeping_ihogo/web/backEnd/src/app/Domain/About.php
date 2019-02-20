<?php
namespace App\Domain;

use App\Model\About as ModelCURD;

// 业务实现
class About {

    public function insert($newData) {
        $model = new ModelCURD();
        return $model->insert($newData);
    }

    public function update($id, $newData) {
        $model = new ModelCURD();
        return $model->update($id, $newData);
    }

    public function getAllData() {
        $model = new ModelCURD();
        return $model->getAllData();
    }

    public function delete($id) {
        $model = new ModelCURD();
        return $model->delete($id);
    }

    public function getList($state, $page, $perpage) {
        $rs = array('items' => array(), 'total' => 0);

        $model = new ModelCURD();
        $items = $model->getListItems($state, $page, $perpage);
        $total = $model->getListTotal($state);

        $rs['items'] = $items;
        $rs['total'] = $total;

        return $rs;
    }
}
