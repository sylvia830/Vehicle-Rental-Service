<link rel="stylesheet" href="Oracle_php.css">
<html>
    <head>
        <title>Vehicle Rental</title>
    </head>

    <body>

        <hr />
        <h1>Vehicle Rental Transaction</h1>
        <a class="nav-link" href="oracle-test.php">Go Back to Main Page</a>
        <hr />
        

        <h2> Display Available Vehicles </h2>
        <form method = "GET" action="vehicleTransaction.php">
            <input type="hidden" id="DisplayVehicleRequest" name="DisplayVehicleRequest">
            <input type="submit" name="displayVehicleTuples"></p>
        </form>

        <hr />


        <h2>Assign Vehicle</h2>
        <form method="POST" action="vehicleTransaction.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateVehiclesRequest" name="updateVehiclesRequest">
            DrivingLicenseNumber: <input type="text" name="insDIDNo"> <br /><br />
            VehicleNumber: <input type="text" name="insVNUM"> <br /><br />
            RentalType: <input type="text" name="insRentType"> <br /><br />
            RentalLocationID: <input type="text" name="insLocation"> <br /><br />

            <input type="submit" value="Update" name="updateVehiclesTuple"></p>
        </form>

        <h2> List RSA </h2>
        <form method = "GET" action="vehicleTransaction.php">
            <input type="hidden" id="DisplayRSARequest" name="DisplayRSARequest">
            <input type="submit" name="displayRSA"></p>
        </form>

        <h2>Project Vehicle Data</h2>
        <form method="POST" action="vehicleTransaction.php"> <!--refresh page when submitted-->
            <input type="hidden" id="getVehicleValues" name="getVehicleValues">
            VehicleNumber: <input type="checkbox" name="col1"> <br /><br />
            countryOfManufacture: <input type="checkbox" name="col3"> <br /><br />
            company: <input type="checkbox" name="col4"> <br /><br />
            rentalLocation_ID: <input type="checkbox" name="col5"> <br /><br />
            category: <input type="checkbox" name="col6"> <br /><br />
            <input type="submit" value="Update" name="getVehicleValuesTuples"></p>
        </form>

        <hr />

        <h2> Display Customers </h2>
        <form method = "GET" action="vehicleTransaction.php">
            <input type="hidden" id="DisplayCustomerRequest" name="DisplayCustomerRequest">
            <input type="submit" name="displayCustomerTuples"></p>
        </form>

        <hr />

        <h2> Display a Customer's Email </h2>
        <form method = "POST" action="vehicleTransaction.php">
            <input type="hidden" id="DisplayCustomerEmailRequest" name="DisplayCustomerEmailRequest">
            DrivingLicenseNumber: <input type="text" name="insDIDNoForEmail"> <br /><br />
            <input type="submit" name="displayCustomerEmailTuple"></p>
        </form>

        <hr />

        


        <hr />

        <h2> Project Customer Emails </h2>
        <form method = "GET" action="vehicleTransaction.php">
            <input type="hidden" id="DisplayEmailRequest" name="DisplayEmailRequest">
            <input type="submit" name="displayEmailTuples"></p>
        </form>

        <hr />

        <?php
        //this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr); 
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

            return $statement;
        }

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
        In this case you don't need to create the statement several times. Bound variables cause a statement to only be
        parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection. 
        See the sample code below for how this function is used */

            global $db_conn, $success;
            $statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
                }

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table demoTable:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function printCustomerResult($result) { //prints results from a select statement *HEREEE
            echo "<br>Retrieved data from table Customers:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Number</th><th>Address</th><th>Email</th><th>VehicleNumber</th></tr>";

            /*while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["drivingLicenseNumber"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["phoneNumber"] . "</td><td>" . $row["Address"] . "</td><td>" . $row["email"] . "</td></tr>"; //or just use "echo $row[0]" 
            } */

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td></tr>" ; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
            // ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_ayandas", "a70600945", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleUpdateVehicle() {
            global $db_conn;

            $DID = $_POST['insDIDNo'];
            $VNUM = $_POST['insVNUM'];

            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Vehicles SET drivingLicenseNumber='" . $DID . "' WHERE VehicleNumber='" . $VNUM . "'");
            OCICommit($db_conn);

            handleInsertRestRent();


        }

        

        function handleUpdateRequest() {
            global $db_conn;

            $old_name = $_POST['oldName'];
            $new_name = $_POST['newName'];

            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE demoTable SET name='" . $new_name . "' WHERE name='" . $old_name . "'");
            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE demoTable");

            // Create new table
            echo "<br> creating new table <br>";
            executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, name char(30))");
            executePlainSQL("CREATE TABLE Customers (drivingLicenseNumber int PRIMARY KEY, Name CHAR(20), phoneNumber INT, Address CHAR(20), email CHAR(20))");
            executePlainSQL("CREATE TABLE Rental_Service_Agency (Name CHAR(20) PRIMARY KEY,
    Budget INT)");
            executePlainSQL("CREATE TABLE Rental_Locations_Have (ID INT PRIMARY KEY,
            Agency_Name CHAR(20), Location CHAR (20),
            FOREIGN KEY (Agency_Name) REFERENCES Rental_Service_Agency(Name))");
            executePlainSQL("CREATE TABLE TypeOfRental (Name CHAR(20) PRIMARY KEY)");
            executePlainSQL("CREATE TABLE Rent_type(TypeOfRental_Name CHAR(20) PRIMARY KEY,Fees INT,
            FOREIGN KEY (TypeOfRental_Name) REFERENCES TypeOfRental(Name))");
            executePlainSQL("CREATE TABLE Rent(
            drivingLicenseNumber INT, TypeOfRental_Name CHAR(20), RentalLocation_ID INT,
            PRIMARY KEY (drivingLicenseNumber, TypeOfRental_Name, RentalLocation_ID),
            FOREIGN KEY (drivingLicenseNumber) REFERENCES Customers(drivingLicenseNumber),
            FOREIGN KEY (TypeOfRental_Name) REFERENCES TypeOfRental(Name),
            FOREIGN KEY (RentalLocation_ID) REFERENCES Rental_Locations_Have(ID))");
            executePlainSQL("CREATE TABLE Dealership(Unique_ID INT PRIMARY KEY,Name CHAR(20), 
                DeliveryFees INT)");
            executePlainSQL("CREATE TABLE Vehicles(VehicleNumber INT PRIMARY KEY,drivingLicenseNumber INT,
                countryOfManufacture CHAR(20),company CHAR(20),dealership_ID INT,rentalLocation_ID INT,
                category CHAR(20),FOREIGN KEY (dealership_ID) REFERENCES Dealership(Unique_ID),
                FOREIGN KEY (drivingLicenseNumber) REFERENCES Customers(drivingLicenseNumber),
                FOREIGN KEY (rentalLocation_ID) REFERENCES Rental_Locations_Have(ID))");
            executePlainSQL("CREATE TABLE Rent_licenseNum(drivingLicenseNumber INT PRIMARY KEY,
                VehicleNumber INT, RentalLocation_ID INT, FOREIGN KEY (drivingLicenseNumber) REFERENCES Customers(drivingLicenseNumber),FOREIGN KEY (VehicleNumber) REFERENCES Vehicles(VehicleNumber),FOREIGN KEY (RentalLocation_ID) REFERENCES Rental_Locations_Have(ID))");

            /*executePlainSQL("INSERT INTO Rental_Service_Agency VALUES ("CarRental BC", 500000)");
            executePlainSQL("INSERT INTO Rental_Service_Agency VALUES ("CarRental ON", 600,000)");
            executePlainSQL("INSERT INTO Rental_Service_Agency VALUES ("CarRental AB", 800,000)");
            executePlainSQL("INSERT INTO Rental_Service_Agency VALUES ("CarRental Quebec", 700,000)");
            executePlainSQL("INSERT INTO Rental_Service_Agency VALUES ("CarRental Manitoba", 400,000)");
            executePlainSQL("INSERT INTO Rental_Locations_Have VALUES(1, "CarRental BC", "West Mall")");
            executePlainSQL("INSERT INTO Rental_Locations_Have VALUES(2, "CarRental BC", "Kits Beach")");
            executePlainSQL("INSERT INTO Rental_Locations_Have VALUES(3, "CarRental ON", "Crescent")"); */
    

            OCICommit($db_conn);
        } 


        function handleInsertLocation() {
            global $db_conn;
            $tuple = array (
                ":bind1" => $_POST['insLocationID'],
                ":bind2" => $_POST['insRSAName'],
                ":bind3" => $_POST['insLocationName']

            );

            $alltuples = array (
                $tuple
            );



            executeBoundSQL("insert into Rental_Locations_Have values (:bind1, :bind2, :bind3)", $alltuples);
            OCICommit($db_conn);

        }

        function handleDisplayCustomerEmail() {
            global $db_conn;
            
            $var = $_POST['insDIDNoForEmail'];
            // echo "customer is " . $var;
        
            $result =  executePlainSQL("SELECT email from Customers WHERE drivingLicenseNumber = {$var}");
            //$result = executePlainSQL("SELECT email FROM Customers ");
            echo "<br>Customer Email";
            echo "<table>";
            echo "<tr><th>Email</th></tr>";
        
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";

    
        }

        function handleVehicleSelect() {
            global $db_conn;
            
            $col1 = $_POST['col1'];
            $col2 = $_POST['col2'];
            $col3 = $_POST['col3'];
            $col4 = $_POST['col4'];
            $col5 = $_POST['col5'];
            $col6 = $_POST['col6'];

            $a=array();

            if($col1 == "on") {
                array_push($a,"VehicleNumber");
            }
            if($col2 == "on") {
                array_push($a,"drivingLicenseNumber");
            }
            if($col3 == "on") {
                array_push($a,"countryOfManufacture");
            }
            if($col4 == "on") {
                array_push($a,"company");
            }
            if($col5 == "on") {
                array_push($a,"rentalLocation_ID");
            }
            if($col6 == "on") {
                array_push($a,"category");
            }



            //print_r($a);
            //echo count($a);

            if(count($a) == 0) {
                $result =  executePlainSQL("SELECT * from Vehicles");
            } else {
                $insertString = $a[0];
                /*foreach ($a as $value) {
                    $insertString = $insertString .",". " ". $value;
                } */

                for($i = 1; $i <= count($a)-1; $i++) {
                    $insertString = $insertString .",". " ". $a[$i];
                }

                //echo $insertString;
                $result =  executePlainSQL("SELECT {$insertString} from Vehicles ");

            }
        
            //$result =  executePlainSQL("SELECT email from Vehicles");
            //$result = executePlainSQL("SELECT email FROM Customers ");
            echo $insertString;
            echo "<br>";
            echo "<table>";
            echo "<tr><th> </th></tr>";
        
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td> <td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td><td>" . $row[6] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";

    
        }



        

        function handleInsertRestRent() {
            global $db_conn;
            $tuple = array (
                ":bind1" => $_POST['insDIDNo'],
                ":bind2" => $_POST['insVNUM'],
                ":bind3" => $_POST['insRentType'],
                ":bind4" => $_POST['insLocation']

            );

            $alltuples = array (
                $tuple
            );



            executeBoundSQL("insert into Rent values (:bind1, :bind3, :bind4)", $alltuples);
            executeBoundSQL("insert into Rent_licenseNum values (:bind1, :bind2, :bind4)", $alltuples);
            OCICommit($db_conn);

        }

        function handleInsertRSA() {
            global $db_conn;
            $tuple = array (
                ":bind1" => $_POST['insBudget'],
                ":bind2" => $_POST['insRSAName']

            );

            $alltuples = array (
                $tuple
            );



            executeBoundSQL("insert into Rental_Service_Agency values (:bind2, :bind1)", $alltuples);
            OCICommit($db_conn);
        }



        function handleInsertCustomer() {
            global $db_conn;

            $tuple = array (
                ":bind1" => $_POST['insDID'],
                ":bind2" => $_POST['insCustomerName'],
                ":bind3" => $_POST['insPN'],
                ":bind4" => $_POST['insAddress'],
                ":bind5" => $_POST['insEmail']

            );


            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Customers values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
            OCICommit($db_conn);

        }

        function handleInsertRequest() {
            global $db_conn;

            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['insNo'],
                ":bind2" => $_POST['insName']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into demoTable values (:bind1, :bind2)", $alltuples);
            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM Rental_Locations_Have");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
            }
        }


        function handleDispRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT id, name FROM demoTable");
            printResult($result);
        }

        function handleDispCustomer() {
            global $db_conn;
            $result = executePlainSQL("SELECT Customers.drivingLicenseNumber, Name, phoneNumber, Address, email, VehicleNumber FROM Customers, Vehicles WHERE Vehicles.drivingLicenseNumber = Customers.drivingLicenseNumber");
            printCustomerResult($result);
        }

        function handleDispLocation() {
            global $db_conn;
            $result = executePlainSQL("SELECT ID, Agency_Name, Location FROM Rental_Locations_Have");

            echo "<br>All Agencies";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Location</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function handleDispRSA() {
            global $db_conn;
            $result = executePlainSQL("SELECT Name, Budget FROM Rental_Service_Agency");

            echo "<br>All Agencies";
            echo "<table>";
            echo "<tr><th>Name</th><th>Budget</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function handleDispAvailableVehicles() {
            //displayVehicleTuples
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM Vehicles WHERE drivingLicenseNumber IS NULL ");
            echo "<br>All Available Vehicles";
            echo "<table>";
            echo "<tr><th>VehicleNumber</th><th>drivingLicenseNumber</th><th>countryOfManufacture</th><th>company</th><th>dealership_ID</th><th>rentalLocation_ID</th><th>category</th></tr>";
        
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td> <td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] . "</td><td>" . $row[6] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        function handleDispCustomerEmails() {
   
            global $db_conn;
            $result = executePlainSQL("SELECT email FROM Customers ");
            echo "<br>Customer Emails";
            echo "<table>";
            echo "<tr><th>Emails</th></tr>";
        
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>";
        }

        // HANDLE ALL POST ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateVehiclesRequest', $_POST)) {
                    handleUpdateVehicle();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('insertCustomerRequest', $_POST)) {
                    handleInsertCustomer();
                } else if (array_key_exists('insertRSARequest', $_POST)) {
                    handleInsertRSA();
                } else if (array_key_exists('insertLocationRequest', $_POST)) {
                    handleInsertLocation();
                } else if (array_key_exists('DisplayCustomerEmailRequest', $_POST)) {
                    handleDisplayCustomerEmail();
                } else if (array_key_exists('getVehicleValues', $_POST)) {
                    handleVehicleSelect();
                }
//getVehicleValuesTuples
                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                } else if (array_key_exists('displayTuples',  $_GET)) {
                    // code...
                    handleDispRequest();
                } else if (array_key_exists('displayCustomerTuples',  $_GET)) {
                    // code...
                    handleDispCustomer();
                } else if (array_key_exists('displayRSA',  $_GET)) {
                    // code...
                    handleDispRSA();
                } else if (array_key_exists('displayLocationTuples',  $_GET)) {
                    // code...
                    handleDispLocation();
                } else if (array_key_exists('displayVehicleTuples',  $_GET)) {
                    // code...
                    handleDispAvailableVehicles();
                } else if (array_key_exists('displayEmailTuples',  $_GET)) {
                    // code...
                    handleDispCustomerEmails();
                } 

            

                disconnectFromDB();
            }
        }

        if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['insertCustomerSubmit']) || isset($_POST['insertRSASubmit']) || isset($_POST['insertLocationSubmit']) || isset($_POST['updateVehiclesTuple']) || isset($_POST['displayCustomerEmailTuple']) || isset($_POST['getVehicleValuesTuples'])  ) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['DisplayTupleRequest']) || isset($_GET['DisplayCustomerRequest']) || isset($_GET['DisplayRSARequest']) || isset($_GET['DisplayLocationRequest']) || isset($_GET['DisplayVehicleRequest']) || isset($_GET['DisplayEmailRequest']) ) {
            handleGETRequest();
        }
        ?>
    </body>
</html>