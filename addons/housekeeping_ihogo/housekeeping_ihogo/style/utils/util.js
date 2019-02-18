var formatTime = function(date) {
    var year = date.getFullYear(), month = date.getMonth() + 1, day = date.getDate(), hour = date.getHours(), minute = date.getMinutes(), second = date.getSeconds();
    return [ year, month, day ].map(formatNumber).join("/") + " " + [ hour, minute, second ].map(formatNumber).join(":");
}, formatNumber = function(n) {
    return (n = n.toString())[1] ? n : "0" + n;
};

module.exports = {
    formatTime: formatTime
};