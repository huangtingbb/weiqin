


var rooturl = (window.document.location.href);
var uploadFile = false;
rooturl = rooturl.substr(0, rooturl.indexOf('frontEnd/view'));

var app = new Vue({
    el: '#app',
    data: {
        slideData: [],
        trclass: function (index) {
            if (index % 2) {
                return 'even'
            } else {
                return 'odd'
            }
        },
        options: [],
        value: '',
        visible: false
    },
    methods: {
        deleteImg: function (id) {

            if (window.confirm('你确定要删除吗?')) {
                $.ajax({
                    type: "GET",
                    url: rooturl + 'backEnd/public/?s=Wokers.delete',
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
        url: rooturl + 'backEnd/public/?s=Wokers.getAllData',
        data: {
            skip: 0,
            limit: 9999,
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
    if ($('#inputName').val() && $('#telPhoneInput').val()) {
        if (uploadFile && $('#exampleInputFile').val() && $('#inputSort').val() != null && $('#inputTitle').val() != '') {
            $('#imgUpForm').ajaxSubmit({
                success: function (resData) {
                    if (resData.ret == 200) {
                        var imgurl = document.location.protocol+ '//' + resData.data.url;
                        // _this.resetForm();
                        $.ajax({
                            type: "GET",
                            url: rooturl + 'backEnd/public/?s=Wokers.insert',
                            data: {
                                name: $('#inputName').val(),
                                phone: $('#inputName').val(),
                                sort: $('#inputSort').val() ? parseInt($('#inputSort').val()) : 1,
                                price: $('#howMuchInput').val() ? ($('#howMuchInput').val()) : '',
                                serviceData: $('#promiseInput').val() ? $('#promiseInput').val() : '',
                                introduction: $('#introductionInput').val() ? ($('#introductionInput').val()) : '',
                                map: $('#serverMapInput').val() ? ($('#serverMapInput').val()) : '',
                                img: imgurl,
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
    } else {
        var h = app.$createElement;
        app.$notify({
            title: '通知',
            message: h('span', { style: 'color: red' }, '请输入完整')
        });
    }

};