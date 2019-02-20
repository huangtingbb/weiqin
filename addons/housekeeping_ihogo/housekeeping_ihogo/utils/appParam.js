var siteinfo=require('../siteinfo.js');

var siteUrl = siteinfo.siteroot;

siteUrl = siteUrl.substr(0, siteUrl.indexOf('app/index.php'));

siteUrl = siteUrl +'addons/housekeeping_ihogo/web/backEnd/public/?s=';

module.exports = {
	'wxApp': { 
		'appKey': 'wxc5bd60572f88d253',
		'secret': 'dbb9df1314f6155a2154de9e980ae63d',
		'version': '版本号:6.2.9',
	},
	'member': {
		'memId': 2,
		'memKey': '5hN46ZatQrr4nBRkMRsuTJJmkwKwHF7Y',
	},
	'apiUrl': {
		"URL": 'https://ordering.zxsite.cn',
    "local1":'https://demo.labride.com.cn/public/?s=',
    'local': siteUrl,
		'addBooking':'/api/v1/book/add',
		'memInfo':'/api/v1/member/find',
		'getOpenID':'/api/v1/wechat/get_open_id',
		"openidUrl": 'https://api.weixin.qq.com/sns/jscode2session',
		'wildDog': 'https://ordering-lite.wilddogio.com/bus/',
		'addOder': '/api/v1/order/add',
		'categoryLists': '/api/v1/dishes/lists',
		'activity': '/api/v1/activity',
		'category': '/api/v1/dishes_category',
		'tableId': '/api/v1/merchant/dining_table',
		'aboutUs': '/api/v1/merchant/about',
		'launch': '/api/v1/merchant/launch',
		'wxpayApi': '/api/v1/order/wxpay',
		'choosePay': '/api/v1/merchant/pay_method',
		'merchantInfo': '/api/v1/merchant/info',
		'diningTableArea': '/api/v1/dining_table_area',
		'diningTable': '/api/v1/dining_table',
    'merchantList':'/api/v1/merchant/lists',
	},
	'res': {
		'menuBtnSrc': "http://qn.zxsite.cn/ordering/cart2.png",
		'menuCloseBtnSrc':"http://qn.zxsite.cn/ordering/close2.png",
	},
  'appParamSetting': {
    'timeout': 260,
  },
  'bmob':{
    'id':'123',
    'key':'123'
  },
  siteInfo: siteinfo,
}