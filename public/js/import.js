$(document).ready(prepareButtons);
var file;
var parsedCsv;

function prepareButtons(){
    $('.importButton').on('click', importFile);
    $('.importForm').on('change', function(){
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
    });
}

function importFile() {
    for (var i = 1; i < parsedCsv.length - 1; i++) {
        $( $( ".importTable" ) ).append( "<tr class='importTableRow_" + i + "'>" );
        for (var j = 0; j<13; j++) {
            switch (j) {
                case 0:
                    $( $( ".importTableRow_" + i) ).append( "<td>" + parsedCsv[i][j].slice(1) + "</td>" );
                    break;
                case 12:
                    $( $( ".importTableRow_" + i) ).append( "<td>" + parsedCsv[i][j].slice(0, -1) + "</td>" );
                    break;
                default:
                    $( $( ".importTableRow_" + i) ).append( "<td>" + parsedCsv[i][j] + "</td>" );
                    break;
            }
        }
        $( $( ".importTable" ) ).append( "</tr>" );
    }

    // $.ajax({
    //     url: "/import/add/",
    //     type: "POST",
    //     contentType: false,
    //     processData: false,
    //
    //     data: {
    //         file: file
    //     },
    //
    //     complete: function (data) {
    //
    //     }
    // })
}