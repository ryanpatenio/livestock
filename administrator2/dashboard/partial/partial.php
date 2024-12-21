<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require("connection/connection.php"); // Ensure this file has your DB connection settings

function insertOneClientAnimalIntoParentTable($con, $client_id) {
    // Step 1: Search for an animal record for the client
    $query = "SELECT ANIMAL_ID FROM animal WHERE CLIENT_ID = ?  LIMIT 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $client_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Step 2: Check if an animal is found  
    if ($row = mysqli_fetch_assoc($result)) {
        $animal_id = $row['ANIMAL_ID'];

        // Step 3: Insert the animal ID and client ID into the parent table
        $insertQuery = "INSERT INTO parent (CLIENT_ID, ANIMAL_ID) VALUES (?, ?)
                        ON DUPLICATE KEY UPDATE ANIMAL_ID = ANIMAL_ID"; // Avoid duplicates
        $insertStmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, 'ii', $client_id, $animal_id);

        if (mysqli_stmt_execute($insertStmt)) {
            echo "Successfully inserted or updated ANIMAL_ID {$animal_id} for CLIENT_ID {$client_id} in the parent table.";
        } else {
            echo "Error inserting record into the parent table: " . mysqli_error($con);
        }

        mysqli_stmt_close($insertStmt);
    } else {
        echo "No animal record found for CLIENT_ID {$client_id}.";
    }

    mysqli_stmt_close($stmt);
}

// Fetch all clients with unpaid status
$clientQuery = "SELECT c.CLIENT_ID, CONCAT(FNAME, ' ', LNAME) AS full_name  from dispersal d, client c where  d.CLIENT_ID = c.CLIENT_ID and d.1ST_PAYMENT_ID = 1 and d.2ND_PAYMENT_ID = 0 and d.STATUS = 'PENDING' ORDER BY c.FNAME ASC";
$clientPartialResult = mysqli_query($con, $clientQuery);
$clientsPartial = mysqli_fetch_all($clientPartialResult, MYSQLI_ASSOC);


$clientQuery2 = "SELECT CLIENT_ID, CONCAT(FNAME, ' ', LNAME) AS full_name FROM client ORDER BY FNAME ASC";
$clientResult = mysqli_query($con, $clientQuery2);
$clients = mysqli_fetch_all($clientResult, MYSQLI_ASSOC);


// Fetch all animals by clients
$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';
$Query2 = "SELECT ANIMAL_ID, ANIMALTYPE, ANIMAL_SEX FROM animal WHERE CLIENT_ID = ? AND ANIMAL_SEX = 'Female'";
$stmt2 = mysqli_prepare($con, $Query2);

// Check if statement preparation was successful
if ($stmt2) {
    mysqli_stmt_bind_param($stmt2, 'i', $client_id);

   
    if (mysqli_stmt_execute($stmt2)) {
        $animalResult = mysqli_stmt_get_result($stmt2);

        // Check if rows are found
        if (mysqli_num_rows($animalResult) > 0) {
            $animals = mysqli_fetch_all($animalResult, MYSQLI_ASSOC);
           
        } else {
            echo "No results found.";
        }
    } else {
        echo "Error executing query: " . mysqli_error($con);
    }
} else {
    echo "Error preparing statement: " . mysqli_error($con);
}



// Initialize variables
$dispersals = [];
$selectedClientName = '';

if (isset($_GET['client_id']) && !empty($_GET['client_id'])) {
    $client_id = $_GET['client_id'];

    // Fetch dispersals for this client
    $dispersalQuery = "SELECT DISPERSAL_ID, CLIENT_ID, 1ST_PAYMENT_ID, 2ND_PAYMENT_ID, STATUS FROM dispersal WHERE CLIENT_ID = ?";
    $stmt = mysqli_prepare($con, $dispersalQuery);
    mysqli_stmt_bind_param($stmt, 'i', $client_id);
    mysqli_stmt_execute($stmt);
    $dispersalResult = mysqli_stmt_get_result($stmt);
    $dispersals = mysqli_fetch_all($dispersalResult, MYSQLI_ASSOC);

    // Fetch the client's name
    $clientNameQuery = "SELECT CONCAT(FNAME, ' ', LNAME) AS full_name FROM client WHERE CLIENT_ID = ?";
    $stmt = mysqli_prepare($con, $clientNameQuery);
    mysqli_stmt_bind_param($stmt, 'i', $client_id);
    mysqli_stmt_execute($stmt);
    $clientNameResult = mysqli_stmt_get_result($stmt);

    if ($clientNameResult && $clientRow = mysqli_fetch_assoc($clientNameResult)) {
        $selectedClientName = $clientRow['full_name'];
    } else {
        $selectedClientName = 'Unknown Client'; // Default in case no result is found
    }

    // Insert one of the client's animals into the parent table
    insertOneClientAnimalIntoParentTable($con, $client_id);
}


mysqli_close($con);
?>

<div class="content-wrapper">
  <!-- Page Header -->
  <div class="content-header" style="margin-top: -20px;">
    <div class="container-fluid">
      <div class="row mb-1 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-users"></i> Dispersal Records -- Partially Paid Clients</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right bg-light p-2 rounded">
            <li class="breadcrumb-item text-dark"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Admin</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Clients List Section -->
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm">
              <div class="card-header bg-primary text-white">
                  <h6 class="mb-0"><b>List of Partially Paid Clients</b></h6>
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
                      <?php foreach ($clientsPartial as $client) { ?>
                        <tr>
                          <td><?= htmlspecialchars($client['full_name']); ?></td>
                          <td>
                            <a href="index2.php?page=PartialPayments&client_id=<?= $client['CLIENT_ID']; ?>" class="btn btn-info btn-sm elevation-1">
                              View
                            </a>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Dispersal Details Section -->
        <div class="col-md-6 mb-4">
          <div class="card shadow-lg border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="mb-0">
              <i class="fas fa-list mr-2"></i>Dispersal Information
            </h6>
            <!-- <a href="#" class="btn btn-dark btn-sm ml-auto" data-toggle="modal" data-target="#Add_dispersalModal">
              <i class="fas fa-plus"></i> New
            </a> -->
          </div>
            <div class="card-body">
              <!-- Client Information -->
              <div class="mb-4">
                <h6 class="font-weight-bold text-muted">Client:</h6>
                <p id="clientNameDisplay" class="text-dark">
                  <?= $selectedClientName ? htmlspecialchars($selectedClientName) : "Select a client to view dispersal details"; ?>
                </p>
              </div>

              <!-- Dispersal Table -->
              <h5 class="text-primary font-weight-bold">Dispersal Details</h5>
              <div class="table-responsive">
                <table class="table table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>Dispersal ID</th>
                      <th>1st Payment</th>
                      <th>2nd Payment</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($dispersals)) { ?>
                      <?php foreach ($dispersals as $dispersal) {
                        $isFirstPaymentPaid = !empty($dispersal['1ST_PAYMENT_ID']);
                        $isSecondPaymentPaid = !empty($dispersal['2ND_PAYMENT_ID']);
                        $status = $isFirstPaymentPaid && $isSecondPaymentPaid ? "Completed" : ($isFirstPaymentPaid ? "Partially Paid" : "Unpaid");
                      ?>
                        <tr>
                          <td><?= htmlspecialchars($dispersal['DISPERSAL_ID']); ?></td>
                          <td>
                            <?php if (!$isFirstPaymentPaid) { ?>
                              <button class="btn btn-danger btn-sm payment-button-1st" 
                                      id="edit-btn"
                                      data-dispersal-id1="<?= $dispersal['DISPERSAL_ID']; ?>" 
                                      data-payment-type="1ST_PAYMENT_ID" 
                                      data-client-name="<?= htmlspecialchars($selectedClientName); ?>">
                                Unpaid
                              </button>
                            <?php } else { ?>
                              <span class="badge badge-success">Paid</span>
                            <?php } ?>
                          </td>
                          <td>
                            <?php if (!$isSecondPaymentPaid) { ?>
                              <button class="btn btn-danger btn-sm payment-button-2nd" 
                                      id="edit-btn"                                    
                                      data-dispersal-id2="<?= $dispersal['DISPERSAL_ID']; ?>" 
                                      data-payment-type="2ND_PAYMENT_ID" 
                                      data-client-name="<?= htmlspecialchars($selectedClientName); ?>">
                                Unpaid
                              </button>
                            <?php } else { ?>
                              <span class="badge badge-success">Paid</span>
                            <?php } ?>
                          </td>
                          <td>
                            <span class="<?= $status === 'Completed' ? 'text-success font-weight-bold' : ($status === 'Partially Paid' ? 'text-warning font-weight-bold' : 'text-danger font-weight-bold'); ?>">
                              <?= htmlspecialchars($status); ?>
                            </span>
                          </td>
                        </tr>
                      <?php } ?>
                    <?php } else { ?>
                      <tr>
                        <td colspan="4" class="text-center text-muted">
                          No dispersal details found for this client.
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include('modal/updateFirstPayment.php'); ?>
  <?php include('modal/updateSecondPayment.php'); ?>

<script src="../livestock2/administrator2/dashboard/partial/partial.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    $('#main').css('filter', 'none');
    $('#loader').hide();


  // Toggle payment details based on status selection
  document.getElementById('paymentStatus1').addEventListener('change', function() {
    document.getElementById('paymentDetails1').style.display = (this.value === '1') ? 'block' : 'none';
  });

  document.getElementById('paymentStatus2').addEventListener('change', function() {
    document.getElementById('paymentDetails2').style.display = (this.value === '1') ? 'block' : 'none';
  });

  // Toggle new/existing client fields
  document.getElementById('clientType').addEventListener('change', function() {
    document.getElementById('existingClientDiv').style.display = (this.value === 'existing') ? 'block' : 'none';
    document.getElementById('newClientDiv').style.display = (this.value === 'new') ? 'block' : 'none';
  });

  // Populate payment modal fields when a payment button is clicked
  const paymentButtons = document.querySelectorAll('.payment-button');
  paymentButtons.forEach(button => {
    button.addEventListener('click', function() {
      document.getElementById('dispersalId').value = this.dataset.dispersalId;
      document.getElementById('paymentType').value = this.dataset.paymentType;
      document.getElementById('paid_by').value = this.dataset.clientName;
    });
  });
});

</script>