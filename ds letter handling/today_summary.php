<?php
session_start();
include("connection.php");

// 🔐 Admin Only
if (!isset($_SESSION['ID']) || strtolower($_SESSION['role']) !== 'postman_officer') {
    header("Location: login.php");
    exit();
}

$today = date('Y-m-d');
$dsid = $_SESSION['dsid'];

// Fetch User Details
$userQuery = $conn->query("
    SELECT u.Name, p.province_name, d.district_name, ds.dsname
    FROM user u
    LEFT JOIN provinces p ON u.province_id = p.province_id
    LEFT JOIN district d ON u.district_id = d.district_id
    LEFT JOIN dsdivision ds ON u.dsid = ds.dsid
    WHERE u.ID = '{$_SESSION['ID']}'
");
$userData = $userQuery->fetch_assoc();

// Section-wise letter count for today
$summaryQuery = $conn->query("
    SELECT s.section_name, 
           COUNT(l.letter_id) AS total_letters,
           SUM(l.post_type='Normal') AS normal_letters,
           SUM(l.post_type='Registered') AS registered_letters
    FROM letters l
    LEFT JOIN section s ON l.section_id = s.section_id
    WHERE l.dsid='$dsid' AND DATE(l.created_at)='$today'
    GROUP BY s.section_id
    ORDER BY s.section_name ASC
");

// Sidebar Active Page
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Today Summary - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body{ font-family:'Segoe UI',sans-serif; background:#eef1f5; margin:0; }

/* Sidebar */
.sidebar{ width:260px; height:100vh; position:fixed; background:linear-gradient(180deg,#0f2027,#203a43,#2c5364); color:#fff; display:flex; flex-direction:column; }
.sidebar-header{ text-align:center; padding:25px 10px; border-bottom:1px solid rgba(255,255,255,0.2); }
.sidebar-menu{ flex:1; padding-top:20px; }
.sidebar-menu a{ display:flex; align-items:center; gap:12px; padding:12px 20px; margin:6px 15px; border-radius:10px; color:white; text-decoration:none; transition:0.3s; }
.sidebar-menu a:hover{ background:rgba(255,255,255,0.2); }
.sidebar-menu a.active{ background:rgba(255,255,255,0.3); }
.logout{ padding:15px; border-top:1px solid rgba(255,255,255,0.2); }

.main{ margin-left:260px; padding:30px; }

/* Compact Table */
.table th, .table td{
    vertical-align: middle;
    padding:4px 6px;  /* compact spacing */
    font-size:13px;
}
.table th{ background:#0a1f44; color:#fff; font-weight: bold; }
/* Remove highlight/striped row effect */
.table tbody tr{ background: #fff; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-envelope-paper"></i> Admin Panel</h4>
        <small><?= htmlspecialchars($userData['Name']); ?></small>
    </div>
    <div class="sidebar-menu">
        <a href="admin_dashboard.php" class="<?= $currentPage=='admin_dashboard.php'?'active':'' ?>"><i class="bi bi-speedometer2"></i> Main Page</a>
        <a href="previous_letters.php" class="<?= $currentPage=='previous_letters.php'?'active':'' ?>"><i class="bi bi-folder2-open"></i> Previous Letters</a>
        <a href="today_summary.php" class="<?= $currentPage=='today_summary.php'?'active':'' ?>"><i class="bi bi-bar-chart"></i> Today Summary</a>
    </div>
    <div class="logout text-center">
        <a href="logout.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</div>

<!-- Main -->
<div class="main">
    <h2>Today Summary (<?= date('Y-m-d'); ?>)</h2>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Section Name</th>
                    <th>Total Letters</th>
                    <th>Normal Letters</th>
                    <th>Registered Letters</th>
                </tr>
            </thead>
            <tbody>
                <?php if($summaryQuery->num_rows > 0): $i=1; ?>
                    <?php while($row = $summaryQuery->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['section_name']); ?></td>
                            <td><?= $row['total_letters']; ?></td>
                            <td><?= $row['normal_letters']; ?></td>
                            <td><?= $row['registered_letters']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No letters entered today</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>