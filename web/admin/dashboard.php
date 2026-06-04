<?php
session_start();
require_once '../config/db.php';


// Autentimine – ainult sisselogitud admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php'); exit;
}


// ---- KUSTUTA ----
if (isset($_GET['kustuta'])) {
    $stmt = $pdo->prepare('DELETE FROM poordumised WHERE id=?');
    $stmt->execute([(int)$_GET['kustuta']]);
    header('Location: dashboard.php'); exit;
}


// ---- MUUDA STAATUST ----
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['staatus_id'])) {
    $stmt = $pdo->prepare('UPDATE poordumised SET staatus=? WHERE id=?');
    $stmt->execute([$_POST['staatus'], (int)$_POST['staatus_id']]);
    header('Location: dashboard.php'); exit;
}


// ---- LISA UUS ----
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['uus_nimi'])) {
    $stmt = $pdo->prepare(
        'INSERT INTO poordumised (nimi,osakond,kontakt,kirjeldus) VALUES (?,?,?,?)'
    );
    $stmt->execute([
        $_POST['uus_nimi'], $_POST['uus_osakond'],
        $_POST['uus_kontakt'], $_POST['uus_kirjeldus']
    ]);
    header('Location: dashboard.php'); exit;
}


// ---- LOE KÕIK ----
$poordumised = $pdo->query(
    'SELECT * FROM poordumised ORDER BY loodud DESC'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="UTF-8"><title>Admin Dashboard</title>
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">Admin Dashboard</span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Logi välja</a>
  </div>
</nav>
<div class="container mt-4">


<!-- LISA UUS PÖÖRDUMINE -->
<div class="card mb-4">
 <div class="card-header bg-success text-white">Lisa uus pöördumine</div>
 <div class="card-body">
  <form method="post" class="row g-2">
   <div class="col-md-3">
     <input type="text" name="uus_nimi" class="form-control" placeholder="Nimi" required>
   </div>
   <div class="col-md-3">
     <input type="text" name="uus_osakond" class="form-control" placeholder="Osakond" required>
   </div>
   <div class="col-md-3">
     <input type="text" name="uus_kontakt" class="form-control" placeholder="Kontakt" required>
   </div>
   <div class="col-md-3">
     <input type="text" name="uus_kirjeldus" class="form-control" placeholder="Kirjeldus" required>
   </div>
   <div class="col-12">
     <button type="submit" class="btn btn-success">Lisa</button>
   </div>
  </form>
 </div>
</div>


<!-- PÖÖRDUMISTE TABEL -->
<h5>Kõik pöördumised (<?= count($poordumised) ?>)</h5>
<table class="table table-striped table-bordered">
<thead class="table-dark">
  <tr>
    <th>ID</th><th>Nimi</th><th>Osakond</th><th>Kontakt</th>
    <th>Kirjeldus</th><th>Staatus</th><th>Loodud</th><th>Tegevus</th>
  </tr>
</thead>
<tbody>
<?php foreach($poordumised as $p): ?>
<tr>
  <td><?= $p['id'] ?></td>
  <td><?= htmlspecialchars($p['nimi']) ?></td>
  <td><?= htmlspecialchars($p['osakond']) ?></td>
  <td><?= htmlspecialchars($p['kontakt']) ?></td>
  <td><?= htmlspecialchars(substr($p['kirjeldus'],0,50)) ?>...</td>
  <td>
    <form method="post" class="d-flex gap-1">
      <input type="hidden" name="staatus_id" value="<?= $p['id'] ?>">
      <select name="staatus" class="form-select form-select-sm">
        <option value="uus" <?= $p['staatus']==='uus'?'selected':'' ?>>Uus</option>
        <option value="menetluses" <?= $p['staatus']==='menetluses'?'selected':'' ?>>Menetluses</option>
        <option value="lahendatud" <?= $p['staatus']==='lahendatud'?'selected':'' ?>>Lahendatud</option>
      </select>
      <button type="submit" class="btn btn-warning btn-sm">Muuda</button>
    </form>
  </td>
  <td><?= $p['loodud'] ?></td>
  <td>
    <a href="dashboard.php?kustuta=<?= $p['id'] ?>"
       onclick="return confirm('Kustuta?')"
       class="btn btn-danger btn-sm">Kustuta</a>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</body></html>
