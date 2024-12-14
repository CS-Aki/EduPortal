<?php
class DbConnection {
    private $db_server = "localhost";
    private $db_user = "root";
    private $db_password = "";
    private $db_name = "classroom_db";

    protected function connect() {
        $dsn = 'mysql:host=' . $this->db_server . ';dbname=' . $this->db_name;
        $pdo = new PDO($dsn, $this->db_user, $this->db_password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for errors
        return $pdo;
    }

    // Public method to get the connection instance
    public function getConnection() {
        return $this->connect();
    }
}

// Function to fetch active student count
function getActiveStudentCount() {
    $db = new DbConnection();        // Instantiate the DbConnection class
    $pdo = $db->getConnection();     // Get the PDO instance

    $query = "SELECT COUNT(*) AS total_count FROM `users` WHERE user_category = 4 AND status = 'Active'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_count'] ?? 0; // Return the count or 0 if no results
}

// Function to fetch active student count
function getActiveProfessorCount() {
    $db = new DbConnection();        // Instantiate the DbConnection class
    $pdo = $db->getConnection();     // Get the PDO instance

    $query = "SELECT COUNT(*) AS total_count FROM `users` WHERE user_category = 3 AND status = 'Active'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_count'] ?? 0; // Return the count or 0 if no results
}

// Function to fetch active student count
function getActiveStaffCount() {
    $db = new DbConnection();        // Instantiate the DbConnection class
    $pdo = $db->getConnection();     // Get the PDO instance

    $query = "SELECT COUNT(*) AS total_count FROM `users` WHERE user_category = 2 AND status = 'Active'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_count'] ?? 0; // Return the count or 0 if no results
}

// Function to fetch active student count
function getActiveSubjectCount() {
    $db = new DbConnection();        // Instantiate the DbConnection class
    $pdo = $db->getConnection();     // Get the PDO instance

    $query = "SELECT COUNT(DISTINCT class_name) AS unique_class_count FROM `classes`";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['unique_class_count'] ?? 0; // Return the count or 0 if no results
}

function getTopClassesWithEnrollment($limit = 5) {
    $db = new DbConnection(); // Assuming you already have a DbConnection class
    $pdo = $db->getConnection(); // Use the connect() method to get the PDO instance

    // SQL query to fetch top N popular classes
    $query = "SELECT c.class_name, COUNT(jc.user_id) AS enrollment_count
              FROM join_class jc
              JOIN classes c ON jc.class_code = c.class_code
              JOIN users ON users.user_id = jc.user_id
              WHERE users.user_category = 4
              GROUP BY c.class_name
              ORDER BY enrollment_count DESC
              LIMIT :limit";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize an array to hold formatted output
    $topSubjects = [
        'top1' => $results[0]['class_name'] ?? 'No Data',
        'top2' => $results[1]['class_name'] ?? 'No Data',
        'top3' => $results[2]['class_name'] ?? 'No Data',
        'top4' => $results[3]['class_name'] ?? 'No Data',
        'top5' => $results[4]['class_name'] ?? 'No Data',
    ];

    return $topSubjects; // Return the formatted array
}

function getMonthlyEnrollment($months = 4) {
    $db = new DbConnection();
    $pdo = $db->getConnection();

    $query = "SELECT 
                 DATE_FORMAT(created, '%Y-%m') AS month, 
                 COUNT(*) AS enrolled_count
              FROM users
              WHERE user_category = 4 
                AND created >= DATE_SUB(CURDATE(), INTERVAL :months MONTH)
              GROUP BY month
              ORDER BY month DESC";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':months', $months, PDO::PARAM_INT);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Manual assignment of data
    $data = [];
    foreach ($results as $row) {
        $data[$row['month']] = (int)$row['enrolled_count'];
    }

    // Assign specific months manually
    $september = $data['2024-09'] ?? 0;
    $october = $data['2024-10'] ?? 0;
    $november = $data['2024-11'] ?? 0;
    $december = $data['2024-12'] ?? 0;

    return [
        'September' => $september,
        'October' => $october,
        'November' => $november,
        'December' => $december,
    ];
}

function getMonthlyPassFail($months = 4) {
    $db = new DbConnection();
    $pdo = $db->getConnection();

    $query = "SELECT 
                 SUM(CASE WHEN grade >= 75 THEN 1 ELSE 0 END) AS passed_count,
                 SUM(CASE WHEN grade < 75 THEN 1 ELSE 0 END) AS failed_count,
                 DATE_FORMAT(created, '%Y-%m') AS month
              FROM grades
              WHERE created >= DATE_SUB(CURDATE(), INTERVAL :months MONTH)
              GROUP BY month
              ORDER BY month DESC";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':months', $months, PDO::PARAM_INT);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($results as $row) {
        $data[$row['month']] = [
            'passed' => (int)$row['passed_count'],
            'failed' => (int)$row['failed_count'],
        ];
    }

    // Assign specific months manually
    $september = $data['2024-09'] ?? ['passed' => 0, 'failed' => 0];
    $october = $data['2024-10'] ?? ['passed' => 0, 'failed' => 0];
    $november = $data['2024-11'] ?? ['passed' => 0, 'failed' => 0];
    $december = $data['2024-12'] ?? ['passed' => 0, 'failed' => 0];

    return [
        'September' => $september,
        'October' => $october,
        'November' => $november,
        'December' => $december,
    ];
}


?>

