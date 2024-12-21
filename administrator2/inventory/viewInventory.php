<?php

require("connection/connection.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validate if the correct query parameter 'vaccID' exists and is an integer
if (!isset($_GET['vaccID']) || !filter_var($_GET['vaccID'], FILTER_VALIDATE_INT)) {
    // Redirect to inventory if 'vaccID' is missing or invalid
    echo "<script>location.href = 'index.php?page=inventory';</script>";
    exit; // Ensure no further code is executed
}

$vaccID = $_GET['vaccID'];

// Check if the vaccine ID exists in the database
$validationQuery = "SELECT 1 FROM vaccine_type WHERE VACCINE_TYPE_ID = ?";
$validationStmt = mysqli_prepare($con, $validationQuery);

if ($validationStmt) {
    mysqli_stmt_bind_param($validationStmt, 'i', $vaccID);
    mysqli_stmt_execute($validationStmt);
    $validationResult = mysqli_stmt_get_result($validationStmt);

    if (mysqli_num_rows($validationResult) === 0) {
        // Redirect if the vaccine ID is not found
        mysqli_stmt_close($validationStmt);
        echo "<script>location.href = 'index.php?page=inventory';</script>";
        exit; // Ensure no further code is executed
    }

    mysqli_stmt_close($validationStmt);
} else {
    // Handle errors in query preparation for validation
    die("Failed to prepare validation statement: " . mysqli_error($con));
}

// Proceed to fetch the vaccine data
$query = "SELECT 
    vt.VACCINE_TYPE_ID,
    vt.VACCINE_NAME,
    vt.DESCRIPTION,
    vh.QTY_ADD AS received,
    vh.DATE_CREATED AS log_date
FROM 
    vaccine_type vt
JOIN 
    vaccine_history vh ON vt.VACCINE_TYPE_ID = vh.VACCINE_TYPE_ID
WHERE 
    vt.VACCINE_TYPE_ID = ?
ORDER BY 
    vh.DATE_CREATED ASC;";

$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    // Bind the parameter to the query
    mysqli_stmt_bind_param($stmt, 'i', $vaccID);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Fetch the result set
    $result = mysqli_stmt_get_result($stmt);

    // Fetch all rows into an associative array
    $vaccine_received_logs = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Handle errors in query preparation
    die("Failed to prepare statement: " . mysqli_error($con));
}

//query for displaying usage Data
$query2 = "SELECT 
    vt.VACCINE_TYPE_ID,
    vt.VACCINE_NAME,
    vt.DESCRIPTION,
    vu.use_quantity AS usaged,
    vu.date_used as use_date
FROM 
    vaccine_type vt
JOIN 
    vaccine_usage vu ON vt.VACCINE_TYPE_ID = vu.VACCINE_TYPE_ID
WHERE 
    vt.VACCINE_TYPE_ID = ?
ORDER BY 
    vu.date_used ASC;";

$stmt2 = mysqli_prepare($con, $query2);

if ($stmt2) {
    // Bind the parameter to the query
    mysqli_stmt_bind_param($stmt2, 'i', $vaccID);

    // Execute the query
    mysqli_stmt_execute($stmt2);

    // Fetch the result set
    $result2 = mysqli_stmt_get_result($stmt2);

    // Fetch all rows into an associative array
    $vaccine_usaged_logs = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    // Close the statement
    mysqli_stmt_close($stmt2);
} else {
    // Handle errors in query preparation
    die("Failed to prepare statement: " . mysqli_error($con));
}

//inventory stocks remaining
$query3 = "SELECT 

    SUM(v.QUANTITY) AS available_quantity, vt.VACCINE_NAME
   
FROM 
    vaccine v
JOIN 
    vaccine_type vt ON v.VACCINE_TYPE_ID = vt.VACCINE_TYPE_ID
WHERE 
    v.EXPIRY_DATE > NOW() AND vt.VACCINE_TYPE_ID = ?
GROUP BY 
    vt.VACCINE_NAME, vt.DESCRIPTION, v.VACCINE_TYPE_ID

";

$stmt3 = mysqli_prepare($con, $query3);

if ($stmt3) {
    // Bind the parameter to the query
    mysqli_stmt_bind_param($stmt3, 'i', $vaccID);

    // Execute the query
    mysqli_stmt_execute($stmt3);

    // Fetch the result set
    $result3 = mysqli_stmt_get_result($stmt3);

    // Fetch all rows into an associative array
    $countRes = mysqli_fetch_all($result3, MYSQLI_ASSOC);

    // Ensure that you are accessing the right element from the result set
    if (count($countRes) > 0) {
        $stocksCount = $countRes[0]['available_quantity'];
        $vaccineName = $countRes[0]['VACCINE_NAME'];
    } else {
        $stocksCount = 0; // Set a default value if no rows are returned
    }

    // Close the statement
    mysqli_stmt_close($stmt3);
} else {
    // Handle errors in query preparation
    die("Failed to prepare statement: " . mysqli_error($con));
}

$query4 = "SELECT 
    SUM(vu.use_quantity) AS 'count_usage'
    
FROM 
    vaccine_type vt
JOIN 
    vaccine_usage vu ON vt.VACCINE_TYPE_ID = vu.VACCINE_TYPE_ID
WHERE 
    vt.VACCINE_TYPE_ID = ?
ORDER BY 
    vu.date_used ASC;";


$stmt4 = mysqli_prepare($con, $query4);

if ($stmt4) {
    // Bind the parameter to the query
    mysqli_stmt_bind_param($stmt4, 'i', $vaccID);

    // Execute the query
    mysqli_stmt_execute($stmt4);

    // Fetch the result set
    $result4 = mysqli_stmt_get_result($stmt4);

    // Fetch all rows into an associative array
    $countRes = mysqli_fetch_all($result4, MYSQLI_ASSOC);

    // Ensure that you are accessing the right element from the result set
    if (count($countRes) > 0) {
        $stocksUsageCount = $countRes[0]['count_usage'];
       
    } else {
        $stocksCount = 0; // Set a default value if no rows are returned
    }

    // Close the statement
    mysqli_stmt_close($stmt4);
} else {
    // Handle errors in query preparation
    die("Failed to prepare statement: " . mysqli_error($con));
}

$query5 = "SELECT v.VACCINE_ID,vt.VACCINE_TYPE_ID, v.EXPIRY_DATE, vt.VACCINE_NAME, vt.`DESCRIPTION`, v.QUANTITY AS 'remaining_qty',v.DATE_CREATED AS 'date_received' FROM vaccine v JOIN vaccine_type vt ON v.VACCINE_TYPE_ID = vt.VACCINE_TYPE_ID WHERE v.QUANTITY != 0 AND v.EXPIRY_DATE > NOW() AND v.VACCINE_TYPE_ID = ?";
$stmt5 = mysqli_prepare($con, $query5);

if ($stmt5) {
    // Bind the parameter to the query
    mysqli_stmt_bind_param($stmt5, 'i', $vaccID);

    // Execute the query
    mysqli_stmt_execute($stmt5);

    // Fetch the result set
    $result5 = mysqli_stmt_get_result($stmt5);

    // Fetch all rows into an associative array
    $stocksRemaining = mysqli_fetch_all($result5, MYSQLI_ASSOC);

   
    // Close the statement
    mysqli_stmt_close($stmt5);
} else {
    // Handle errors in query preparation
    die("Failed to prepare statement: " . mysqli_error($con));
}

?>


<div class="content-wrapper">
    <div class="content-header">
        <h1 class="m-0">Vaccine Details</h1>
    </div>

    <section class="content">
        
    <div class="row">
    <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                        <div class="row">
                            <div class="col-6">
                            <h4><strong style="color:rgb(2, 247, 55);"><?= $vaccineName ? $vaccineName : ''  ?></strong> Stocks on hand <strong style="color:rgb(2, 247, 55);">(<?php echo $stocksCount ? $stocksCount : '' ?>)</strong></h4>
                            </div> 
                            <div class="col-6">
                                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="">Print</button> 
                            </div>                     
                        </div>
                            
                        </div>
                        <div class="card-body">
                            <div id="table-responsive">
                                <table class="table datatable table-light stocks-on-hand-table" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Vaccine NAME</th>
                                            <th>Description</th>                                            
                                            <th>Remaining Quantity</th>
                                            <th>EXPIRY DATE</th>
                                            <th>DATE_RECEIVED</th>
                                            <!-- <th>Action</th> -->
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($stocksRemaining as $stock) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?=$stock['VACCINE_NAME'] ?></td>
                                                <td><?=$stock['DESCRIPTION'] ?></td>
                                                <td><?=$stock['remaining_qty'] ?></td>
                                                <td><?= date('F j, Y', strtotime($stock['EXPIRY_DATE'])) ?></td>
                                                <td><?= date('F j, Y', strtotime($stock['date_received'])) ?></td>
                                                <!-- <td>
                                                    <button type="button" class="btn btn-sm btn-warning fa fa-edit" data-name="<?=$stock['VACCINE_NAME'] ?>" data-qty="<?=$stock['remaining_qty'] ?>" id="edit-btn-qty"  data-id="<?= $stock['VACCINE_ID'] ?>">  Edit</button>
                                                </td> -->
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

            <div class="row mt-5">

                <!-- Vaccine Inventory List -->
                <div class="col-md-12 ">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                        <div class="row">
                            <div class="col-6">
                            <h4>Vaccine Received</h4>
                            </div> 
                            <div class="col-6">
                                    
                            </div>                     
                        </div>
                            
                        </div>
                        <div class="card-body">
                            <div id="table-responsive">
                                <table class="table datatable table-light vaccine-receive-table" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Vaccine NAME</th>
                                            <th>Description</th>                                            
                                            <th>QTY RECEIVED</th>
                                            <th>DATE_RECEIVED</th>
                                            
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                        foreach ($vaccine_received_logs as $vaccLogs) { ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?=$vaccLogs['VACCINE_NAME'] ?></td>
                                            <td><?=$vaccLogs['DESCRIPTION'] ?></td>
                                            <td><?=$vaccLogs['received'] ?></td>
                                            <td><?= $vaccLogs['log_date']?></td>
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

            <div class="row">

            <!-- Vaccine Inventory List -->
            <div class="col-md-12 mt-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                        <div class="row">
                            <div class="col-6">
                              <h4>Vaccine Usage (<strong style="color:rgb(2, 247, 55);"><?= $stocksUsageCount ? $stocksUsageCount : '' ?></strong>)</h4>
                            </div> 
                            <div class="col-6">
                                    
                            </div>                     
                        </div>
                            
                        </div>
                        <div class="card-body">
                            <div id="table-responsive">
                                <table class="table datatable table-light vaccine-usage-table" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">

                                        <tr>
                                            <th>No.</th>
                                            <th>Vaccine Type</th>
                                            <th>Description</th>
                                            <th>QTY USED</th>
                                            <th>DATE_USED</th>
   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <?php
                                    $i = 1;
                                    
                                    foreach ($vaccine_usaged_logs as $usageLog) { ?>

                                    <tr>
                                        <td><?=$i; ?></td>
                                        <td><?= $usageLog['VACCINE_NAME'] ?></td>
                                        <td><?=$usageLog['DESCRIPTION'] ?></td>
                                        <td><?=$usageLog['usaged'] ?></td>
                                        <td><?=$usageLog['use_date'] ?></td>
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

<?php include('editModal.php'); ?>

<script>
    $(document).ready(function(){
        $('#main').css('filter', 'none');
        $('#loader').hide();

        $('.stocks-on-hand-table').dataTable({

        });

        $('.vaccine-receive-table').dataTable({

        });

        $('.vaccine-usage-table').dataTable({

        });
        
        const editModal = $('#editModal');

        $(document).on('click','#edit-btn-qty',function(e){
            e.preventDefault();

            //clear
            $('#vaccine_id').val("");
            $('#quantity').val("")
            $('#vaccine-name').val("");

            let vaccine_ID = $(this).attr('data-id');
            let qty = $(this).attr('data-qty');
            let vaccine_name = $(this).attr('data-name');

           
            $('#vaccine_id').val(vaccine_ID);
            $('#quantity').val(qty)
            $('#vaccine-name').val(vaccine_name);

             $('#editModal').modal('show');

        });

        $('#quantityForm').submit(function(e){
            e.preventDefault();

            let Data = $(this).serialize();
            $url = baseUrl + "action=updateQty";
    
            swalMessage('custom','Are you sure you want to update this Vaccine?',function(){
                AjaxPost(
                    $url,
                    'POST',
                    Data,
                    function(){
                        logs(true);
                    },
            
                    function(response){

                        if(response.code != 0){
                            msg(response.message,'error');
                            return;
                        }
            
                        message(response.message,'success');
                        formModalClose(editModal,$('#quantityForm'));
                    },
            
                    function(){
                        logs(false);
                    }
                );

            }); 
        });

    });


</script>

