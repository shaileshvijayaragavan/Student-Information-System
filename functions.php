<?php
/**
 * Common functions used across the Student Information System
 */

/**
 * Sanitize user input to prevent XSS
 * 
 * @param string $data Input data to sanitize
 * @return string Sanitized data
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Generate a random string
 * 
 * @param int $length Length of the random string
 * @return string Random string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * Convert date from database format to display format
 * 
 * @param string $date Date in Y-m-d format
 * @return string Date in d/m/Y format
 */
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

/**
 * Calculate age from date of birth
 * 
 * @param string $dob Date of birth in Y-m-d format
 * @return int Age in years
 */
function calculateAge($dob) {
    $today = new DateTime();
    $birthDate = new DateTime($dob);
    $interval = $today->diff($birthDate);
    return $interval->y;
}

/**
 * Get grade letter based on percentage
 * 
 * @param float $percentage Percentage marks
 * @return string Grade letter
 */
function getGradeLetter($percentage) {
    if ($percentage >= 90) {
        return 'A+';
    } elseif ($percentage >= 80) {
        return 'A';
    } elseif ($percentage >= 75) {
        return 'B+';
    } elseif ($percentage >= 70) {
        return 'B';
    } elseif ($percentage >= 65) {
        return 'C+';
    } elseif ($percentage >= 60) {
        return 'C';
    } elseif ($percentage >= 55) {
        return 'D+';
    } elseif ($percentage >= 50) {
        return 'D';
    } else {
        return 'F';
    }
}

/**
 * Get attendance percentage for a student in a course
 * 
 * @param mysqli $conn Database connection
 * @param int $studentId Student ID
 * @param int $courseId Course ID
 * @return float Attendance percentage
 */
function getAttendancePercentage($conn, $studentId, $courseId) {
    $query = "SELECT 
                COUNT(*) as total_classes,
                SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) as present_count
              FROM attendance 
              WHERE student_id = ? AND course_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $studentId, $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if ($data['total_classes'] == 0) {
        return 0;
    }
    
    return round(($data['present_count'] / $data['total_classes']) * 100, 2);
}

/**
 * Get course average grade for a student
 * 
 * @param mysqli $conn Database connection
 * @param int $studentId Student ID
 * @param int $courseId Course ID
 * @return float Average grade percentage
 */
function getCourseAverageGrade($conn, $studentId, $courseId) {
    $query = "SELECT 
                AVG((marks_obtained/max_marks) * 100) as average_grade
              FROM grades g
              JOIN enrollments e ON g.enrollment_id = e.enrollment_id
              WHERE e.student_id = ? AND e.course_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $studentId, $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    return round($data['average_grade'], 2);
}

/**
 * Check if a page is the current page
 * 
 * @param string $page Page name
 * @return string Active class if current page
 */
function isActivePage($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return ($currentPage == $page) ? 'active' : '';
}
?>