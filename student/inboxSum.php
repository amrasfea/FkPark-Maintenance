<?php
require '../session_check.php';
require '../config.php'; // Database connection

// Check if user_id is set in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: User ID is not set in the session.");
}

$userId = $_SESSION['u_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summon Ticket Inbox</title>
    <!--EXTERNAL CSS-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../css/inbox.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/inbox.css">
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
</head>
<body>
<?php include('../navigation/studentNav.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bg-primary text-white mailbox-widget pb-0">
                    <h2 class="text-white pb-3">Summon Ticket Inbox</h2>
                    <ul class="nav nav-tabs custom-tab border-bottom-0 mt-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="inbox-tab" data-toggle="tab" aria-controls="inbox" href="#inbox" role="tab" aria-selected="true">
                                <span class="d-block d-md-none"><i class="ti-email"></i></span>
                                <span class="d-none d-md-block"> INBOX</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="inbox" aria-labelledby="inbox-tab" role="tabpanel">
                        <div>
                            <!-- Mail list-->
                            <div class="table-responsive">
                                <table class="table email-table no-wrap table-hover v-middle mb-0 font-14">
                                    <tbody>
                                        <?php
                                            // Query to fetch summon ticket information related to the current user
                                            $sql = "SELECT summon.*, vehicle.*, user.* 
                                                    FROM summon 
                                                    INNER JOIN vehicle ON summon.v_id = vehicle.v_id 
                                                    INNER JOIN user ON vehicle.u_id = user.u_id 
                                                    WHERE user.u_id = $userId";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // Output data of each row
                                                while($row = $result->fetch_assoc()) {
                                                    echo '<tr>';
                                                    echo '<td>';
                                                    echo '<a class="link" href="javascript: void(0)">';
                                                    echo '<span class="badge badge-pill text-white font-medium badge-danger mr-2">Summon Ticket</span>';
                                                    echo '<span class="text-dark">NEW MESSAGE SUMMON !</span>';
                                                    echo '<span class="text-dark"><a>' . $row["v_plateNum"] . '</a></span>';
                                                    echo '</a>';
                                                    echo '</td>';
                                                    echo '<td class="text-muted">' . $row["sum_date"] . '</td>';
                                                    echo '<td><a href="../student/sumReceipt.php?id=' . $row["sum_id"] . '"><button type="button" id="viewbtn" name="viewbtn">View</button></a></td>';
                                                    echo '</tr>';
                                                }
                                            } else {
                                                echo "0 results";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
