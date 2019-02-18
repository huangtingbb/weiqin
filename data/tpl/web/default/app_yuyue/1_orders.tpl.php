<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
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
        <form class="form-horizontal" id="form1" role="form" aciton="<?php  echo $this->createWebUrl('orders', array())?>" method="post">
           <div class="form-group">
               <?php  if(is_array($search)) { foreach($search as $val) { ?>
                    <?php  if($val['type'] == 'select') { ?>
               <span style="margin-left: 10px"><?php  echo $val['title'];?>：</span>
                    <select name="so[<?php  echo $val['field_name'];?>]" id="" style="width: 150px;margin-left: 10px">
                            <option value="">全部</option>
                       <?php  if(is_array($val['select'])) { foreach($val['select'] as $ss) { ?>
                            <option value="<?php  echo $ss['title'];?>"
                            <?php  if($ss['title'] == $so[$val['field_name']]) { ?>
                                selected
                            <?php  } ?>
                            ><?php  echo $ss['title'];?></option>
                       <?php  } } ?>
                    </select>
                    <?php  } else if($val['type'] == 'datetime') { ?>
               <span style="margin-left: 10px"><?php  echo $val['title'];?>：</span>
                        <?php  echo tpl_form_field_daterange("so[$val[field_name]]", array('start' => $so[$val['field_name']]['start'], 'end' => $so[$val[field_name]]['end']));?>
                    <?php  } else { ?>
                        <span style="margin-left: 10px"><?php  echo $val['title'];?>：</span><input type="<?php  echo $val['type'];?>" name="so[<?php  echo $val['field_name'];?>]" id="title" value="<?php  echo $so[$val['field_name']];?>" placeholder="" style="width: 100px;">
                    <?php  } ?>
               <?php  } } ?>
           </div>
           <div class="form-group">
            <button type="submit" class="btn btn-primary" style="float: left;margin-left: 15px;">搜索</button>
            <!-- <button type="button" class="btn btn-warning" style="float: left;margin-left: 15px;" id="output">导出</button> -->
            <input type="hidden" id="method" name="method" value="">
          </div>
        </form>

        <table class="table table-bordered table-hover">
          <tbody>
            <tr>
              <td style="text-align: center;background: #428BCA;color: white;">编号</td>
              <?php  if(is_array($fields)) { foreach($fields as $val) { ?>
                <td style="text-align: center;background: #428BCA;color: white;"><?php  echo $val['title'];?></td>
              <?php  } } ?>
                <?php  if($cof['audit'] == 1) { ?>
                    <td style="text-align: center;background: #428BCA;color: white;">审核</td>
                <?php  } ?>
              <td style="text-align: center;background: #428BCA;color: white;">提交时间</td>
              <td style="text-align: center;background: #428BCA;color: white;">操作</td>
            </tr>
            <?php  if(is_array($items)) { foreach($items as $val) { ?>
                <tr>
                  <td style="text-align: center;"><?php  echo $val['id'];?></td>
                  <?php  if(is_array($fields)) { foreach($fields as $vval) { ?>
                  <td style="text-align: center;"><?php  echo $val[$vval['field_name']];?></td>
                  <?php  } } ?>
                  <?php  if($cof['audit'] == 1) { ?>
                    <td style="text-align: center;"><?php  if($val['audit'] == 1) { ?>已审<?php  } else { ?>待审<?php  } ?></td>
                  <?php  } ?>
                  <td style="text-align: center;"><?php  echo $val['dateline'];?></td>
                  <td style="text-align: center;">
                    <!-- <a href="##" class="btn btn-xs btn-warning" onclick="detail(<?php  echo $val['id'];?>);">详情</a> -->
                      <?php  if($cof['audit'] == 1 && $val['audit'] == 0) { ?>
                      <a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="if (confirm('确定审核？')) { location.href = '<?php  echo $this->createWebUrl('orders', array('action' => 'examine', 'id' => $val['id']))?>'; }">审核</a>
                      <?php  } ?>
                    <a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="if (confirm('确定删除？')) { location.href = '<?php  echo $this->createWebUrl('orders', array('action' => 'delete', 'id' => $val['id']))?>'; }">删除</a>
                  </td>
                </tr>
            <?php  } } ?>
          </tbody>
        </table>
        <form style="float: right;"><?php  echo $pager;?></form>
    </div>
</div>
<!-- 模态框（Modal） --> 
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h4 class="modal-title" id="myModalLabel">预约详情</h4> 
            </div> 
            <div class="modal-body" id="content"></div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> 
            </div> 
        </div><!-- /.modal-content --> 
    </div><!-- /.modal -->
</div>
<script type="text/javascript">
    function detail(id){
        $.ajax({
            url:"<?php  echo $this->createWebUrl('orders', array('action' => 'detail'))?>",
            data:{id:id},
            dataType:'json',
            success:function(data){
                var inner_html = '<table class="table table-bordered table-hover">'+
                                 '<tbody>'+
                                 '<tr><td style="font-weight:600;">编号</td><td>'+data[0]+'</td></tr>'+
                                 '<tr><td style="font-weight:600;">日期</td><td>'+data[1]+'</td></tr>';
                for(var i=1;i<(data.length/2);i++){
                    inner_html += '<tr><td style="font-weight:600;">'+(data[2*i])+'</td><td>'+(data[2*i+1])+'</td></tr>';
                }
                inner_html +='</tbody>';
                inner_html +='</table>';
                $('#content').html(inner_html);
            },
            error:function(){
                console.log(2222222);
            }
        });

        $('#myModal').modal('show')
    }

    $('#output').click(function(){
      $('#method').val('output');
      $('#form1').submit();
      $('#method').val('');
    });

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>