<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/app_yuyue_header', TEMPLATE_INCLUDEPATH)) : (include template('common/app_yuyue_header', TEMPLATE_INCLUDEPATH));?>

path: path/test.html

<br>
<?php  echo tpl_form_field_multi_image('single-image');?>
