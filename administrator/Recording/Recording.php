<?php
require("connection/connection.php");

// Fetch all clients
$clientQuery = "SELECT CLIENT_ID, CONCAT(FNAME, ' ', LNAME) AS full_name FROM client";
$clientResult = mysqli_query($con, $clientQuery);
$clients = mysqli_fetch_all($clientResult, MYSQLI_ASSOC);
mysqli_free_result($clientResult);

// Fetch animals for selected client if client_id is set
$animals = [];
$selectedClient = '';
$client_id = $_GET['client_id'];
if (isset($_GET['client_id'])) {
    
    $animalQuery = "SELECT 
                        ANIMAL_ID, 
                        ANIMALTYPE, 
                        BIRTHDATE, 
                        ANIMAL_SEX AS GENDER, 
                        STATUS, 
                        VACCINE_CARD_ID, isVaccinated,
                        IMAGE_PATH
                    FROM animal 
                    WHERE CLIENT_ID = ?";
                    
    if ($stmt = mysqli_prepare($con, $animalQuery)) {
        mysqli_stmt_bind_param($stmt, 'i', $client_id);
        mysqli_stmt_execute($stmt);
        $animalResult = mysqli_stmt_get_result($stmt);
        $animals = mysqli_fetch_all($animalResult, MYSQLI_ASSOC);

        // Fetch client's full name for display
        $clientNameQuery = "SELECT CONCAT(FNAME, ' ', LNAME) AS full_name FROM client WHERE CLIENT_ID = ?";
        if ($stmt = mysqli_prepare($con, $clientNameQuery)) {
            mysqli_stmt_bind_param($stmt, 'i', $client_id);
            mysqli_stmt_execute($stmt);
            $clientNameResult = mysqli_stmt_get_result($stmt);
            $selectedClient = mysqli_fetch_assoc($clientNameResult)['full_name'] ?? '';
        }
    }
}
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
    }
}

// Insert vaccine into vaccine_card when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['VACCINE_ID']) && isset($_POST['animal_id']) && isset($_POST['DATE'])) {
        $vaccine_id = $_POST['VACCINE_ID'];
        $animal_id = $_POST['animal_id'];
        $date = $_POST['DATE'];

        $insertVaccineCardQuery = "INSERT INTO vaccine_card (VACCINE_ID, ANIMAL_ID, DATE) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($con, $insertVaccineCardQuery)) {
            mysqli_stmt_bind_param($stmt, 'iis', $vaccine_id, $animal_id, $date);
            mysqli_stmt_execute($stmt);
            // You can handle success or redirection here
        }
    }
}

$query2  = "SELECT s.SCHEDULE_ID, vt.VACCINE_NAME,vt.`DESCRIPTION`,s.EVENT_DATE FROM schedule s,vaccine_type vt WHERE s.VACCINE_TYPE_ID = vt.VACCINE_TYPE_ID AND s.CLIENT_ID = ? AND s.`STATUS` = 1 AND s.isCompleted != 1";


$stmt5 = mysqli_prepare($con, $query2);

if ($stmt5) {
    // Bind the parameter to the query
    mysqli_stmt_bind_param($stmt5, 'i', $client_id);

    // Execute the query
    mysqli_stmt_execute($stmt5);

    // Fetch the result set
    $result5 = mysqli_stmt_get_result($stmt5);

    // Fetch all rows into an associative array
    $schedules = mysqli_fetch_all($result5, MYSQLI_ASSOC);

   
    // Close the statement
    mysqli_stmt_close($stmt5);
} else {
    // Handle errors in query preparation
    die("Failed to prepare statement: " . mysqli_error($con));
}
mysqli_close($con);
?>

<div class="content-wrapper">
    <div class="content-header">
        <h1 class="m-0 text-primary"><i class="fas fa-user"></i> Client Module</h1>
        <p class="text-muted">Manage clients, view animal details, and track vaccination status.</p>
    </div>

    <section class="content">
        <div class="container-fluid p-3">
            <div class="row">
                <!-- Client List -->

                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><b>List of Clients</b></h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="clientTBL" class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Client</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clients as $client): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($client['full_name']); ?></td>
                                                <td>
                                                    <a href="index.php?page=Recording&client_id=<?= $client['CLIENT_ID']; ?>" 
                                                    class="btn btn-sm btn-info fa fa-search">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                 </div>


                 <!-- Animal Information -->
                 <div class="col-md-8">
                    <div class="card shadow">
                        <!-- Card Header -->
                        <div class="card-header bg-success text-white d-flex align-items-center">
                            <h5 class="mb-0"><i class="fas fa-paw"></i> Animal Information</h5>
                            <a href="#" 
                            class="btn btn-warning btn-sm ml-auto" 
                            style="border-radius: 20px; font-weight: bold;" 
                            data-toggle="modal" 
                            data-target="#AddCattleModal">
                            + Add New
                            </a>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <h6 class="mb-3">
                                <strong>Client:</strong> 
                                <span id="clientNameDisplay" class="text-primary">
                                    <?= htmlspecialchars($selectedClient) ?: "Select a client to view animal details"; ?>
                                </span>
                            </h6>

                            <!-- Table -->
                            <table class="table table-bordered table-striped" id="animal-info-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Animal Type</th>
                                        <th>Birthdate</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>Vaccination Status</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; if (!empty($animals)): ?>
                                        <?php foreach ($animals as $animal): ?>
                                            <tr>
                                                <td><?=$i; ?></td>
                                                <!-- Animal Type -->
                                                <td><?= htmlspecialchars($animal['ANIMALTYPE']); ?></td>

                                                <!-- Birthdate -->
                                                <td><?= htmlspecialchars($animal['BIRTHDATE']); ?></td>

                                                <!-- Gender -->
                                                <td><?= $animal['GENDER'] == 1 ? 'Male' : 'Female'; ?></td>

                                                <!-- Status -->
                                                <td>
                                                    <button class="btn btn-sm <?= $animal['STATUS'] == 1 ? 'btn-success' : 'btn-danger'; ?> editStatusBtn"
                                                            data-animal-id="<?= $animal['ANIMAL_ID']; ?>"
                                                            data-current-status="<?= $animal['STATUS']; ?>">
                                                        <?= $animal['STATUS'] == 1 ? 'Alive' : 'Dead'; ?>
                                                    </button>
                                                </td>

                                                <!-- Vaccination Status -->
                                                <td>
                                                    <button class="btn btn-sm <?= $animal['isVaccinated'] == 0 ? 'btn-warning' : 'btn-primary'; ?>" 
                                                            id="vacc-status"
                                                            data-animal-id="<?= $animal['ANIMAL_ID']; ?>">
                                                        <?= $animal['isVaccinated'] == 0 ? 'Not Vaccinated' : 'Vaccinated'; ?>
                                                    </button>
                                                </td>

                                                <!-- Image -->
                                                <td>
                                                    <?php if (!empty($animal['IMAGE_PATH'])): ?>
                                                        <img src="includes/<?= htmlspecialchars($animal['IMAGE_PATH']); ?>" 
                                                            alt="Animal Image" 
                                                            class="img-thumbnail" 
                                                            style="width: 150px;">
                                                    <?php else: ?>
                                                        <span class="text-muted">No image</span>
                                                    <?php endif; ?>
                                                </td>

                                                <!-- Actions -->
                                                <td>
                                                    <button class="btn btn-sm btn-primary" 
                                                            id="view-btn" 
                                                            data-id="<?= $animal['ANIMAL_ID']; ?>">
                                                        <i class="fa fa-eye"></i> View
                                                    </button>
                                                    <button class="btn btn-sm btn-success" 
                                                            id="add-btn" 
                                                            data-current-vaccination-status="<?= $animal['isVaccinated'] == 0 ? 'Not Vaccinated' : 'Vaccinated'; ?>" 
                                                            data-id="<?= $animal['ANIMAL_ID']; ?>">
                                                        <i class="fa fa-plus"></i> Add
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php $i++; endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No animal details found for this client.
                                            </td>
                                        </tr>
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
<?php include('addVaccination.php'); ?>
<?php include('viewAnimalModal.php'); ?>

<!-- Edit Animal Status Modal -->
<div class="modal fade" id="editAnimalStatusModal" tabindex="-1" role="dialog" aria-labelledby="editAnimalStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnimalStatusModalLabel">Edit Animal Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editAnimalStatusForm">
                <div class="modal-body">
                    <input type="hidden" name="animal_id" id="statusAnimalIdInput">
                    <div class="form-group">
                        <label for="statusSelect">Status</label>
                        <select class="form-control" id="statusSelect" name="status">
                            <option value="1">Alive</option>
                            <option value="2">Dead</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="../livestock2/administrator/Recording/recording.js"></script>
<!-- Scripts to handle modals and updates -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle vaccine button click

    $('#animal-info-table').dataTable({

    });

    const editVaccineButtons = document.querySelectorAll('.editVaccineBtn');
    editVaccineButtons.forEach(button => {
        button.addEventListener('click', function() {
            const animalId = this.dataset.animalId;
            const currentVaccinationStatus = this.dataset.currentVaccinationStatus;

            document.getElementById('vaccineAnimalIdInput').value = animalId;
            document.getElementById('vaccineSelect').value = currentVaccinationStatus;

            // Show/hide vaccine fields based on vaccination status
            toggleVaccineFields(currentVaccinationStatus);

            $('#editAnimalVaccineModal').modal('show');
        });
    });

    // Listen for changes in vaccination status dropdown to toggle fields
    document.getElementById('vaccineSelect').addEventListener('change', function() {
        toggleVaccineFields(this.value);
    });

    // Function to toggle vaccine-related fields
    function toggleVaccineFields(vaccinationStatus) {
        const vaccineTypeGroup = document.getElementById('vaccineTypeGroup');
        const vaccineIdGroup = document.getElementById('vaccineIdGroup');
        const vaccineDateGroup = document.getElementById('vaccineDateGroup');
        const vaccineScheduleGroup = document.getElementById('vaccineScheduleGroup');

        if (vaccinationStatus == '2') { // Vaccinated
            vaccineTypeGroup.style.display = 'block';
            vaccineIdGroup.style.display = 'block';
            vaccineDateGroup.style.display = 'block';
            vaccineScheduleGroup.style.display = 'block';
        } else { // Not Vaccinated
            vaccineTypeGroup.style.display = 'none';
            vaccineIdGroup.style.display = 'none';
            vaccineDateGroup.style.display = 'none';
            vaccineScheduleGroup.style.display = 'none';
        }
    }

    // Fetch vaccines based on selected vaccine type
    document.getElementById('vaccineTypeSelect').addEventListener('change', function() {
        const vaccineTypeId = this.value;
        fetchVaccines(vaccineTypeId);
    });

    function fetchVaccines(vaccineTypeId) {
        const vaccineIdSelect = document.getElementById('VACCINE_ID');
        vaccineIdSelect.innerHTML = ''; // Clear existing options

        // Use AJAX or any method to fetch vaccines based on vaccineTypeId
        // Example: fetch('/path/to/vaccines.php?vaccine_type_id=' + vaccineTypeId)
        // After fetching, populate the vaccineIdSelect dropdown

        // Sample data insertion
        const vaccines = [
            {id: 1, name: 'Vaccine 1'},
            {id: 2, name: 'Vaccine 2'}
        ];

        vaccines.forEach(function(vaccine) {
            const option = document.createElement('option');
            option.value = vaccine.id;
            option.text = vaccine.name;
            vaccineIdSelect.appendChild(option);
        });
    }
});

</script>

<?php
// Check if the AddCattleModal.php file exists before including it
$addCattleModalPath = "administrator/AddCattle/AddCattle.php";
if (file_exists($addCattleModalPath)) {
    include($addCattleModalPath);
} else {
    echo "<p style='color: red;'>Error: Add Cattle Modal file not found.</p>";
}
?>