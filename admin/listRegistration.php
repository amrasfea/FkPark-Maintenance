<?php
session_start();
require '../config.php'; // Database connection

// Initialize the success message variable
$successMessage = '';

// Handle the deletion of a student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete']) && isset($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);
    if ($deleteId > 0) {
        // Delete the student record from the database
        $deleteQuery = "DELETE FROM profiles WHERE u_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        $stmt->close();

        // Set the success message
        $successMessage = "Student deleted successfully.";
    }
}

// Fetch newly registered student information if available
$newlyRegisteredId = isset($_GET['newly_registered_id']) ? intval($_GET['newly_registered_id']) : 0;
$newlyRegisteredStudent = null;

if ($newlyRegisteredId > 0) {
    $studentQuery = "SELECT u.u_id, p.p_name, p.p_course, p.p_faculty, p.p_icNumber 
                     FROM user u
                     JOIN profiles p ON u.u_id = p.u_id
                     WHERE u.u_id = ?";
    $stmt = $conn->prepare($studentQuery);
    $stmt->bind_param("i", $newlyRegisteredId);
    $stmt->execute();
    $result = $stmt->get_result();
    $newlyRegisteredStudent = $result->fetch_assoc();
    $stmt->close();
}

// Fetch all students for listing, excluding the newly registered student
$searchTerm = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $searchTerm = isset($_POST['searchArea']) ? trim($_POST['searchArea']) : '';
}

$studentsQuery = "SELECT u.u_id, p.p_name, p.p_course, p.p_faculty, p.p_icNumber 
                  FROM user u
                  JOIN profiles p ON u.u_id = p.u_id
                  WHERE u.u_type = 'Student'";

if (!empty($searchTerm)) {
    $studentsQuery .= " AND p.p_name LIKE ?";
}

if ($newlyRegisteredId > 0) {
    $studentsQuery .= " AND u.u_id != $newlyRegisteredId";
}

$stmt = $conn->prepare($studentsQuery);

if (!empty($searchTerm)) {
    $searchTerm = "%{$searchTerm}%";
    $stmt->bind_param("s", $searchTerm);
}

$stmt->execute();
$studentsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Registered User</title>
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>List Registration</h2>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="" class="search-form">
            <div class="form-group">
                <div class="search-input-group">
                    <input type="text" class="form-control" id="searchArea" name="searchArea" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button type="submit" name="search" class="search-button">Search</button>
                </div>
            </div>
        </form>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Faculty</th>
                    <th>IC Number</th>
                    <th>Action</th> <!-- Added Action column -->
                </tr>
            </thead>
            <tbody>
                <?php if ($newlyRegisteredStudent): ?>
                <tr style="background-color: #d4edda;">
                    <td><?php echo htmlspecialchars($newlyRegisteredStudent['u_id']); ?></td>
                    <td><?php echo htmlspecialchars($newlyRegisteredStudent['p_name']); ?></td>
                    <td><?php echo htmlspecialchars($newlyRegisteredStudent['p_course']); ?></td>
                    <td><?php echo htmlspecialchars($newlyRegisteredStudent['p_faculty']); ?></td>
                    <td><?php echo htmlspecialchars($newlyRegisteredStudent['p_icNumber']); ?></td>
                    <td>
                        <a href="../admin/viewRegistration.php?id=<?php echo $newlyRegisteredStudent['u_id']; ?>" class="view-button">View</a>
                        <a href="../admin/edit_student.php?id=<?php echo $newlyRegisteredStudent['u_id']; ?>" class="edit-button">Edit</a>
                        <form method="post" action="listRegistration.php" onsubmit="return confirm('Are you sure you want to delete this student?');" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $newlyRegisteredStudent['u_id']; ?>">
                            <button type="submit" name="delete" class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endif; ?>
                <?php while ($row = $studentsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['u_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['p_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['p_course']); ?></td>
                    <td><?php echo htmlspecialchars($row['p_faculty']); ?></td>
                    <td><?php echo htmlspecialchars($row['p_icNumber']); ?></td>
                    <td>
                        <a href="../admin/viewRegistration.php?id=<?php echo $row['u_id']; ?>" class="view-button">View</a>
                        <a href="../admin/edit_student.php?id=<?php echo $row['u_id']; ?>" class="edit-button">Edit</a>
                        <form method="post" action="listRegistration.php" onsubmit="return confirm('Are you sure you want to delete this student?');" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['u_id']; ?>">
                            <button type="submit" name="delete" class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

