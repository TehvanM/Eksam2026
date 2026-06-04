<?php
session_start();
require_once '../config/db.php';
$error = '';


if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php'); exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kasutajanimi = trim($_POST['kasutajanimi'] ?? '');
    $parool       = $_POST['parool'] ?? '';


    $stmt = $pdo->prepare('SELECT * FROM admin_kasutajad WHERE kasutajanimi=?');
    $stmt->execute([$kasutajanimi]);
    $admin = $stmt->fetch();


    // Kontroll hashitud parooliga
    if ($admin && password_verify($parool, $admin['parool_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_kasutajanimi'] = $admin['kasutajanimi'];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Vale kasutajanimi või parool!';
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="UTF-8">
  <title>Admin login</title>
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
 <div class="row justify-content-center">
  <div class="col-md-5">
   <div class="card shadow">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0">Admin sisselogimine</h4>
    </div>
    <div class="card-body">
     <?php if ($error): ?>
       <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
     <?php endif; ?>
     <form method="post">
       <div class="mb-3">
         <label class="form-label">Kasutajanimi</label>
         <input type="text" name="kasutajanimi" class="form-control" required>
       </div>
       <div class="mb-3">
         <label class="form-label">Parool</label>
         <input type="password" name="parool" class="form-control" required>
       </div>
       <button type="submit" class="btn btn-dark w-100">Logi sisse</button>
     </form>
    </div>
   </div>
  </div>
 </div>
</div>
</body></html>
