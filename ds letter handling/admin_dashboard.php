<?php
session_start();
include("connection.php");

// 🔐 Admin Only
if (!isset($_SESSION['ID']) || strtolower($_SESSION['role']) !== 'postman_officer') {
    header("Location: login.php");
    exit();
}

$today = date('Y-m-d');
$userID = $_SESSION['ID'];
$dsid = $_SESSION['dsid']; // Admin DS ID

// Fetch User Details
$userQuery = $conn->query("
    SELECT u.Name, p.province_name, d.district_name, ds.dsname
    FROM user u
    LEFT JOIN provinces p ON u.province_id = p.province_id
    LEFT JOIN district d ON u.district_id = d.district_id
    LEFT JOIN dsdivision ds ON u.dsid = ds.dsid
    WHERE u.ID = '$userID'
");
$userData = $userQuery->fetch_assoc();

// Counts (DS-wise)
$totalLetters = $conn->query("SELECT COUNT(*) as total FROM letters WHERE dsid='$dsid'")->fetch_assoc()['total'];
$todayLetters = $conn->query("SELECT COUNT(*) as total FROM letters WHERE dsid='$dsid' AND DATE(created_at)='$today'")->fetch_assoc()['total'];
$previousLetters = $totalLetters - $todayLetters;

// Fetch Today's Letters (DS-wise)
$letters = $conn->query("
    SELECT l.letter_id, l.subject, l.file_number,
           l.recipient_name, l.recipient_address,
           l.post_type, s.section_name, l.created_at
    FROM letters l
    LEFT JOIN section s ON l.section_id = s.section_id
    WHERE l.dsid='$dsid' AND DATE(l.created_at)='$today'
    ORDER BY l.created_at ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{ margin:0; font-family:'Segoe UI',sans-serif; background:#f4f6fb; }
/* Sidebar */
.sidebar{ width:260px; height:100vh; position:fixed; background:linear-gradient(180deg,#0f2027,#203a43,#2c5364); color:#fff; display:flex; flex-direction:column; }
.sidebar-header{ text-align:center; padding:25px 10px; border-bottom:1px solid rgba(255,255,255,0.2); }
.sidebar-menu{ flex:1; padding-top:20px; }
.sidebar-menu a{ display:flex; align-items:center; gap:12px; padding:12px 20px; margin:6px 15px; border-radius:10px; color:white; text-decoration:none; transition:0.3s; }
.sidebar-menu a:hover{ background:rgba(255,255,255,0.2); }
.sidebar-menu a.active{ background:rgba(255,255,255,0.3); }
.logout{ padding:15px; border-top:1px solid rgba(255,255,255,0.2); }

/* Topbar */
.topbar{ margin-left:260px; padding:10px 20px; box-shadow:0 3px 10px rgba(0,0,0,0.12); display:flex; justify-content:space-between; align-items:center; color:white; font-size:14px; border-bottom-left-radius:10px; border-bottom-right-radius:10px; }
.topbar .badge{ font-size:0.85rem; padding:5px 10px; border-radius:15px; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition: transform 0.2s; }
.topbar .badge:hover{ transform: translateY(-2px); }

/* Main */
.main{ margin-left:260px; padding:30px; }

/* Cards */
.stat-card{ border-radius:15px; color:white; padding:25px; box-shadow:0 4px 20px rgba(0,0,0,0.08); transition:0.3s; text-align:center; }
.stat-card:hover{ transform:translateY(-5px); }
.card-blue{ background:linear-gradient(45deg,#1e3c72,#2a5298); }
.card-green{ background:linear-gradient(45deg,#11998e,#38ef7d); }
.card-orange{ background:linear-gradient(45deg,#ff9966,#ff5e62); }

/* Modern Table */
.table-responsive{ overflow-x:auto; }
.table-hover tbody tr:hover{ background: #f1f5f9; transition: background 0.2s ease-in-out; }

/* Modern Compact Table */
.table-responsive{
    overflow-x:auto;
}

.table{
    font-size: 14px;
    margin-bottom: 0;
}

.table thead th{
    padding: 8px 10px !important;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    vertical-align: middle;
}

.table tbody td{
    padding: 6px 10px !important;
    font-size: 13px;
    line-height: 1.2;
    vertical-align: middle;
}

.table-hover tbody tr:hover{
    background:#f1f5f9;
    transition:0.2s;
}

/* Reduce row height */
.table tbody tr{
    height: 38px;
}

/* Better alignment */
.table td,
.table th{
    text-align:left;
}

/* Hide Postal Cost on Dashboard, show only for print */
.print-only{
    display:none;
}
@media print {
    /* Hide the 7th column (Section) */
    .table-printable table th:nth-child(7),
    .table-printable table td:nth-child(7) {
        display: none !important;
    }
}
@media print {

/* Post Type column hide in print */
.table-printable table th:nth-child(6),
.table-printable table td:nth-child(6){
    display:none !important;
}

}
@media print{
    .print-only{
        display:table-cell !important;
    }
}

/* Print Button Styling */
.print-btn{ width:130px; padding:6px 12px; font-size:0.9rem; border-radius:6px; margin:auto; display:block; }

/* Print-specific styling */
@media print {

    body * { visibility: hidden; }

    .table-printable, 
    .table-printable * { 
        visibility: visible; 
    }

    .table-printable { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
    }

    /* Table Styling */
    .table-printable table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 12px !important;
        font-family: Arial, sans-serif !important;
    }

    /* Table headers bold + highlighted */
    .table-printable table thead th,
    .table-printable table thead th * {
        font-weight: 700 !important;
        background-color: #ffd966 !important;
        border: 1px solid #000 !important;
        padding: 6px 8px !important;
        color: #000 !important;
    }

    /* Table rows */
    .table-printable table tbody td,
    .table-printable table tbody td * {
        border: 1px solid #000 !important;
        padding: 4px 6px !important;
        line-height: 1.1 !important;
        text-align: left !important;
        color: #000 !important;
    }

    .no-print { display: none !important; }
}
</style>
</head>

<script>
function printLetters(type){
    let rows = Array.from(document.querySelectorAll("tbody tr"));
    let tableBody = document.querySelector("tbody");

    // Group rows by section and filter by type
    let sectionMap = {};
    rows.forEach(row => {
        if(row.dataset.type === type){
            let section = row.cells[6].innerText; // Section column
            if(!sectionMap[section]) sectionMap[section] = [];
            sectionMap[section].push(row);
        }
        row.style.display = "none"; // hide all initially
    });

    // Remove old title/total if any
    let oldTotalRow = document.getElementById("totalRow");
    if(oldTotalRow) oldTotalRow.remove();
    let oldTitle = document.getElementById("printTitle");
    if(oldTitle) oldTitle.remove();

    let tableContainer = document.querySelector(".table-printable");

    // Create Dynamic Print Title
    let title = document.createElement("h4");
    title.id = "printTitle";
    title.style.textAlign = "center";
    title.style.marginBottom = "15px";
    title.innerText = type === "Normal" ? "Normal Letters" : "Registered Letters";
    tableContainer.insertBefore(title, tableContainer.firstChild);

    // Clear tbody
    tableBody.innerHTML = "";

    let counter = 1;
    let total = 0;

    // Append rows section-wise
    for(const section in sectionMap){
        // Section header row
        let secRow = document.createElement("tr");
        let secCell = document.createElement("td");
        secCell.colSpan = 9;
        secCell.style.fontWeight = "bold";
        secCell.style.backgroundColor = "#f0f0f0";
        secCell.innerText = "SECTION: " + section;
        secRow.appendChild(secCell);
        tableBody.appendChild(secRow);

        // Append rows of this section
        sectionMap[section].forEach(row=>{
            row.style.display = "";
            row.cells[0].innerText = counter++; // renumber
            tableBody.appendChild(row);
            total++;
        });
    }

    // Add total row
    let totalRow = document.createElement("tr");
    totalRow.id = "totalRow";
    totalRow.innerHTML = `
        <td colspan="9" style="text-align:right;font-weight:bold;">
            Total ${type} Letters: ${total}
        </td>
    `;
    tableBody.appendChild(totalRow);

    // Print
    window.print();

    // Restore original dashboard table
    tableBody.innerHTML = "";
    rows.forEach(row => {
        row.style.display = "";
        tableBody.appendChild(row);
    });

    // Restore original numbering
    let i = 1;
    rows.forEach(row => row.cells[0].innerText = i++);
}
</script>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-envelope-paper"></i> Admin Panel</h4>
        <small><?= htmlspecialchars($userData['Name']); ?></small>
    </div>
    <div class="sidebar-menu">
        <a href="admin_main.php" class="active"><i class="bi bi-speedometer2"></i> Main Page</a>
        <a href="previous_letters.php"><i class="bi bi-folder2-open"></i> Previous Letters</a>
        <a href="today_summary.php"><i class="bi bi-folder2-open"></i> Today Summary</a>
    </div>
    <div class="logout text-center">
        <a href="logout.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</div>

<!-- Topbar -->
<div class="topbar" style="background: linear-gradient(90deg, #1e3c72, #2a5298); color: #fff;">
    <div class="d-flex align-items-center">
        <i class="bi bi-envelope-paper" style="font-size:1.5rem; margin-right:10px;"></i>
        <span style="font-weight:600; font-size:1.2rem;">Letter Handling System</span>
    </div>
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="badge bg-light text-dark">Province: <strong><?= htmlspecialchars($userData['province_name']); ?></strong></div>
        <div class="badge bg-light text-dark">District: <strong><?= htmlspecialchars($userData['district_name']); ?></strong></div>
        <div class="badge bg-light text-dark">DS: <strong><?= htmlspecialchars($userData['dsname']); ?></strong></div>
        <div class="badge bg-warning text-dark">Admin: <strong><?= htmlspecialchars($userData['Name']); ?></strong></div>
    </div>
</div>

<!-- Main -->
<div class="main">
    <!-- Cards -->
    <div class="row mb-4">
        <div class="col-md-4"><div class="stat-card card-blue"><h2><?= $todayLetters ?></h2><p>Today's Letters</p></div></div>
        <div class="col-md-4"><div class="stat-card card-green"><h2><?= $totalLetters ?></h2><p>Total Letters</p></div></div>
        <div class="col-md-4"><div class="stat-card card-orange"><h2><?= $previousLetters ?></h2><p>Previous Letters</p></div></div>
    </div>

    <!-- Letters Table -->
    <div class="card shadow-sm p-3 mb-4 table-printable">
        <h5 class="mb-3"><?= date('Y-m-d'); ?></h5>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>File Number</th>
                        <th>Recipient Name</th>
                        <th>Recipient Address</th>
                        <th>Post Type</th>
                        <th>Section</th>
                        <th>Date</th>
                        <th class="print-only">Postal Cost</th> <!-- print-only class added -->
                    </tr>
                </thead>
                <tbody>
                    <?php if($letters->num_rows > 0): ?>
                        <?php $i = 1; while($row = $letters->fetch_assoc()): ?>
                          <tr data-type="<?= $row['post_type'];?>">
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['subject']); ?></td>
                            <td><?= htmlspecialchars($row['file_number']); ?></td>
                            <td><?= htmlspecialchars($row['recipient_name']); ?></td>
                            <td><?= htmlspecialchars($row['recipient_address']); ?></td>
                            <td><?= htmlspecialchars($row['post_type']); ?></td>
                            <td><?= htmlspecialchars($row['section_name']); ?></td>
                            <td><?= htmlspecialchars($row['created_at']); ?></td>
                            <td class="print-only"></td> <!-- empty postal cost -->
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="text-center">No letters entered today</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center gap-3 mt-3 no-print">
            <button onclick="printLetters('Normal')" class="btn btn-success print-btn">
                <i class="bi bi-printer me-1"></i> Print Normal Letters
            </button>

            <button onclick="printLetters('Registered')" class="btn btn-warning print-btn">
                <i class="bi bi-printer me-1"></i> Print Registered Letters
            </button>
        </div>
    </div>
</div>
</body>
</html>