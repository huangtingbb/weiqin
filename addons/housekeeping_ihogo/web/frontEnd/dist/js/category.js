
var rooturl = (window.document.location.href);
var uploadFile = false;
rooturl = rooturl.substr(0, rooturl.indexOf('frontEnd/view'));

var app = new Vue({
    el: '#app',
    data: {
        slideData: [],
    },
    methods: {
        deleteImg: function (id) {

            if (window.confirm('你确定要删除吗?')) {
                $.ajax({
                    type: "GET",
                    url: rooturl + 'backEnd/public/?s=Category.delete',
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
        url: rooturl + 'backEnd/public/?s=Category.getAllData',
        data: {

        },
        // dataType: "json",
        success: function (datar) {
            app.slideData = datar.data;
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
    if ($('#inputTitle').val().match(regExp)) {
        uploadFileAndInsertData();
    } else if ($('#inputTitle').val() == '') {
        uploadFileAndInsertData();
    } else {
        var h = app.$createElement;
        app.$notify({
            title: '通知',
            message: h('span', { style: 'color: red' }, '请输入正确格式网址')
        });
    }



    function uploadFileAndInsertData() {
        if (uploadFile && $('#exampleInputFile').val() && $('#exampleInputFile').val() != null && $('#exampleInputFile').val() != '') {
            if ($('#inputName').val()!='') {
                $('#imgUpForm').ajaxSubmit({
                    success: function (resData) {
                        if (resData.ret == 200) {
                            var imgurl = document.location.protocol+ '//' + resData.data.url;
                            // _this.resetForm();
                            $.ajax({
                                type: "GET",
                                url: rooturl + 'backEnd/public/?s=Category.insert',
                                data: {
                                    img: imgurl,
                                    sort: $('#exampleInputPassword1').val() ? parseInt($('#exampleInputPassword1').val()) : 1,
                                    url: $('#inputTitle').val() ? $('#inputTitle').val() : '',
                                    name: $('#inputName').val() ? $('#inputName').val() : '',
                                },
                                dataType: "json",
                                success: function (datar) {
                                    getAllData();
                                    var h = app.$createElement;
                                    app.$notify({
                                        title: '通知',
                                        message: h('span', { style: 'color: red' }, '上传成功')
                                    });
                                    return false;
                                },
                                error: function (errrrr) {
                                    console.log(errrrr);
                                    return false;
                                }
                            });
                            return false;
                        } else {
                            alert("文件上传失败,请重试");
                        }
                    },
                    error: function (err) {
                        return false;

                    },
                });
            }else {
                var h = app.$createElement;
                app.$notify({
                    title: '通知',
                    message: h('span', { style: 'color: red' }, '请输入分类名称')
                });
            }
        } else {
            var h = app.$createElement;
            app.$notify({
                title: '通知',
                message: h('span', { style: 'color: red' }, '请上传文件')
            });
        }
    }

};