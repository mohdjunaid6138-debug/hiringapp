
<?php
$host = "localhost";
$db = "actor_registration";
$user = "root";
$pass = ""; // default is blank on XAMPP

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Upload photo
$photoName = $_FILES['photo']['name'];
$photoTmp = $_FILES['photo']['tmp_name'];
$uploadDir = "uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$photoPath = $uploadDir . time() . "_" . basename($photoName);
move_uploaded_file($photoTmp, $photoPath);

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$bio = $_POST['bio'];

// Insert into database
$sql = "INSERT INTO actors (name, email, phone, dob, gender, photo, bio)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $name, $email, $phone, $dob, $gender, $photoPath, $bio);

if ($stmt->execute()) {
    echo "<h2>Shukriya! Aapka form successfully submit ho gaya hai.</h2>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
