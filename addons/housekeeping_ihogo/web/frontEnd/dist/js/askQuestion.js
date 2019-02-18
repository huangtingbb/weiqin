


var rooturl = (window.document.location.href);
var uploadFile = false;
rooturl = rooturl.substr(0, rooturl.indexOf('frontEnd/view'));

var app = new Vue({
    el: '#app',
    data: {
        slideData: [{
            title: '',
            id: '',
            url: '',
        }],
        trclass: function (index) {
            if (index % 2) {
                return 'even'
            } else {
                return 'odd'
            }
        },
    },
    methods: {
        deleteImg: function (id) {

            if (window.confirm('你确定要删除吗?')) {
                $.ajax({
                    type: "GET",
                    url: rooturl + 'backEnd/public/?s=About.delete',
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function (datar) {
                        var h = app.$createElement;
                        app.$notify({
                            title: '通知',
                            message: h('span', { style: 'color: red' }, '删除成功')
                        });
                        getAllData();
                    },
                    error: function (errrrr) {
                        console.log(errrrr);
                    }
                });

            } else {
                //alert("取消");

            }


        },
    },
});

getAllData();

function getAllData() {
    $.ajax({
        type: "GET",
        url: rooturl + 'backEnd/public/?s=Notice.getAllData',
        data: {
            limit: 'all'
        },
        dataType: "json",
        success: function (datar) {
            app.slideData = datar.data
        },
        error: function (errrrr) {
            console.log(errrrr);
        }
    });
}

$('#exampleInputFile').on('change', function () {
    if ($(this).val()) {
        uploadFile = true;
    }
});

function subImg() {
    // 验证是否是网址
    var regExp = /(http[s]?|ftp):\/\/[^\/\.]+?\..+\w$/i;
    if ($('#telPhoneInput').val().match(regExp)) {
        uploadFileAndInsertData();
    } else {
        var h = app.$createElement;
        app.$notify({
            title: '通知',
            message: h('span', { style: 'color: red' }, '请输入正确格式网址')
        });
    }




    function uploadFileAndInsertData() {
        $.ajax({
            type: "GET",
            url: rooturl + 'backEnd/public/?s=Notice.update',
            data: {
                id: app.slideData[0].id,
                title: $('#inputName').val() ? $('#inputName').val() : '',
                url: $('#telPhoneInput').val() ? $('#telPhoneInput').val() : '',
            },
            dataType: "json",
            success: function (datar) {
                getAllData();
                var h = app.$createElement;
                app.$notify({
                    title: '通知',
                    message: h('span', { style: 'color: red' }, '保存成功')
                });
                return false;
            },
            error: function (errrrr) {
                console.log(errrrr);
                return false;
            }
        });
    }

};