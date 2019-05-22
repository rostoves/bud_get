var file;
var parsedCsv;
var mccArray = [];
var descArray = [];
var importTableArray = [];

$(document).ready(function () {
    $('#importCsvFileInput').on('change', parseFile);
    $('#loadFileButton').on('click', importFile);
    loadData('import/getMCC', function () {
        mccArray = this;
        console.log(mccArray);
    });
    loadData('import/getDesc', function () {
        descArray = this;
        console.log(descArray);
    });
});

function parseFile() {
    file = this.files[0];
    var config = {
        delimiter: function (input) {
            var delimeter = '";"';
            return delimeter;
        },
        newline: "",
        quoteChar: '',
        escapeChar: '',
        header: false,
        transformHeader: undefined,
        dynamicTyping: false,
        preview: 0,
        encoding: "CP1251",
        worker: false,
        comments: false,
        step: undefined,
        download: false,
        skipEmptyLines: false,
        chunk: undefined,
        fastMode: undefined,
        beforeFirstChunk: undefined,
        withCredentials: undefined,
        transform: undefined,
        error: function(err, file, inputElem, reason) {
            console.log(err, file, inputElem, reason);
        },
        complete: function(results, file) {
            parsedCsv = results.data;
            console.log(parsedCsv);
        }
    };
    Papa.parse(file, config);
}

function importFile() {
    for (var i = 0; i < parsedCsv.length - 1; i++) {
        switch (i) {
            case 0:
                $( $( ".importTable" ) ).append( "<section class='importTableHeader badge-primary'>" );
                for (var j = 0; j<=13; j++) {
                    switch (j) {
                        case 1:
                        case 8:
                        case 10:
                            break;
                        case 13:
                            $( $( ".importTableHeader") ).append( "<span>Комментарий</span>" );
                            break;
                        default:
                            $( $( ".importTableHeader") ).append( "<span>" + parsedCsv[i][j] + "</span>" );
                            break;
                    }
                }
                $( $( ".importTable" ) ).append( "</section>" );
                break;
            default:
                $( $( ".importTable" ) ).append( "<div class='importTableRow' id='tr_" + i + "'>" );
                for (var j = 0; j<=15; j++) {
                    switch (j) {
                        case 1:
                        case 8:
                        case 10:
                            break;
                        case 0:
                            $( $( "#tr_" + i) ).append( "<span>" + parsedCsv[i][j].slice(1) + "</span>" );
                            break;
                        case 4:
                        case 6:
                        case 11:
                            var descCat = findCategoryForDesc(parsedCsv[i][11]);
                            if (descCat !== false) parsedCsv[i][9] = descCat;
                            $( $( "#tr_" + i) ).append( "<input value='" + parsedCsv[i][j] + "'>" );
                            break;
                        case 9:
                            $( $( "#tr_" + i) ).append( "<input type='text' class='importCategory' id='ic_" + i + "' value='" + parsedCsv[i][j] + "'>" );
                            markNewCategory(parsedCsv[i][j], "#ic_" + i);
                            break;
                        case 12:
                            $( $( "#tr_" + i) ).append( "<input value='" + parsedCsv[i][j].slice(0, -1) + "'>" );
                            break;
                        case 13:
                            $( $( "#tr_" + i) ).append( "<input type='text'>" );
                            break;
                        case 14:
                            $( $( "#tr_" + i) ).append( "<button class='splitImportRowButton' id='s" + i + "'>Разделить</button>" );
                            break;
                        case 15:
                            $( $( "#tr_" + i) ).append( "<button class='deleteImportRowButton' id='d" + i + "'>Удалить</button>" );
                            break;
                        default:
                            $( $( "#tr_" + i) ).append( "<span>" + parsedCsv[i][j] + "</span>" );
                            break;
                    }
                }
                $( $( ".importTable" ) ).append( "</div>" );
                break;
        }
    }
    $('.splitImportRowButton').on('click', rowInsertAfter);
    $('.deleteImportRowButton').on('click', rowDelete);
    autocompleteCategories();
    changeImportButtonsForExport();
}

function findCategoryForDesc(_cellDesc) {
    var result = false;
    for (var i = 0; i < descArray.length - 1; i++) {
        if (descArray[i].description === _cellDesc) {
            result = descArray[i].name;
            console.log("Change category to "+result+" for "+_cellDesc);
        }
    }

    return result;
}

function markNewCategory(_category, _selector) {
    if (mccArray.indexOf(_category) == -1 ) {
        $(_selector).addClass("badge-info");
    } else {
        $(_selector).removeClass("badge-info");
    }
}

function autocompleteCategories() {
    $('.importCategory').autocomplete({
        source: mccArray
    });
}

function changeImportButtonsForExport() {
    $('.importButtonForm').html("<input type='submit' class='exportTableButton' value='Импорт операций'>");
    $('.exportTableButton').on('click', collectImportArray);
}

function changeImportButtonsForFile() {
    $('.importButtonForm').html("");
    $('#topImportButtonForm').html('<input type="file" class="form-control-file importCsvFileInput" id="importCsvFileInput"><input type="submit" id="loadFileButton" value="Загрузить файл">');
    $('#importCsvFileInput').on('change', parseFile);
    $('#loadFileButton').on('click', importFile);
}

function rowInsertAfter() {
    var id = getRandom();
    var row = this.id.slice(1);
    var date = "<span>" + parsedCsv[row][0].slice(1) + "</span>";
    var card = "<span>" + parsedCsv[row][2] + "</span>";
    var status = "<span>" + parsedCsv[row][3] + "</span>";
    var operation_sum = "<input value='0,00'>";
    var operation_cur = "<span>" + parsedCsv[row][5] + "</span>";
    var bargain_sum = "<input value='0,00'>";
    var bargain_cur = "<span>" + parsedCsv[row][7] + "</span>";
    var category = "<input type='text' class='importCategory' id='ic_" + id + "' value='" + parsedCsv[row][9] + "'>";
    var desc = "<input value='" + parsedCsv[row][11] + "'>";
    var bonuses = "<input value='0,00'>";
    var comment = "<input type='text'>";
    var deleteImportRowButton = "<button class='deleteImportRowButton' id='d" + id + "'>Удалить</button>";
    $( $( "#tr_" + row) ).after(
        "<div class='importTableRow' id='tr_" + id + "'>"
        + date + card + status + operation_sum + operation_cur + bargain_sum + bargain_cur + category + desc + bonuses + comment + deleteImportRowButton +
        "</div>"
    );
    autocompleteCategories();
    markNewCategory(parsedCsv[row][9], "#ic_" + id);
    $('.deleteImportRowButton').on('click', rowDelete);
}

function rowDelete() {
    var row = this.id.slice(1);
    console.log("#tr_" + row + " was deleted.");
    $("#tr_" + row).remove();
}

function collectImportArray() {
    importTableArray = [];
    $(".importTable div").each(function() {
        var arrayOfThisRow = [];
        var tableData = $(this).children();
        for (i = 0; i < tableData.length; i++) {
            switch (tableData[i].nodeName) {
                case "INPUT":
                    arrayOfThisRow.push(tableData[i].value);
                    break;
                case "SPAN":
                    arrayOfThisRow.push(tableData[i].innerText);
                    break;
            }
        }
        arrayOfThisRow.push(this.id);

        importTableArray.push(arrayOfThisRow);
    });

    console.log(importTableArray);

    sendPOST('import/importTable', importTableArray, function () {
        renderResultsTable(this);
    });
}

function renderResultsTable(arr) {
    arr.importedOperations.forEach(function(item, i, arr) {
        $("#"+item).remove();
    });
    if (arr.alreadyImportedOperations.length < 1 && arr.notImportedOperations.length < 1) {
        checkOutdatedPlans(function () {
            console.log(this);
            if (this == true) {
                loadOplistWithOutdatedPlans();
            } else {
                $( ".importTableHeader").remove();
                changeImportButtonsForFile();
            }
        });
    } else {
        arr.alreadyImportedOperations.forEach(function(item, i, arr) {
            $("#"+item).addClass("badge-warning");
        });
        arr.notImportedOperations.forEach(function(item, i, arr) {
            $("#"+item).addClass("badge-danger");
        });
    }
}

function checkOutdatedPlans(callback) {
    var filter = {
        status: [" =", "'PLAN'"],
        operation_date: [" <", 'GETDATE()'],
        type:  [" !=", "'Regular'"]
    };

    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: 'import/checkOutdatedPlans',
            filter
        },
        complete: function (data) {
            callback.call(data.responseJSON.length > 0);
        }
    });
}

function loadOplistWithOutdatedPlans() {
    window.open("/oplist/?filter%5Bstatus%5D%5B%5D=+in&filter%5Bstatus%5D%5B%5D=%27PLAN%27&filter%5Btype%5D%5B%5D=+!=&filter%5Btype%5D%5B%5D=%27Regular%27&filter%5Boperation_date%5D%5B%5D=+<&filter%5Boperation_date%5D%5B%5D=%27"+getToday()+"+23%3A59%3A59%27", "_self");
}