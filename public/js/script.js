function getRandom() {
    return Math.floor(Math.random() * (1000000 - 100000 + 1)) + 100000;
}

function loadData(_action, callback) {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: _action
        },
        success: function (data) {
            callback.call(data);
        }
    });
}

function sendPOST(_action, _data = undefined, callback = undefined) {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: _action,
            data: _data
        },
        success: function (data) {
            console.log(data);
            callback.call(data);
        }
    });
}
