<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/app_yuyue_header', TEMPLATE_INCLUDEPATH)) : (include template('common/app_yuyue_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .circle {
        width:24px;
        height:24px;
        line-height:22px;
        text-align:center;
        border-radius:50%;
        border:1px solid red;
        color:red;
    }
</style>
<div class="main">
    <div class="col-lg-12">
        <div class="panel panel-success">
            <div class="main">
                <ul class="nav nav-tabs">
                    <li class="active">
                    <a href="<?php  echo $this->createWebUrl('fields')?>"><?php  if($_GPC[ 'action']=='') { ?>字段列表<?php  } else { ?>返回字段列表<?php  } ?></a>
                    </li>
                    <!-- <li <?php  if($_GPC[ 'action']=='add' ) { ?>class="active" <?php  } ?>>
                    <a href="<?php  echo $this->createWebUrl('fields', array('action' => 'add'))?>">添加</a>
                    </li>
                    <li <?php  if($_GPC[ 'action']=='edit' ) { ?>class="active" <?php  } ?>>
                    <a href="javascript:void(0);">编辑</a>
                    </li> -->
                </ul>
                </ul>
            </div>
            <div class="panel-body">
                <?php  if($_GPC['action'] == '') { ?>

                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th style="width: 15%;">字段名称</th>
                                <th style="width: 15%;text-align: center;">字段类型</th>
                                <th style="width: 15%;">启用</th>
                                <th style="width: 15%;">搜索</th>
                                <th style="width: 15%;">排序</th>
                                <th style="width: 10%;">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  if(is_array($list)) { foreach($list as $val) { ?>
                            <tr>
                                <td style="width: 10%;height: 50px;line-height: 50px;">
                                    <?php  echo $val['title'];?>
                                </td>
                                <td style="width: 20%;height: 50px;line-height: 50px;text-align: center;">
                                    <?php  if($val['type']== 'number') { ?>数字类型<?php  } ?>
                                    <?php  if($val['type']== 'select') { ?>选择类型<?php  } ?>
                                    <?php  if($val['type']== 'datetime') { ?>日期时间<?php  } ?>
                                    <?php  if($val['type']== 'text') { ?>文本类型<?php  } ?>
                                    <?php  if($val['type']== 'mobile') { ?>手机号<?php  } ?>
                                </td>
                                <td style="width: 10%;height: 50px;line-height: 50px;">
                                    <?php  if($val['is_open']== '1') { ?>启用<?php  } ?>
                                    <?php  if($val['is_open']== '0') { ?>停用<?php  } ?>
                                </td>
                                <td style="width: 10%;height: 50px;line-height: 50px;">
                                    <?php  if($val['is_search']== '1') { ?>开启<?php  } ?>
                                    <?php  if($val['is_search']== '0') { ?>关闭<?php  } ?>
                                </td>
                                <td style="width: 10%;height: 50px;line-height: 50px;">
                                    <?php  echo $val['orderby'];?>
                                </td>
                                <td style="width: 10%;height: 50px;line-height: 50px;">
                                    <a href="<?php  echo $this->createWebUrl('fields', array('action' => 'edit', 'field_id' => $val['id']))?>" class="btn btn-xs btn-warning">编辑</a>
                                </td>
                            </tr>
                            <?php  } } ?>
                        </tbody>
                    </table>
                <?php  } ?>
                <?php  if($_GPC['action'] == 'edit') { ?>
                <form action="<?php  echo $this->createWebUrl('fields', array('action' => 'update'))?>" method="post">
                    <input type="hidden" name="field_id" value="<?php  echo $detail['id'];?>">
                    <p>字段名称：<input type="text" name="data[title]" value="<?php  echo $detail['title'];?>"></p>
                    <?php  if($detail['default'] == 0) { ?>
                    <p>字段类型：
                        <select id="field_type" name="data[type]">
                            <option value='text' <?php  if($detail['type'] == 'text') { ?>selected=selected<?php  } ?>>文本</option>
                            <option value='mobile' <?php  if($detail['type'] == 'mobile') { ?>selected=selected<?php  } ?>>手机号</option>
                            <option value='datetime' <?php  if($detail['type'] == 'datetime') { ?>selected=selected<?php  } ?>>日期时间</option>
                            <option value='number' <?php  if($detail['type'] == 'number') { ?>selected=selected<?php  } ?>>数字</option>
                            <option value='select' <?php  if($detail['type'] == 'select') { ?>selected=selected<?php  } ?>>下拉选择</option>
                        </select>
                    </p>
                    <?php  } else { ?>
                    <input type="hidden" value="<?php  echo $detail['type'];?>" name="data[type]" >
                    <?php  } ?>
                    <p>排序：<input type="text" name="data[orderby]" value="<?php  echo $detail['orderby'];?>"></p>
                    <p>开启：
                        <label><input type="radio" name="data[is_open]" <?php  if($detail['is_open'] == 1) { ?>checked=checked<?php  } ?>  value="1" >开启</label>
                        <label style="margin-left:30px;"><input type="radio" name="data[is_open]" <?php  if($detail['is_open'] == 0) { ?>checked=checked<?php  } ?> value="0" >关闭</label>
                    </p>
                    <p>模板消息字段：
                        <label><input type="radio" name="data[is_temp]" <?php  if($detail['is_temp'] == 1) { ?>checked=checked<?php  } ?>  value="1" >是</label>
                        <label style="margin-left:30px;"><input type="radio" name="data[is_temp]" <?php  if($detail['is_temp'] == 0) { ?>checked=checked<?php  } ?> value="0" >否</label>
                    </p>
                    <p>允许搜索：
                        <label><input type="radio" name="data[is_search]" <?php  if($detail['is_search'] == 1) { ?>checked=checked<?php  } ?>  value="1" >是</label>
                        <label style="margin-left:30px;"><input type="radio" name="data[is_search]" <?php  if($detail['is_search'] == 0) { ?>checked=checked<?php  } ?> value="0" >否</label>
                    </p>
                    <div id="select_items" class="form-group <?php  if($detail['type'] == 'select') { ?>show<?php  } else { ?>hidden<?php  } ?>">
                        <p class="bg-primary">下拉选择项目列表：</p>
                        <button class="btn btn-success" id="additems" type="button">+添加项目</button>
                        <?php  if(is_array($detail['select_items'])) { foreach($detail['select_items'] as $val) { ?>
                            <div>
                                <br>
                                名称：<input type="text" class="item" name="select[title][]" value="<?php  echo $val['title'];?>">&nbsp;&nbsp;
                                排序：<input type="text" class="item" name="select[orderby][]" value="<?php  echo $val['orderby'];?>">&nbsp;&nbsp;
                                <label><div class="circle del">x</div></label>
                            </div>
                        <?php  } } ?>
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
<script type="text/javascript">
    $('#additems').click(function(){
        $('#select_items').append('<div><br>名称：<input type="text" class="item" name="select[title][]">&nbsp;&nbsp;排序：<input type="text" class="item" name="select[orderby][]" value="10">&nbsp;&nbsp;<label><div class="circle del">x</div></label></div>');

        $('.del').click(function(){
            $(this).parent().parent().remove();
        });
    });

    $('.del').click(function(){
        $(this).parent().parent().remove();
    });

    $('#field_type').change(function(){
        if($(this).val() == 'select'){
            $('#select_items').addClass('show');
            $('#select_items').removeClass('hidden');
        }else{
            $('#select_items').addClass('hidden');
            $('#select_items').removeClass('show');
        }
    });
   
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
