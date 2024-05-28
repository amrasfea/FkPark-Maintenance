<?php
/*$server = "localhost";
$username = "root";
$password = "";
$dbname = "fkpark";

// Create connection
$conn = mysqli_connect($server, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if not exists
if (mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $dbname")) {
    echo "Database created successfully or already exists.<br>";
} else {
    die("Error creating database: " . mysqli_error($conn));
}

// Select database
mysqli_select_db($conn, $dbname) or die(mysqli_error($conn));

// MODULE 1
// TABLE: USER
$createUserTableQuery = "CREATE TABLE IF NOT EXISTS user (
    u_id INT AUTO_INCREMENT PRIMARY KEY,
    u_email VARCHAR(100) NOT NULL UNIQUE,
    u_password VARCHAR(255) NOT NULL,
    u_type ENUM('Unit Keselamatan Staff','Administrators','Student') NOT NULL
)";

if (mysqli_query($conn, $createUserTableQuery)) {
    echo "User table created successfully or already exists.<br>";
} else {
    die("Error creating user table: " . mysqli_error($conn));
}


// TABLE: PROFILE
$createProfileTableQuery = "CREATE TABLE IF NOT EXISTS profiles (
    p_id INT AUTO_INCREMENT PRIMARY KEY,
    p_name VARCHAR(100) NOT NULL,
    p_course ENUM('SOFTWARE ENGINEERING', 'NETWORKING', 'GRAPHIC DESIGN') DEFAULT NULL,
    p_faculty VARCHAR(100) DEFAULT NULL,
    p_icNumber VARCHAR(15) NOT NULL,
    p_email VARCHAR(100) NOT NULL,
    p_phoneNum VARCHAR(15) DEFAULT NULL,
    p_address VARCHAR(100) DEFAULT NULL,
    p_postCode VARCHAR(10) DEFAULT NULL,
    p_country VARCHAR(50) DEFAULT NULL,
    p_state VARCHAR(50) DEFAULT NULL,
    p_department VARCHAR(100) DEFAULT NULL,
    p_bodyNumber VARCHAR(10) DEFAULT NULL,
    p_position VARCHAR(100) DEFAULT NULL,
    u_id INT,
    FOREIGN KEY (u_id) REFERENCES user (u_id)
)";

if (mysqli_query($conn, $createProfileTableQuery)) {
    echo "Profile table created successfully or already exists.<br>";
} else {
    die("Error creating profile table: " . mysqli_error($conn));
}

// TABLE: VEHICLE
$createVehicleTableQuery = "CREATE TABLE IF NOT EXISTS vehicle (
    v_id INT AUTO_INCREMENT PRIMARY KEY,
    v_vehicleType ENUM('MOTORCYCLE','CAR') NOT NULL,
    v_brand VARCHAR(50) NOT NULL,
    v_roadTaxValidDate DATE NOT NULL,
    v_licenceValidDate DATE NOT NULL,
    v_licenceClass VARCHAR(5) NOT NULL,
    v_phoneNum INT NOT NULL,
    v_vehicleGrant BLOB NOT NULL,
    v_approvalStatus ENUM('Reject','Approve') DEFAULT NULL,
    v_remarks TEXT DEFAULT NULL,
    v_qrCode VARCHAR(500) DEFAULT NULL,
    v_plateNum VARCHAR(10) NOT NULL,
    v_model VARCHAR(50) NOT NULL,
    u_id INT,
    FOREIGN KEY (u_id) REFERENCES user (u_id)
)";

if (mysqli_query($conn, $createVehicleTableQuery)) {
    echo "Vehicle table created successfully or already exists.<br>";
} else {
    die("Error creating vehicle table: " . mysqli_error($conn));
}

// MODULE 2
// TABLE: PARKSPACE
$createParkSpaceTableQuery = "CREATE TABLE IF NOT EXISTS parkSpace(
    ps_id VARCHAR(10) PRIMARY KEY,
    ps_area VARCHAR(10) NOT NULL,
    ps_category VARCHAR(10) NOT NULL,
    ps_date DATE NOT NULL,
    ps_time TIME NOT NULL,
    ps_typeEvent VARCHAR(50) DEFAULT NULL,
    ps_descriptionEvent VARCHAR(50) DEFAULT NULL,
    ps_QR VARCHAR(255) DEFAULT NULL,
    ps_availableStat VARCHAR(10) DEFAULT NULL
    )";

if (mysqli_query($conn, $createParkSpaceTableQuery)) {
    echo "ParkSpace table created successfully or already exists.<br>";
} else {
    die("Error creating ParkSpace table: " . mysqli_error($conn));
}

// MODULE 3
// TABLE: BOOKINFO
$createBookInfoTableQuery = "CREATE TABLE IF NOT EXISTS bookInfo(
    b_id INT AUTO_INCREMENT PRIMARY KEY,
    u_id INT,
    b_date DATE NOT NULL,
    b_time TIME NOT NULL,
    b_parkStart TIME DEFAULT NULL,
    b_duration INT DEFAULT NULL,
    b_status VARCHAR(10)DEFAULT NULL,
    b_QRid VARCHAR(255) DEFAULT NULL,
    v_id INT ,
    ps_id VARCHAR(10),
    FOREIGN KEY (u_id) REFERENCES user(u_id)
    FOREIGN KEY (v_id) REFERENCES vehicle(v_id),
   FOREIGN KEY (ps_id) REFERENCES parkSpace(ps_id)
)";

if (mysqli_query($conn, $createBookInfoTableQuery)) {
    echo "BookInfo table created successfully or already exists.<br>";
} else {
    die("Error creating BookInfo table: " . mysqli_error($conn));
}

// MODULE 4 


//TABLE :VIOLATION TYPE
$createViolationTypeTableQuery = "CREATE TABLE IF NOT EXISTS violationType (
    vt_id INT AUTO_INCREMENT PRIMARY KEY,
    vt_name VARCHAR(200) NOT NULL,
    vt_demeritPoints INT NOT NULL
)";

if (mysqli_query($conn, $createViolationTypeTableQuery)) {
    echo "ViolationType table created successfully or already exists.<br>";
} else {
    die("Error creating ViolationType table: " . mysqli_error($conn));
}

// TABLE: SUMMON
$createSummonTableQuery = "CREATE TABLE IF NOT EXISTS summon (
    sum_id INT AUTO_INCREMENT PRIMARY KEY,
    sum_date DATE DEFAULT NULL,
    sum_vModel VARCHAR(50) NOT NULL,
    sum_vBrand VARCHAR(100) NOT NULL,
    sum_vPlate VARCHAR(10) NOT NULL,
    sum_location VARCHAR(10) NOT NULL,
    sum_violationType VARCHAR(200) NOT NULL,
    sum_demerit INT NOT NULL,
    sum_status VARCHAR(200) DEFAULT NULL,
    sum_QR VARCHAR(200) DEFAULT NULL,
    vt_id INT DEFAULT NULL,
    v_id INT NOT NULL,
    FOREIGN KEY (vt_id) REFERENCES violationType (vt_id),
    FOREIGN KEY (v_id) REFERENCES vehicle(v_id)
    
   
)";

if (mysqli_query($conn, $createSummonTableQuery)) {
    echo "Summon table created successfully or already exists.<br>";
} else {
    die("Error creating Summon table: " . mysqli_error($conn));
}

mysqli_close($conn);
?>*/
