<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold text-primary">Binalbagan Dispersal Office Monitoring Report</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item text-dark">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid p-3">
      <div class="row">
        <div class="col-md">
          <div class="card shadow-lg rounded">
            <div class="card-header bg-primary text-white border-bottom d-flex align-items-center">
              <h3 class="font-weight-semibold mb-0">Dispersal and Schedule Summary</h3>
            </div>
            <form action="save_report.php" method="POST" id="reportForm">
              <table class="table table-bordered table-striped table-responsive">
                <thead class="thead-light">
                  <tr>
                    <th>Category</th>
                    <th>Total Count</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Total Dispersals</td>
                    <td>
                      <?php 
                        require("connection/connection.php");
                        $query = "SELECT COUNT(*) as dispersal_count FROM dispersal";
                        $result = mysqli_query($con, $query);
                        echo ($row = mysqli_fetch_assoc($result)) ? $row['dispersal_count'] : 0;
                        mysqli_close($con);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Confirmed Schedules</td>
                    <td>
                      <?php 
                        require("connection/connection.php");
                        $query = "SELECT COUNT(*) as confirmed_count FROM schedule WHERE STATUS = 1";
                        $result = mysqli_query($con, $query);
                        echo ($row = mysqli_fetch_assoc($result)) ? $row['confirmed_count'] : 0;
                        mysqli_close($con);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Pending Schedules</td>
                    <td>
                      <?php 
                        require("connection/connection.php");
                        $query = "SELECT COUNT(*) as pending_count FROM schedule WHERE STATUS = 0";
                        $result = mysqli_query($con, $query);
                        echo ($row = mysqli_fetch_assoc($result)) ? $row['pending_count'] : 0;
                        mysqli_close($con);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Unpaid Dispersals</td>
                    <td>
                      <?php 
                        require("connection/connection.php");
                        $query = "SELECT COUNT(*) as unpaid_count FROM dispersal WHERE 1ST_PAYMENT_ID = 0 AND 2ND_PAYMENT_ID = 0";
                        $result = mysqli_query($con, $query);
                        echo ($row = mysqli_fetch_assoc($result)) ? $row['unpaid_count'] : 0;
                        mysqli_close($con);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Partially Paid Dispersals</td>
                    <td>
                      <?php 
                        require("connection/connection.php");
                        $query = "SELECT COUNT(*) as partial_count FROM dispersal WHERE STATUS = 'Partially Paid'";
                        $result = mysqli_query($con, $query);
                        echo ($row = mysqli_fetch_assoc($result)) ? $row['partial_count'] : 0;
                        mysqli_close($con);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Fully Paid Dispersals</td>
                    <td>
                      <?php 
                        require("connection/connection.php");
                        $query = "SELECT COUNT(*) as full_count FROM dispersal WHERE STATUS = 'Completed'";
                        $result = mysqli_query($con, $query);
                        echo ($row = mysqli_fetch_assoc($result)) ? $row['full_count'] : 0;
                        mysqli_close($con);
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Total Clients</td>
                    <td>
                      <?php 
                        require("connection/connection.php");
                        $query = "SELECT COUNT(*) as client_count FROM client";
                        $result = mysqli_query($con, $query);
                        echo ($row = mysqli_fetch_assoc($result)) ? $row['client_count'] : 0;
                        mysqli_close($con);
                      ?>
                    </td>
                  </tr>
                </tbody>
              </table>

              <div class="text-center mt-4">
                <button type="button" class="btn btn-primary btn-lg" onclick="printReport()">Print Report</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  function printReport() {
    window.print();
  }
</script>


<script>
  function calculateTotal() {
    const fields = document.querySelectorAll('.client-served');
    let total = 0;
    fields.forEach(field => {
      total += parseInt(field.value) || 0;
    });
    document.getElementById('totalClients').textContent = total;
  }

  function printReport() {
    window.print();
  }

  // Initialize tooltip for inputs
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<style>
  .content-wrapper {
    background-color: #f8f9fa;
  }

  .card {
    background-color: #ffffff;
    border-radius: 8px;
  }

  .card-header {
    background-color: #007bff;
    color: white;
  }

  .table-bordered {
    border-color: #dee2e6;
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
  }

  th, td {
    padding: 10px;
  }

  .thead-light th {
    background-color: #e9ecef;
  }

  .form-control-sm {
    max-width: 80px;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }

  .font-weight-bold {
    font-weight: bold;
  }

  .text-center {
    text-align: center;
  }

  .text-right {
    text-align: right;
  }
</style>
