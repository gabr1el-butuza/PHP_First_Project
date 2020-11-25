$(document).ready(function () {
    $("#addNew").on('click', function () {
        $("#AddNewData").modal('show');
    })

    loadData();
});

function loadData() {
    getData();
}

function getData() {
    $.ajax({
        url: 'functions.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key: 'getData'
        }, success: function (response) {
            if (response != 'noResults') {
                $('#tableDataBody').html(response);
                $('#dataTable').DataTable();
            }
        }
    });
}

function updateData(identifier) {
    var country_id = $(identifier).attr("id");
    $.ajax({
        url: "functions.php",
        method: "POST",
        dataType: "json",
        data: {
            key: "update",
            id: country_id
        }, success: function (response) {
            $("#countryName").val(response.countryName);
            $("#shortDesc").val(response.shortDesc);
            $("#longDesc").val(response.longDesc);
            $("#insertBtn").val("Update");
            $("#insertBtn").attr("onclick", "saveData('edit')");
            $("#country_id").val(country_id);
            $("#AddNewData").modal('show');
            loadData();
        }
    });
}

function deleteData(id) {
    //var country_id = $(identifier).attr("id");
    console.log("delete function");
    $.ajax({
        url: "functions.php",
        method: "POST",
        dataType: "text",
        data: {
            key: "delete",
            id: id
        }, success: function (response) {
            console.log(response);
            loadData();
        }
    });
}

function viewData(id) {
    console.log("View DATA!");
    $.ajax({
        url: "functions.php",
        method: "POST",
        dataType: "text",
        data: {
            key: "view",
            id: id
        }, success: function (response) {
            console.log(response);
            $('#infoTableBody').html(response);
            //$('#infoTable').DataTable();
            $("#viewData").modal('show');

        }
    });
}

function saveData(key) {
    console.log("button was clicked!")
    var name = $("#countryName");
    var shortDesc = $("#shortDesc");
    var longDesc = $("#longDesc");
    var id = $("#country_id");

    if (isNotEmpty(name) && isNotEmpty(shortDesc) && isNotEmpty(longDesc)) {
        // Ajax call
        $.ajax({
            url: 'functions.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: key,
                name: name.val(),
                shortDesc: shortDesc.val(),
                longDesc: longDesc.val(),
                id: id.val()
            }, success: function (response) {
                console.log(response);
                loadData();
            }
        });
    }

}

function isNotEmpty(id) {
    if (id.val() == '') {
        id.css('border', '1px solid red');
        return false;
    } else {
        id.css('border', '');
        return true;
    }
}