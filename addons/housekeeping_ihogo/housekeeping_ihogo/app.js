const Bmob = require('utils/bmob.js');
const appParam = require('utils/appParam.js');
const util = require('utils/util.js');

var siteInfo = require('siteinfo.js')

var that;
Bmob.initialize(appParam.bmob.id, appParam.bmob.key);

App({
  onLaunch: function() {
    var _this = this,
      logs = wx.getStorageSync("logs") || [];
    logs.unshift(Date.now()), wx.setStorageSync("logs", logs), wx.login({
      success: function(res) {}
    }), wx.getSetting({
      success: function(res) {
        res.authSetting["scope.userInfo"] && wx.getUserInfo({
          success: function(res) {
            _this.globalData.userInfo = res.userInfo, _this.userInfoReadyCallback && _this.userInfoReadyCallback(res);
          }
        });
      }
    });
  },
  globalData: {
    userInfo: null
  },
  siteInfo: require('siteinfo.js'),
});