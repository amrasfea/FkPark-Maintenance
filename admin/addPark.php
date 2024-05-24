<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Park</title>
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/park.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <!--FAVICON-->
</head>
<body>
    <?php include('../navigation/adminNav.php'); ?>
    <div class="container mt-5">
        <h2>Parking Space Form</h2>
        <form id="parkingForm" method="post" action="">
            <div class="button-group">
                <button type="button" name="newForm" onclick="newForm()">New Form</button>
            </div>
            <div class="form-group">
                
                <label for="pArea">Parking Area:</label>
                <input type="text" class="form-control" id="pArea" name="pArea">

                <label for="spaceno">Space Number:</label>
                <input type="text" class="form-control" id="spaceno" name="spaceno">

                <label for="pID">Parking ID:</label>
                <input type="text" class="form-control" id="pID" name="pID">

                <label for="category">Category:</label>
                <input type="text" class="form-control" id="category" name="category">

                
            </div>
            <div class="button-group">
                <button type="button" name="cancel" onclick="clearForm()">Cancel</button>
                <button type="button" name="save" onclick="saveForm()">Save</button>
            </div>
        </form>
    </div>
    <script>
         function clearForm() {
            document.getElementById("parkingForm").reset();
            document.getElementById("successMessage").style.display = "none";
        }

        function saveForm() {
            // Display alert message
            alert("Successfully saved!");
            // Optionally, you can also display the success message in the form
            document.getElementById("successMessage").style.display = "block";
        }

        function newForm() {
            clearForm();
            document.getElementById("pArea").focus(); // Set focus to the first input field to indicate a new form is ready to be filled.
        }
    </script>
</body>
</html>
