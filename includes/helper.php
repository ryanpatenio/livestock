<?php

// Include Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';

// Include your database connection file (adjust path if necessary)
require("../connection/connection.php");
require("../includes/config.php");

class Helper {
    private $con;

    // Constructor to accept the database connection
    public function __construct($connection)
    {
        $this->con = $connection;
    }

    function base_url($path = '')
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/' . ltrim($path, '/');
    }
    

   public function message($message, $status = 200, $data = []) {
        // Create the response array
        $response = [
            'status' => $status === 200 ? 'success' : 'error', // If status is 200, it's a success, else it's an error
            'message' => $message,
            'code' => $status === 200 ? '0' : '1', //0 true 1 false
            'data' => $data // Optional data, which can be passed if needed
        ];
    
        // Send JSON response
        echo json_encode($response);
        exit; // Stop further script execution to ensure only the response is sent
    }
    


    public function regularQuery($query, $params = [])
    {
        // Determine the query type (SELECT, INSERT, UPDATE)
        $query_type = strtoupper(substr(trim($query), 0, 6));
        
        try {
            // Prepare the statement
            $stmt = $this->con->prepare($query);

            if ($stmt === false) {
                throw new Exception("Failed to prepare query: " . $this->con->error);
            }

            // Bind parameters if provided
            if (!empty($params)) {
                // Create a dynamic binding string, e.g., 'ssi' for string, string, integer
                $types = str_repeat('s', count($params)); // Assuming all params are strings for simplicity
                $stmt->bind_param($types, ...$params);
            }

            // Execute the query
            $stmt->execute();

            switch ($query_type) {
                case 'SELECT':
                    $result = $stmt->get_result();
                    if ($result) {
                        return $result->fetch_all(MYSQLI_ASSOC); // Return all results as an array
                    }
                    break;

                case 'INSERT':
                    return ['insert_id' => $this->con->insert_id]; // Return the insert ID

                case 'UPDATE':
                    return $stmt->affected_rows > 0; // Return true if rows were updated

                default:
                    throw new Exception("Unsupported query type: $query_type");
            }
        } catch (Exception $e) {
            error_log("Error Code:  - Message: " . $e->getMessage(), 3, 'errors.log');
        }

        return false; // Return false for unsupported query types or failures
    }
}
