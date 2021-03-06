<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="<?php  echo MODULE_URL?>/template/static/css/colorpicker.css">

<div class="main">
    <div class="col-lg-12" style="margin:30px auto;">
        <p><h1>颜色DIY</h1></p>
        <form class="form-horizontal" role="form" aciton="<?php  echo $this->createWebUrl('items_manager', array())?>" method="post">
            <input type="hidden" name="action" value="color">
            <div class="form-group">
                <label class="control-label col-sm-2">小程序头部主色</label>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-2">
                    <div id="colorSelector1"><div style="width: 34px;height: 34px;background:<?php  echo $config['color']['base_color'];?> ;float: left;border: 1px solid #ccc;border-right: 0;"></div></div>
                    <input type="text" id="base_color" name="color[base_color]" value="<?php  echo $config['color']['base_color'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off" style="width: 100px">
                </div>
                <div class="form-controls col-sm-3 help-block">顶部颜色</div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">小程序预约显示颜色</label>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-2">
                    <div id="colorSelector2"><div style="width: 34px;height: 34px;background:<?php  echo $config['color']['yuyue_color'];?> ;float: left;border: 1px solid #ccc;border-right: 0;"></div></div>
                    <input type="text" id="yuyue_color" name="color[yuyue_color]" value="<?php  echo $config['color']['yuyue_color'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off" style="width: 100px">
                </div>
                <div class="form-controls col-sm-3 help-block">banner图下的预约人数背景色</div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">小程序按钮</label>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-2">
                    <div id="colorSelector3"><div style="width: 34px;height: 34px;background:<?php  echo $config['color']['btn_color'];?> ;float: left;border: 1px solid #ccc;border-right: 0;"></div></div>
                    <input type="text" id="btn_color" name="color[btn_color]" value="<?php  echo $config['color']['btn_color'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off" style="width: 100px">
                </div>
                <div class="form-controls col-sm-3 help-block">小程序按钮颜色背景色</div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">小程序背景色</label>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-2">
                    <div id="colorSelector4"><div style="width: 34px;height: 34px;background:<?php  echo $config['color']['bg_color'];?> ;float: left;border: 1px solid #ccc;border-right: 0;"></div></div>
                    <input type="text" id="bg_color" name="color[bg_color]" value="<?php  echo $config['color']['bg_color'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off" style="width: 100px">
                </div>
                <div class="form-controls col-sm-3 help-block">小程序背景颜色</div>
            </div>
            <button type="submit" class="btn btn-primary" style="float: right;">确定</button>
        </form>
    </div>
    <div class="col-lg-12" style="margin:30px auto;">
        <p><h1>参数设置</h1></p>
        <form class="form-horizontal" role="form" aciton="<?php  echo $this->createWebUrl('items_manager', array())?>" method="post">
          <input type="hidden" name="action" value="app">
          <div class="form-group">
            <label for="input1" class="col-sm-2 control-label">Appid</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="input1" name="app[appid]" placeholder="请输入小程序Appid" value="<?php  echo $config['app']['appid'];?>">
            </div>
          </div>
          <div class="form-group">
            <label for="input2" class="col-sm-2 control-label">Appsecret</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="input2" name="app[appsecret]" placeholder="请输入小程序Appsecret" value="<?php  echo $config['app']['appsecret'];?>">
            </div>
          </div>
          <div class="form-group">
            <label for="input3" class="col-sm-2 control-label">模版id</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="input3" name="app[template_id]" placeholder="请输入小程序模版ID" value="<?php  echo $config['app']['template_id'];?>">
              <span class="help-block">*根据字段管理中设置的模板消息字段，在小程序平台申请适合的消息模板。</span>
            </div>
          </div>
          <span style="margin-left:80px;">(填写这三个参数以后，方可发送微信模版消息)</span>
          <button type="submit" class="btn btn-primary" style="float: right;">确定</button>
        </form>
    </div>
    <div class="col-lg-12" style="margin:30px auto;">
        <p><h1>功能设置</h1></p>
        <form class="form-horizontal" role="form" aciton="<?php  echo $this->createWebUrl('items_manager', array())?>" method="post">
          <input type="hidden" name="action" value="system">
          <div class="form-group">
            <label for="input1" class="col-sm-2 control-label">小程序名称</label>
            <div class="col-sm-10">
              <input type="text" class="form-control col-sm-4" id="input1" name="system[app_name]" placeholder="请输入小程序名称" value="<?php  echo $config['system']['app_name'];?>">
            </div>
          </div>
          <div class="form-group">
            <label for="input1" class="col-sm-2 control-label">咨询电话</label>
            <div class="col-sm-10">
              <input type="text" class="form-control col-sm-4" id="input1" name="system[phone]" placeholder="请输入咨询电话" value="<?php  echo $config['system']['phone'];?>">
              <span class="help-block">*咨询电话将显示在预约说明的下方</span>
            </div>
          </div>
          <div class="form-group">
            <label for="input1" class="col-sm-2 control-label">预约人数基础数字</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="input1" name="system[base_number]" value="<?php  echo $config['system']['base_number'];?>">
              <span class="help-block">*首页已经预约人数：基础数字+实际预约人数</span>
            </div>
          </div>
          <div class="form-group">
            <label for="input1" class="col-sm-2 control-label">提前预约天数</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="input1" name="system[max_days]" value="<?php  echo $config['system']['max_days'];?>">
              <span class="help-block">*在启用了预约日期字段的情况下，这里填写的数字决定了可以预约的最远日期</span>
            </div>
          </div>
          <div class="form-group">
            <label for="input1" class="col-sm-2 control-label">最大预约人数</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="input1" name="system[max_num]"  value="<?php  echo $config['system']['max_num'];?>">
              <span class="help-block">*在启用了预约人数字段的情况下，这里填写的数字决定了一次可以预约的最多人数</span>
            </div>
          </div>
          <div class="form-group">
            <label for="input2" class="col-sm-2 control-label">预约信息审核</label>
            <div class="col-sm-10">
              <label><input type="radio" name="system[audit]" <?php  if($config['system']['audit'] == 1) { ?>checked=checked<?php  } ?>  value="1" >开启</label>
              <label style="margin-left:30px;"><input type="radio" name="system[audit]" <?php  if($config['system']['audit'] == 0) { ?>checked=checked<?php  } ?> value="0" >关闭</label>
              <span class="help-block">*如果开启了审核，用户提交预约信息之后，在后台经过人工审核操作才会发送预约成功的模板消息；如果关闭审核，则用户提交信息之后会立即收到预约成功的通知。</span>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" style="float: right;">确定</button>
        </form>
    </div>
    <div class="col-lg-12" style="margin:30px auto;">
        <form class="form-horizontal" role="form" aciton="<?php  echo $this->createWebUrl('items_manager', array())?>" method="post">
          <p><h1>首页预约说明</h1></p>
          <input type="hidden" name="action" value="notice">
          <?php  echo tpl_ueditor('notice[index_content]', $value = $config['notice']['index_content'], $options = array('height'=>500))?>
          <br>
        <p><h1>预约说明详情</h1></p>
          <input type="hidden" name="action" value="notice">
          <?php  echo tpl_ueditor('notice[content]', $value = $config['notice']['content'], $options = array('height'=>500))?>
          <br>
          <button type="submit" class="btn btn-primary" style="float: right;">提交</button>
        </form>
    </div>
</div>
<script src="/addons/app_yuyue/template/static/js/colorpicker.js"></script>
  <script type="text/javascript">
      $('#colorSelector1').ColorPicker({
          color: '#0000ff',
          onShow: function (colpkr) {
              $(colpkr).fadeIn(500);
              return false;
          },
          onHide: function (colpkr) {
              $(colpkr).fadeOut(500);
              return false;
          },
          onChange: function (hsb, hex, rgb) {
              $('#colorSelector1 div').css('backgroundColor', '#' + hex);
              $('#base_color').val("#"+hex);
          }
      });
      $('#colorSelector2').ColorPicker({
          color: '#0000ff',
          onShow: function (colpkr) {
              $(colpkr).fadeIn(500);
              return false;
          },
          onHide: function (colpkr) {
              $(colpkr).fadeOut(500);
              return false;
          },
          onChange: function (hsb, hex, rgb) {
              $('#colorSelector2 div').css('backgroundColor', '#' + hex);
              $('#yuyue_color').val("#"+hex);
          }
      });
      $('#colorSelector3').ColorPicker({
          color: '#0000ff',
          onShow: function (colpkr) {
              $(colpkr).fadeIn(500);
              return false;
          },
          onHide: function (colpkr) {
              $(colpkr).fadeOut(500);
              return false;
          },
          onChange: function (hsb, hex, rgb) {
              $('#colorSelector3 div').css('backgroundColor', '#' + hex);
              $('#btn_color').val("#"+hex);
          }
      });
      $('#colorSelector4').ColorPicker({
          color: '#0000ff',
          onShow: function (colpkr) {
              $(colpkr).fadeIn(500);
              return false;
          },
          onHide: function (colpkr) {
              $(colpkr).fadeOut(500);
              return false;
          },
          onChange: function (hsb, hex, rgb) {
              $('#colorSelector4 div').css('backgroundColor', '#' + hex);
              $('#bg_color').val("#"+hex);
          }
      });


</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>