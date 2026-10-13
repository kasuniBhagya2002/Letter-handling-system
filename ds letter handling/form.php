<?php
session_start();
include("connection.php"); // ensure $conn is defined

// ================= ACCESS CONTROL =================
if (empty($_SESSION['ID']) || empty($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

/* USER DETAILS */
$user_id    = $_SESSION['ID'];
$role       = strtolower(trim($_SESSION['role']));
$section_id = $_SESSION['section_id'];
$dsid       = $_SESSION['dsid'];

if (!in_array($role, ['postman_officer','user'])) {
    die("Access denied.");
}

// Fetch user details
$stmt = $conn->prepare("
    SELECT s.section_name, d.dsname
    FROM section s
    LEFT JOIN dsdivision d ON d.dsid = ?
    WHERE s.section_id = ?
");
$stmt->bind_param("ii",$dsid,$section_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// ================= FORM SUBMISSION =================
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['edit_id'])) {
        // UPDATE EXISTING LETTER (today only)
        $stmt = $conn->prepare("
            UPDATE letters
            SET subject=?, file_number=?, recipient_name=?, recipient_address=?, post_type=?
            WHERE id=? AND created_by=? AND DATE(created_at)=CURDATE()
        ");
        $stmt->bind_param(
            "ssssiii",
            $_POST['subject'],
            $_POST['file_no'],
            $_POST['recipient'],
            $_POST['address'],
            $_POST['post_type'],
            $_POST['edit_id'],
            $user_id
        );
        $stmt->execute();
        $stmt->close();
        $success = true;
    } else {
        // INSERT NEW LETTER
        $stmt = $conn->prepare("
            INSERT INTO letters
            (subject, file_number, recipient_name, recipient_address, post_type, created_by, section_id, dsid)
            VALUES (?,?,?,?,?,?,?,?)
        ");
        $stmt->bind_param(
            "sssssiis",
            $_POST['subject'],
            $_POST['file_no'],
            $_POST['recipient'],
            $_POST['address'],
            $_POST['post_type'],
            $user_id,
            $section_id,
            $dsid
        );
        $stmt->execute();
        $letter_id = $stmt->insert_id;
        $stmt->close();

        // daily register
        $stmt2 = $conn->prepare("INSERT INTO daily_letter_register (letter_id, register_date) VALUES (?, CURDATE())");
        $stmt2->bind_param("i",$letter_id);
        $stmt2->execute();
        $stmt2->close();
        $success = true;
    }
}

// ================= FETCH LETTERS =================
// All letters by this officer, DS-wise (section + dsid)
$stmt3 = $conn->prepare("
    SELECT letter_id,subject, file_number, recipient_name, recipient_address, post_type, created_at
    FROM letters
    WHERE created_by=? AND dsid=? AND section_id=?
    ORDER BY created_at DESC
");
$stmt3->bind_param("iii",$user_id,$dsid,$section_id);
$stmt3->execute();
$letters = $stmt3->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt3->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Officer Letter Form</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body{margin:0;font-family:'Inter','Segoe UI',sans-serif;background:#eef1f5;}
.header{background:#0a1f44;color:#fff;padding:18px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 4px 15px rgba(0,0,0,.2);}
.header h1{font-size:20px;margin:0;}
.header small{opacity:.8;font-size:12px;}
.logout{background:#dc3545;color:#fff;padding:7px 16px;border-radius:25px;text-decoration:none;font-size:13px;}
.logout:hover{background:#b02a37}

/* FLEX LAYOUT */
.main-container{display:flex;gap:20px;justify-content:center;margin-top:30px;flex-wrap:wrap;}
.form-card{width:380px;background:#fff;border-radius:14px;padding:28px;box-shadow:0 25px 40px rgba(0,0,0,.08);}
.form-card h2{text-align:center;margin-bottom:22px;color:#0a1f44;}
.field{margin-bottom:14px;}
label{font-size:12px;font-weight:600;margin-bottom:4px;display:block;}
input,select,textarea{width:100%;padding:9px 12px;border-radius:8px;border:1px solid #d0d5dd;font-size:13px;}
textarea{resize:none;}
.btn{margin-top:10px;width:100%;padding:9px;background:#0a1f44;border:none;border-radius:8px;color:#fff;font-size:14px;cursor:pointer;}
.btn:hover{background:#081a39;}

/* TABLE */
.table-container {flex:1;min-width:600px;max-width:900px;background:#fff;border-radius:14px;padding:15px;box-shadow:0 20px 30px rgba(0,0,0,.08);}
table{width:100%;border-collapse: collapse;font-size: 13px;}
th, td{border:1px solid #ccc;padding:6px 8px;text-align:left;}
th{background:#0a1f44;color:#fff;}
.edit-btn{background:#ffc107;color:#000;padding:3px 6px;border:none;border-radius:6px;cursor:pointer;font-size:12px;}
.edit-btn:hover{background:#e0a800;}
.clear-btn{background:#dc3545;color:#fff;padding:3px 6px;border:none;border-radius:6px;cursor:pointer;font-size:12px;margin-top:5px;}
.clear-btn:hover{background:#b02a37;}
</style>
</head>

<body>
<div class="header">
    <div>
        <h1>Letter Handling</h1>
        <small><?= htmlspecialchars($user['dsname'] ?? '') ?> | <?= htmlspecialchars($user['section_name'] ?? '') ?> | <?= htmlspecialchars($_SESSION['role'] ?? '') ?></small>
    </div>
    <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-container">
    <!-- LEFT FORM -->
    <div class="form-card">
        <h2>New Outgoing Letter</h2>
        <form method="POST" id="letterForm">
            <input type="hidden" name="edit_id" id="edit_id">
            <div class="field">
                <label>Subject</label>
                <input type="text" name="subject" id="subject" required>
            </div>
            <div class="field">
                <label>File Number</label>
                <input type="text" name="file_no" id="file_no" required>
            </div>
            <div class="field">
                <label>Recipient Name</label>
                <input type="text" name="recipient" id="recipient" required>
            </div>
            <div class="field">
                <label>Recipient Address</label>
                <textarea name="address" id="address" rows="3" required></textarea>
            </div>
            <div class="field">
                <label>Post Type</label>
                <select name="post_type" id="post_type" required>
                    <option value="">Select</option>
                    <option value="Normal">Normal Post</option>
                    <option value="Registered">Registered Post</option>
                </select>
            </div>
            <button class="btn"><i class="fas fa-paper-plane"></i> Submit</button>
            <button type="button" class="clear-btn" id="clearFormBtn"><i class="fas fa-eraser"></i> Clear Form</button>
        </form>
    </div>

    <!-- RIGHT TABLE -->
    <div class="table-container">
        <h2>All Letters (History)</h2>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>File No</th>
                    <th>Recipient</th>
                    <th>Post Type</th>
                    <th>Created At</th>
                    <th>Edit Today</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($letters)): ?>
                    <?php foreach($letters as $l): ?>
                    <tr>
                        <td><?= htmlspecialchars($l['subject'] ?? '') ?></td>
                        <td><?= htmlspecialchars($l['file_number'] ?? '') ?></td>
                        <td><?= htmlspecialchars($l['recipient_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($l['post_type'] ?? '') ?></td>
                        <td><?= htmlspecialchars($l['created_at'] ?? '') ?></td>
                        <td>
                            <?php if(date('Y-m-d', strtotime($l['created_at'])) == date('Y-m-d')): ?>
                            <button class="edit-btn" onclick='editLetter(<?= json_encode($l) ?>)'>Edit</button>
                            <?php else: ?>
                            -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No letters found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($success): ?>
<script>
Swal.fire({icon:'success',title:'Saved',text:'Letter details saved successfully',confirmButtonColor:'#0a1f44'});
</script>
<?php endif; ?>

<script>
function editLetter(letter){
    document.getElementById('edit_id').value = letter.id;
    document.getElementById('subject').value = letter.subject;
    document.getElementById('file_no').value = letter.file_number;
    document.getElementById('recipient').value = letter.recipient_name;
    document.getElementById('address').value = letter.recipient_address;
    document.getElementById('post_type').value = letter.post_type;
    window.scrollTo({top:0,behavior:'smooth'});
}

// Clear form functionality
document.getElementById('clearFormBtn').addEventListener('click', function(){
    document.getElementById('letterForm').reset();
    document.getElementById('edit_id').value = '';
});
</script>
</body>
</html>