$(document).ready(function () {
    $(".comparisonBlockCategorySelect").on('change', sendComparisonMccUpdate);
    $(".comparisonBlockTypeSelect").on('change', sendComparisonCatUpdate);
    $(".comparisonBlockMccSelect").on('change', sendComparisonDescUpdate);
    $('.deleteMccButton').on('click', mccDelete);
    $('#deleteMccModalButton').on('click', deleteMccModalAnswer);
    $('.deleteCatButton').on('click', catDelete);
    $('#deleteCatModalButton').on('click', deleteCatModalAnswer);
    $('.deleteDescButton').on('click', descDelete);
    $('#deleteDescModalButton').on('click', deleteDescModalAnswer);
    $('.operationListMccName').on('change', sendMccNameUpdate);
    $('.operationListCatName').on('change', sendCatNameUpdate);
    $('.operationListDescName').on('change', sendDescNameUpdate);
});

function sendComparisonMccUpdate() {
    sendFieldUpdate('categories/updateMccCat', this.id.slice(8), '[id_operations_categories]', this.value);
}

function sendComparisonCatUpdate() {
    sendFieldUpdate('categories/updateCatType', this.id.slice(9), '[id_operations_types]', this.value);
}

function sendComparisonDescUpdate() {
    sendFieldUpdate('categories/updateDescMcc', this.id.slice(9), '[id_mcc_desc]', this.value);
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

function catDelete() {
    $('#deleteCatModalButton').attr('id',   'm' + this.id);
}

function deleteCatModalAnswer() {
    var cat = this.id.slice(2);
    console.log("Category " + cat + " was deleted.");
    $("#cat_" + cat).remove();
    $(this).attr('id', 'deleteCatModalButton');
    sendFieldUpdate('categories/deleteCat', cat, '', $('#newCatSelect')[0].value);
}

function descDelete() {
    $('#deleteDescModalButton').attr('id',   'm' + this.id);
}

function deleteDescModalAnswer() {
    var desc = this.id.slice(2);
    console.log("Description " + desc + " was deleted.");
    $("#desc_" + desc).remove();
    $(this).attr('id', 'deleteDescModalButton');
    sendFieldUpdate('categories/deleteDesc', desc, '', $('#newDescSelect')[0].value);
}

function sendMccNameUpdate() {
    sendFieldUpdate('categories/updateNameColumn', this.id.slice(9), '[merchant_codes]', '\''+this.value+'\'');
}

function sendCatNameUpdate() {
    sendFieldUpdate('categories/updateNameColumn', this.id.slice(9), '[operations_categories]', '\''+this.value+'\'');
}

function sendDescNameUpdate() {
    sendFieldUpdate('categories/updateDescColumn', this.id.slice(10), '[descriptions]', '\''+this.value+'\'');
}