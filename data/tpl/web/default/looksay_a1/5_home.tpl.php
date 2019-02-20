<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form class="" action="" method="post">
    <div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">APPID</label>
			<div class="col-sm-10 col-lg-9 col-xs-12">
				<input id="" name="appid" type="text" class="form-control" value="<?php  echo $appid;?>">
				<span class="help-block">腾讯AI开放平台申请（https://ai.qq.com/）</span>
			</div>
		</div>
  	<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">APPKEY</label>
			<div class="col-sm-10 col-lg-9 col-xs-12">
				<input id="" name="appkey" type="text" class="form-control" value="<?php  echo $appkey;?>">
				<span class="help-block">腾讯AI开放平台申请（https://ai.qq.com/）</span>
			</div>
		</div>

					<button type="submit" class="btn btn-primary">确认</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

  
  
    </form>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>