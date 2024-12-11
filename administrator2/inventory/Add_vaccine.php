<!-- Button to trigger modal -->

<!-- Modal -->
<div class="modal fade" id="addVaccineModal" tabindex="-1" role="dialog" aria-labelledby="addVaccineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVaccineModalLabel">Add New Vaccine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="includes/action.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Vaccine</label>
                        <select class="custom-select" required name="VACCINE_TYPE_ID">
                            <option value="" selected>-SELECT-</option>
                            <?php 
                            require("connection/connection.php");

                            $query = "SELECT * FROM vaccinetype";

                            // Get Result
                            $result = mysqli_query($con, $query);

                            // Check if query was successful
                            if ($result) {
                                // Fetch Data into an array
                                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                // Iterate over the array using foreach loop
                                foreach ($rows as $row) { 
                                    ?>
                                    <option value="<?= htmlspecialchars($row['VACCINE_TYPE_ID']); ?>"><?= htmlspecialchars($row['VACCINE_NAME']); ?></option>
                                    <?php
                                }

                                // Free result set
                                mysqli_free_result($result);
                            } else {
                                // Handle database error
                                echo "Error: " . mysqli_error($con);
                            }

                            // Close Connection
                            mysqli_close($con);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="InputDESCRIPTION">DESCRIPTION</label>
                        <input type="text" name="DESCRIPTION" class="form-control" id="InputDESCRIPTION" placeholder="Enter DESCRIPTION">
                    </div>
                    <div class="form-group">
                        <label for="InputQUANTITYL">QUANTITY</label>
                        <input type="number" name="QUANTITY" class="form-control" id="InputQUANTITYL" placeholder="Input Quantity">
                    </div>
                    <div class="form-group">
                        <label for="InputDATE_CREATED">DATE CREATED</label>
                        <input type="date" name="DATE_CREATED" class="form-control" id="InputDATE_CREATED" placeholder="Enter DATE CREATED">
                    </div>
                    <div class="form-group">
                        <label for="InputInputEXPIRY_DATE">EXPIRATION DATE</label>
                        <input type="date" name="EXPIRY_DATE" class="form-control" id="InputEXPIRY_DATE" placeholder="Enter EXPIRATION DATE">
                    </div>
                    <button type="submit" name="btn-addvaccine" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
