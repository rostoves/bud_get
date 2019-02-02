var file;
var parsedCsv;
var mccArray = [];
var importTableArray = [];

$(document).ready(function () {
    $('#importCsvFileInput').on('change', parseFile);
    $('#loadFileButton').on('click', importFile);
    loadData('import/getMCC', function () {
        mccArray = this;
        console.log(mccArray);
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
                            $( $( "#tr_" + i) ).append( "<button class='splitButton' id='s" + i + "'>Разделить</button>" );
                            break;
                        case 15:
                            $( $( "#tr_" + i) ).append( "<button class='deleteButton' id='d" + i + "'>Удалить</button>" );
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
    $('.splitButton').on('click', rowInsertAfter);
    $('.deleteButton').on('click', rowDelete);
    autocompleteCategories();
    changeImportButtons();
}

function markNewCategory(_category, _selector) {
    if (mccArray.indexOf(_category) == -1 ) {
        $(_selector).addClass("badge-warning");
    } else {
        $(_selector).removeClass("badge-warning");
    }
}

function autocompleteCategories() {
    $('.importCategory').autocomplete({
        source: mccArray
    });
}

function changeImportButtons() {
    $('.importButtonForm').html("<input type='submit' class='exportTableButton' value='Импорт операций'>");
    $('.exportTableButton').on('click', collectImportArray);
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
    var deleteButton = "<button class='deleteButton' id='d" + id + "'>Удалить</button>";
    $( $( "#tr_" + row) ).after(
        "<div class='importTableRow' id='tr_" + id + "'>"
        + date + card + status + operation_sum + operation_cur + bargain_sum + bargain_cur + category + desc + bonuses + comment + deleteButton +
        "</div>"
    );
    autocompleteCategories();
    markNewCategory(parsedCsv[row][9], "#ic_" + id);
    $('.deleteButton').on('click', rowDelete);
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

        importTableArray.push(arrayOfThisRow);
    });

    console.log(importTableArray);

    $.ajax({
        url: "/",
        type: "POST",
        data: {
            action: 'import/importTable',
            table: importTableArray
        },
        complete: function (data) {
            // console.log(data);
        }
    });
}