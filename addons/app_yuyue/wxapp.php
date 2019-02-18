<?php
/**
 * app_yuyue模块小程序接口定义
 *
 * @author 不畏浮云
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class App_yuyueModuleWxapp extends WeModuleWxapp {
	protected $app_tables = array(
		'config'=>'bwfy_yuyue_config',
		'field'=>'bwfy_yuyue_field',
		'image'=>'bwfy_yuyue_image',
		'items'=>'bwfy_yuyue_items',
		'select'=>'bwfy_yuyue_select'
	);

	public function doPageHello(){
		$this->result(0,'',['test'=>123456]);
	}
	public function doPageTest(){
		global $_GPC, $_W;
		$allow_yuyue_date = $last_item = $last_yuyue = $last_yuyue_item = $form_data = array();
		$lists = pdo_getall($this->app_tables['field'],array('is_open'=>1),array(),'',array('orderby ASC','default DESC','id ASC'));
		$images = pdo_getall($this->app_tables['image']);
		$cfg = $this->get_config('system');
		$yuyue_cfg = $this->get_config('notice');
		$yuyue_info = array();
		if($cfg['phone']){
			$yuyue_info['phone'] = $cfg['phone'];
		}
		$uid = $_W['member']['uid'];
		$last_yuyue = pdo_get($this->app_tables['items'],array('uid'=>$uid),array(),'',array('id DESC'));
		$yuyue_info['content'] = htmlspecialchars_decode($yuyue_cfg['index_content']);
		$allow_yuyue_date['start'] = date('Y-m-d');
		$allow_yuyue_date['end'] = date('Y-m-d',time()+$cfg['max_days']*86400);
		$now_count = pdo_count($this->app_tables['items']) + $cfg['base_number'];
		$last_item = pdo_get($this->app_tables['items'],array(),array(),'',array('id DESC'));
		$last_item['dateline'] = $this->format_time($last_item['dateline']);
		$is_new_user = 0;
		foreach($lists as $k=>$v){
			if($select_items = pdo_getall($this->app_tables['select'],array('field_id'=>$v['id']),array(),'',array('orderby ASC'))){
				foreach($select_items as $kk=>$vv){
					$lists[$k]['select_items'][] = $vv['title'];
				}
				$list[$k]['select_items'] = array_values($list[$k]['select_items']);
			}
			$form_data[$v['field_name']] = '';
			if(!empty($last_yuyue)){
				if($v['type'] != 'datetime'){
				$last_yuyue_item[$v['field_name']] = $last_yuyue[$v['field_name']];
				}else{
					$last_yuyue_item[$v['field_name']] = '';
				}
			}else{
				$is_new_user = 1;
			}			
		}
		$data  = array('items'=>$lists,'advs'=>$images,'is_new'=>$is_new_user,'form_data'=>$form_data,'config'=>$allow_yuyue_date,'cfg_config' => $cfg,'yuyue_info'=>$yuyue_info,'count'=>$now_count,'last_item'=>$last_item,'last_yuyue'=>$last_yuyue_item);
		$errno = 0;
		$message = '返回消息';
		return $this->result($errno, $message, $data);
	}

	public function doPageGetData(){
		global $_GPC, $_W;
		$_data = json_decode(htmlspecialchars_decode($_GPC['data']),true);
		$data = $this->check_fields($_data);
		$data['data']['uid'] = $_W['member']['uid'];
		$data['data']['open_id'] = $_W['openid'];
		if(!$data['error']){
			$res = pdo_insert($this->app_tables['items'],$data['data']);
			if(!empty($res)){
				$id = pdo_insertid();
				$cof = $this->get_config('system');
				if($cof['audit'] == 0){
					$this->Msgb($id);
				}
				return $this->result(0,'提交成功', $id);
			}else{
				return $this->result(1,'提交失败', '');
			}
		}else{
			return $this->result(1,$data['msg'], '');
		}
	}

	public function doPageGetDetail(){
		global $_GPC, $_W;
		$id = $_GPC['id'];
		$detail = pdo_get($this->app_tables['items'],['id'=>$id]);
		$fields = pdo_getall($this->app_tables['field'],array('is_open'=>1),array(),'',array('orderby ASC','default DESC','id ASC'));
		foreach($fields as $k=>$v){
			if($v['type'] == 'datetime'){
				$detail[$v['field_name']] = date('Y-m-d',$detail[$v['field_name']]);
			}
			if($v['type'] == 'mobile'){
				$detail[$v['field_name']] = substr_replace($detail[$v['field_name']], '****', 3, 4);;
			}
			$fields[$k]['value'] = $detail[$v['field_name']] ? $detail[$v['field_name']] : '';
		}
		if(!empty($detail)){
			return $this->result(0,'查询成功', $fields);
		}else{
			return $this->result(1,'查询失败', '');
		}
	}

	public function doPageArt(){
		$config  = $this->get_config('notice');
		$sys_cfg = $this->get_config('system');
		$res = array();
		if($sys_cfg['phone']){
			$res['phone'] = $sys_cfg['phone'];
		}
		$res['content'] = htmlspecialchars_decode($config['content']);
		return $this->result(0,'查询成功！', $res);
	}

	public function Msgb($id){
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
			$temp_data['keyword'.$i] = array('value' => $v);
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
			"page"=> "app_yuyue/pages/detail/detail?id=".$id,
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
	public function  doPageLogin(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '授权成功';
		$data1 = array(
			'errno' => 0
		);
		if($_W['member']['uid'] && $_W['openid']){
			$data1['uid'] = $_W['member']['uid'];
			$data1['openid'] = $_W['openid'];
		}else{
			$message = '授权失败';
			$data1 = array(
				'errno' => 1
			);
		}
		return $this->result($errno, $message, $data1);
	}
	public function doPageGetOpenid()
	{
		global $_GPC, $_W;
		$app = $this->get_config('app');
		$appid = $app['appid'];
		$secret = $app['appsecret'];
		$code = $_GPC['code'];

		//初始化
		$curl = curl_init();
		//设置抓取的url
		curl_setopt($curl, CURLOPT_URL, 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code');
		//设置头文件的信息作为数据流输出
		curl_setopt($curl, CURLOPT_HEADER, 0);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//执行命令
		$data = curl_exec($curl);
		//关闭URL请求
		curl_close($curl);
		//显示获得的数据
		return $this->result(0, '返回消息', $data);
	}

	public function check_fields($data=array())
	{
		$result = array('error'=>0,'msg'=>'');
		if(!($fields = pdo_getall($this->app_tables['field'])) || !$data){
			$result['error'] = 1;
			$result['msg'] = '数据获取失败';
		}else{
			$_fields = array();
			foreach($fields as $k=>$v){
				$_fields[$v['field_name']] = $v;
			}
			$cfg = $this->get_config('system');
			foreach($data as $k=>$v){
				if(!$v){
					$result['error'] = 1;
					$result['msg'] = '请填写'.$_fields[$k]['title'];
				}else{
					switch ($_fields[$k]['type']) {
						case 'mobile':
							if(!preg_match("/^1[3-9]\d{9}$/", $v)){
								$result['error'] = 1;
								$result['msg'] = '手机号码格式错误';
							}
							break;
						case 'number':
							if(!is_numeric($v)){
								$result['error'] = 1;
								$result['msg'] = $_fields[$k]['title'].'必须为数字格式';
							}
							break;
						case 'text':
							# code...
							break;
						case 'select':
							# code...
							break;
						case 'datetime':
							$yuyue_time = strtotime($v);
							$max_days = $cfg['max_days'] > 0 ? $cfg['max_days'] : 7;
							if(($yuyue_time - time()) > $max_days * 86400){
								$result['error'] = 1;
								$result['msg'] = '最多只能提前'.$max_days.'天预约';
							}
							$data[$k] = $yuyue_time;
							break;
						default:
							# code...
							break;
					}
				}
			}
			if($cfg['audit'] == 1){
				$data['audit'] = 0;
			}else{
				$data['audit'] = 1;
			}
			if($cfg['max_num'] && $data['num'] && $data['num'] > $cfg['max_num']){
				$result['error'] = 1;
				$result['msg'] = '最多只能预约'.$cfg['max_num'].'人';
			}
			$data['dateline'] = time();
			$result['data'] = $data;
			return $result;
		}
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

	public function format_time($time, $format='')
	{
		
		if($format){
			if($format == 'w'){
				$week = array('0'=>'星期日','1'=>'星期一','2'=>'星期二','3'=>'星期三','4'=>'星期四','5'=>'星期五','6'=>'星期六');
				return $week[date('w',$time)];
			}else{
				return date($format,$time);
			}
		}
		$s = date('Y-m-d H:i:s',$time);
		$sdaytime = mktime(0,0,0,date('m'),date('d'),date('Y'));
		$stime = time() - $time;
		if($time >= $sdaytime){ //当天
			if($stime > 3600) {
				return intval($stime / 3600).'小时前';
			} elseif($stime > 1800) {
				return '半小时前';
			} elseif($stime > 60) {
				return intval($stime / 60).'分钟前';
			} elseif($stime > 0) {
				return $stime.'秒前';
			} elseif($stime == 0) {
				return '刚刚';
			} else {
				return $s.'';
			}
		}else if(($days = intval($stime / 86400)) >= 0 && $days < 7){
			if($days == 0) {
				return '昨天';
			} elseif($days == 1) {
				return '前天';
			} else {
				return ($days + 1).'天前';
			}
		}else if(empty($time)){
			return '0';
		}else{
			return $s.'';
		}
	}

	public function doPageGetConfig()
	{
		global $_GPC, $_W;
		$errno = 0;
		$message = '获取成功';
		$key = $_GPC['key'];
		if(!$key){
			return false;
		}else if(!$config = pdo_get($this->app_tables['config'],array('k'=>$key),array())){
			return false;
		}else{
			return $this->result($errno, $message, iunserializer($config['v']));
		}
	}

	public function doPageGetAll(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '获取成功';
		if($_W['member']['uid']){
			$data = pdo_getall($this->app_tables['items'], array('uid' => $_W['member']['uid']), array());
			foreach($data as $key => &$val){
				if($val['date']){
					$val['date'] = date('Y-m-d H:i:s', $val['date']);
				}
			}
		}else{
			$data = array();
			$errno = 1;
			$message = '请先登录';
		}
		return $this->result($errno, $message, $data);
	}
}
