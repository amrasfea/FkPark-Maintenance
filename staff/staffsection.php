<?php
include('staffProfile.php'); // Include only data retrieval logic
?>
<div class="user-info">
   <div class="row">
      <div class="col-md-6">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Profile Section</h5>
               <p class="card-text">Name: <?php echo htmlspecialchars($userData['p_name']); ?></p>
               <p class="card-text">Body Number: <?php echo htmlspecialchars($userData['p_bodyNumber']); ?></p>
               <p class="card-text">Email: <?php echo htmlspecialchars($userData['p_email']); ?></p>
               <p class="card-text">Phone: <?php echo htmlspecialchars($userData['p_phoneNum']); ?></p>
               <p class="card-text">Department: <?php echo htmlspecialchars($userData['p_department']); ?></p>
               <p class="card-text">Position: <?php echo htmlspecialchars($userData['p_position']); ?></p>
            </div>
         </div>
      </div>
   </div>
</div>

