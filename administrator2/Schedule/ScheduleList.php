  <?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
  require("connection/connection.php");

  // Fetch all clients
  $clientQuery = "SELECT CLIENT_ID, CONCAT(FNAME, ' ', LNAME) AS full_name FROM client";
  $clientResult = mysqli_query($con, $clientQuery);
  $clients = mysqli_fetch_all($clientResult, MYSQLI_ASSOC);

  //get all vaccine Dat
$query = "select * from vaccine_type";
$result = mysqli_query($con, $query);
$vaccineData = mysqli_fetch_all($result, MYSQLI_ASSOC);

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


  <div class="content-wrapper">
    <div class="content-header">
      <h1 class="font-weight-bold text-primary">Schedule Record - Admin<h1>
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
                <table class="table table-striped table-hover" id="client-table">
                  <thead>
                    <tr> <th>#</th><th>Client</th><th>Action</th></tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; foreach ($clients as $client) { ?>
                      <tr>
                        <td><?=$i; ?></td>
                        <td><?= htmlspecialchars($client['full_name']); ?></td>
                        <td>
                          <a href="index2.php?page=Schedule&client_id=<?= $client['CLIENT_ID']; ?>" class="btn btn-sm btn-info">View</a>
                        </td>
                      </tr>
                    <?php $i++; } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

    <!-- Schedule Information -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header bg-primary text-white d-flex align-items-center">
               
                  <h6>Scheduling Information</h6>
                  <a href="#" class="btn btn-dark ml-auto" data-toggle="modal" data-target="#Add_scheduleModal">New Request</a>
              
              </div>
              <div class="card-body">
                <h6>Client: <span><?= htmlspecialchars($selectedClientName); ?></span></h6>
                <table class="table table-bordered" id="sched-info-table">
                  <thead>
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
                        <td><?=$schedule['VACCINE_NAME'] ?></td>
                        <td><?= $schedule['qty_request'] ?></td>
                        <td><?= htmlspecialchars($schedule['EVENT_NAME']); ?></td>
                        <td><?= htmlspecialchars($schedule['EVENT_DATE']); ?></td>
                        <td><?= $schedule['1ST_REQUIREMENT'] == 0 ? 'Not Submitted' : 'Submitted'; ?></td>
                        <td><?= $schedule['2ND_REQUIREMENT'] == 0 ? 'Not Submitted' : 'Submitted'; ?></td>
                        <td><?= $schedule['STATUS'] == 1 ? 'Confirmed' : 'Pending'; ?></td>
                        <td>
                          <button class="btn btn-sm btn-warning edit-btn" 
                                  data-id="<?= $schedule['SCHEDULE_ID']; ?>" 
                                  data-1st="<?= $schedule['1ST_REQUIREMENT']; ?>" 
                                  data-2nd="<?= $schedule['2ND_REQUIREMENT']; ?>" 
                                   
                                  >Edit</button>


                          <form action="includes/action.php" method="POST" class="d-inline">
                            <input type="hidden" name="schedule_id" value="<?= $schedule['SCHEDULE_ID']; ?>">
                            <button 
                            type="button" 
                            class="btn btn-sm btn-success approve-btn " 
                            data-id="<?= $schedule['SCHEDULE_ID']; ?>" 
                            data-1st="<?= $schedule['1ST_REQUIREMENT']; ?>" 
                            data-2nd="<?= $schedule['2ND_REQUIREMENT']; ?>" 
                            data-event="<?= $schedule['EVENT_DATE']; ?>" 
                            data-toggle="modal" 
                            <?= $schedule['STATUS'] == 1 ? 'disabled' : ''; ?>>
                            Approve
                          </button>
                          </form>
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
    </section>
  </div>
<?php 
include('addSched.php');

?>
<!-- Approve Schedule Modal -->
<div class="modal fade" id="approveScheduleModal" tabindex="-1" aria-labelledby="approveScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Approve Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="approveScheduleForm" method="post" action="">
        <div class="modal-body">
          <input type="hidden" name="schedule_id" id="approveScheduleId">
          <div class="form-group">
            <label for="approveEventDateLabel">Event Date</label>
            <input type="date" name="event_date" id="approveEventDate" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Approve Schedule</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>



  // document.addEventListener('DOMContentLoaded', function () {
  //   document.querySelectorAll('.approve-btn').forEach(function (button) {
  //     button.addEventListener('click', function () {
  //       const scheduleId = button.getAttribute('data-id');
  //       const firstRequirement = button.getAttribute('data-1st');
  //       const secondRequirement = button.getAttribute('data-2nd');

  //       // Check if both requirements are submitted
  //       if (firstRequirement === '0' || secondRequirement === '0') {
  //         alert('Both the 1st and 2nd Requirements must be submitted before approval.');
  //         return;
  //       }

  //       const eventDate = button.getAttribute('data-event');

  //       // Populate modal fields if requirements are met
  //       document.getElementById('approveScheduleId').value = scheduleId;
  //       document.getElementById('approveEventDate').value = eventDate || ''; // Pre-fill the event date if available
  //     });
  //   });
  // });
</script>

  <script>

    $(document).ready(function(){
      $('#sched-info-table').dataTable({


      });
      $('#client-table').dataTable({

      });

    });
    $(document).on('click','.approve-btn',function(e){
      e.preventDefault();

      let ID = $(this).attr('data-id');
      $('#approveScheduleId').val(ID);

      $('#approveEventDate').val("");


        const scheduleId = $(this).attr('data-id');
        const firstRequirement = $(this).attr('data-1st');
        const secondRequirement = $(this).attr('data-2nd');
        
        // Check if both requirements are submitted
        if (firstRequirement === '0' || secondRequirement === '0') {
          alert('Both the 1st and 2nd Requirements must be submitted before approval.');
          return;
        }

        
      $url = baseUrl + "action=getSchedDate";

        AjaxPost(
            $url,
            'POST',
            {schedule_id : ID},
            function(){
                logs(true);
            },
    
            function(response){
               

                if(response.code != 0){
                    msg(response.message,'error');
                    return;
                }
                $('#approveEventDate').val(response.data);

                $('#approveScheduleModal').modal('show');

            },
    
            function(){
                logs(false);
            }
        );



      


    });

  // document.addEventListener('DOMContentLoaded', function () {
  //     document.querySelectorAll('.approve-btn').forEach(function (button) {
  //         button.addEventListener('click', function () {
  //             const scheduleId = button.getAttribute('data-id');
  //             document.getElementById('scheduleId').value = scheduleId;
  //         });
  //     });
  // });
  </script>
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
        <form id="editRequirementsForm" method="post">
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
  
  <script src="../livestock2/administrator2/Schedule/sched.js"></script>
  <script>

$(document).on('click','.edit-btn',function(e){
  e.preventDefault();

  const scheduleId = this.getAttribute('data-id');
  const firstRequirement = this.getAttribute('data-1st');
  const secondRequirement = this.getAttribute('data-2nd');

  document.getElementById('scheduleId').value = scheduleId;
  document.getElementById('firstRequirement').value = firstRequirement;
  document.getElementById('secondRequirement').value = secondRequirement;

  $('#editRequirementsModal').modal('show');


});


  // document.addEventListener('DOMContentLoaded', function () {
  //     document.querySelectorAll('.edit-btn').forEach(function (button) {
  //         button.addEventListener('click', function () {
             
  //         });
  //     });
  // });
  </script>

  <script>
  function searchClient() {
      let searchValue = document.getElementById('clientSearch').value;
      if (searchValue.length > 0) {
          let xhr = new XMLHttpRequest();
          xhr.open("POST", "Administrator/Addcattle/search_client.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function () {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  document.getElementById("searchResults").innerHTML = xhr.responseText;
                  document.getElementById("searchResults").style.display = "block";
              }
          };
          xhr.send("search=" + encodeURIComponent(searchValue));
      } else {
          document.getElementById("searchResults").style.display = "none";
      }
  }

  function selectClient(clientId, clientName) {
      document.getElementById('clientSelect').value = clientId;
      document.getElementById('clientSearch').value = clientName;
      document.getElementById("searchResults").style.display = "none";
  }

  document.addEventListener("click", function(e) {
      if (!e.target.closest(".search-container")) {
          document.getElementById("searchResults").style.display = "none";
      }
  });

 // ini_set('display_errors', 1);
//error_reporting(E_ALL);
  </script>

  <style>
  .search-container {
      position: relative;
      width: 100%;
  }

  #clientSearch {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      box-sizing: border-box;
      border-radius: 4px;
  }

  .autocomplete-suggestions {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: #fff;
      border: 1px solid #ccc;
      border-top: none;
      max-height: 200px;
      overflow-y: auto;
      z-index: 1000;
  }

  .autocomplete-suggestions div {
      padding: 8px;
      cursor: pointer;
  }

  .autocomplete-suggestions div:hover {
      background-color: #f0f0f0;
  }
  </style>