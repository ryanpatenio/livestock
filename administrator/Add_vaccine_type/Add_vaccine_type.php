<style>
    
    #preview {
        max-width: 200px; 
        max-height: 200px; 
        margin-top: 10px;
        border: 2px solid #ccc;
        border-radius: 50%;
        overflow: hidden; 
    }

    #preview img {
        width: 100%;
        height: auto;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1 class="m-0">Add New Vaccine</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Staff</li>
                        <li class="breadcrumb-item"></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid p-2">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md">
                    <form action="includes/action.php" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                              <div id="preview">
                                  <img src="#" alt="Preview" id="imagePreview" style="display: none;">
                              </div>

                            <div class="form-group">
                                <label for="InputVACCINE_NAME">Vaccine Name</label>
                                <input type="text" name="VACCINE_NAME" class="form-control" id="InputVACCINE_NAME" placeholder="Enter Vaccine Name">
                            </div>
                        
                        </div>
                            <button type="submit" name="btn-addvaccinetype" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- right col -->


</div>