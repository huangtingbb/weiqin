<?php
namespace App\Common;

use PhalApi\Exception\BadRequestException;
use PhalApi\Filter;

class SignFilter implements Filter
{
    public function check()
    {
       
        session_id($_GET['sign']);
        @session_start();
        
        // 验证session
        function verifySession()
        {
            // 验证成功
            if ($_GET['sign'] == $_SESSION[$_GET['uid']]) {

            }  
            /**
             * data []
             * msg:"非法请求：wrong sign"
             * ret:401
             */
            else{
                echo 1;
                var_dump($_GET['uid']);
                var_dump($_SESSION[$_GET['uid']]);
                // throw new BadRequestException('wrong sign', 1);
            }
        }

        // 如果是微擎已登陆打开
        if ($_SESSION['w7userFromiHogo_housekeeping_ihogo']['is_login']) {
  
        } else {
            verifySession();
        }

    }
}
