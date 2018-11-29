$(document).ready(function () {
    prepareButtons();
    loadCategories();
});
var file;
var parsedCsv;

function prepareButtons(){
    $('.importForm').on('change', parseFile);
    $('.importButton').on('click', importFile);
}

function loadCategories() {
    $.ajax({
        url: "/",
        type: "POST",
        dataType: "json",
        data: {
            action: 'import/getMCC'
        },
        complete: function (data) {
            console.log(data);
        }
    })
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
        dynamicTyping: true,
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
    for (var i = 1; i < parsedCsv.length - 1; i++) {
        $( $( ".importTable" ) ).append( "<tr id='importTableRow_" + i + "'>" );
        for (var j = 0; j<=13; j++) {
            switch (j) {
                case 0:
                    $( $( "#importTableRow_" + i) ).append( "<td>" + parsedCsv[i][j].slice(1) + "</td>" );
                    break;
                case 1:
                case 8:
                    break;
                case 4:
                case 6:
                    $( $( "#importTableRow_" + i) ).append( "<td><input value='" + parsedCsv[i][j] + "'></td>" );
                    break;
                case 12:
                    $( $( "#importTableRow_" + i) ).append( "<td><input value='" + parsedCsv[i][j].slice(0, -1) + "'></td>" );
                    break;
                case 13:
                    $( $( "#importTableRow_" + i) ).append( "<td><button id='" + i + "' class='splitButton'>Разделить</button></td>" );
                    break;
                default:
                    $( $( "#importTableRow_" + i) ).append( "<td>" + parsedCsv[i][j] + "</td>" );
                    break;
            }
        }
        $( $( ".importTable" ) ).append( "</tr>" );
    }
    $('.splitButton').on('click', rowInsertAfter);
}

function rowInsertAfter() {
    var row = this.id;
    var date = "<td>" + parsedCsv[row][0].slice(1) + "</td>";
    var card = "<td>" + parsedCsv[row][2] + "</td>";
    var status = "<td>" + parsedCsv[row][3] + "</td>";
    var operation_sum = "<td><input value='0,00'></td>";
    var operation_cur = "<td>" + parsedCsv[row][5] + "</td>";
    var bargain_sum = "<td><input value='0,00'></td>";
    var bargain_cur = "<td>" + parsedCsv[row][7] + "</td>";
    var category = "<td>" + parsedCsv[row][9] + "</td>";
    var mcc = "<td>" + parsedCsv[row][10] + "</td>";
    var desc = "<td>" + parsedCsv[row][11] + "</td>";
    var bonuses = "<td><input value='0,00'></td>";
    $( $( "#importTableRow_" + row) ).after(
        "<tr id='importTableRow_" + row + ".1'>"
        + date + card + status + operation_sum + operation_cur + bargain_sum + bargain_cur + category + mcc + desc + bonuses +
        "</tr>"
    );
}