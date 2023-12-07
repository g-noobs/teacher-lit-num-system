<?php
// XAMPP localhost database connection
$host = "localhost";
$user = "u170333284_admin"; // default XAMPP username
$password = "Capstone1!"; // default XAMPP password is empty
$database = "u170333284_db_tagakaulo"; // your database name

// Create connection
$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the user ID from the AJAX request
$userId = $_GET['userId'];

// Query to fetch user information
$queryUserInfo = "
    SELECT 
        ui.first_name,
        ui.last_name,
        ui.personal_id  -- Add personal_id to the query
    FROM 
        tbl_user_info ui
    WHERE 
        ui.user_info_id = '$userId'
";

$resultUserInfo = mysqli_query($connection, $queryUserInfo);

if (!$resultUserInfo) {
    echo "Error: " . mysqli_error($connection);
}

// Fetch user information
$userInfo = mysqli_fetch_assoc($resultUserInfo);

// Query to fetch all topic_id values with topic_status = 1 for the selected student
$query = "
    SELECT 
        tp.topic_id,
        tp.topic_name,
        COALESCE(CONCAT('Completed on ', DATE_FORMAT(lsp.date_completed, '%Y-%m-%d')), 'Not Yet Taken') AS progress_status
    FROM 
        tbl_topic tp
    LEFT JOIN tbl_learner_story_progress lsp ON tp.topic_id = lsp.story_id AND lsp.learner_id = '{$userInfo['personal_id']}'
    WHERE 
        tp.topic_status = 1
";  

// Filter condition for AJAX request
$filterCondition = isset($_GET['filter']) ? $_GET['filter'] : ''; // Assuming the filter is passed in the AJAX request

// Apply filter condition
if ($filterCondition === 'completed') {
    $query .= " AND lsp.date_completed IS NOT NULL";
} elseif ($filterCondition === 'not_completed') {
    $query .= " AND lsp.date_completed IS NULL";
}

$result = mysqli_query($connection, $query);

if ($result) {
    // Output HTML table with topic_id, topic_name, and status values
    echo "<div>
            <h2>Learner Story Progress for {$userInfo['first_name']} {$userInfo['last_name']}</h2>
            <p>Personal ID: {$userInfo['personal_id']}</p> <!-- Display personal_id -->

            <select id='filterSelect' onchange='applyFilter()'>
                <option value='all'>All</option>
                <option value='completed'>Completed</option>
                <option value='not_completed'>Not Completed</option>
            </select>

            <table border='1' id='progressTable'>
                <tr>
                    <th>Topic ID</th>
                    <th>Topic Name</th>
                    <th>Status</th>
                </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='progressRow' data-status='{$row['progress_status']}'>
                <td>{$row['topic_id']}</td>
                <td>{$row['topic_name']}</td>
                <td>{$row['progress_status']}</td>
            </tr>";
    }

    echo "</table>
        <p><button onclick=\"goBack()\">Go Back</button></p>
    </div>";
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>

<script>
    function applyFilter() {
        var filter = document.getElementById('filterSelect').value;
        var rows = document.getElementsByClassName('progressRow');

        for (var i = 0; i < rows.length; i++) {
            var status = rows[i].getAttribute('data-status');

            if (filter === 'all' || (filter === 'completed' && status.includes('Completed')) || (filter === 'not_completed' && status.includes('Not Yet Taken'))) {
                rows[i].style.display = 'table-row';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function goBack() {
        window.history.back();
    }
</script>
