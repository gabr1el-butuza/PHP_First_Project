<?php
if (isset($_POST['key'])) {
    $conn = new mysqli('localhost', 'root', '', 'manage_data');

    if ($_POST['key'] == 'getData') {
        $sql = $conn->query("SELECT id, countryName FROM country ");
        if ($sql->num_rows > 0) {
            $response = "";

            while ($data = $sql->fetch_array()) {
                $response .= '
                <tr>
                    <td>' . $data["id"] . '</td>
                    <td>' . $data["countryName"] . '</td>
                    <td> 
                        <input type="button" id="' . $data["id"] . '" value="Edit" onclick="updateData(this)" class="btn btn-primary">
                        <input type="button" value="View" onclick="viewData(' . $data["id"] . ')" class="btn">
                        <input type="button" value="Delete" onclick="deleteData(' . $data["id"] . ')" class="btn btn-danger">
                    </td>
                </tr>
                ';
            }
            exit($response);
        } else {
            exit("noResults");
        }
    }

    if ($_POST['key'] == 'addNew') {
        $name = $conn->real_escape_string($_POST['name']);
        $shortDesc = $conn->real_escape_string($_POST['shortDesc']);
        $longDesc = $conn->real_escape_string($_POST['longDesc']);
        $sql = $conn->query("SELECT id FROM country WHERE countryName = '$name'");
        if ($sql->num_rows > 0) {
            exit("Country with this name already exists!");
        } else {
            $conn->query("INSERT INTO country (countryName, shortDesc, longDesc) VALUES ('$name', '$shortDesc', '$longDesc')");
            exit("Country has been inserted!");
        }
    }
    // country ID
    $id = $conn->real_escape_string($_POST['id']);

    if ($_POST['key'] == "view") {
        $sql = $conn->query("SELECT * FROM country WHERE id='$id'");
        if ($sql->num_rows > 0) {
            $response = "";
            while ($data = $sql->fetch_array()) {
                $response .= '
                <tr>
                    <td width="30%"><label>Id</label></td>  
                    <td width="70%">' . $data["id"] . '</td>
                </tr>
                <tr>
                    <td width="30%"><label>Country Name</label></td>  
                    <td width="70%">' . $data["countryName"] . '</td>
                </tr>
                <tr>
                    <td width="30%"><label>Short Description</label></td>  
                    <td width="70%">' . $data["shortDesc"] . '</td>
                </tr>
                <tr>
                    <td width="30%"><label>Long Description</label></td>  
                    <td width="70%">' . $data["longDesc"] . '</td>
                </tr>
                ';
            }
            exit($response);
        } else {
            exit("noResults");
        }
    }


    if ($_POST['key'] == "edit") {
        $name = $conn->real_escape_string($_POST['name']);
        $shortDesc = $conn->real_escape_string($_POST['shortDesc']);
        $longDesc = $conn->real_escape_string($_POST['longDesc']);
        //$conn->query("UPDATE country SET countryName='$name', shortDesc='$shortDesc', longDesc='$longDesc' WHERE id='$id'");
        $query = "UPDATE country SET countryName='$name', shortDesc='$shortDesc', longDesc='$longDesc' WHERE id='$id'";
        if ($conn->query($query) === TRUE) {
            die("Updated");
        } else {
            die("error updating");
        }
    }

    if ($_POST['key'] == "delete") {
        $query = "DELETE FROM country WHERE id = '$id'";
        if ($conn->query($query) === TRUE) {
            die("Deleted");
        } else {
            die("Error to delete!");
        }
    }

    if ($_POST['key'] == "update") {

        // $query = $conn->query("SELECT countryName FROM country WHERE id='$id'");
        // $result = $query->fetch_assoc();
        // $row = array(
        //     "countryName" => $result["countryName"]
        // );
        $query = "SELECT countryName, shortDesc, longDesc FROM country WHERE id='$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);


        die(json_encode($row));
    }

    $conn->close();
}
