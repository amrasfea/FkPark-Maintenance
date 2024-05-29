<?php
include('studentProfile.php'); // Include only data retrieval logic
?>
<div class="user-info">
   <div class="row">
      <div class="col-md-6">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Profile Section</h5>
               <p class="card-text">Name: <?php echo htmlspecialchars($userData['p_name']); ?></p>
               <p class="card-text">Matric Number: <?php echo htmlspecialchars($userData['p_matricNum']); ?></p>

               <p class="card-text">Course: <?php echo htmlspecialchars($userData['p_course']); ?></p>
               <p class="card-text">Faculty: <?php echo htmlspecialchars($userData['p_faculty']); ?></p>

               <p class="card-text">IC Number: <?php echo htmlspecialchars($userData['p_icNumber']); ?></p>
               <p class="card-text">Email <?php echo htmlspecialchars($userData['p_email']); ?></p>

               <p class="card-text">Phone: <?php echo htmlspecialchars($userData['p_phoneNum']); ?></p>
               <p class="card-text">Address: <?php echo htmlspecialchars($userData['p_address']); ?></p>

            </div>
         </div>
      </div>
   </div>
</div>
