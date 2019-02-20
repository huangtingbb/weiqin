/**
 * Copyright(C),2016-2026,QinHaolei.com
 * Author: HaoleiQ@gmail.com
 * Date: 2017.10.10 
 * Description: 意见反馈页面
 * Function List: ·反馈内容 ·联系方式 ·上传图片;
**/
var Bmob = require('../../utils/bmob.js');
const app = getApp();
// 反馈文字内容
var feedbackContent = '';
// 联系方式
var contactContent = '';
// 上传意见截图
var uploadImagePath = [];

var pageV = {

  data: {
    chooseImgBtn: '',
  },

  onLoad: function (options) { },

  onShow: function () { },

  onReady: function () { },

  // 上传问题截图
  chooseImg: function () {
    var that = this;
    // 显示标题栏加载动画
    wx.showNavigationBarLoading();
    wx.chooseImage({
      count: 1, // 默认9
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: function (chooseImageRes) {
        // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片  
        var name = 'feedback-image:'+chooseImageRes.tempFilePaths + ""; //上传的图片的别名
        var file = new Bmob.File(name, chooseImageRes.tempFilePaths);
        // 最多上传10张图
        if (uploadImagePath.length < 11) {
          file.save().then(function (res) {
            feedbackContent = "图" + " " + feedbackContent;
            uploadImagePath.push(res.url());
            that.setData({
              src: uploadImagePath,
            });
            // 隐藏加载动画
            wx.hideNavigationBarLoading();
          }, function (error) { });
        } else {
          that.setData({
            chooseImgBtn: 'hide',
          });
        }

      }
    })
  },

  // 删除图片
  deleteImgClick: function (e) {
    var that = this;
    var id = e.currentTarget.id ? e.currentTarget.id : e.target.id;
    if (uploadImagePath.length == 1) {
      uploadImagePath = [];
      that.setData({
        src: uploadImagePath,
      });
    } else {
      for (var i = 0; i < uploadImagePath.length; i++) {
        if (id == uploadImagePath[i]) {
          uploadImagePath.splice(i, 1);
          that.setData({
            src: uploadImagePath,
          });
        }
      }
    }

  },

  // 输入联系方式
  contactInput: function (e) {
    contactContent = e.detail.value;
  },

  // 反馈内容
  feedbackContentInput: function (e) {
    feedbackContent = e.detail.value;
  },

  // 发送反馈
  sendBtnClick: function (e) {
    sendFdbackDataToServer();
  },

  // 返回上页
  returnBtnClick: function () {
    wx.navigateBack();
  },
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

// 获取用户OpenID
function getUserOpenID() {
  wx.getStorage({
    key: 'user_openid',
    success: function (res) {
      sendFdbackDataToServer(res);
    }
  })
}

// 发送反馈
function sendFdbackDataToServer(res) {
  if (feedbackContent != '') {
    var feedbackBomb = Bmob.Object.extend("m_feedback");
    var sendFeedback = new feedbackBomb(); 
    sendFeedback.set("contact", contactContent);
    sendFeedback.set("feedback", feedbackContent);
    // 如果用户上传了图片
    if (uploadImagePath.length > 0) {
      sendFeedback.set('remark', '图片地址:' + uploadImagePath);
    }
    sendFeedback.save(null, {
      success: function (result) {
        wx.showToast({
          title: '感谢您的反馈',
          icon: 'success',
          duration: 1226,
        });
        setTimeout(function () {
          wx.navigateBack();
        }, 1266);
      },
      error: function (result, error) {
        wx.showToast({
          title: '网络故障 请重试',
          icon: 'loading',
          duration: 1226
        })
      }
    });

  } else {
    wx.showToast({
      title: '空空的~',
      icon: 'loading',
      duration: 1222
    })
  }
}