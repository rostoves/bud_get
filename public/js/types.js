$(document).ready(function () {
    $(".comparisonBlockTypeSelect").on('change', sendComparisonCatUpdate);
    $('.deleteCatButton').on('click', catDelete);
    $('#deleteCatModalButton').on('click', deleteCatModalAnswer);
    $('.operationListCatName').on('change', sendCatNameUpdate);
});

function sendComparisonCatUpdate() {
    sendFieldUpdate('types/updateCatType', this.id.slice(9), '[id_operations_types]', this.value);
}

function catDelete() {
    $('#deleteCatModalButton').attr('id',   'm' + this.id);
}

function deleteCatModalAnswer() {
    var cat = this.id.slice(2);
    console.log("Category " + cat + " was deleted.");
    $("#cat_" + cat).remove();
    $(this).attr('id', 'deleteCatModalButton');
    sendFieldUpdate('types/deleteCat', cat, '', $('#newCatSelect')[0].value);
}

function sendCatNameUpdate() {
    sendFieldUpdate('categories/updateNameColumn', this.id.slice(9), '[operations_categories]', '\''+this.value+'\'');
}