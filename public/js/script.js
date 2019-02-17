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

function sendFieldUpdate(_action, _rowId, _field, _newValue) {
    console.log(_action, _rowId, _field, _newValue);
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: _action,
            rowId: _rowId,
            field: _field,
            newValue: _newValue
        },
        success: function (data) {}
    });
}
