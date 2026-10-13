<?php
session_start();
include("connection.php");

// ================= ACCESS CONTROL =================
if (empty($_SESSION['ID']) || empty($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = strtolower(trim($_SESSION['role']));
if ($role !== 'postman_officer') {
    die("Access denied. Only Admin can access this page.");
}

// Get admin's DS ID from session
$admin_dsid = $_SESSION['dsid'] ?? 0;

// ================= SEARCH & FILTER =================
$search_date = $_GET['search_date'] ?? '';
$post_type = $_GET['post_type'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';
$subject_search = $_GET['subject_search'] ?? '';

$query = "
    SELECT 
        l.subject, 
        l.file_number, 
        l.recipient_name, 
        l.recipient_address, 
        l.post_type, 
        l.created_at, 
        s.section_name, 
        d.dsname, 
        u.Name AS created_by_name
    FROM letters l
    LEFT JOIN section s ON s.section_id = l.section_id
    LEFT JOIN dsdivision d ON d.dsid = l.dsid
    LEFT JOIN user u ON u.ID = l.created_by
    WHERE l.dsid = ? 
";

$params = [$admin_dsid];
$types = 'i';

if (!empty($search_date)) {
    $query .= " AND DATE(l.created_at) = ?";
    $params[] = $search_date;
    $types .= 's';
}

if (!empty($date_from) && !empty($date_to)) {
    $query .= " AND DATE(l.created_at) BETWEEN ? AND ?";
    $params[] = $date_from;
    $params[] = $date_to;
    $types .= 'ss';
}

if (!empty($post_type)) {
    $query .= " AND l.post_type = ?";
    $params[] = $post_type;
    $types .= 's';
}

if (!empty($subject_search)) {
    $query .= " AND l.subject LIKE ?";
    $params[] = "%" . $subject_search . "%";
    $types .= 's';
}

$query .= " ORDER BY l.created_at DESC";

$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$letters = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Previous Letters</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { font-family: 'Segoe UI', sans-serif; background: #eef1f5; margin: 0; padding: 0; }
.wrapper { margin-left: 260px; padding: 20px; }
h2 { margin-bottom: 20px; }

/* Filter Form */
.filter-form { display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px; align-items: flex-end; }
.filter-form input, .filter-form select { padding: 6px; border-radius: 5px; border: 1px solid #ccc; }
.filter-form label { font-size: 13px; margin-bottom: 3px; }

/* Buttons */
.filter-form button { padding: 6px 12px; border: none; border-radius: 5px; background: #0a1f44; color: #fff; cursor: pointer; }
.filter-form button:hover { background: #081a39; }

/* Table - screen */
.table-compact th, .table-compact td {
    padding: 4px 6px;
    font-size: 13px;
    vertical-align: middle;
}
.table-compact { border-collapse: collapse; }
.table-compact th, .table-compact td { border: none; }
.table-compact tbody tr { background: #fff; }

/* Print Styles */
@media print {
    body * { 
        visibility: hidden; 
    }

    /* Make only the letters table visible */
    #lettersTable, #lettersTable * { 
        visibility: visible; 
    }

    #lettersTable { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        border-collapse: collapse; 
        font-size: 12px; 
        font-family: Arial, sans-serif;
    }

    /* Table headers */
    #lettersTable thead th,
    #lettersTable thead th * {
        font-weight: 700 !important;           /* Bold */
        background-color: #ffd966 !important;  /* Light yellow highlight */
        color: #000 !important;                /* Black text */
        border: 1px solid #000 !important;     /* Border */
        padding: 6px 8px !important;
        text-align: left !important;
    }

    /* Table rows */
    #lettersTable tbody td,
    #lettersTable tbody td * {
        border: 1px solid #000 !important;  /* Row borders */
        padding: 4px 6px !important;        /* Compact spacing */
        line-height: 1.1 !important;
        text-align: left !important;
        color: #000 !important;
    }

    /* Show Filtered List heading above table and footer with count */
    .d-print-table-header-group, .d-print-table-footer-group { display: table-row-group !important; }

    /* Hide everything else */
    .no-print { 
        display: none !important; 
    }
    .print-heading, .print-heading * {
    visibility: visible;
}

.print-heading {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    text-align: center;
    font-weight: 700;
    margin-bottom: 10px;
}

#lettersTable {
    position: absolute;
    top: 60px; /* heading එකට ඉඩ */
}
}
</style>
</head>
<body>

<?php include('admin_sidebar.php'); ?>

<div class="wrapper">
    <h2>Previous Letters</h2>

    <form method="GET" class="filter-form">

        <div>
            <label><strong>Select Single Date</strong></label><br>
            <input type="date" name="search_date" value="<?= htmlspecialchars($search_date) ?>">
        </div>

        <div>
            <label><strong>From Date</strong></label><br>
            <input type="date" name="date_from" value="<?= htmlspecialchars($date_from) ?>">
        </div>

        <div>
            <label><strong>To Date</strong></label><br>
            <input type="date" name="date_to" value="<?= htmlspecialchars($date_to) ?>">
        </div>

        <div>
            <label><strong>Search by Subject</strong></label><br>
            <input type="text" name="subject_search"
                   placeholder="Enter subject..."
                   value="<?= htmlspecialchars($subject_search) ?>">
        </div>

        <div>
            <label><strong>Post Type</strong></label><br>
            <select name="post_type">
                <option value="">All Types</option>
                <option value="Normal" <?= $post_type=='Normal'?'selected':'' ?>>Normal</option>
                <option value="Registered" <?= $post_type=='Registered'?'selected':'' ?>>Registered</option>
            </select>
        </div>

        <div>
            <button type="submit"><i class="bi bi-search"></i> Search</button>
            <button type="button" id="printBtn" class="no-print"><i class="bi bi-printer"></i> Print Table</button>
        </div>

    </form>

    <div class="table-responsive">
        <!-- Print Only Heading -->
<div class="print-heading d-none d-print-block text-center mb-3">
    <h3 style="font-weight:700;">Filltered List</h3>
</div>
    <table class="table table-compact" id="lettersTable">
        
         
        <thead class="d-none d-print-table-header-group">
            
        </thead>

        <thead style="background:#0a1f44; color:#fff;">
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>File Number</th>
                <th>Recipient</th>
                <th>Post Type</th>
                <th>Date Entered</th>
                <th>Section</th>
                <th>DS Division</th>
                <th>Entered By</th>
            </tr>
        </thead>
        <tbody>
            <?php if($letters): ?>
                <?php foreach($letters as $i => $l): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($l['subject']) ?></td>
                    <td><?= htmlspecialchars($l['file_number']) ?></td>
                    <td><?= htmlspecialchars($l['recipient_name']) ?></td>
                    <td><?= htmlspecialchars($l['post_type']) ?></td>
                    <td><?= htmlspecialchars($l['created_at']) ?></td>
                    <td><?= htmlspecialchars($l['section_name']) ?></td>
                    <td><?= htmlspecialchars($l['dsname']) ?></td>
                    <td><?= htmlspecialchars($l['created_by_name']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="9" class="text-center">No letters found.</td></tr>
            <?php endif; ?>
        </tbody>

        <!-- Print Footer -->
        <tfoot class="d-none d-print-table-footer-group">
            <tr>
                <td colspan="9" style="text-align:right; font-weight:bold;">
                    Num of Filtered Records: <?= count($letters); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('printBtn').addEventListener('click', function(){
    window.print();
});
</script>
</body>
</html>