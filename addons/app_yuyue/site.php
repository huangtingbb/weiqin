<?php
/**
 * app_yuyue模块微站定义
 *
 * @author 不畏浮云
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class App_yuyueModuleSite extends WeModuleSite {

	protected $app_tables = array(
		'config'=>'bwfy_yuyue_config',
		'field'=>'bwfy_yuyue_field',
		'image'=>'bwfy_yuyue_image',
		'items'=>'bwfy_yuyue_items',
		'select'=>'bwfy_yuyue_select'
	);

	//管理设置
	public function doWebItems_manager() {
		global $_GPC, $_W;
		$_allow_key = array('app','notice','system','color');
		if(($key = $_GPC['action']) && in_array($_GPC['action'], $_allow_key)){
			$_data = $_GPC[$key];
			$data = array('v'=>iserializer($_data));
			$res = pdo_update($this->app_tables['config'],$data,array('k'=>$key));
			message('设置完成', $this->createWebUrl('items_manager', array('type' => $_GPC['type'])));
		}else{
			$config = array();
			$config['app'] = pdo_get($this->app_tables['config'],array('k'=>'app'),array('k','v','title'));
			$config['notice'] = pdo_get($this->app_tables['config'],array('k'=>'notice'),array('k','v','title'));
			$config['system'] = pdo_get($this->app_tables['config'],array('k'=>'system'),array('k','v','title'));
			$config['color'] = pdo_get($this->app_tables['config'],array('k'=>'color'),array('k','v','title'));
			foreach($config as $k=>$v){
				$config[$k] = iunserializer($v['v']);
				if($k == 'notice'){
					$config[$k]['index_content'] = htmlspecialchars_decode($config[$k]['index_content']);
					$config[$k]['content'] = htmlspecialchars_decode($config[$k]['content']);
				}
			}
		}
		include $this->template('messenger');
	}
	//头部banner图图片管理操作
	public function doWebImage() {
		global $_GPC, $_W;
		$list = pdo_getall($this->app_tables['image']);
		if($_GPC['action'] == 'create'){
			$data = array(
				'versionid' => $_GPC['versionid'],
				'title' => $_GPC['title'],
				'image' => $_GPC['image'],
				'url'   => $_GPC['url'],
				'create_time' => time(),
			);
			$res = pdo_insert($this->app_tables['image'], $data);
			if(!empty($res)){
				message('增加成功', $this->createWebUrl('image', array('type' => $_GPC['type'])));
			}else{
				message('增加失败', $this->createWebUrl('image'), array('type' => $_GPC['type']));
			}

		}else if($_GPC['action'] == 'edit'){
			$edit = pdo_get($this->app_tables['image'],array('id'=>$_GPC['id']));
		}elseif($_GPC['action'] == 'update'){
			$date = array(
				'title' => $_GPC['title'],
				'image' => $_GPC['image'],
				'url'   => $_GPC['url']
			);

			$result = pdo_update('bwfy_yuyue_image', $date, array('id' => $_GPC['id']));
			if (!empty($result)) {
				message('更新成功！', $this->createWebUrl('image', array('type' => $_GPC['type'])));
			} else {
				message('更新失败！', $this->createWebUrl('image'), array('type' => $_GPC['type']));
			}

		}else if($_GPC['action'] == 'delete'){

			$res = pdo_delete("bwfy_yuyue_image", array('id' => $_GPC['id']));
			if(!empty($res)){
				message(" 删除成功", referer(), 'success');
			}else{
				message(" 删除失败", referer(), 'error');
			}
		}
		include $this->template('lists');
	}

	public function doWebEcho(){
		global $_W,$_GPC;
		echo 'backend HELO',"<br>";
		echo "<a href='".$this->createMobileUrl('hello')."'>MobileUrl:hello</a>";
	}
	public function doWebGetUser(){
		global $_W,$_GPC;
		echo "<pre>";
		print_r($this->app_tables);
		include $this->template('getUser');
	}
	public function doWebSendEmail(){
		global $_W,$_GPC;
		load()->func('communication');
		ihttp_email('1029148937@qq.com','youxiangfasong',['hahhahah']);
		echo $this->createWebUrl('logints');
	}

	public function doWebLogints(){
		global $_W,$_GPC;
		echo 122;
		try{
			dump($_W);
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	public function doWebGetData(){
		echo "<pre>";
		global $_W,$_GPC;
		print_r($_W);
		
	}
	public function doWebTestsd(){
		global $_W,$_GPC;
		$path=$_W['siteurl'].'path:/html';
		load()->func('tpl');
		include $this->template('test');
	}

	public function doMobileHello(){
		global $_W,$_GPC;	
		echo $this->createWebUrl('echo');
	}

	public function doPageEcho(){
		global $_W,$_GPC;
		echo 'front hello ！';
	}

	//预约管理操作
	public function doWebOrders() {
		global $_GPC, $_W;
		if($_GPC['action'] == ''){
			//获取页数
			$pindex = max(1, intval($_GPC['page']));
			//获取页行数
			$psize = 10;
			$fields = pdo_getall($this->app_tables['field'],array('is_open'=>1),array(),'','orderby ASC');
			$so_fields = array();
			$allow_fields = array();
			$limit = array($pindex,$psize);
			foreach($fields as $k=>$v){
				if($v['type'] == 'select'){
					$so_fields[$k]['select_items'] = pdo_getall($this->app_tables['select'],array('field_id'=>$v['id']));
				}
				if($v['is_search'] == 1){
					$so_fields[] = $v;
				}
				$allow_fields[] = $v['field_name'];
			}
			$allow_fields[] = 'dateline';
			$allow_fields[] = 'audit';
			$allow_fields[] = 'id';
			$filter = array();
			$filter['closed'] = 0;
			$orderby = 'id DESC';
			if($so = $_GPC['so']){
				foreach($so as $key => $val){
					if(is_array($val)){
						if(!empty($val['start'])  && !empty($val['end'])){
							$start_time = strtotime($val['start']);
							$end_time = strtotime($val['end']);
							$filter[$key .' >='] = $start_time;
							$filter[$key .' <='] = $end_time;
						}
					}else{
						if(!empty($val)){
							$filter[$key] = $val;
						}
					}
				}
			}
			if($items = pdo_getall($this->app_tables['items'],$filter,$allow_fields,'',$orderby,$limit)){
				foreach($items as $k=>$v){
					foreach($fields as $kk=>$vv){
						if($vv['type'] == 'datetime' && $v[$vv['field_name']]){
							$items[$k][$vv['field_name']] = date('Y-m-d',$v[$vv['field_name']]);
						}
					}
					$items[$k]['dateline'] = date('Y-m-d',$v['dateline']);
				}
				$count = pdo_count($this->app_tables['items'],$filter);
				$pager = pagination($count, $pindex, $psize);
			}

			$cof = $this->get_config('system');
			$search = pdo_getall($this->app_tables['field'], array('is_open' => 1, 'is_search' => 1));
			$fids = array();
			foreach($search as $key => $val){
				if($val['type'] == 'select'){
					$fids[] = $val['id'];
				}
			}
			if(!empty($fids)){
				$select = pdo_getall($this->app_tables['select'], array('field_id' => $fids));
				if(!empty($select)){
					foreach($search as $k => &$v){
						foreach($select as $key => $val){
							if($val['field_id'] == $v['id']){
								$v['select'][$key]['id'] = $val['id'];
								$v['select'][$key]['title'] = $val['title'];
								$v['select'][$key]['field_id'] = $val['field_id'];
							}
						}
					}
				}
			}
			/*if($_GPC['method'] == 'output'){
				 $fname = $file = date('YmdHi').'.xls';
				 $rows = $list;
		        if(headers_sent($file, $line)){
		            echo 'Header already sent @ '.$file.':'.$line;
		            exit();
		        }
		        //header('Pragma: no-cache');
		        //header("Expires: Wed, 26 Feb 1997 08:21:57 GMT");
		        header('cache-control:must-revalidate');
		        if(strpos($_SERVER["HTTP_USER_AGENT"],'MSIE')){
		            $fname = urlencode($fname);
		            header('Content-type: '.$mimeType);
		            //header("Content-type: application/octet-stream");
		            header('cache-control:must-revalidate');
		            Header("Content-Disposition: inline; filename=\"".$fname.'"');
		            header("Pragma:public");
		        }else{
		            header('Content-type: '.$mimeType.';charset=utf-8');
		            header("Content-Disposition: attachment; filename=\"".$fname.'"');
		        }
		        echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style>td{vnd.ms-excel.numberformat:@}</style></head>';
		        echo '<table width="100%" border="1">';
		        foreach($rows as $row){
		            echo '<tr><td>'.implode('</td><td>',$row)."</td></tr>\r\n";
		        }
		        echo '</table>';
		        exit;
			}*/

		}else if($_GPC['action'] == 'detail'){
			$item_detail = pdo_get('mark_list',['id'=>$_GPC['id']]);
			$item_detail = array_values($item_detail);
			$arr = array();
			foreach($item_detail as $key=>$val){
				if($val != null){
					array_push($arr, $val);
				}
			}
			if(is_numeric($arr[1])){
				$arr[1] = date('Y-m-d H:i',$arr[1]);
			}
			echo json_encode($arr);exit;
		}else if($_GPC['action'] == 'delete'){
			$data['closed'] = 1;
			$res = pdo_update($this->app_tables['items'], $data, array('id' => $_GPC['id']));
			if(!empty($res)){
				message(" 删除成功", referer(), 'success');
			}else{
				message(" 删除失败", referer(), 'error');
			}
		}else if($_GPC['action'] == 'examine'){
			$data['audit'] = 1;
			$res = pdo_update($this->app_tables['items'], $data, array('id' => $_GPC['id']));
			if(!empty($res)){
				$this->doPageMsgb($_GPC['id']);
				message(" 审核成功", referer(), 'success');
			}else{
				message(" 审核失败", referer(), 'error');
			}
		}
		include $this->template('orders');
	}
	
	public function doWebTest(){
		global $_W,$_GPC;
		echo '我自定义的菜单';
		include $this->template('test');
	}

	//字段管理操作
	public function doWebFields() {
		global $_GPC, $_W;
		$list = pdo_getall($this->app_tables['field'],array(),array(),'',array('orderby ASC','id ASC'));
		if($_GPC['action'] == 'edit'){
			$detail = pdo_get($this->app_tables['field'],array('id'=>$_GPC['field_id']),array());
			$detail['select_items'] = pdo_getall($this->app_tables['select'],array('field_id'=>$_GPC['field_id']),array());
		}elseif($_GPC['action'] == 'update'){
			if(!$field_id = $_GPC['field_id']){
				message('未指定要修改的内容！', $this->createWebUrl('fields'));
			}else if(!$data = $_GPC['data']){
				message('提交数据有误', $this->createWebUrl('fields'));
			}else{
				$result = pdo_update($this->app_tables['field'], $data, array('id' => $field_id));
				if($data['type'] == 'select' && $select_items = $_GPC['select']){
					pdo_delete($this->app_tables['select'],array('field_id'=>$field_id));
					foreach($select_items['title'] as $k=>$v){
						$select_data['title'] = $v;
						$select_data['field_id'] = $field_id;
						$select_data['dateline'] = time();
						$select_data['orderby'] = $select_items['orderby'][$k];
						pdo_insert($this->app_tables['select'], $select_data);
					}
				}
				message('修改成功！', $this->createWebUrl('fields', array('type' => $_GPC['type'])));
			}
		}
		include $this->template('items');
	}

	public function get_config($key=null)
	{
		if(!$key){
			return false;
		}else if(!$config = pdo_get($this->app_tables['config'],array('k'=>$key),array())){
			return false;
		}else{
			return iunserializer($config['v']);
		}
	}

	public function doPageMsgb($id){
		global $_GPC, $_W;
		$app = $this->get_config('app');
		$temp_fids = pdo_getall($this->app_tables['field'],array('is_temp'=>1,'is_open'=>1),array());
		$allow_fids = $temp_data = array();
		foreach($temp_fids as $k=>$v){
			$allow_fids[] = $v['field_name'];
		}
		$user = pdo_get($this->app_tables['items'], array('id' => $id), array('open_id', 'form_id'));
		$temp_info = pdo_get($this->app_tables['items'], array('id' => $id), $allow_fids);
		$i = 1;
		foreach($temp_info as $k=>$v){
			$temp_data['keyword'.$i] = $v;
			$i++;
		}
		$appid = $app['appid'];
		$secret = $app['appsecret'];
		$template_id = $app['template_id'];

		//获取access_tocken
		//初始化
		$curl = curl_init();
		//设置抓取的url
		curl_setopt($curl, CURLOPT_URL, 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret);
		//设置头文件的信息作为数据流输出
		curl_setopt($curl, CURLOPT_HEADER, 0);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//执行命令
		$data = curl_exec($curl);
		//关闭URL请求
		curl_close($curl);
		$data = json_decode($data,true);
		//return $this->result(0, '发送成功', $data['access_token']);
		//初始化
		$curl = curl_init();
		//设置抓取的url
		curl_setopt($curl, CURLOPT_URL, 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$data['access_token']);
		//设置头文件的信息作为数据流输出
		curl_setopt($curl, CURLOPT_HEADER, 1);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//设置post方式提交
		curl_setopt($curl, CURLOPT_POST, 1);
		//设置post数据
		$post_data = array(
			"touser"=> $user['open_id'],
			"template_id"=> $template_id,
			//"page"=> "/add_order/pages/detail/detial?id=".$id,
			//"page"=> "detail?id=".$id,
			"page"=> "pages/detail/detail?id=".$id,
			"form_id"=> $user['form_id'],
			"data"=> $temp_data
		);
		$post_data = json_encode($post_data);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		//执行命令
		$info = curl_exec($curl);
		//关闭URL请求
		curl_close($curl);
		//显示获得的数据
	}

	public function doWebHelp() {
		global $_GPC, $_W;
		$result = $this->get_info();
		include $this->template('help');
	}

	public function get_info()
	{
		load()->func('communication');
		$url = 'https://api.buweifuyun.com/api.php?API=client/xcxinfo/getxcxinfo&data={"name":"yuyue"}';
		$response = ihttp_request($url);
		$result = json_decode($response['content'], true);
		if($result['error'] == 0){
			return $result['data'];
		}else{
			return false;
		}
	}
}
