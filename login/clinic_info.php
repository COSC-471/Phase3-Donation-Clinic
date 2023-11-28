
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clinic Information</title>
        
        <link rel="stylesheet" href="index.css">
       
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: light-gray;
            margin: 0;
            padding: 0;
        }

        img {
            height: 350px;
        }

        table {
            width: 80%;
            margin: 80px auto;
            margin-top: 20px;
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

        ul {
            background-color: rgb(250, 250, 244, 0.8);
        }
    </style>
    </head>

    <body>
        <ul>
            <li><a style="font-family: arial black; color: #123b4b; font-size: 2em; line-height:60px" href="index.html">Red Cross</a></li>
            <li><a style="color: #123b4b; font-size: 2em; line-height:60px" href="clinic_info.php">Clinics</a></li>
            <li style="float:right; line-height:60px"><a class="active" href="login.php">Employee Portal</a></li>
            <li style="float:right; line-height:60px"><a class="active" href="Donor-login.php">Patient Portal</a></li>

        </ul>
        <img src="https://www.redcross.org/content/dam/redcross/uncategorized/5/763x260-red-cross-flag.jpg.transform/1288/q82/feature/image.jpeg"/>
        <div style="justify-content: left; text-align: left">
            <button style="margin-left: 150px; margin-top: 50px;height: 50px; width: 200px; background-color: light-gray;" onclick="location.href='Create-appt.php'">Create Appointment</button>
        </div>
        <table>
            <tr>
                <th>Name</th><th>Location</th>
            </tr>
            <?php
                // Connect to database
                $con = mysqli_connect("localhost", "root", "", "blood clinic");

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