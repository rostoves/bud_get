$(document).ready(function () {
    prepareButtons();
    loadCategories();
});
var file;
var parsedCsv;
var mccArray = [];
var importTableArray = [];

function prepareButtons(){
    $('.importForm').on('change', parseFile);
    $('.importButton').on('click', importFile);
    $('.exportButton').on('click', collectTableArray);
}

function collectTableArray() {
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
            action: 'import/postTable',
            table: importTableArray
        },
        complete: function (data) {
            // console.log(data);
        }
    });
}

function loadCategories() {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: 'import/getMCC'
        },
        success: function (data) {
            mccArray = data;
            console.log(mccArray);
        }
    });
}

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
        complete: function(results, file) {
            parsedCsv = results.data;
            console.log(parsedCsv);
        },
        error: function(err, file, inputElem, reason) {
            console.log(err, file, inputElem, reason);
        },
        download: false,
        skipEmptyLines: false,
        chunk: undefined,
        fastMode: undefined,
        beforeFirstChunk: undefined,
        withCredentials: undefined,
        transform: undefined
    };
    Papa.parse(file, config);
}

function importFile() {
    for (var i = 0; i < parsedCsv.length - 1; i++) {
        switch (i) {
            case 0:
                $( $( ".importTable" ) ).append( "<div class='importTableHeader'>" );
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
                            $( $( "#tr_" + i) ).append( "<input class='importCategory ic_" + i + "' value='" + parsedCsv[i][j] + "'>" );
                            markNewCategory(parsedCsv[i][j], ".ic_" + i);
                            break;
                        case 12:
                            $( $( "#tr_" + i) ).append( "<input value='" + parsedCsv[i][j].slice(0, -1) + "'>" );
                            break;
                        case 13:
                            $( $( "#tr_" + i) ).append( "<input>" );
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
                break;
        }
        $( $( ".importTable" ) ).append( "</div>" );
    }
    $('.splitButton').on('click', rowInsertAfter);
    $('.deleteButton').on('click', rowDelete);
    autocompleteCategories();
}

function markNewCategory(_category, _selector) {
    if (mccArray.indexOf(_category) == -1 ) {
        $(_selector).addClass("red");
    } else {
        $(_selector).removeClass("red");
    }
}

function autocompleteCategories() {
    $('.importCategory').autocomplete({
        source: mccArray
    });
}

function rowInsertAfter() {
    var row = this.id.slice(1);
    var date = "<span>" + parsedCsv[row][0].slice(1) + "</span>";
    var card = "<span>" + parsedCsv[row][2] + "</span>";
    var status = "<span>" + parsedCsv[row][3] + "</span>";
    var operation_sum = "<input value='0,00'>";
    var operation_cur = "<span>" + parsedCsv[row][5] + "</span>";
    var bargain_sum = "<input value='0,00'>";
    var bargain_cur = "<span>" + parsedCsv[row][7] + "</span>";
    var category = "<input class='importCategory' value='" + parsedCsv[row][9] + "'>";
    var desc = "<span>" + parsedCsv[row][11] + "</span>";
    var bonuses = "<input value='0,00'>";
    var deleteButton = "<button class='deleteButton' id='d" + row + "_1'>Удалить</button>";
    $( $( "#tr_" + row) ).after(
        "<div id='tr_" + row + "_1'>"
        + date + card + status + operation_sum + operation_cur + bargain_sum + bargain_cur + category + desc + bonuses + deleteButton +
        "</div>"
    );
    autocompleteCategories();
    $('.deleteButton').on('click', rowDelete);
}

function rowDelete() {
    var row = this.id.slice(1);
    $("#tr_" + row).remove();
}