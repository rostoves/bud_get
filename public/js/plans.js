$(document).ready(function () {
    $('#updateRegularsButton').on('click', updateRegulars);
    $('#addOperationModalButton').on('click', addPlanOperation);
});

function updateRegulars() {
    sendPOST('plans/updateRegulars');
}

function addPlanOperation() {
    var date = $.format.date($('#addOperationDate')[0].value+'T00:00:00+03:00', 'dd.MM.yyyy');
    var sum = $('#addOperationSum')[0].value;
    var mcc = $('#addOperationMcc')[0].value;
    var desc = $('#addOperationDesc')[0].value;
    var comment = $('#addOperationComment')[0].value;
    var operation = [[date, '', 'PLAN', sum, 'RUB', sum, 'RUB', mcc, desc, 0, comment, '']];
    console.log(operation);
    sendPOST('plans/addOperation', operation);
}
