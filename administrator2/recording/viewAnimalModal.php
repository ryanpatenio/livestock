<!-- Edit Vaccination Status Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="editAnimalVaccineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnimalVaccineModalLabel">Animal Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="">
                <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <div class="card-body">
                                <h6 class="mb-3">
                                    <strong>Client:</strong> 
                                    <span id="" class="text-primary"><?= $selectedClient ?: "Select a client to view animal details"; ?></span>
                                </h6>
                                <h6 class="mb-3">
                                    <strong>Vaccine Card ID:</strong> 
                                    <span id="vaccine-id" class="text-primary"></span>
                                </h6>
                                <h6 class="mb-3">
                                    <strong>ANIMAL TYPE:</strong> 
                                    <span id="animal-type" class="text-primary"></span>
                                </h6>
                                <table class="table table-bordered table-striped" id="tbl-data">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Vaccine Name</th>
                                            <th>Qty Used</th>
                                            <th>Date Vaccinated</th>                                         
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <!-- <div class="col">

                    </div> -->
                </div>


                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>