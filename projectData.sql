CREATE TABLE demoTable (id int PRIMARY KEY, name char(30));

CREATE TABLE Customers (drivingLicenseNumber int PRIMARY KEY, Name CHAR(20), phoneNumber INT, Address CHAR(20), email CHAR(20));

INSERT INTO Customer VALUES (420, 'Lakshya', 420, 'ubc', '1@gmail.com');
INSERT INTO Customer VALUES (122334, 'Amine', 123298208, 'Portland', 'amine@clbn.com');


CREATE TABLE Rental_Service_Agency (Name CHAR(20) PRIMARY KEY,Budget INT);

INSERT INTO Rental_Service_Agency VALUES ('CarRental AB', 600000);
INSERT INTO Rental_Service_Agency VALUES('CarRental QB', 900000);


CREATE TABLE Rental_Locations_Have (ID INT PRIMARY KEY,
            Agency_Name CHAR(20), Location CHAR (20),
            FOREIGN KEY (Agency_Name) REFERENCES Rental_Service_Agency(Name));

INSERT INTO Rental_Locations_Have VALUES(134, 'CarRental BC', 'UBC');
INSERT INTO Rental_Locations_Have VALUES(199, 'CarRental AB'. 'Alberta Road');

CREATE TABLE TypeOfRental (Name CHAR(20) PRIMARY KEY);

INSERT INTO TypeOfRental VALUES('1 Day');
INSERT INTO TypeOfRental VALUES('1 Month');


CREATE TABLE Rent_type(TypeOfRental_Name CHAR(20) PRIMARY KEY, Fees INT,
            FOREIGN KEY (TypeOfRental_Name) REFERENCES TypeOfRental(Name));

INSERT INTO Rent_type Values('1 Week', 500);
INSERT INTO Rent_type Values('1 Day', 200);


CREATE TABLE Rent(
            drivingLicenseNumber INT, TypeOfRental_Name CHAR(20), RentalLocation_ID INT,
            PRIMARY KEY (drivingLicenseNumber, TypeOfRental_Name, RentalLocation_ID),
            FOREIGN KEY (drivingLicenseNumber) REFERENCES Customers(drivingLicenseNumber),
            FOREIGN KEY (TypeOfRental_Name) REFERENCES TypeOfRental(Name),
            FOREIGN KEY (RentalLocation_ID) REFERENCES Rental_Locations_Have(ID));

INSERT INTO Rent VALUES(420, '1 Day', 134);
INSERT INTO Rent VALUES(123456, '1 Month', 199);


CREATE TABLE Dealership(Unique_ID INT PRIMARY KEY,Name CHAR(20), 
                DeliveryFees INT);

INSERT INTO Dealership VALUES(2, '2', 100);
INSERT INTO Dealership Values(1, '1', 100);

CREATE TABLE Vehicles(VehicleNumber INT PRIMARY KEY,drivingLicenseNumber INT,
                countryOfManufacture CHAR(20),company CHAR(20),dealership_ID INT,rentalLocation_ID INT,
                category CHAR(20),
                FOREIGN KEY (dealership_ID) REFERENCES Dealership(Unique_ID),
                FOREIGN KEY (drivingLicenseNumber) REFERENCES Customers(drivingLicenseNumber),
                FOREIGN KEY (rentalLocation_ID) REFERENCES Rental_Locations_Have(ID) );

INSERT INTO Vehicles Values(22, NULL, 'India', 'IndianCar', 134, 'Car');
INSERT INTO Vehicles Values(21, 420, 'Germany', 'BMW', 134, 'Car');

CREATE TABLE Rent_licenseNum(drivingLicenseNumber INT PRIMARY KEY,
                VehicleNumber INT, RentalLocation_ID INT, FOREIGN KEY (drivingLicenseNumber) REFERENCES Customers(drivingLicenseNumber),FOREIGN KEY (VehicleNumber) REFERENCES Vehicles(VehicleNumber) on Delete Cascade,FOREIGN KEY (RentalLocation_ID) REFERENCES Rental_Locations_Have(ID) );

INSERT INTO Rent_licenseNum VALUES (11111, 55, 134);
INSERT INTO Rent_licenseNum VALUES(123456, 1, 134);

CREATE TABLE Employee (UniqueID int PRIMARY KEY, Name char(30), Role char(30), Wage int); 

INSERT INTO Employee VALUES(13, 'Sylvia', 'Cashier', 20);
INSERT INTO Employee VALUES(15, 'Ayan', 'CarWash', 10);


CREATE TABLE Insurance_Benefit (BenefitID int PRIMARY KEY, name char(30));
INSERT INTO Insurance_Benefit VALUES(1, 'Insurance1');
INSERT INTO Insurance_Benefit VALUES(1, 'Insurance1');



CREATE TABLE Employee_Benefits (UniqueID int , BenefitID int, PRIMARY KEY (UniqueID,BenefitID), FOREIGN KEY (UniqueID) REFERENCES Employee(UniqueID) ON DELETE CASCADE, FOREIGN KEY (BenefitID) REFERENCES Insurance_Benefit(BenefitID) ON DELETE CASCADE);

INSERT INTO Employee_Benefits Values(13, 1);
INSERT INTO Employee_Benefits Values(13, 2);
