$(document).ready(function () {
    $('#updateRegularsButton').on('click', updateRegulars);
});

function updateRegulars() {
    sendPOST('plans/updateRegulars');
}
