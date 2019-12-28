var descArray = [];

$(document).ready(function () {
    $('.operationListFilter').on('change', sendFilter);
    prepareButtons();
    loadData('op_list_table/getDescList', function () {
        descArray = this;
        autocompleteDescription();
    });
});

function prepareButtons() {
    $('#addOperationModalButton').on('click', addOperation);
    $('.deleteOperationButton').on('click', operationRowDelete);
    $('#deleteOperationModalButton').on('click', deleteModalAnswer);
    $('.operationListMccSelect').on('change', sendOperationMccUpdate);
    $('.operationListComment').on('change', sendOperationCommentUpdate);
    $('.operationListDate').on('change', sendOperationDateUpdate);
    $('.operationListSum').on('change', sendOperationSumUpdate);
    // $('.operationListCardSelect').on('change', sendOperationCardUpdate);
    // $('.operationsListDescription').on('change', sendOperationDescUpdate);
}

function autocompleteDescription() {
    $('#addOperationDesc').autocomplete({
        source: descArray
    });
}

function addOperation() {
    var status = $('#addOperationStatus')[0].value;
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

function sendOperationMccUpdate() {
    sendFieldUpdate('op_list_table/updateOperation', this.id.slice(7), '[id_mcc]', this.value);
}

function sendOperationCommentUpdate() {
    sendFieldUpdate('op_list_table/updateOperation', this.id.slice(8), '[comment]', '\''+this.value+'\'');
}

function sendOperationDateUpdate() {
    sendFieldUpdate('op_list_table/updateOperation', this.id.slice(5), '[operation_date]', '\''+this.value+'\'');
}

function sendOperationSumUpdate() {
    sendFieldUpdate('op_list_table/updateOperation', this.id.slice(4), '[bargain_sum]', this.value);
}

// function sendOperationCardUpdate() {
//     sendFieldUpdate('op_list_table/updateOperation', this.id.slice(5), '[id_card]', this.value);
// }

// function sendOperationDescUpdate() {
//     sendFieldUpdate('op_list_table/updateOperationDesc', this.id.slice(5), this.value);
// }

function sendFilter() {
    var status = collectSelectedValues('status');
    // var card_id = collectSelectedValues('card_id');
    var mcc_id = collectSelectedValues('mcc_id');
    var category = collectSelectedValues('category');
    var type = collectSelectedValues('type');
    var filter = {};

    if (status.length > 0) {
        status.unshift(" in");
        filter.status = status;
    }
    // if (card_id.length > 0) {
    //     card_id.unshift(" in");
    //     filter.card_id = card_id;
    // }
    if (mcc_id.length > 0) {
        mcc_id.unshift(" in");
        filter.mcc_id = mcc_id;
    }
    if (category.length > 0) {
        category.unshift(" in");
        filter.category = category;
    }
    if (type.length > 0) {
        type.unshift(" in");
        filter.type = type;
    }
    if ($('#filter_operation_date_from')[0].value != "" && $('#filter_operation_date_to')[0].value != "") {
        filter.operation_date = [" BETWEEN", '\''+$('#filter_operation_date_from')[0].value+'\'', '\''+$('#filter_operation_date_to')[0].value+' 23:59:59\''];
    } else if ($('#filter_operation_date_from')[0].value != "" && $('#filter_operation_date_to')[0].value == "") {
        filter.operation_date = [" >=", '\''+$('#filter_operation_date_from')[0].value+'\''];
    } else if ($('#filter_operation_date_from')[0].value == "" && $('#filter_operation_date_to')[0].value != "") {
        filter.operation_date = [" <=", '\''+$('#filter_operation_date_to')[0].value+' 23:59:59\''];
    }

    console.log(filter);
    $.ajax({
        url: "/op_list_table/",
        type: "GET",
        dataType: "json",
        data: {
            order: $('#filter_order')[0].value,
            filter
        },
        complete: function (data) {
            $('.operationsListTableContainer').html(data.responseText);
            prepareButtons();
        }
    });
}

function collectSelectedValues(filter) {
    var arr = [];
    $('#filter_'+filter+' option:selected').each(function() {
        if (this.value !== filter) arr.push(this.value);
    });
    return arr;
}