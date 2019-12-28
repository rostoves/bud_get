$(document).ready(function () {
    $(".comparisonBlockCategorySelect").on('change', sendComparisonMccUpdate);
    $('.deleteMccButton').on('click', mccDelete);
    $('#deleteMccModalButton').on('click', deleteMccModalAnswer);
    $('.operationListMccName').on('change', sendMccNameUpdate);
});

function sendComparisonMccUpdate() {
    sendFieldUpdate('categories/updateMccCat', this.id.slice(8), '[id_operations_categories]', this.value);
}

function mccDelete() {
    $('#deleteMccModalButton').attr('id',   'm' + this.id);
}

function deleteMccModalAnswer() {
    var mcc = this.id.slice(2);
    console.log("Mcc " + mcc + " was deleted.");
    $("#mcc_" + mcc).remove();
    $(this).attr('id', 'deleteMccModalButton');
    sendFieldUpdate('categories/deleteMcc', mcc, '', $('#newMccSelect')[0].value);
}

function sendMccNameUpdate() {
    sendFieldUpdate('categories/updateNameColumn', this.id.slice(9), '[merchant_codes]', '\''+this.value+'\'');
}