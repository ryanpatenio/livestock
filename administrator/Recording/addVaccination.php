<!-- Edit Vaccination Status Modal -->
<div class="modal fade" id="addVaccinationModal" tabindex="-1" role="dialog" aria-labelledby="editAnimalVaccineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnimalVaccineModalLabel">Edit Vaccination Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="editAnimalVaccineForm">
                <div class="modal-body">
                    <input type="hidden" name="animal_id" id="vaccineAnimalIdInput">

                    <div class="form-group">
                        <label for="vaccineSelect">Vaccination Status</label>
                        <input type="text" class="form-control" id="vaccination_status" readonly>
                    </div>

                    <div class="form-group" id="vaccineScheduleGroup">
                        <label for="vaccineTypeSelect">Schedule </label>
                        <select class="form-control" id="select-schedule" name="schedule_id" required>
                            <option value="">Select</option>
                            <?php
                            foreach ($schedules as $sched) { ?>
                                 <option value="<?=$sched['SCHEDULE_ID'] ?>"><?= $sched['VACCINE_NAME'].' | '.$sched['EVENT_DATE'] ?></option>
                        <?php    }
                            
                            ?>
                          
                        </select>
                    </div>
                    <div class="form-group" id="">
                        <label for="vaccine Name">Vaccine Name</label>
                        <input type="text" class="form-control" id="vaccine-name" readonly>
                    </div>
                   
                    <div class="form-group" id="">
                        <label for="vaccine Name">Vaccine DESCRIPTION</label>
                        <input type="text" class="form-control" id="vaccine-description" readonly>
                    </div>
                    <div class="form-group" id="">
                        <label for="vaccine Name">QTY to Used</label>
                        <input type="text" class="form-control" id="vaccine-qty-request" readonly>
                    </div>

                    <div class="form-group" id="">
                        <label for="vaccine Name">Vaccine CARD ID</label>
                        <input type="text" name="vaccine_card_id" class="form-control" id="vaccine-card-id" readonly>
                    </div>
                    

                    <div class="form-group" id="vaccineDateGroup" >
                        <label for="DATE">Date</label>
                        <input type="date" class="form-control" id="DATE" name="DATE" readonly>
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