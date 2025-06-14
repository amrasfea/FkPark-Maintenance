<?php
session_start();
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session and if the user is an admin
if (!isset($_SESSION['u_id']) || $_SESSION['role'] !== 'Administrators') {
    die("Error: You do not have permission to view this page.");
}

// Retrieve all pending bookings with student info
$sql = "
    SELECT 
        b.b_id, b.ps_id, b.b_date, b.b_time, b.b_platenum,
        p.ps_area, p.ps_availableStat,
        pr.p_name AS student_name, pr.p_email AS student_email
    FROM bookinfo b
    JOIN parkspace p ON b.ps_id = p.ps_id
    JOIN user u ON b.u_id = u.u_id
    JOIN profiles pr ON pr.u_id = u.u_id
    WHERE b.b_status = 'Pending'
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Booking Approval</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
</head>
<body>

<?php include('../navigation/adminNav.php'); ?>

<div class="container mt-5">
    <h2>Pending Bookings</h2>

    <?php if (!empty($flash)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($flash) ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <table class='table table-striped' id="bookingTable">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Student Email</th>
                    <th>Parking Space ID</th>
                    <th>Parking Area</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Plate Number</th>
                    <th>Availability Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["student_name"]) ?></td>
                    <td><?= htmlspecialchars($row["student_email"]) ?></td>
                    <td><?= htmlspecialchars($row["ps_id"]) ?></td>
                    <td><?= htmlspecialchars($row["ps_area"]) ?></td>
                    <td><?= htmlspecialchars($row["b_date"]) ?></td>
                    <td><?= htmlspecialchars($row["b_time"]) ?></td>
                    <td><?= htmlspecialchars($row["b_platenum"]) ?></td>
                    <td><?= htmlspecialchars($row["ps_availableStat"]) ?></td>
                    <td>
                        <button class='btn btn-success btn-sm' data-toggle='modal' data-target='#confirmApproveModal' data-id='<?= $row["b_id"] ?>'>Approve</button>
                        <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#confirmRejectModal' data-id='<?= $row["b_id"] ?>'>Reject</button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending bookings found.</p>
    <?php endif; ?>
</div>

<!-- JS dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#bookingTable').DataTable();

    // Attach booking ID to approve modal link
    $('#confirmApproveModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const bId = button.data('id');
        $('#confirmApproveBtn').attr('href', 'approveBook.php?b_id=' + bId);
    });

    // Attach booking ID to reject modal link
    $('#confirmRejectModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const bId = button.data('id');
        $('#confirmRejectBtn').attr('href', 'rejectBook.php?b_id=' + bId);
    });
});
</script>

<!-- Approve Confirmation Modal -->
<div class="modal fade" id="confirmApproveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Confirm Approval</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Are you sure you want to approve this booking?
      </div>
      <div class="modal-footer">
        <a href="#" id="confirmApproveBtn" class="btn btn-success">Yes, Approve</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Reject Confirmation Modal -->
<div class="modal fade" id="confirmRejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirm Rejection</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Are you sure you want to reject this booking?
      </div>
      <div class="modal-footer">
        <a href="#" id="confirmRejectBtn" class="btn btn-danger">Yes, Reject</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
