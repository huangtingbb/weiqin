<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
    <div class="col-lg-12">
        <div class="panel panel-success">
            <div class="main">
                <ul class="nav nav-tabs">
                    <li <?php  if($_GPC[ 'action']=='' && $_GPC['type'] != 2 ) { ?>class="active" <?php  } ?>>
                    <a href="<?php  echo $this->createWebUrl('image')?>">图片列表</a>
                    </li>
                    <li <?php  if($_GPC[ 'action']=='add' ) { ?>class="active" <?php  } ?>>
                    <a href="<?php  echo $this->createWebUrl('image', array('action' => 'add'))?>">添加</a>
                    </li>
                    <li <?php  if($_GPC[ 'action']=='edit' ) { ?>class="active" <?php  } ?>>
                    <a href="javascript:void(0);">编辑</a>
                    </li>
                </ul>
                </ul>
            </div>
            <div class="panel-body">
                <?php  if($_GPC['action'] == '') { ?>
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th style="width: 15%;">图片名称</th>
                                <th style="width: 15%;">图片</th>
                                <th style="width: 15%;">跳转页面地址</th>
                                <th style="width: 10%;">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  if(is_array($list)) { foreach($list as $val) { ?>
                            <tr>
                                <td style="width: 15%;height: 50px;line-height: 50px;"><?php  echo $val['title'];?></td>
                                <td style="width: 15%;"><img src="<?php  echo tomedia($val['image']);?>" style="width: 100px;height: 50px;"></td>
                                <td style="width: 20%;height: 50px;line-height: 50px;">
                                    <?php  echo $val['url'];?>
                                </td>
                                <td style="width: 10%;height: 50px;line-height: 50px;">
                                    <a href="<?php  echo $this->createWebUrl('image', array('action' => 'edit', 'id' => $val['id']))?>" class="btn btn-xs btn-warning">编辑</a>
                                    <a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="if (confirm('确定删除？')) { location.href = '<?php  echo $this->createWebUrl('image', array('action' => 'delete', 'id' => $val['id']))?>'; }">删除</a>
                                </td>
                            </tr>
                            <?php  } } ?>
                        </tbody>
                    </table>
                <?php  } ?>
                <?php  if($_GPC['action'] == 'add') { ?>
                <form action="<?php  echo $this->createWebUrl('image', array('action' => 'create'))?>" method="post">
                    <input type="hidden" name="versionid" value="<?php  echo $_W['uniacid'];?>">
                    <div class="form-group">
                        <label>图片名称：</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="不显示在前台">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label>图片：</label>
                        <?php  echo tpl_form_field_image('image');?>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label>跳转页面地址：</label>
                        <input type="text" name="url" id="url" class="form-control" placeholder="填写完整的Https://开头地址">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="提交" class="btn btn-primary">
                    </div>
                </form>
                <?php  } ?>
                <?php  if($_GPC['action'] == 'edit') { ?>
                <form action="<?php  echo $this->createWebUrl('image', array('action' => 'update'))?>" method="post">
                    <input type="hidden" name="id" value="<?php  echo $edit['id'];?>">
                    <input type="hidden" name="versionid" value="<?php  echo $edit['versionid'];?>">
                    <div class="form-group">
                        <label>图片名称</label>
                        <input type="text" name="title"  class="form-control" placeholder="" value="<?php  echo $edit['title'];?>">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label>图片</label>
                        <?php  echo tpl_form_field_image('image', $edit['image']);?>
                    </div>
                    <div class="form-group">
                        <label>跳转页面地址</label>
                        <input type="text" name="url" class="form-control"  value="<?php  echo $edit['url'];?>" placeholder="填写完整的Https://开头地址">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="提交" class="btn btn-primary">
                    </div>
                </form>
                <?php  } ?>
            </div>
        </div>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>