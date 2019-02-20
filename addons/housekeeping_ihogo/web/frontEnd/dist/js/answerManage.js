


var rooturl = (window.document.location.href);
var uploadFile = false;
rooturl = rooturl.substr(0, rooturl.indexOf('frontEnd/view'));

var app = new Vue({
    el: '#app',
    data: {
        slideData: [{
            company_img: '',
            company_name: '',
            phone: '',
            map_gps: '',
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
        url: rooturl + 'backEnd/public/?s=About.getAllData',
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
    if ($('#inputName').val() && $('#telPhoneInput').val()) {
        if (uploadFile && $('#exampleInputFile').val() && $('#exampleInputFile').val() != null && $('#exampleInputFile').val() != '') {
            uploadFileAndInsertData();
        } else {
            $.ajax({
                type: "GET",
                url: rooturl + 'backEnd/public/?s=About.update',
                data: {
                    id:app.slideData[0].id,
                    map_gps: $('#howMuchInput').val() ? $('#howMuchInput').val() : '',
                    phone: $('#telPhoneInput').val() ? $('#telPhoneInput').val() : '',
                    company_name: $('#inputName').val() ? $('#inputName').val() : '',
                    company_img:app.slideData[0].company_img,
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
            return false;
        }
    } else if ($('#inputName').val()) {
        var h = app.$createElement;
        app.$notify({
            title: '通知',
            message: h('span', { style: 'color: red' }, '请填写公司电话')
        });
    } else {
        var h = app.$createElement;
        app.$notify({
            title: '通知',
            message: h('span', { style: 'color: red' }, '请填写公司名称')
        });
    }



    function uploadFileAndInsertData() {
        if (uploadFile && $('#exampleInputFile').val() && $('#exampleInputFile').val() != null && $('#exampleInputFile').val() != '') {
            $('#imgUpForm').ajaxSubmit({
                success: function (resData) {
                    if (resData.ret == 200) {
                        var imgurl = document.location.protocol+ '//' + resData.data.url;
                        // _this.resetForm();
                        $.ajax({
                            type: "GET",
                            url: rooturl + 'backEnd/public/?s=About.update',
                            data: {
                                id:app.slideData[0].id,
                                company_img: imgurl,
                                map_gps: $('#howMuchInput').val() ? $('#howMuchInput').val() : '',
                                phone: $('#telPhoneInput').val() ? $('#telPhoneInput').val() : '',
                                company_name: $('#inputName').val() ? $('#inputName').val() : '',
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
        } else {
            var h = app.$createElement;
            app.$notify({
                title: '通知',
                message: h('span', { style: 'color: red' }, '请上传文件')
            });
        }
    }

};