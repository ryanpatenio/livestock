<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require("connection/connection.php"); // Ensure this file has your DB connection settings


// Fetch all clients
$clientQuery = "SELECT CLIENT_ID, CONCAT(FNAME, ' ', LNAME) AS full_name FROM client ORDER BY FNAME ASC";
$clientResult = mysqli_query($con, $clientQuery);
$clients = mysqli_fetch_all($clientResult, MYSQLI_ASSOC);


?>


<style>
  @media print {
    #print-btn {
      display: none;
    }
  }
</style>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-1 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-users"></i> Dispersal List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right bg-light p-2 rounded">
            <li class="breadcrumb-item text-dark"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Staff</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Section -->
  <section class="content">
    <div class="container-fluid p-3">
      <div class="row">
        <div class="col-12">
          <div class="card shadow-lg rounded">
            <!-- Card Header -->
            <div class="card-header d-flex align-items-center bg-primary text-white">
              <h5 class="mb-0"><i class="fas fa-list"></i> Dispersal List</h5>
              <a href="#" class="btn btn-success ml-auto" onclick="printReport()" id="print-btn">
                <i class="fas fa-print"></i> Print
              </a>
            </div>

            <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="dispersalTBL" class="table table-striped table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Client Name</th>
                      <th>Parent Animal Type</th>
                      <th>First Payment</th>
                      <th>Second Payment</th>
                      <th>Date Created</th>
                      <th>Status</th>
                  
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     require("connection/connection.php");
                      $query = "SELECT d.DISPERSAL_ID,c.CLIENT_ID,
                            CONCAT(c.FNAME, ' ', c.LNAME) AS name,
                            cat.category_name AS animal_parent,
                            d.1ST_PAYMENT_ID,
                            d.2ND_PAYMENT_ID,
                            d.`STATUS`,
                            d.date_created
                        FROM 
                            dispersal d
                        LEFT JOIN 
                            client c ON d.CLIENT_ID = c.CLIENT_ID
                        LEFT JOIN 
                            animal a ON d.PARENT_ANIMAL_ID = a.ANIMAL_ID
                        LEFT JOIN
                            category cat ON a.category_id = cat.category_id
                        ORDER BY d.date_created DESC
                        "; 
                      $result = mysqli_query($con, $query);
                      $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                     
                    ?>
                    
                        <?php
                        $i = 1;

                        foreach ($rows as $dis) {
                          $isFirstPaymentPaid = !empty($dis['1ST_PAYMENT_ID']);
                          $isSecondPaymentPaid = !empty($dis['2ND_PAYMENT_ID']);
                          $status = $isFirstPaymentPaid && $isSecondPaymentPaid ? "Completed" : ($isFirstPaymentPaid ? "Partially Paid" : "Unpaid");
                          
                          ?>
                          <tr>
                            <td><?=$i; ?></td>
                            <td><?=$dis['name'] ?></td>
                            <td><?=$dis['animal_parent'] ?></td>
                            <td>
                            <?php 
                                echo $dis['1ST_PAYMENT_ID'] == '0' 
                                    ? "<button class='btn btn-danger btn-sm payment-button-1st' 
                                                id='edit-btn'
                                                data-client-id = '{$dis['CLIENT_ID']}'
                                                data-dispersal-id1='{$dis['DISPERSAL_ID']}' 
                                                data-payment-type='1ST_PAYMENT_ID' 
                                                data-client-name1='{$dis['name']}'>
                                            Unpaid
                                        </button>" 
                                    : "<span class='badge badge-success'>Paid</span>";
                               ?>
                            </td>
                            <td>
                        <?php
                            echo $dis['2ND_PAYMENT_ID'] == '0' 
                                    ? "<button class='btn btn-danger btn-sm payment-button-2nd' 
                                                id='edit-btn'
                                                data-client-id2 = '{$dis['CLIENT_ID']}'
                                                data-dispersal-id2='{$dis['DISPERSAL_ID']}' 
                                                data-payment-type='1ST_PAYMENT_ID' 
                                                data-client-name2='{$dis['name']}'>
                                            Unpaid
                                        </button>" 
                                    : "<span class='badge badge-success'>Paid</span>";
                               ?>
                            </td>
                            <td><?=$dis['date_created'] ?></td>
                            <td class="<?= $status === 'Completed' ? 'text-success font-weight-bold' : ($status === 'Partially Paid' ? 'text-warning font-weight-bold' : 'text-danger font-weight-bold'); ?>"><?= $status; ?></td>
                        </tr>
                      <?php $i++;  }
                        
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

  <?php

include('modal/updateFirstPayment.php');
include('modal/updateSecondPayment.php');
  ?>
 
<script src="../livestock2/administrator/dashboard/dispersal/dispersal.js"></script>
<script>
$(document).ready(function(){
$('#dispersalTBL').dataTable({

});

});

  function printReport() {
    window.print();
  }
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

