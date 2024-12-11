<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require("connection/connection.php");

// Fetch all vaccine types for dropdown
$vaccineTypeQuery = "SELECT * FROM vaccine_type";
$vaccineTypeResult = mysqli_query($con, $vaccineTypeQuery);
$vaccineTypes = mysqli_fetch_all($vaccineTypeResult, MYSQLI_ASSOC);
mysqli_free_result($vaccineTypeResult);

// Fetch vaccines by selected type if vaccine_type_id is set
$vaccines = [];
$selectedVaccineType = '';
if (isset($_GET['vaccine_type_id'])) {
    $vaccine_type_id = $_GET['vaccine_type_id'];
    $vaccineQuery = "SELECT * FROM vaccine WHERE VACCINE_TYPE_ID = ?";
    if ($stmt = mysqli_prepare($con, $vaccineQuery)) {
        mysqli_stmt_bind_param($stmt, 'i', $vaccine_type_id);
        mysqli_stmt_execute($stmt);
        $vaccineResult = mysqli_stmt_get_result($stmt);
        $vaccines = mysqli_fetch_all($vaccineResult, MYSQLI_ASSOC);

        // Fetch vaccine type name for display
            $typeNameQuery = "SELECT VACCINE_NAME FROM vaccine_type WHERE VACCINE_TYPE_ID = ?";
            if ($stmt = mysqli_prepare($con, $typeNameQuery)) {
                mysqli_stmt_bind_param($stmt, 'i', $vaccine_type_id);
                mysqli_stmt_execute($stmt);
                $typeNameResult = mysqli_stmt_get_result($stmt);
                if ($typeNameResult && $row = mysqli_fetch_assoc($typeNameResult)) {
                    $selectedVaccineType = $row['VACCINE_NAME'];
                } else {
                    $selectedVaccineType = ''; // or provide a default value
                }
                mysqli_free_result($typeNameResult);
            }
    }
}

mysqli_close($con);
?>

<div class="content-wrapper">
    <div class="content-header">
        <h1 class="m-0">Vaccine Inventory Module</h1>
    </div>

    <section class="content">
        <div class="container-fluid p-2">
            <div class="row">
                <!-- Vaccine Type List -->
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header"><h6><b>Vaccine Types</b>   <button class="btn btn-primary float-right" data-toggle="modal" data-target="#Add_vaccine_typeModal">+Add New Vaccine Type</button></h6></div>
                        <div class="card-body">
                            <table id="vaccineTypeTBL" class="table table-bordered table-hover">
                                <thead><tr><th>Vaccine Type</th><th>Action</th></tr></thead>
                                <tbody>
                                    <?php foreach ($vaccineTypes as $type): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($type['VACCINE_NAME']); ?></td>
                                            <td><a href="index2.php?page=inventory&vaccine_type_id=<?= $type['VACCINE_TYPE_ID']; ?>" class="btn-sm btn-info elevation-1">View</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Vaccine Inventory List -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6><b>Inventory for Vaccine Type: <?= $selectedVaccineType ?: "Select a type to view details"; ?></b></h6>
                            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#AddVaccineModal">+ New Vaccine</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead><tr><th>Description</th><th>Quantity</th><th>Date Created</th><th>Expiry Date</th><th>Action</th></tr></thead>
                                <tbody>
                                    <?php if ($vaccines): ?>
                                        <?php foreach ($vaccines as $vaccine): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($vaccine['DESCRIPTION']); ?></td>
                                                <td><?= htmlspecialchars($vaccine['QUANTITY']); ?></td>
                                                <td><?= htmlspecialchars($vaccine['DATE_CREATED']); ?></td>
                                                <td><?= htmlspecialchars($vaccine['EXPIRY_DATE']); ?></td>
                                                <td><button class="btn btn-sm btn-info editVaccineBtn" data-id="<?= $vaccine['VACCINE_ID']; ?>">Edit</button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="6">No vaccines found for this type.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modals for adding new vaccine -->
<div class="modal fade" id="AddVaccineModal" tabindex="-1" role="dialog" aria-labelledby="AddVaccineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="includes/action.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Vaccine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vaccineType">Vaccine Type</label>
                        <select class="custom-select" required name="VACCINE_TYPE_ID">
                            <option value="" selected>-SELECT-</option>
                            <?php foreach ($vaccineTypes as $type): ?>
                                <option value="<?= htmlspecialchars($type['VACCINE_TYPE_ID']); ?>"><?= htmlspecialchars($type['VACCINE_NAME']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="dateCreated">Date Created</label>
                        <input type="date" class="form-control" id="dateCreated" name="date_created" required>
                    </div>
                    <div class="form-group">
                        <label for="expiryDate">Expiry Date</label>
                        <input type="date" class="form-control" id="expiryDate" name="expiry_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="btn-addvaccine" class="btn btn-primary">Save Vaccine</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for handling AJAX-based modal interactions -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).on('click', '.editVaccineBtn', function() {
        const vaccineId = $(this).data('id');
        $('#editVaccineIdInput').val(vaccineId);
        $('#editVaccineModal').modal('show');
    });

    $('#editVaccineForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'update_vaccine.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    $('#editVaccineModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            },
            error: function() {
                alert('An error occurred while updating the vaccine.');
            }
        });
    });
</script>
<?php include("administrator2/inventory/Add_vaccine_type.php"); ?>