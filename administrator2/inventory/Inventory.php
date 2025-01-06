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

//fetch inventory
$query2  = "SELECT 
    vt.VACCINE_NAME AS 'VACCINE_NAME', 
    vt.DESCRIPTION,
    v.VACCINE_TYPE_ID,
    SUM(v.QUANTITY) AS available_quantity,
    MIN(v.DATE_CREATED) AS first_created_date,
    MAX(v.EXPIRY_DATE) AS EXPIRY_DATE
FROM 
    vaccine v
JOIN 
    vaccine_type vt ON v.VACCINE_TYPE_ID = vt.VACCINE_TYPE_ID
WHERE 
    v.EXPIRY_DATE > NOW() -- Ensure only non-expired vaccines are included
GROUP BY 
    vt.VACCINE_NAME, vt.DESCRIPTION, v.VACCINE_TYPE_ID
ORDER BY 
    first_created_date ASC;
";

$executeQuery = mysqli_query($con, $query2);
$inventory =  mysqli_fetch_all($executeQuery, MYSQLI_ASSOC);


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
        <div class="container-fluid p-3">
            <div class="row">
                <!-- Vaccine Type List -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><b>List of Vaccine Types</b></h6>
                            <button class="btn btn-success float-right" data-toggle="modal" data-target="#addVaccTypeModal">+ add</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="vaccineTypeTBL" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Vaccine Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($vaccineTypes as $type) {
                                        
                                        ?>
                                            <tr>
                                                <td><?=$i; ?></td>
                                                <td><?= htmlspecialchars($type['VACCINE_NAME']); ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" id="edit-vacc-type-btn" data-id="<?=$type['VACCINE_TYPE_ID']; ?>"><i class="fa fa-edit">edit</i></button>
                                                </td>
                                                <!-- <td><a href="index.php?page=inventory&vaccine_type_id=<?= $type['VACCINE_TYPE_ID']; ?>" class="btn btn-sm btn-outline-info">View</a></td> -->
                                            </tr>

                                    <?php $i++;  } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
             </div>

                <!-- Vaccine Inventory List -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <div class="row">
                                <div class="col-6">
                                     <h4>Inventory</h4>
                                </div>
                                <div class="col-6">
                                     <button class="btn btn-primary float-right" data-toggle="modal" data-target="#AddVaccineModal">+ Add New Vaccine</button>
                                </div>
                            </div>
                           
                            
                        </div>
                        <div class="card-body">
                            <div id="table-responsive">
                                <table class="table datatable table-light inventory-table" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Vaccine Type</th>
                                            <th>Description</th>
                                            <th>Available Quantity</th>
                                           
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                            foreach ($inventory as $data) { ?>
                                                <tr>
                                                    <td><?=$i; ?></td>
                                                    <td><?=$data['VACCINE_NAME'] ?></td>
                                                    <td><?=$data['DESCRIPTION'] ?></td>
                                                    <td><?=$data['available_quantity'] ?></td>
                                                   
                                                    <td>
                                                        <a href="index2.php?page=viewInventory&vaccID=<?=$data['VACCINE_TYPE_ID'] ?>" class="btn btn-sm btn-primary "><i class="fa fa-eye"> view</i></a>
                                                       
                                                    
                                                    </td>
                                                </tr>
                                          <?php $i++; }
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Add New Vaccine Modal -->
<div class="modal fade" id="AddVaccineModal" tabindex="-1" role="dialog" aria-labelledby="AddVaccineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" id="addVaccineForm" method="POST">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Add New Vaccine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="vaccineType">Vaccine Type</label>
                        <select class="custom-select" required name="VACCINE_TYPE_ID">
                            <option value="" selected>- SELECT -</option>
                            <?php foreach ($vaccineTypes as $type): ?>
                                <option value="<?= htmlspecialchars($type['VACCINE_TYPE_ID']); ?>"><?= htmlspecialchars($type['VACCINE_NAME']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="quantity">Quantity</label>
                        <input type="number" min="5" class="form-control" id="quantity" name="QUANTITY" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="expiryDate">Expiry Date</label>
                        <input type="date" class="form-control" id="expiryDate" name="EXPIRY_DATE" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="btn-add-vaccine" class="btn btn-primary">Save Vaccine</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
include('modal/addVaccyTypeModal.php');
include('modal/editVaccTypeModal.php');

?>

<script src="../livestock2/administrator2/inventory/inventory.js"></script>
<script src="../livestock2/administrator2/inventory/vaccine.js"></script>
<!-- JavaScript for handling AJAX-based modal interactions -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
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
