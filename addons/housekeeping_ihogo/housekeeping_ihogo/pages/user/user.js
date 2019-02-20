var app = getApp();
var phoneNumber=0;
var mapForLa;
var mapFrLo;
var that;
Page({
    data: {
        umoney: [],
        cardnum: []
    },
    onLoad: function(options) {
      that=this;
       wx.getStorage({
         key: 'phone',
         success: function(res) {
           phoneNumber=res.data;
         },
      });
      wx.getStorage({
        key: 'map',
        success: function (res) {
          mapForLa = res.data[0];
          mapFrLo = res.data[1];
          
          that.setData({
            mapForLa: mapForLa
          });
        },
      });
      wx.getStorage({
        key: 'AboutCompanyData',
        success: function (res) {
         that.setData({
           aboutCompany:res.data,
         });
        },
      });

      
    },
    onReady: function() {},
    onShow: function() {
 
    }, 
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}, 
    toService: function(e) {
        wx.navigateTo({
            url: "service/service"
        });
    },
    toAddress: function(e) {
        wx.navigateTo({
            url: "address/address"
        });
    },
    toBackstage: function(e) {
        wx.navigateTo({
            url: "../backstage/backstage"
        });
    },
    toDialogue: function(e) { 
        wx.makePhoneCall({
          phoneNumber: phoneNumber+''
        }); 
    },
    toBgorder: function(e) {
        wx.navigateTo({
            url: "bgorder/bgorder"
        });
    },
    toRecharge: function(e) {
        wx.navigateTo({
            url: "recharge/recharge"
        });
    },

    toBargain: function (e) {

      // wx.previewImage({
      //   current: 'http://temp-customs-1251903635.coscd.myqcloud.com/XinShiChuang-Sg/qrcode_for_gh_e48236ed7205_1280.jpg', // 当前显示图片的http链接
      //   urls: ['http://temp-customs-1251903635.coscd.myqcloud.com/XinShiChuang-Sg/qrcode_for_gh_e48236ed7205_1280.jpg'] ,// 需要预览的图片http链接列表
      //   success:function(){
      //     wx.showToast({
      //       title: '长按识别二维码',
      //       icon:'loading'
      //     })
      //   }
      // })
    },
 
    go2Map: function (e) {
 
      wx.openLocation({
        latitude: parseFloat(mapForLa),
        longitude: parseFloat(mapFrLo),
        scale:17,
        name:'新视窗家政服务'
      }); 
    },

    // feedback: function (e) {
    //   wx.navigateTo({
    //     url: "../feedback/index"
    //   });
    // },

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
});