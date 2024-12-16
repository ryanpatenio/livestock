<!-- Modal -->
<div class="modal fade" id="Add_dispersalModal" tabindex="-1" role="dialog" aria-labelledby="Add_dispersalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="Add_dispersalModalLabel">Create New Dispersal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" method="POST" enctype="multipart/form-data">
                    <!-- Client Search -->
                    <div class="form-group">
                        <label for="clientSearch">Paid By : Client Name</label>
                        <div class="search-container">
                            <input 
                                type="text" 
                                id="clientSearch" 
                                class="form-control" 
                                placeholder="Search Client" 
                                onkeyup="searchClient()" 
                                autocomplete="off" 
                                required
                            >
                            <input type="hidden" name="CLIENT_ID" id="clientSelect">
                            <div id="searchResults" class="autocomplete-suggestions"></div>
                        </div>
                    </div>

                    <!-- Paid To -->
                    <div class="form-group" id="paidToGroup">
                        <label for="paidTo">Paid To: Client Name</label>
                        <select name="paidTo" id="paidTo" class="form-control">
                            <option value="ryan">Ryan Wong</option>
                        </select>
                    </div>

                    <!-- Client Type -->
                    <div class="form-group">
                        <label for="existingClient">Client Type</label>
                        <select name="existingClient" id="existingClient" class="form-control">
                            <option value="existing">Existing Client</option>
                            <option value="notexisting">Not Existing Client</option>
                        </select>
                    </div>

                    <!-- Additional Client Info (Hidden by Default) -->
                    <div class="form-container" id="clientForm" style="display: none;">
                        <label>First Name:</label>
                        <input type="text" name="firstName" class="form-control" placeholder="Enter First Name">
                        
                        <label>Last Name:</label>
                        <input type="text" name="lastName" class="form-control" placeholder="Enter Last Name">
                        
                        <label>Middle Initial:</label>
                        <input type="text" name="middleInitial" class="form-control" placeholder="Enter Middle Initial">
                        
                        <label>Association:</label>
                        <input type="text" name="association" class="form-control" placeholder="Enter Association">
                        
                        <label>Contact:</label>
                        <input type="text" name="contact" class="form-control" placeholder="Enter Contact">
                        
                        <label>Address:</label>
                        <input type="text" name="address" class="form-control" placeholder="Enter Address">
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" name="btn-dispersal" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    // Toggle Client Form and Paid To Dropdown
    document.getElementById('existingClient').addEventListener('change', function () {
        const clientForm = document.getElementById('clientForm');
        const paidToGroup = document.getElementById('paidToGroup');
        
        if (this.value === 'notexisting') {
            clientForm.style.display = 'block';
            paidToGroup.style.display = 'none';
        } else {
            clientForm.style.display = 'none';
            paidToGroup.style.display = 'block';
        }
    });

    // AJAX-based Client Search
    function searchClient() {
        const searchValue = document.getElementById('clientSearch').value.trim();
        const searchResults = document.getElementById('searchResults');

        if (searchValue) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "administrator/Addcattle/search_client.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    searchResults.innerHTML = xhr.responseText;
                    searchResults.style.display = "block";
                }
            };
            xhr.send("search=" + encodeURIComponent(searchValue));
        } else {
            searchResults.style.display = "none";
        }
    }

    // Select Client from Suggestions
    function selectClient(clientId, clientName) {
        document.getElementById('clientSelect').value = clientId;
        document.getElementById('clientSearch').value = clientName;
        document.getElementById('searchResults').style.display = "none";
    }

    // Hide Suggestions on Outside Click
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".search-container")) {
            document.getElementById("searchResults").style.display = "none";
        }
    });
</script>

<!-- Styles -->
<style>
    .search-container {
        position: relative;
    }

    .autocomplete-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ccc;
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
