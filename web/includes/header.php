<?php
session_start();
require_once __DIR__.'/../config/db.php';
?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kasutajatugi</title>
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<!-- BÄNNER -->
<div class="bg-primary text-white py-4 mb-0">
  <div class="container d-flex align-items-center gap-3">
    <img src="/kasutajatugi/img/it_support.png" alt="IT" height="60">
    <h1 class="mb-0">Kasutajatugi</h1>
  </div>
</div>
<!-- MENÜÜ -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <button class="navbar-toggler" type="button"
      data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/kasutajatugi/">Avaleht</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/kasutajatugi/kkk.php">KKK</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/kasutajatugi/kontaktid.php">Kontaktid</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
