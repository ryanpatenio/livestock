<?php
// Include the database connection file
require("connection/connection.php");

// Fetch clients for the dropdown menu (assuming clients are already in the database)
$clientQuery = "SELECT CLIENT_ID, CONCAT(FNAME, ' ', LNAME) AS full_name FROM client";
$clientResult = mysqli_query($con, $clientQuery);
$clients = mysqli_fetch_all($clientResult, MYSQLI_ASSOC);

$query = "SELECT 
    vt.VACCINE_TYPE_ID,
    vt.VACCINE_NAME,
    vt.DESCRIPTION,
    v.QUANTITY,
    CASE 
        WHEN v.QUANTITY IS NULL THEN 0
        ELSE v.QUANTITY
    END AS QUANTITY_DISPLAY
FROM 
    vaccine_type vt
LEFT JOIN 
    vaccine v 
ON 
    vt.VACCINE_TYPE_ID = v.VACCINE_TYPE_ID;
";
$result = mysqli_query($con, $query);
$vaccineData = mysqli_fetch_all($result, MYSQLI_ASSOC);



// Check if the form is submitted
if (isset($_POST['submit_schedule'])) {
    // Get form data
    $event_name = mysqli_real_escape_string($con, $_POST['event_name']);
    $event_date = mysqli_real_escape_string($con, $_POST['event_date']);
    $client_id = mysqli_real_escape_string($con, $_POST['client_id']);
    $first_requirement = mysqli_real_escape_string($con, $_POST['first_requirement']);
    $second_requirement = mysqli_real_escape_string($con, $_POST['second_requirement']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $created_at = date('Y-m-d H:i:s'); // Current timestamp

    // Insert the data into the schedule table
    $query = "INSERT INTO schedule (EVENT_NAME, EVENT_DATE, CLIENT_ID, 1ST_REQUIREMENT, 2ND_REQUIREMENT, STATUS, CREATED_AT) 
              VALUES ('$event_name', '$event_date', '$client_id', '$first_requirement', '$second_requirement', '$status', '$created_at')";
    
    if (mysqli_query($con, $query)) {
        echo "Schedule created successfully.";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
  // Fetch schedules for a specific client
  $schedules = [];
  $selectedClientName = '';
  if (isset($_GET['client_id']) && !empty($_GET['client_id'])) {
      $client_id = intval($_GET['client_id']);

      // Get schedules
      $scheduleQuery = "SELECT vt.VACCINE_NAME,s.QTY_USED AS 'qty_request',s.SCHEDULE_ID, s.EVENT_NAME, s.EVENT_DATE, s.1ST_REQUIREMENT, s.2ND_REQUIREMENT, s.STATUS FROM schedule s, vaccine_type vt WHERE s.VACCINE_TYPE_ID = vt.VACCINE_TYPE_ID and CLIENT_ID = ? ORDER BY s.STATUS ASC";
      $stmt = mysqli_prepare($con, $scheduleQuery);
      mysqli_stmt_bind_param($stmt, 'i', $client_id);
      mysqli_stmt_execute($stmt);
      $scheduleResult = mysqli_stmt_get_result($stmt);
      $schedules = mysqli_fetch_all($scheduleResult, MYSQLI_ASSOC);

      // Get client name
      $clientNameQuery = "SELECT CONCAT(FNAME, ' ', LNAME) AS full_name FROM client WHERE CLIENT_ID = ?";
      $stmt = mysqli_prepare($con, $clientNameQuery);
      mysqli_stmt_bind_param($stmt, 'i', $client_id);
      mysqli_stmt_execute($stmt);
      $clientNameResult = mysqli_stmt_get_result($stmt);
      if ($clientNameResult && $clientRow = mysqli_fetch_assoc($clientNameResult)) {
          $selectedClientName = $clientRow['full_name'];
      } else {
          $selectedClientName = 'Unknown Client';
      }

     
  }




  mysqli_close($con);
  ?>

  <style>
    #schedTable {
    width: 100%;
    table-layout: fixed;
    overflow-x: auto;
    display: block;
}

  </style>

<div class="content-wrapper">
  <div class="content-header">
    <h1 class="font-weight-bold text-primary">Schedule Record - STAFF</h1>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Client List -->
        <div class="col-md-4">
          <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h6 class="mb-0">Clients</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                    <table class="table table-striped table-hover" id="clientTbl">
                      <thead class="thead-light">
                        <tr>
                          <th>#</th>
                          <th>Client</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1; foreach ($clients as $client) { ?>
                          <tr>
                            <td><?=$i; ?></td>
                            <td><?= htmlspecialchars($client['full_name']); ?></td>
                            <td>
                              <a href="index.php?page=Schedule&client_id=<?= $client['CLIENT_ID']; ?>" class="btn btn-sm btn-info">View</a>
                            </td>
                          </tr>
                        <?php $i++; } ?>
                      </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>

        <!-- Schedule Information -->
        <div class="col-md-8">
            <div class="card shadow-sm">
              <div class="card-header bg-primary text-white d-flex align-items-center">
                <h6>Scheduling Information</h6>
                <a href="#" class="btn btn-dark btn-sm ml-auto" data-toggle="modal" data-target="#Add_scheduleModal">
                  <i class="fas fa-plus"></i> New Request
                </a>
              </div>
              <div class="card-body">
                <h6><strong>Client:</strong> <?= htmlspecialchars($selectedClientName); ?></h6>
                <!-- Make the table responsive -->
                <div class="table-responsive">
                  <table class="table table-bordered" id="schedTable">
                    <thead class="thead-dark">
                      <tr>
                        <th>Vaccine Name</th>
                        <th>QTY Req.</th>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>1st Req.</th>
                        <th>2nd Req.</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($schedules as $schedule) { ?>
                        <tr>
                          <td><?= $schedule['VACCINE_NAME'] ?></td>
                          <td><?= $schedule['qty_request'] ?></td>
                          <td><?= htmlspecialchars($schedule['EVENT_NAME']); ?></td>
                          <td><?= htmlspecialchars($schedule['EVENT_DATE']); ?></td>
                          <td><?= $schedule['1ST_REQUIREMENT'] == 0 ? 'Not Submitted' : 'Submitted'; ?></td>
                          <td><?= $schedule['2ND_REQUIREMENT'] == 0 ? 'Not Submitted' : 'Submitted'; ?></td>
                          <td>
                            <?php if ($schedule['STATUS'] == 1) { ?>
                              <span class="badge badge-success">Confirmed</span>
                            <?php } elseif ($schedule['STATUS'] == 2) { ?>
                              <span class="badge badge-danger">Cancelled</span>
                            <?php } else { ?>
                              <span class="badge badge-warning">Pending</span>
                            <?php } ?>
                          </td>
                          <td>
                            <button class="btn btn-sm btn-warning edit-btn" 
                                    data-id="<?= $schedule['SCHEDULE_ID']; ?>" 
                                    data-1st="<?= $schedule['1ST_REQUIREMENT']; ?>" 
                                    data-2nd="<?= $schedule['2ND_REQUIREMENT']; ?>" 
                                    data-toggle="modal" 
                                    data-target="#editRequirementsModal">
                              Edit
                            </button>
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
</div>

<?php
include('modal/addModal.php');

?>
  <!-- Edit Modal -->
  <div class="modal fade" id="editRequirementsModal" tabindex="-1" aria-labelledby="editRequirementsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Edit Requirements</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editRequirementsForm" method="post" action="">
          <div class="modal-body">
          <input type="hidden" name="schedule_id" id="scheduleId">

            <div class="form-group">
              <label for="firstRequirement">1st Requirement</label>
              <select name="first_requirement" id="firstRequirement" class="form-control">
                <option value="0">Not Submitted</option>
                <option value="1">Submitted</option>
              </select>
            </div>
            <div class="form-group">
              <label for="secondRequirement">2nd Requirement</label>
              <select name="second_requirement" id="secondRequirement" class="form-control">
                <option value="0">Not Submitted</option>
                <option value="1">Submitted</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Requirements</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- <script src="../livestock2/plugins/jquery/jquery.min.js"></script> -->
  <script src="../livestock2/administrator/Schedule/sched.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.edit-btn').forEach(function (button) {
          button.addEventListener('click', function () {
              const scheduleId = this.getAttribute('data-id');
              const firstRequirement = this.getAttribute('data-1st');
              const secondRequirement = this.getAttribute('data-2nd');

              document.getElementById('scheduleId').value = scheduleId;
              document.getElementById('firstRequirement').value = firstRequirement;
              document.getElementById('secondRequirement').value = secondRequirement;
          });
      });
  });
  </script>