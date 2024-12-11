<!-- Add Cattle Modal -->
<div class="modal fade" id="AddCattleModal" tabindex="-1" aria-labelledby="AddCattleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="AddCattleModalLabel">Add New Animal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="includes/action.php" method="POST" enctype="multipart/form-data" id="addCattleForm">
        <div class="modal-body">
          <div class="row">
            <!-- Client Search Input -->
            <div class="form-group mb-3 col-12">
              <label for="clientSearch">Client</label>
              <input type="text" id="clientSearch" placeholder="Search Client" class="form-control" onkeyup="searchClient()" autocomplete="off">
              <input type="hidden" name="CLIENT_ID" id="clientSelect">
              <div id="searchResults" class="autocomplete-suggestions" style="display: none;"></div>
            </div>
          </div>

          <div class="row">
            <!-- Birthdate Input -->
            <div class="col-md-6 mb-3">
              <label for="InputBIRTHDATE">Birthdate</label>
              <input type="date" name="BIRTHDATE" class="form-control" id="InputBIRTHDATE" required>
            </div>

            <!-- Animal Type Input -->
            <div class="col-md-6 mb-3">
              <label for="InputANIMALTYPE">Animal Type</label>
              <input type="text" name="ANIMALTYPE" class="form-control" id="InputANIMALTYPE" required>
            </div>

            <!-- Gender Select -->
            <div class="col-md-6 mb-3">
              <label for="InputANIMAL_SEX">Gender</label>
              <select name="ANIMAL_SEX" class="form-control" id="InputANIMAL_SEX" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>

            <!-- Status Select -->
            <div class="col-md-6 mb-3">
              <label for="STATUS">Status</label>
              <select name="STATUS" class="form-control" required>
                <option value="1">Alive</option>
                <option value="2">Dead</option>
              </select>
            </div>

            <!-- Vaccine Card Select -->
            <div class="col-md-6 mb-3">
              <label for="VACCINE_CARD_ID">Vaccine Card ID</label>
              <select name="VACCINE_CARD_ID" class="form-control" required>
                <option value="1">Not Vaccinated</option>
                <option value="2">Vaccinated</option>
              </select>
            </div>

            <!-- Image Upload -->
            <div class="col-md-6 mb-3">
              <label for="InputIMAGE">Upload Image</label>
              <input type="file" name="IMAGE_PATH" class="form-control-file" id="InputIMAGE" required>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="submit" name="btn-Cattle" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript for Client Search (AJAX) -->
<script>
function searchClient() {
  let searchValue = document.getElementById('clientSearch').value;
  if (searchValue.length > 0) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "administrator/Addcattle/search_client.php", true);
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
</script>

<!-- Styles for Search Suggestions -->
<style>
.search-container {
  position: relative;
  width: 100%;
}

#clientSearch {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
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
