function countryOptions() {
    $.ajax({
        url: 'csv//data.csv',
        dataType: 'text',
    }).done(successFunction);
}

function successFunction(data) {
    var allRows = data.split(/\r?\n|\r/);

    var options;
    for (var singleRow = 0; singleRow < allRows.length; singleRow++) {
        var rowCells = allRows[singleRow].split(',');
        options += '<option>' + rowCells[0] + '</option>';
    }
    document.getElementById("countrySelect").append(options);
}