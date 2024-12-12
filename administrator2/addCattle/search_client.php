<?php

if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];

    $con = mysqli_connect('localhost', 'root', '', 'dispersal_db');
    if (!$con) {
        echo json_encode(['error' => 'Unable to connect to database.']);
        exit;
    }

    $query = "
        SELECT CLIENT_ID, CONCAT(FNAME, ' ', LNAME) AS full_name
        FROM client
        WHERE CONCAT(FNAME, ' ', LNAME) LIKE ?
        LIMIT 5
    ";
    
    $stmt = $con->prepare($query);
    $likeSearchQuery = '%' . $searchQuery . '%';
    $stmt->bind_param('s', $likeSearchQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div onclick="selectClient(\'' . htmlspecialchars($row['CLIENT_ID']) . '\', \'' . htmlspecialchars($row['full_name']) . '\')">';
            echo htmlspecialchars($row['full_name']);
            echo '</div>';
        }
    } else {
        echo '<div>No results found!</div>';
    }

    $stmt->close();
    mysqli_close($con);
}
?>
