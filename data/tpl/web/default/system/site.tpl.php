<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-title">站点设置</div>
<ul class="we7-page-tab">
	<li<?php  if($do == 'copyright') { ?> class="active"<?php  } ?>><a href="<?php  echo url('system/site');?>">站点信息</a></li>
</ul>
<div class="clearfix">
	<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">关闭站点</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" name="status" id="status-1" <?php  if($settings['status'] == 1) { ?> checked="checked" <?php  } ?> value="1" />
				<label class="radio-inline" for="status-1">
					 是
				</label>
				<input type="radio" name="status" id="status-0" <?php  if($settings['status'] == 0) { ?> checked="checked" <?php  } ?> value="0" /> 
				<label class="radio-inline" for="status-0">
					否
				</label>
			</div>
		</div>
		<div class="form-group reason" <?php  if($settings['status'] == 0) { ?> style="display:none;" <?php  } ?>>
			<label class="col-sm-2 control-label" style="text-align:left;">关闭原因</label>
			<div class="col-sm-8">
				<textarea style="height:150px;" class="form-control" cols="70" name="reason" autocomplete="off"><?php  echo $settings['reason'];?></textarea>
				<input type="hidden" name="reasons" value="<?php  echo $settings['reason'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">备案号</label>
			<div class="col-sm-8">
				<input type="text" name="icp" class="form-control" value="<?php  echo $settings['icp'];?>">
			</div>
		</div>

		<h5 class="page-header">调试开关</h5>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">是否开启调试模式</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" id="develop_status-1" name="develop_status" <?php  if($settings['develop_status'] == 1) { ?> checked="checked" <?php  } ?> value="1" />
				<label class="radio-inline" for="develop_status-1">
					是
				</label>
				<input type="radio" id="develop_status-0" name="develop_status" <?php  if($settings['develop_status'] == 0) { ?> checked="checked" <?php  } ?> value="0" />
				<label class="radio-inline" for="develop_status-0">
					否
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">是否开启日志</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" id="log_status-1" name="log_status" <?php  if($settings['log_status'] == 1) { ?> checked="checked" <?php  } ?> value="1" />
				<label class="radio-inline" for="log_status-1">
					是
				</label>
				<input type="radio" id="log_status-0" name="log_status" <?php  if($settings['log_status'] == 0) { ?> checked="checked" <?php  } ?> value="0" />
				<label class="radio-inline" for="log_status-0">
					否
				</label>
			</div>
		</div>
		
		
		<div class="form-group">
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
				<input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
	<script type="text/javascript">
			$("#form1").submit(function() {
				if ($("input[name='status']:checked").val() == 1) {
					if ($("textarea[name='reason']").val() == '') {
						util.message('请填写站点关闭原因');
						return false;
					}
				}
			});
			$("input[name='status']").click(function() {
				if ($(this).val() == 1) {
					$(".reason").show();
					var reason = $("input[name='reasons']").val();
					$("textarea[name='reason']").text(reason);
				} else {
					$(".reason").hide();
				}
			});
			$("input[name='mobile_status']").click(function() {
				if ($(this).val() == 0) {
					$("#login_type_status-1").attr("checked", false);
					$("#login_type_status-0").prop("checked", true);
					$("#login_type_status-1").attr("disabled", true);
				} else {
					$("#login_type_status-1").attr("disabled", false);
				}
			});
	</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
