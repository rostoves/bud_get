$(document).ready(function () {
    $('.deleteOperationButton').on('click', operationRowDelete);
    $('#deleteOperationModalButton').on('click', deleteModalAnswer);
});

function operationRowDelete() {
    $('.deleteOperationModalButton').attr('id',   'm' + this.id);
}

function deleteModalAnswer() {
    var row = this.id.slice(2);
    console.log("Operation " + row + " was deleted.");
    $("#row_" + row).remove();
    $(this).attr('id', 'deleteOperationModalButton');
}