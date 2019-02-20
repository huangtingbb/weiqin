/**
 * Copyright(C),2016-2026,QinHaolei.com
 * Author: HaoleiQ@gmail.com
 * Date: 2017.10.10 
 * Description: 意见反馈页面
 * Function List: ·反馈内容 ·联系方式 ·上传图片;
**/
var Bmob = require('../../utils/bmob.js');
const app = getApp();
const appParam = app.appParam;
// 反馈文字内容
var feedbackContent = '';
// 联系方式
var contactContent = '';
// 上传意见截图
var uploadImagePath = [];

var that;

var pageV = {

  data: {
    chooseImgBtn: '',
    siteUrl:''
  },

  onLoad: function (options) { 
    that=this;
    if (options.about) {
      that.setData({
        siteUrl: 'https://mp.weixin.qq.com/mp/homepage?__biz=MzUyMTU0MzIxMw==&hid=1&sn=90dbd9c7321846e4511688edf0a3cdd4&scene=18#wechat_redirect'
      });
    }

    else if (options.history){
       that.setData({
         siteUrl: 'https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzUyMTU0MzIxMw==#wechat_redirect'
       });
    } 
    else if(options.url){
      that.setData({
        siteUrl: options.url
      });
    }


  },

  onShow: function () { },

  onReady: function () { }, 
  onShareAppMessage: function () {
    if (res.from === 'button') {
      // 来自页面内转发按钮
      console.log(res.target)
    }
    return {
      title: '新视窗',
      path: 'pages/index/index'
    }
  },
};

// 初始化
Page(pageV);
