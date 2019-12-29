$(document).ready(function () {
    $('#descriptionsSearchInput').on('change', sendDescSearch);
    prepareButtons();
});

function prepareButtons() {
    $(".comparisonBlockMccSelect").on('change', sendComparisonDescUpdate);
    $('.deleteDescButton').on('click', descDelete);
    $('#deleteDescModalButton').on('click', deleteDescModalAnswer);
    $('.operationListDescName').on('change', sendDescNameUpdate);
}

function sendComparisonDescUpdate() {
    sendFieldUpdate('descriptions/updateDescMcc', this.id.slice(9), '[id_mcc_desc]', this.value);
}

function descDelete() {
    $('#deleteDescModalButton').attr('id',   'm' + this.id);
}

function deleteDescModalAnswer() {
    var desc = this.id.slice(2);
    console.log("Description " + desc + " was deleted.");
    $("#desc_" + desc).remove();
    $(this).attr('id', 'deleteDescModalButton');
    sendFieldUpdate('descriptions/deleteDesc', desc, '', $('#newDescSelect')[0].value);
}

function sendDescNameUpdate() {
    sendFieldUpdate('descriptions/updateDescColumn', this.id.slice(10), '[descriptions]', '\''+this.value+'\'');
}

function sendDescSearch() {
    var search = descriptionsSearchInput.value;

    console.log(search);
    $.ajax({
        url: "/descriptions_table/",
        type: "GET",
        dataType: "json",
        data: {
            search
        },
        complete: function (data) {
            $('.descriptionsListTableContainer').html(data.responseText);
            prepareButtons();
        }
    });
}