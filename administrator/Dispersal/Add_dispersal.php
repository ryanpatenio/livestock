<!-- Modal -->
<div class="modal fade" id="Add_dispersalModal" tabindex="-1" role="dialog" aria-labelledby="Add_dispersalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="Add_dispersalModalLabel">Create New Dispersal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form with search functionality -->
                <form action="includes/action.php" method="POST" enctype="multipart/form-data">
                    <!-- Client Search Input -->
                    <div class="form-group">
                        <label for="clientSearch">Client</label>
                        <div class="search-container">
                            <input type="text" id="clientSearch" placeholder="Search Client" class="form-control" onkeyup="searchClient()" autocomplete="off">
                            <input type="hidden" name="CLIENT_ID" id="clientSelect">
                            <div id="searchResults" class="autocomplete-suggestions" style="display: none;"></div>
                        </div>
                    </div>

                    <!-- 1st Payment ID -->
                    <div class="form-group">
                        <label for="Input1ST_PAYMENT_ID">1st Payment ID</label>
                        <input type="number" name="1ST_PAYMENT_ID" class="form-control" id="Input1ST_PAYMENT_ID" placeholder="Input 1st Payment ID">
                    </div>

                    <!-- 2nd Payment ID -->
                    <div class="form-group">
                        <label for="Input2ND_PAYAMENT_ID">2nd Payment ID</label>
                        <input type="number" name="2ND_PAYAMENT_ID" class="form-control" id="Input2ND_PAYAMENT_ID" placeholder="Enter 2nd Payment ID">
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="InputSTATUS">Status</label>
                        <input type="text" name="STATUS" class="form-control" id="InputSTATUS" placeholder="Enter Status">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="btn-dispersal" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX-based client search -->
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

<!-- Styles for search functionality -->
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
