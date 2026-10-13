<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
}

/* Sidebar Container */
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: #203a43; /* same background for all pages */
    color: #fff;
    padding-top: 25px;
    box-shadow: 5px 0 25px rgba(0,0,0,0.15);
    display: flex;
    flex-direction: column;
}

/* Logo Section */
.sidebar-header {
    text-align: center;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.15);
}

.sidebar-header h4 {
    margin: 0;
    font-weight: 600;
    letter-spacing: 1px;
}

.sidebar-header small {
    opacity: 0.8;
}

/* Menu Links */
.sidebar-menu {
    flex: 1;
    padding-top: 20px;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    margin: 6px 15px;
    border-radius: 12px;
    color: #fff;
    text-decoration: none;
    font-size: 15px;
    transition: all 0.3s ease;
    position: relative;
    background: #203a43; /* consistent background for all links */
}

/* Hover Effect */
.sidebar-menu a:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(6px);
}

/* Active Link */
.sidebar-menu a.active {
    background: rgba(255,255,255,0.25);
    font-weight: 600;
}

/* Active Left Indicator */
.sidebar-menu a.active::before {
    content: "";
    position: absolute;
    left: -15px;
    width: 5px;
    height: 100%;
    background: #00e0ff;
    border-radius: 0 5px 5px 0;
}

/* Logout Section */
.logout-section {
    padding: 15px;
    border-top: 1px solid rgba(255,255,255,0.15);
}

.logout-section a {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ffdddd;
    text-decoration: none;
    padding: 10px;
    border-radius: 10px;
    transition: 0.3s;
}

.logout-section a:hover {
    background: rgba(255,0,0,0.2);
}
</style>

<div class="sidebar">

    <div class="sidebar-header">
        <h4><i class="bi bi-envelope-paper"></i> Admin Panel</h4>
        <small>
            <?= htmlspecialchars($_SESSION['Name'] ?? 'Admin'); ?>
        </small>
    </div>

    <div class="sidebar-menu">
        <!-- Main Page -->
        <a href="admin_dashboard.php"
           class="<?= basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Main Page
        </a>

        <!-- Previous Letters -->
        <a href="previous_letters.php"
           class="<?= basename($_SERVER['PHP_SELF']) == 'previous_letters.php' ? 'active' : '' ?>">
            <i class="bi bi-folder2-open"></i> Previous Letters
        </a>

        <!-- Today Summary -->
        <a href="today_summary.php"
           class="<?= basename($_SERVER['PHP_SELF']) == 'today_summary.php' ? 'active' : '' ?>">
            <i class="bi bi-bar-chart"></i> Today Summary
        </a>
    </div>

    <div class="logout-section">
        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?');">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

</div>