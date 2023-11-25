
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clinic Information</title>
        <!--
        <link rel="stylesheet" href="index.css">
        -->
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: light-gray;
            margin: 0;
            padding: 0;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: red;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    </head>

    <body>
        <table>
            <tr>
                <th>Name</th><th>Location</th>
            </tr>
            <?php
                // Connect to database
                $con = mysqli_connect("localhost", "root", "", "blood_clinic");

                if ($con -> connect_error) {
                    die("Connection failed:" . $con -> connect_error);
                }

                $sql = "SELECT * FROM `clinic`";

                $result = $con -> query($sql);

                if ($result -> num_rows > 0) {
                    while ($row = $result -> fetch_assoc()) {
                        echo "<tr><td>" . $row["Hospital_Receiving"] . "</td><td>" . $row["Location"] . "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }

                $con -> close();

            ?>
            
        </table>

    </body>
</html>