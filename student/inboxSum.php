<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summon Ticket Inbox</title>
    <!--EXTERNAL CSS-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../css/inbox.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/bookForm.css">
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
                                        <!-- row -->
                                        <tr>
                                            <!-- Message -->
                                            <td>
                                                <a class="link" href="javascript: void(0)">
                                                    <span class="badge badge-pill text-white font-medium badge-danger mr-2">Summon Ticket</span>
                                                    <span class="text-dark"><a>Your have new summon ticket ! [BJW 2020]</a></span>
                                                </a>
                                            </td>
                                            <!-- Time -->
                                            <td class="text-muted">May 13</td>
                                            <td><a href="../student/viewSummon.php"><button type="button" id="viewbtn" name="viewbtn">View</button></a></td>
                                        </tr>
                                        <!-- Add more rows for other summon ticket notifications -->
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
