<?php
/**
 * looksay_a1模块微站定义
 *
 * @author xue5226677
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Looksay_a1ModuleSite extends WeModuleSite {


	public function doWebIndex() {
      if($_POST){
      	     //添加一条用户记录，并判断是否成功
        
            $user_data = array(
                'look_appid' => $_POST['appid'],
                'look_appkey' => $_POST['appkey'],
            );
            $result = pdo_update('ims_look_config', $user_data);  
      }      
      $withpermission = pdo_get('ims_look_config', array('look_id' => 1));
      $appid = $withpermission['look_appid'];
      $appkey = $withpermission['look_appkey'];
      include $this->template('home');
	}
	

}