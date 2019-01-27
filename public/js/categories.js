$(document).ready(function () {
    loadTypes();
    loadCats();
    loadMcc();
});

var typesArray = [];
var catsArray = [];
var mccArray = [];

function loadTypes() {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: 'categories/getTypes'
        },
        success: function (data) {
            typesArray = data;
        }
    });
}

function loadCats() {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: 'categories/getCats'
        },
        success: function (data) {
            catsArray = data;
            renderCatsTable();
        }
    });
}

function loadMcc() {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: 'categories/getMCC'
        },
        success: function (data) {
            mccArray = data;
            renderMccTable();
        }
    });
}

function renderCatsForm(defaultCatId, mccId) {
    var optionCatsList = '';
    for (var i = 0; i < catsArray.length; i++) {
        if (catsArray[i].id == defaultCatId) {
            optionCatsList += "<option class='green' selected value='" + catsArray[i].id + "'>" + catsArray[i].name + "</option>";
        } else {
            optionCatsList += "<option value='" + catsArray[i].id + "'>" + catsArray[i].name + "</option>";
        }
    }

    return "<select class='comparisonBlockCategorySelect' id='mcc_cat_" + mccId + "'>" + optionCatsList + "</select>";
}

function renderTypesForm(defaultTypeId, catId) {
    var optionTypesList = '';
    for (var i = 0; i < typesArray.length; i++) {
        if (typesArray[i].id == defaultTypeId) {
            optionTypesList += "<option class='green' selected value='" + typesArray[i].id + "'>" + typesArray[i].name + "</option>";
        } else {
            optionTypesList += "<option value='" + typesArray[i].id + "'>" + typesArray[i].name + "</option>";
        }
    }

    return "<select class='comparisonBlockTypeSelect' id='cat_type_" + catId + "'>" + optionTypesList + "</select>";
}

function renderMccTable() {
    for (var y = 0; y < mccArray.length; y++) {
        $(".comparisonBlockMccCats").append("<div class='comparisonBlockMcc' id='mcc_" + mccArray[y].id + "'>" + mccArray[y].name + "</div>" + renderCatsForm(mccArray[y].id_operations_categories, mccArray[y].id));
    }
    $(".comparisonBlockCategorySelect").on('change', sendComparisonMccUpdate);
}

function renderCatsTable() {
    for (var i = 0; i < catsArray.length; i++) {
        $(".comparisonBlockCatsTypes").append("<div class='comparisonBlockCats' id='cat_" + catsArray[i].id + "'>" + catsArray[i].name + "</div>" + renderTypesForm(catsArray[i].id_operations_types, catsArray[i].id));
    }
    $(".comparisonBlockTypeSelect").on('change', sendComparisonCatUpdate);
}

function sendComparisonMccUpdate() {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: 'categories/updateMccCat',
            mccId: this.id.slice(8),
            newMccCatId: this.value
        },
        success: function (data) {}
    });
}

function sendComparisonCatUpdate() {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: 'categories/updateCatType',
            catId: this.id.slice(9),
            newCatTypeId: this.value
        },
        success: function (data) {}
    });
}