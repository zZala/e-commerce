function countryOptions() {
    $.ajax({
        url: 'check/returnListOfCountries.php',
    }).done(successFunction);
}

function successFunction(data) {
    var allRows = data.split("+");

    var options;
    for (var singleRow = 0; singleRow < allRows.length; singleRow++) {
        var rowCells = allRows[singleRow].split(';');
        options += '<option>' + rowCells[0] + '</option>';
    }

    document.getElementById("countrySelectShip").innerHTML += options;
    document.getElementById("countrySelect").innerHTML += options;
}