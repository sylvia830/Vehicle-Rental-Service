<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  This file shows the very basics of how to execute PHP commands
  on Oracle.  
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values
 
  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->
<link rel="stylesheet" href="Oracle_php.css">
<html>
    <head>
        <title>Vehicle Rental Service</title>
    </head>

    <body>

        <hr />
        <h1>Vehicle Rental Service</h1>
        <a class="nav-link" href="vehicleTransaction.php">Go to Vehicle Transcation Page</a>
        <br>
        <a class="nav-link" href="employees.php">Go to Employees Page</a>
        <hr />


        <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="oracle-test.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />

        <h2>TypeOfRental</h2>
        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertTypeRequest" name="insertTypeRequest">
            Name: <input type="text" name="insTypeName"> <br /><br />

            <input type="submit" value="Insert" name="insertTypeSubmit"></p>

        </form>

            <form method = "GET" action="oracle-test.php">
            <input type="hidden" id="DisplayTypeRequest" name="DisplayTypeRequest">
            <input type="submit" value="Display" name="displayTypeTuples"></p>
        
        </form>

        <hr />

        <h2>Insert Values into RentType</h2>
        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertRentTypeRequest" name="insertRentTypeRequest">
            TypeOfRental_Name: <input type="text" name="insTypeName"> <br /><br />
            Fees: <input type="text" name="insFees"> <br /><br />

            <input type="submit" value="Insert" name="insertRentTypeSubmit"></p>

            </form>

            <form method = "GET" action="oracle-test.php">
            <input type="hidden" id="DisplayRentTypeRequest" name="DisplayRentTypeRequest">
            <input type="submit" value="Display RentType" name="displayRentTypeTuples"></p>
    
        </form>

        <hr />

        <h2>Vehicles</h2>
        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertVehicleRequest" name="insertVehicleRequest">
            VehicleNumber: <input type="text" name="insVehicleNo"> <br /><br />
            LicenseNumber: <input type="text" name="insDID"> <br /><br />
            countryManufacture: <input type="text" name="insCountry"> <br /><br />
            company: <input type="text" name="insCompany"> <br /><br />
            dealershipID: <input type="text" name="insDealershipID"> <br /><br />
            locationID: <input type="text" name="insLocationID"> <br /><br />
            category: <input type="text" name="insCategory"> <br /><br />

            <input type="submit" value="Insert" name="insertVehicleSubmit"></p>
        </form>

         <form method = "GET" action="oracle-test.php">
            <input type="hidden" id="DisplayVehicleRequest" name="DisplayVehicleRequest">
            <input type="submit" value= "Display Vehicles" name="displayVehicleTuples"></p>
        </form>
        <hr />



        <h2>Insert Values into Rent_licenseNum</h2>
        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertRentLicenceRequest" name="insertRentLicenseRequest">
            LicenseNumber: <input type="text" name="insDID"> <br /><br />
            VehicleNumber: <input type="text" name="insVehicleNo"> <br /><br />
            locationID: <input type="text" name="insLocationID"> <br /><br />
            <input type="submit" value="Insert" name="insertRentLicenseSubmit"></p>

        </form>

            <form method = "GET" action="oracle-test.php">
            <input type="hidden" id="DisplayRentLicenseRequest" name="DisplayRentLicenseRequest">
            <input type="submit" value="Display RentLicenseNum" name="displayRentLicenseTuples"></p>

        </form>
        <hr />

        <h2>Rental Service Agency</h2>
        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertRSARequest" name="insertRSARequest">
            Budget: <input type="text" name="insBudget"> <br /><br />
            Name: <input type="text" name="insRSAName"> <br /><br />
            <input type="submit" value="Insert" name="insertRSASubmit"></p>
        </form>

        <form method = "GET" action="oracle-test.php">
            <input type="hidden" id="DisplayRSARequest" name="DisplayRSARequest">
            <input type="submit" value="Display Current Agency" name="displayRSA"></p>
        </form>


        <hr />


        <h2>Dealership</h2>
        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertDealershipRequest" name="insertDealershipRequest">
            ID: <input type="text" name="insDealershipID"> <br /><br />
            Name: <input type="text" name="insDealershipName"> <br /><br />
            DeliveryFees: <input type="text" name="insDeliveryFees"> <br /><br />
            <input type="submit" value="Insert" name="insertDealershipSubmit"></p>
        </form>

        <form method = "GET" action="oracle-test.php">
            <input type="hidden" id="DisplayDealershipRequest" name="DisplayDealershipRequest">
            <input type="submit" value= "Display Dealership" name="displayDealershipTuples"></p>
        </form>


        <hr />

        <h2>Rental Location</h2>
        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertLocationRequest" name="insertLocationRequest">
            ID: <input type="text" name="insLocationID"> <br /><br />
            Name: <input type="text" name="insRSAName"> <br /><br />
            Location: <input type="text" name="insLocationName"> <br /><br />
            <input type="submit" value="Insert" name="insertLocationSubmit"></p>
        </form>

        <form method = "GET" action="oracle-test.php">
            <input type="hidden" id="DisplayLocationRequest" name="DisplayLocationRequest">
            <input type="submit" value="Display Location" name="displayLocationTuples"></p>
        </form>


        <hr />

        <h2>Customers</h2>
        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertCustomerRequest" name="insertCustomerRequest">
            LicenseNumber: <input type="text" name="insDID"> <br /><br />
            Name: <input type="text" name="insCustomerName"> <br /><br />
            Phone: <input type="text" name="insPN"> <br /><br />
            Address: <input type="text" name="insAddress"> <br /><br />
            Email: <input type="text" name="insEmail"> <br /><br />

            <input type="submit" value="Insert" name="insertCustomerSubmit">
        
        </form>
            <a href="vehicleTransaction.php">
                <input class="button" type="submit"
                      value="vehicleTransaction">
            </a>

        <form method = "GET" action="oracle-test.php">
            <input type="hidden" id="DisplayCustomerRequest" name="DisplayCustomerRequest">
            <input type="submit" value= "Display Customers" name="displayCustomerTuples"></p>
        </form>

        <hr />

        <h2>Delivery Fees</h2>
        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="getFeesValues" name="getFeesValues">
            Enter max/min/avg: <input type="text" name="col1"> <br /><br />
            <input type="submit" value="Check Fees" name="getFeesTuples"></p>
        </form>

        <hr />


        <h2> Display the Number of Rented Vehicles of different companies </h2>
        <form method = "GET" action="oracle-test.php">
            <input type="hidden" id="DisplayCompanyRequest" name="DisplayCompanyRequest">
            <input type="submit" name="displayCompanyTuples"></p>
        </form>


        <hr />


        <h2>Update Email in Customer</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="oracle-test.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateEmailRequest" name="updateEmailRequest">
            Old Email: <input type="text" name="oldEmail"> <br /><br />
            New Email: <input type="text" name="newEmail"> <br /><br />

            <input type="submit" value="Update" name="updateEmailSubmit"></p>
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
            echo "<tr><th>drivingLicenseNumber</th><th>Name</th><th>Number</th><th>Address</th><th>Email</th></tr>";

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
            executePlainSQL("CREATE TABLE Rent_type(TypeOfRental_Name CHAR(20) PRIMARY KEY, Fees INT,
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
                category CHAR(20),
                FOREIGN KEY (dealership_ID) REFERENCES Dealership(Unique_ID),
                FOREIGN KEY (drivingLicenseNumber) REFERENCES Customers(drivingLicenseNumber),
                FOREIGN KEY (rentalLocation_ID) REFERENCES Rental_Locations_Have(ID) )");
            executePlainSQL("CREATE TABLE Rent_licenseNum(drivingLicenseNumber INT PRIMARY KEY,
                VehicleNumber INT, RentalLocation_ID INT, FOREIGN KEY (drivingLicenseNumber) REFERENCES Customers(drivingLicenseNumber),FOREIGN KEY (VehicleNumber) REFERENCES Vehicles(VehicleNumber) on Delete Cascade,FOREIGN KEY (RentalLocation_ID) REFERENCES Rental_Locations_Have(ID) )");

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


        function handleInsertDealership() {
            global $db_conn;
            $tuple = array (
                ":bind1" => $_POST['insDealershipID'],
                ":bind2" => $_POST['insDealershipName'],
                ":bind3" => $_POST['insDeliveryFees']

            );

            $alltuples = array (
                $tuple
            );



            executeBoundSQL("insert into Dealership values (:bind1, :bind2, :bind3)", $alltuples);
            OCICommit($db_conn);

        }

        function handleInsertRentLicense() {
            global $db_conn;
            $tuple = array (
                ":bind1" => $_POST['insDID'],
                ":bind2" => $_POST['insVehicleNo'],
                ":bind3" => $_POST['insLocationID']

            );

            $alltuples = array (
                $tuple
            );



            executeBoundSQL("insert into Rent_LicenseNum values (:bind1, :bind2, :bind3)", $alltuples);
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



        function handleInsertType() {
            global $db_conn;
            $tuple = array (
                ":bind1" => $_POST['insTypeName']

            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into TypeOfRental values (:bind1)", $alltuples);
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

        function handleInsertVehicle() {
            global $db_conn;

            $tuple = array (
                ":bind1" => $_POST['insVehicleNo'],
                ":bind2" => $_POST['insDID'],
                ":bind3" => $_POST['insCountry'],
                ":bind4" => $_POST['insCompany'],
                ":bind5" => $_POST['insDealershipID'],
                ":bind6" => $_POST['insLocationID'],
                ":bind7" => $_POST['insCategory']

            );


            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Vehicles values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7)", $alltuples);
            OCICommit($db_conn);

        }

        function handleInsertRentType() {
            global $db_conn;

            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['insTypeName'],
                ":bind2" => $_POST['insFees']
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Rent_type values (:bind1, :bind2)", $alltuples);
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

    

        function handleUpdateEmailRequest() {
            global $db_conn;

            $old_email = $_POST['oldEmail'];
            $new_email = $_POST['newEmail'];

            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE Customers SET email='" . $new_email . "' WHERE email='" . $old_email . "'");
            OCICommit($db_conn);
        }




        function handleDispType() {
            global $db_conn;
            $result = executePlainSQL("SELECT Name FROM TypeOfRental");
            echo "<br>All Types of Rental";
            echo "<table>";
            echo "<tr><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] .  "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>"; 
        }


        function handleDispRentType() {
            global $db_conn;
            $result = executePlainSQL("SELECT TypeOfRental_Name, Fees FROM Rent_type");
            echo "<br>All Rent Types";
            echo "<table>";
            echo "<tr><th>TypeOfRental_Name</th><th>Fees</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>"; 
        }



        function handleDispCompany() {
            global $db_conn;
            $result = executePlainSQL("SELECT company, count(*) from Vehicles, Customers where Customers.drivingLicenseNumber = Vehicles.drivingLicenseNumber group by company");
            echo "<br>Number of Rented Vehicles of a certain company";
            echo "<table>";
            echo "<tr><th>Company</th><th>Number of rented vehicles</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>"; 
        }



        function handleDispCustomer() {
            global $db_conn;
            $result = executePlainSQL("SELECT drivingLicenseNumber, Name, phoneNumber, Address, email FROM Customers");
            printCustomerResult($result);
        }


        function handleDispDealership() {
            global $db_conn;
            $result = executePlainSQL("SELECT Unique_ID, Name, DeliveryFees FROM Dealership");
            echo "<br>All Dealerships";
            echo "<table>";
            echo "<tr><th>Unique_ID</th><th>Name</th><th>DeliveryFees</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" .$row[2]. "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>"; 
        }


        function handleDispRentLicense() {
            global $db_conn;
            $result = executePlainSQL("SELECT drivingLicenseNumber, VehicleNumber, RentalLocation_ID FROM Rent_LicenseNum");
            echo "<br>All RentLicenseNum ";
            echo "<table>";
            echo "<tr><th>drivingLicenseNumber</th><th>VehicleNumber</th><th>RentalLocation_ID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" .$row[2]. "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>"; 
        }


        function handleDispVehicle() {
            global $db_conn;
            $result = executePlainSQL("SELECT VehicleNumber, drivingLicenseNumber, countryOfManufacture, company, dealership_ID, rentalLocation_ID, category FROM Vehicles");
            echo "<br>All Vehicles";
            echo "<table>";
            echo "<tr><th>VehicleNumber </th><th>drivingLicenseNumber </th><th>countryOfManufacture </th><th>company </th><th>dealership_ID </th><th>rentalLocation_ID </th><th>category </th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" .$row[2]. "</td><td>" .$row[3]."</td><td>" .$row[4]."</td><td>" .$row[5]."</td><td>" .$row[6]. "</td></tr>"; //or just use "echo $row[0]" 
            }

            echo "</table>"; 
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

        function handleGetFees() {
            global $db_conn;
            
            $col1 = $_POST['col1'];

            $result =  executePlainSQL("SELECT {$col1}(DeliveryFees) from Dealership ");

        
            echo "<br> {$col1} DeliveryFees";
            echo "<table>";
            echo "<tr><th>Fees</th></tr>";
        
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
                } else if (array_key_exists('updateEmailRequest', $_POST)) {
                    handleUpdateEmailRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('insertCustomerRequest', $_POST)) {
                    handleInsertCustomer();
                } else if (array_key_exists('insertRSARequest', $_POST)) {
                    handleInsertRSA();
                } else if (array_key_exists('insertLocationRequest', $_POST)) {
                    handleInsertLocation();
                } else if (array_key_exists('insertVehicleRequest', $_POST)) {
                    handleInsertVehicle();
                } else if (array_key_exists('insertTypeRequest', $_POST)) {
                    handleInsertType();
                } else if (array_key_exists('insertRentTypeRequest', $_POST)) {
                    handleInsertRentType();
                } else if (array_key_exists('insertDealershipRequest', $_POST)) {
                    handleInsertDealership();
                } else if (array_key_exists('insertRentLicenseRequest', $_POST)) {
                    handleInsertRentLicense();
                } else if (array_key_exists('getFeesValues', $_POST)) {
                    handleGetFees();
                } 

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
                    handleDispVehicle();
                } else if (array_key_exists('displayTypeTuples',  $_GET)) {
                    // code...
                    handleDispType();
                } else if (array_key_exists('displayRentTypeTuples',  $_GET)) {
                    // code...
                    handleDispRentType();
                } else if (array_key_exists('displayDealershipTuples',  $_GET)) {
                    // code...
                    handleDispDealership();
                } else if (array_key_exists('displayRentLicenseTuples',  $_GET)) {
                    // code...
                    handleDispRentLicense();
                } else if (array_key_exists('displayDeliveryFeesTuples',  $_GET)) {
                    // code...
                    handleDispDeliveryFees();
                } else if (array_key_exists('displayCompanyTuples',  $_GET)) {
                    // code...
                    handleDispCompany();
                } else if (array_key_exists('displayVehicleCompanyTuples',  $_GET)) {
                    // code...
                    handleDispVehicleCompany();
                } 
 
                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateEmailSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['insertCustomerSubmit']) || isset($_POST['insertRSASubmit']) || isset($_POST['insertLocationSubmit']) || isset($_POST['insertVehicleSubmit']) || isset($_POST['insertTypeSubmit']) || isset($_POST['insertRentTypeSubmit']) || isset($_POST['insertDealershipSubmit']) || isset($_POST['insertRentLicenseSubmit']) || isset($_POST['getFeesTuples'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['DisplayTupleRequest']) || isset($_GET['DisplayCustomerRequest']) || isset($_GET['DisplayRSARequest']) || isset($_GET['DisplayLocationRequest']) || isset($_GET['DisplayVehicleRequest']) || isset($_GET['DisplayTypeRequest'])|| isset($_GET['DisplayRentTypeRequest']) || isset($_GET['DisplayDealershipRequest']) || isset($_GET['DisplayRentLicenseRequest']) || isset($_GET['DisplayDeliveryFeesRequest']) || isset($_GET['DisplayCompanyRequest']) || isset($_GET['DisplayVehicleCompanyRequest'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>

