<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb we7-breadcrumb">
	<a href="<?php  echo url('article/notice/category');?>"><i class="wi wi-back-circle"></i> </a>
	<li>
		<a href="<?php  echo url('article/notice/category');?>">公告分类</a>
	</li>
	<li>
		添加分类
	</li>
</ol>

<?php  if($do == 'category_post') { ?>
<div class="clearfix">
	<form action="<?php  echo url('article/notice/category_post');?>" method="post" class="we7-form" role="form">
		
				<div id="tpl">
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 control-label">分类名称</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="title[]" vlaue="" placeholder="分类名称"/>
							<div class="help-block">请填写分类名称</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 control-label">排序</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="displayorder[]" vlaue="" placeholder="排序"/>
							<div class="help-block">数字越大，越靠前</div>
						</div>
					</div>
					<hr/>
				</div>
				<div id="container"></div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 control-label"></label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<a href="javascript:;" id="category-add"><i class="fa fa-plus-circle"></i> 继续添加分类</a>
					</div>
				</div>
			
		<div class="form-group">
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<input type="submit" class="btn btn-primary" name="submit" value="提交" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
</div>
<?php  } ?>
<script>
	$(function(){
		$('#category-add').click(function(){
			var html = $('#tpl').html();
			$('#container').append(html);
			return false;
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
