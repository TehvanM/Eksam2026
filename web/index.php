<?php
require_once 'includes/header.php';
$success = $error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi      = trim($_POST['nimi']      ?? '');
    $osakond   = trim($_POST['osakond']   ?? '');
    $kontakt   = trim($_POST['kontakt']   ?? '');
    $kirjeldus = trim($_POST['kirjeldus'] ?? '');


    // Valideerimine – tühjad väljad keelatud
    if (!$nimi || !$osakond || !$kontakt || !$kirjeldus) {
        $error = 'Kõik väljad on kohustuslikud!';
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO poordumised (nimi,osakond,kontakt,kirjeldus) VALUES (?,?,?,?)'
        );
        $stmt->execute([$nimi, $osakond, $kontakt, $kirjeldus]);
        $success = 'Pöördumine on edukalt esitatud!';
    }
}
?>


<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>


<div class="row justify-content-center">
 <div class="col-md-8">
  <div class="card shadow">
   <div class="card-header bg-primary text-white">
     <h2 class="h5 mb-0">Esita IT-probleem</h2>
   </div>
   <div class="card-body">
    <form method="post" novalidate>
     <div class="mb-3">
       <label class="form-label fw-bold">Nimi *</label>
       <input type="text" name="nimi" class="form-control" required>
     </div>
     <div class="mb-3">
       <label class="form-label fw-bold">Osakond *</label>
       <input type="text" name="osakond" class="form-control" required>
     </div>
     <div class="mb-3">
       <label class="form-label fw-bold">Kontakt (e-post/telefon) *</label>
       <input type="text" name="kontakt" class="form-control" required>
     </div>
     <div class="mb-3">
       <label class="form-label fw-bold">Probleemi kirjeldus *</label>
       <textarea name="kirjeldus" class="form-control" rows="5" required></textarea>
     </div>
     <button type="submit" class="btn btn-primary">Saada</button>
    </form>
   </div>
  </div>
 </div>
</div>
<?php require_once 'includes/footer.php'; ?>
