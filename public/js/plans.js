$(document).ready(function () {
    $('#updateRegularsButton').on('click', updateRegulars);
    $('#addOperationModalButton').on('click', function () {
        addOperation('PLAN');
    });
});

function updateRegulars() {
    sendPOST('plans/updateRegulars');
}
