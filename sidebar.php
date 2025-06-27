<aside class="app-sidebar">
    <nav class="sidebar-nav">
        <ul>
            <li class="<?php echo isActivePage('index.php') && dirname($_SERVER['PHP_SELF']) == '/student_information_system/modules/dashboard' ? 'active' : ''; ?>">
                <a href="../../modules/dashboard/index.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/modules/students/') !== false ? 'active' : ''; ?>">
                <a href="../../modules/students/index.php">
                    <i class="fas fa-user-graduate"></i> Students
                </a>
            </li>
            <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/modules/courses/') !== false ? 'active' : ''; ?>">
                <a href="../../modules/courses/index.php">
                    <i class="fas fa-book"></i> Courses
                </a>
            </li>
            <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/modules/enrollments/') !== false ? 'active' : ''; ?>">
                <a href="../../modules/enrollments/index.php">
                    <i class="fas fa-user-plus"></i> Enrollments
                </a>
            </li>
            <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/modules/grades/') !== false ? 'active' : ''; ?>">
                <a href="../../modules/grades/index.php">
                    <i class="fas fa-chart-line"></i> Grades
                </a>
            </li>
            <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/modules/attendance/') !== false ? 'active' : ''; ?>">
                <a href="../../modules/attendance/index.php">
                    <i class="fas fa-calendar-check"></i> Attendance
                </a>
            </li>
           
        </ul>
    </nav>
</aside>