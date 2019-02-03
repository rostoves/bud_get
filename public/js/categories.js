var typesArray = [];
var catsArray = [];
var mccArray = [];

$(document).ready(function () {
    loadData('categories/getTypes', function () {
        typesArray = this;
    });
    loadData('categories/getCats', function () {
        renderCatsTable(this);
    });
    loadData('categories/getMCC', function () {
        renderMccTable(this);
    });
});

function renderMccTable(data) {
    console.log(data);
    mccArray = data;
    for (var y = 0; y < mccArray.length; y++) {
        $(".comparisonBlockMccCats").append("<div class='comparisonBlockMcc' id='mcc_" + mccArray[y].id + "'>" + mccArray[y].name + "</div>" + renderMccCatsForm(mccArray[y].id_operations_categories, mccArray[y].id));
    }
    $(".comparisonBlockCategorySelect").on('change', sendComparisonMccUpdate);
}

function renderCatsTable(data) {
    catsArray = data;
    for (var i = 0; i < catsArray.length; i++) {
        $(".comparisonBlockCatsTypes").append("<div class='comparisonBlockCats' id='cat_" + catsArray[i].id + "'>" + catsArray[i].name + "</div>" + renderCatsTypesForm(catsArray[i].id_operations_types, catsArray[i].id));
    }
    $(".comparisonBlockTypeSelect").on('change', sendComparisonCatUpdate);
}

function renderMccCatsForm(defaultCatId, mccId) {
    var optionCatsList = '';
    for (var i = 0; i < catsArray.length; i++) {
        if (catsArray[i].id == defaultCatId) {
            optionCatsList += "<option selected value='" + catsArray[i].id + "'>" + catsArray[i].name + "</option>";
        } else {
            optionCatsList += "<option value='" + catsArray[i].id + "'>" + catsArray[i].name + "</option>";
        }
    }

    return "<select class='comparisonBlockCategorySelect' id='mcc_cat_" + mccId + "'>" + optionCatsList + "</select>";
}

function renderCatsTypesForm(defaultTypeId, catId) {
    var optionTypesList = '';
    for (var i = 0; i < typesArray.length; i++) {
        if (typesArray[i].id == defaultTypeId) {
            optionTypesList += "<option selected value='" + typesArray[i].id + "'>" + typesArray[i].name + "</option>";
        } else {
            optionTypesList += "<option value='" + typesArray[i].id + "'>" + typesArray[i].name + "</option>";
        }
    }

    return "<select class='comparisonBlockTypeSelect' id='cat_type_" + catId + "'>" + optionTypesList + "</select>";
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