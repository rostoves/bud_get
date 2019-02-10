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

function sendPOST(_action) {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: _action
        },
        success: function (data) {

        }
    });
}
