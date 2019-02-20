var rooturl = (window.document.location.href);

getCheckApi();
function getCheckApi() {
    $.ajax({
        type: "GET",
        url: rooturl + '../../../../backEnd/public/?s=Category.getAllData',
        data: {

        },
        success: function (datar) {
            if (datar.data.errstatus===true) {
                window.location.href = '../../../../../';
            }
        },
        error: function (errrrr) {
            console.log(errrrr);
        }
    });
}

function logginOff() {
    if
    (confirm("您确定要退出？")) {
        // window.opener = null;
        // window.open('', '_self'); 
        // window.close();

        // window.history.go(-50);
        window.location.href = '../../../../../';
    }
    else { }
}
