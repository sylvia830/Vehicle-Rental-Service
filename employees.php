<link rel="stylesheet" href="Oracle_php.css">
<html>
<head>
    <meta charset="utf-8">
    <title> Employees </title>
</head>
<body>

    <hr />
        <h1>Employees</h1>
        <a class="nav-link" href="oracle-test.php">Go Back to Main Page</a>
    <hr />

    <h2>Reset</h2>
    <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

    <form method="POST" action="employees.php">
        <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
        <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
        <p><input type="submit" value="Reset" name="resetTables"></p>
    </form>

     <hr />

    <h2>Insert Employees</h2>
    <form method="POST" action="employees.php">
        <input type="hidden" id="insertEmployeeRequest" name="insertEmployeeRequest"> 
        Unique ID :   <input type="text" name="insUID"><br><br>
        Name :        <input type="text" name="insEName"><br><br>
        Role :        <input type="text" name="insRole"><br><br>
        Wage :        <input type="text" name="insWage"><br><br>
    
        <button type="submit" id="insertEmployeeSubmit" name="insertEmployeeSubmit"> Insert </button>
    </form>   

    <hr />

    <h2>Insert Benefit</h2>
    <form method="POST" action="employees.php">
        <input type="hidden" id="insertBenefitRequest" name="insertBenefitRequest"> 
        Benefit ID :   <input type="text" name="insBenefitID"><br><br>
        Name :        <input type="text" name="insBenefitName"><br><br>
    
        <button type="submit" id="insertBenefitSubmit" name="insertBenefitSubmit"> Insert </button>
    </form> 

    <h2>Assign Employee Benefits</h2>
    <form method="POST" action="employees.php">
        <input type="hidden" id="insertEmployeeBenefitRequest" name="insertEmployeeBenefitRequest"> 
        EMPUnique ID :   <input type="text" name="insEUID"><br><br>
        BenefitID :        <input type="text" name="insBNAME"><br><br>
        
        <button type="submit" id="insertEmployeeSubmit" name="insertEmployeeBenefitSubmit"> Insert </button>
    </form> 
    
     <hr>
     <h2> Display Employees </h2>
        <form method = "GET" action="employees.php">
            <input type="hidden" id="DisplayEmployeeRequest" name="DisplayEmployeeRequest"> 
            <button type="submit" id="displayEmployeeSubmit" name="displayEmployeeSubmit"> Display </button>
        </form>
     <hr>

     <h2> Display Benefits </h2>
        <form method = "GET" action="employees.php">
            <input type="hidden" id="DisplayBenefitRequest" name="DisplayBenefitRequest"> 
            <button type="submit" id="displayBenefitSubmit" name="displayBenefitSubmit"> Display </button>
        </form>
     <hr>

     <h2> Display Employee Benefits </h2>
        <form method = "GET" action="employees.php">
            <input type="hidden" id="DisplayEmployeeBenefitRequest" name="DisplayEmployeeBenefitRequest"> 
            <button type="submit" id="displayEmployeeBenefitSubmit" name="displayEmployeeBenefitSubmit"> Display </button>
        </form>
     <hr>


     <h2> Delete Employees </h2>
        <form method = "POST" action="employees.php">
            Unique Id: <input type="text" name="delUID"><br><br>
            <button type="submit" id="deleteEmployeeSubmit" name="deleteEmployeeSubmit"> Delete </button>
        </form>
     <hr>

     <h2> Display Employees who have all the benefits </h2>
        <form method = "GET" action="employees.php">
            <input type="hidden" id="DisplayEmployeeAllRequest" name="DisplayEmployeeAllRequest"> 
            <button type="submit" id="displayEmployeeAllSubmit" name="displayEmployeeAllSubmit"> Display Employees who have all the benefits</button>
        </form>
     <hr>




<?php 
// include 'oracle_test.php';
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

    function handleDeleteEmployee(){
            global $db_conn;
            $UniqueId=$_POST['delUID'];
            $AgencyName=$_POST['delAName'];
            executePlainSQL("DELETE from Employee where UniqueID=$UniqueId");
            ocicommit($db_conn);
            // oci_close($db_conn);
            // AND Agency_Name=$AgencyName
            //$s=oci_parse($db_conn, "DELETE from Employee_Have where Unique_id=$UniqueId AND Agency_Name=$AgencyName");
            // $result=oci_execute($s);
            // if($result){
            //     echo "operation successful";
            //     oci_commit($db_conn);
            // }
            // oci_close($db_conn);
        }

        
    function handleResetRequest() {
        global $db_conn;
        // Drop old table
        executePlainSQL("DROP TABLE demoTable");

            // Create new table
        echo "<br> creating new table <br>";
        executePlainSQL("CREATE TABLE Employee (UniqueID int PRIMARY KEY, Name char(30), Role char(30), Wage int)"); 
        executePlainSQL("CREATE TABLE Insurance_Benefit (BenefitID int PRIMARY KEY, name char(30))");
        executePlainSQL("CREATE TABLE Employee_Benefits (UniqueID int , BenefitID int, PRIMARY KEY (UniqueID, BenefitID), FOREIGN KEY (UniqueID) REFERENCES Employee(UniqueID) ON DELETE CASCADE, FOREIGN KEY (BenefitID) REFERENCES Insurance_Benefit(BenefitID) ON DELETE CASCADE)");

        OCICommit($db_conn);

    }

    



    function handleInsertEmployee() {
            global $db_conn;

            $tuple = array (
                ":bind1" => $_POST['insUID'],
                ":bind2" => $_POST['insEName'],
                ":bind3" => $_POST['insRole'],
                ":bind4" => $_POST['insWage'],
                ":bind5" => $_POST['insAName']
            );


            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into Employee values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
            OCICommit($db_conn);
    }

    function handleInsertBenefit() {
        global $db_conn;

        $tuple = array (
            ":bind1" => $_POST['insBenefitID'],
            ":bind2" => $_POST['insBenefitName'],
        );


        $alltuples = array (
            $tuple
        );

        executeBoundSQL("insert into Insurance_Benefit values (:bind1, :bind2)", $alltuples);
        OCICommit($db_conn);
}

function handleInsertEmployee_Benefit() {
    global $db_conn;

    $tuple = array (
        ":bind1" => $_POST['insEUID'],
        ":bind2" => $_POST['insBNAME'],
    );


    $alltuples = array (
        $tuple
    );

    executeBoundSQL("insert into Employee_Benefits values (:bind1, :bind2)", $alltuples);
    OCICommit($db_conn);
}



        
    
        function handleDispEmployee() {
            global $db_conn;
            $result = executePlainSQL("SELECT UniqueID, Name, Role, Wage FROM Employee");
            // printEmployeeResult($result);
            echo "<br>Retrieved data from table Employees:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Role</th><th>Wage</th></tr>";

            // while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            //     echo "<tr><td>" . $row["drivingLicenseNumber"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["phoneNumber"] . "</td><td>" . $row["Address"] . "</td><td>" . $row["email"] . "</td></tr>"; //or just use "echo $row[0]" 
            // } 

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr>"; //or just use "echo $row[0]" 

            }

            echo "</table>";

        }

        function handleDispBenefit() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM Insurance_Benefit");
            // printEmployeeResult($result);
            echo "<br>Retrieved data from table Insurance_Benefit:<br>";
            echo "<table>";
            echo "<tr><th>BenefitID</th><th>Name</th><</tr>";

            // while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            //     echo "<tr><td>" . $row["drivingLicenseNumber"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["phoneNumber"] . "</td><td>" . $row["Address"] . "</td><td>" . $row["email"] . "</td></tr>"; //or just use "echo $row[0]" 
            // } 

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr>"; //or just use "echo $row[0]" 

            }

            echo "</table>";

        }

        function handleDisplayEmployee_Benefits() {
            global $db_conn;
            $result = executePlainSQL("SELECT * FROM Employee_Benefits");

            echo "<br>Retrieved data from table Employee_Benefits:<br>";
            echo "<table>";
            echo "<tr><th>EmployeeID</th><th>BenefitID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr>"; //or just use "echo $row[0]" 

            }
            echo "</table>";
        }


        function handleDisplayEmployeeAll() {
            global $db_conn;
            $result = executePlainSQL("SELECT e.UniqueID, e.Name from Employee e where not exists (select * from Insurance_Benefit i where not exists (select b.UniqueID from Employee_Benefits b where e.UniqueID  = b.UniqueID AND i.BenefitID = b.BenefitID))");

            echo "<br>Display all the employees who have all the benefits:<br>";
            echo "<table>";
            echo "<tr><th>EmployeeID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]" 

            }
            echo "</table>";
        }


        function handlePOSTRequest(){
                    if(array_key_exists('insertEmployeeSubmit', $_POST))
                        handleInsertEmployee();
                    else if(array_key_exists('deleteEmployeeSubmit', $_POST))
                        handleDeleteEmployee();
                    else if(array_key_exists('resetTablesRequest', $_POST))
                        handleResetRequest();
                    else if(array_key_exists('insertBenefitRequest', $_POST))
                        handleInsertBenefit();
                    else if(array_key_exists('insertEmployeeBenefitSubmit', $_POST))
                        handleInsertEmployee_Benefit();
                   

                        
                
        }



        function handleGETRequest(){
                if(array_key_exists('displayEmployeeSubmit', $_GET))
                        handleDispEmployee();
                else if(array_key_exists('displayEmployeeBenefitSubmit', $_GET))
                        handleDisplayEmployee_Benefits();
                else if(array_key_exists('displayBenefitSubmit', $_GET))
                        handleDispBenefit();
                else if(array_key_exists('displayEmployeeAllSubmit', $_GET))
                        handleDisplayEmployeeAll();
                
               
        }
//insertBenefitSubmit
        if(isset($_POST['insertEmployeeSubmit'])||isset($_POST['deleteEmployeeSubmit']) ||isset($_POST['resetTables']) ||isset($_POST['insertBenefitSubmit']) ||isset($_POST['insertEmployeeBenefitSubmit'])  )
            {
                if(connectToDB()){
                 handlePOSTRequest();
                 disconnectFromDB();
             }
            }
        if(isset($_GET['displayEmployeeSubmit']) || isset($_GET['DisplayEmployeeRequest'])  || isset($_GET['DisplayEmployeeBenefitRequest'])  || isset($_GET['DisplayBenefitRequest']) || isset($_GET['DisplayEmployeeAllRequest']))
            {
                if(connectToDB()){
                    handleGETRequest();
                    disconnectFromDB();
                }  
            }

?>


 </body>
</html>
