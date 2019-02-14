$(document).ready(function () {
    $('.deleteOperationButton').on('click', operationRowDelete);
    $('#deleteOperationModalButton').on('click', deleteModalAnswer);
});

function addOperation(status) {
    var date = new Date($('#addOperationDate')[0].value);
    var card = $('#addOperationCard')[0].value;
    var sum = $('#addOperationSum')[0].value;
    var mcc = $('#addOperationMcc')[0].value;
    var desc = $('#addOperationDesc')[0].value;
    var comment = $('#addOperationComment')[0].value;
    var operation = [];

    if ($('#addOperationDateRepeat').prop("checked")) {
        console.log('Repeatable operation, every '+$('#addOperationDatePeriod')[0].value);

        for (let i = 0; i<$('#addOperationRepeatCount')[0].value; i++) {
            operation.push([$.format.date(date+'T00:00:00+03:00', 'dd.MM.yyyy'), card, status, sum, 'RUB', sum, 'RUB', mcc, desc, 0, comment, '']);
            switch ($('#addOperationDatePeriod')[0].value) {
                case 'month':
                    date.setMonth(date.getMonth()+1);
                    break;
                case 'week':
                    date.setDate(date.getDate()+7);
                    break;
                case 'day':
                    date.setDate(date.getDate()+1);
                    break;
                case 'year':
                    date.setFullYear(date.getFullYear()+1);
                    break;
            }
        }
        console.log(operation);
        sendPOST('op_list_table/addOperation', operation);
    } else {
        operation.push([$.format.date(date+'T00:00:00+03:00', 'dd.MM.yyyy'), card, status, sum, 'RUB', sum, 'RUB', mcc, desc, 0, comment, '']);
        console.log(operation);
        sendPOST('op_list_table/addOperation', operation);
    }
}

function operationRowDelete() {
    $('.deleteOperationModalButton').attr('id',   'm' + this.id);
}

function deleteModalAnswer() {
    var row = this.id.slice(2);
    console.log("Operation " + row + " was deleted.");
    $("#row_" + row).remove();
    $(this).attr('id', 'deleteOperationModalButton');
    sendPOST('op_list_table/deleteOperation', row);
}