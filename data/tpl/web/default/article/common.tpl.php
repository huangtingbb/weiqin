<?php defined('IN_IA') or exit('Access Denied');?><div class="we7-page-title">文章公告管理</div>
<ul class="we7-page-tab">
    <li <?php  if($action == 'news' && $do == 'list') { ?> class="active"<?php  } ?>><a href="<?php  echo url('article/news/list');?>">新闻列表</a></li>
    <li <?php  if($action == 'news' && $do == 'category') { ?> class="active"<?php  } ?>><a href="<?php  echo url('article/news/category');?>">新闻分类</a></li>
    <li <?php  if($action == 'notice' && $do == 'list') { ?> class="active"<?php  } ?>><a href="<?php  echo url('article/notice/list');?>">公告列表</a></li>
    <li <?php  if($action == 'notice' && $do == 'category') { ?> class="active"<?php  } ?>><a href="<?php  echo url('article/notice/category');?>">公告分类</a></li>
</ul>