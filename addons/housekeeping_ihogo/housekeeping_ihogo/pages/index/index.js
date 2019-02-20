 var that;
 const Bmob = require('../../utils/bmob.js');
 const appParam = require('../../utils/appParam.js');
 var app = getApp();
 Page({
   data: {
     imgUrls: [],
     indicatorDots: !1,
     autoplay: !1,
     interval: 3e3,
     duration: 800,
     url: [],
     notice: [],
     hot: [],
     order: []
   },
   onLoad: function(options) {
     that = this;
     wx.getSystemInfo({
       success: function(res) {
         that.setData({
           ContentTextHeight: res.windowHeight,
           sysW: res.windowWidth,
         });
       }
     });
     init();

   },
   onShow: function() {},

   onPullDownRefresh: function() {
     wx.showToast({
       title: '刷新成功',
     })
     init();
     wx.stopPullDownRefresh();

   },

   toAbout: function(e) {
     wx.navigateTo({
       url: "about/about"
     });
   },
   onShareAppMessage: function() {
     if (res.from === 'button') {
       // 来自页面内转发按钮
       console.log(res.target)
     }
     return {
       title: '新视窗',
       path: 'pages/index/index'
     }
   },

   go2DetailsWeb: function(e) {
     wx.navigateTo({
       url: '../website/index?url=' + e.currentTarget.dataset.url,
     })
   },
   toDialogue: function(e) {
     wx.makePhoneCall({
       phoneNumber: (e.currentTarget.dataset.phone) + ''
     });
   },

   // 取消选择时段
   cancelPopChooseTime: function() {
     that.setData({
       showCloseAllPopx: false,
     });
   },

   openManDetails: function(e) {
     var currentMan = {
       map: e.currentTarget.dataset.map,
       name: e.currentTarget.dataset.name,
       phone: e.currentTarget.dataset.phone,
       price: e.currentTarget.dataset.price,
       service: e.currentTarget.dataset.service,
       introduction: e.currentTarget.dataset.introduction,
       img: e.currentTarget.dataset.img
     };

     that.setData({
       showCloseAllPopx: true,
       currentMan: currentMan
     });
   },
   go2Us: function() {
     wx.switchTab({
       url: '../user/user',
     })
   },
 });


 function init() {
   // 获取sign
   wx.login({
     success: function(code) {
       wx.request({
         url: appParam.apiUrl.local + 'Login.wxOpenid',
         data: {
           code: code.code,
           acid: appParam.siteInfo.acid,
         },
         complete: function(userData) {
           wx.setStorage({
             key: 'userData',
             data: userData.data.data,
             success: function() {
              //  
               wx.request({
                 url: appParam.apiUrl.local + 'About.getAllData',
                 data: {
                   sign: userData.data.data.sign,

                   uid: userData.data.data.uid,
                 },
                 success: function(results) {
                   that.setData({
                     phoneNumber: parseInt(results.data.data[0].phone)
                   });
                   wx.setStorage({
                     key: 'phone',
                     data: parseInt(results.data.data[0].phone),
                   });
                   wx.setStorage({
                     key: 'map',
                     data: [results.data.data[0].map_gps.split(',')[0], results.data.data[0].map_gps.split(',')[1]],
                   });

                   wx.setStorage({
                     key: 'AboutCompanyData',
                     data: results.data.data[0],
                   })
                 },
                 fail: function(err) {
                   console.log(err)
                 }
               });
              //  
               wx.request({
                 url: appParam.apiUrl.local + 'SliderImg.getAllData',
                 data: {
                   sign: userData.data.data.sign,

                   uid: userData.data.data.uid,
                 },
                 success: function (results) {
                   that.setData({
                     swiperDataList: results.data.data,
                   });
                 },
                 fail: function (err) {
                   console.log(err)
                 }
               });
               //  
               wx.request({
                 url: appParam.apiUrl.local + 'Notice.getAllData',
                 data: {
                   sign: userData.data.data.sign, 
                   uid: userData.data.data.uid,
                 },
                 success: function (results) {
                   that.setData({
                     notice: results.data.data[0]
                   });
                 },
                 fail: function (err) {
                   console.log(err)
                 }
               });
               //  
               wx.request({
                 url: appParam.apiUrl.local + 'Category.getAllData',
                 data: {
                   sign: userData.data.data.sign,
                   uid: userData.data.data.uid,
                 },
                 success: function (results) {
                   that.setData({
                     categoryList: results.data.data
                   });
                 },
                 fail: function (err) {
                   console.log(err)
                 }
               });
               //  
               wx.request({
                 url: appParam.apiUrl.local + 'Wokers.getAllData',
                 data: {
                   sign: userData.data.data.sign,
                   uid: userData.data.data.uid,
                 },
                 success: function (results) {
                   that.setData({
                     hotMan: results.data.data
                   });
                 },
                 fail: function (err) {
                   console.log(err)
                 }
               });
              //  

            
             },
           })
         
         },
         fail: function(err) {
           console.log(err)
         }
       });
     }
   })

 };