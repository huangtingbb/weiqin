<?php
/**
 *
 *
 * @author Haoleiqin
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Init
{
    private $wechat_app;
    private $allConfig;
    public function __construct()
    {
        global $_W;
        $this->wechat_app = $_W['account']; 
        $this->allConfig = $_W; 
        
    }

    private function session()
    {
        @session_start();
        $_SESSION['w7userFromiHogo_housekeeping_ihogo'] = [
            'wxapp' => [
                'wxapp_id' => $this->wechat_app['uniacid'],
            ],
            'we7_data' => [
                'wxapp_id' => $this->wechat_app['uniacid'],
                'app_name' => $this->wechat_app['name'],
                'app_id' => $this->wechat_app['key'],
                'app_secret' => $this->wechat_app['secret'],
            ],
            'is_login' => true,
        ];
    }

    private function go()
    
    {
        global $_W;
        $backEndUrl = "{$_W['siteroot']}addons/{$_W['current_module']['name']}/web/backEnd/public/?s=Utils_Check.world";
        $frontEndUrl = "{$_W['siteroot']}addons/{$_W['current_module']['name']}/web/frontEnd/view/index.html";
        header('Location:' . $frontEndUrl);
        exit;
    }

    public function execute()
    { 
        $this->session();
        $this->go();
        // var_dump ($_SESSION['mininote_wechat']);
    }
}
// global $_W;
// echo json_encode($_W);
(new Init)->execute();
