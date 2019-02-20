<?php
namespace App\Api;

use PhalApi\Api;
use PhalApi\Model\NotORMModel as NotORM;

/**
 * 登录验证
 * @author Qin Haoleiq@gmail.com
 * @desc 登录方法
 */

class Login extends Base
{

    public function getRules()
    {
        return array(
            'index' => array(
                'username' => array('name' => 'username', 'require' => true, 'type' => 'string', 'desc' => '帐号'),
                'password' => array('name' => 'password', 'require' => true, 'type' => 'string', 'desc' => '密码'),
            ),
            'wxLogin' => array(
                'openid' => array('name' => 'openid', 'require' => true, 'type' => 'string', 'desc' => '微信用户openid'),
            ),
            'wxOpenid' => array(
                'code' => array('name' => 'code', 'require' => true, 'type' => 'string', 'desc' => '微信login获取的code'),
                'acid' => array('name' => 'acid', 'require' => false, 'type' => 'string', 'desc' => '微擎应用id'),
                'appid' => array('name' => 'appid', 'require' => false, 'type' => 'string', 'desc' => 'appid'),
                'secret' => array('name' => 'secret', 'require' => false, 'type' => 'string', 'desc' => 'secret'),
            ),
        );
    }

    /**
     * 普通用户登录验证
     * @desc 向数据库插入一条纪录数据
     * @return string sign sign
     * @return string uid uid
     */
    public function index()
    {
        $user = \PhalApi\DI()->notorm->ihogo_housekeeping_user;
        $result = $user
            ->select('*')
            ->where('username', $this->username)
            ->where('password', $this->password)
            ->fetchOne();

        if ($result['username']) {
            // 登陆成功
            session_start();
            $_SESSION[$result['uid']] = session_id();

            return array(
                'sign' => session_id(),
                'uid' => $result['uid'],
            );
        } else {
            // 登录失败
            return 'Login Fail';
        }
        return $result;
    }

    /**
     * 获取微信openid
     * @desc 获取微信openid
     * @return string openid openid
     */
    public function wxOpenid()
    {
        $that = $this;
        // 从微擎获取小程序信息
        function getWxInfo($code)
        {

        }

        /**
         * 从微信获取小程序openid
         * @desc 从微信获取小程序openid
         * @return string data openid
         * @return string data uid
         */
        function getOpenid($code, $appid, $secret, $acid)
        {
            session_start();
            // 获取openid
            function getOpenidFromWx($code, $appid, $secret)
            {
                //调用官方接口
                $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
                $result = file_get_contents($api, false);

                $result = json_decode($result);

                // 把openid存到user表中
                $user = \PhalApi\DI()->notorm->ihogo_housekeeping_user;
                $hasUserOpenidRes = $user
                    ->select('*')
                    ->where('openid', $result->openid)
                    ->fetchOne();

                if($result->openid){
                    $_SESSION[$result->openid] = session_id();
                }       

                // 已经存在的客户
                if ($hasUserOpenidRes) {
                    return array(
                        'openid' => $result->openid,
                        'uid' => $result->openid,
                        'sign' => $_SESSION[$result->openid],
                    );
                }
                
                // 不存在的 添加新客户
                else {
                    $data = array('openid' => $result->openid, 'uid' => $result->openid);
                    $user->insert($data);
                    return array(
                        'openid' => $result->openid,
                        'uid' => $result->openid,
                        'sign' => $_SESSION[$result->openid],
                    );
                }
            }

            // 是否是微擎用户
            if ($acid) {
                $wxinfo = \PhalApi\DI()->notorm->ims_account_wxapp;
                $result = $wxinfo
                    ->select('*')
                    ->where('acid', $acid)
                    ->fetchAll();

                $appid = $result[0]['key']; //微信开发者appId
                $secret = $result[0]['secret']; // appId秘钥
                return getOpenidFromWx($code, $appid, $secret);
            } else {
                return getOpenidFromWx($code, $appid, $secret);
            }
        }

        return getOpenid($this->code, $this->appid, $this->secret, $this->acid);
    }
}
