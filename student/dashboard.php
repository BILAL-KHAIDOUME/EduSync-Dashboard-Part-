<?php
session_start();
require 'config.php';

$user_id = $_SESSION['user_id'];

// Profil
$stmt = $conn->prepare("
    SELECT users.firstname, users.lastname, users.email, classes.name AS classe
    FROM users
    INNER JOIN students ON students.user_id = users.id
    INNER JOIN classes ON classes.id = students.class_id
    WHERE users.id = :x
");
$stmt->execute([':x' => $user_id]);
$user = $stmt->fetch();

$stmt = $conn->prepare("
    SELECT courses.title, users.firstname AS prof_name
    FROM enrollments
    INNER JOIN courses ON enrollments.course_id = courses.id
    INNER JOIN users ON courses.professor_id = users.id
    WHERE enrollments.student_id = (
        SELECT id FROM students WHERE user_id = ?
    )
");
$stmt->execute([$user_id]);
$courses = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Étudiant</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
<div class="flex">

  
  <aside class="w-64 bg-blue-700 text-white min-h-screen p-5 fixed">
    <h2 class="text-xl font-bold mb-6">Student Dashboard</h2>
    <nav class="space-y-3 text-sm">
      <a href="#profile"    class="block p-2 rounded hover:bg-blue-600">Mon Profil</a>
      <a href="#courses"    class="block p-2 rounded hover:bg-blue-600">Mes Cours</a>
      <a href="#classmates" class="block p-2 rounded hover:bg-blue-600">Ma Classe</a>
      <a href="#modules"    class="block p-2 rounded hover:bg-blue-600">Modules</a>
    </nav>
    <div class="absolute bottom-5 left-5 right-5">
      <a href="logout.php" class="block text-center bg-red-500 hover:bg-red-600 text-white text-sm p-2 rounded">
        Se déconnecter
      </a>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="ml-64 flex-1 p-6 space-y-10">

    <!-- HEADER -->
    <div>
      <h1 class="text-2xl font-bold">Dashboard Étudiant</h1>
      <p class="text-gray-500 text-sm">Espace personnel et suivi académique</p>
    </div>

    <!-- PROFIL -->
    <section id="profile" class="bg-white p-5 rounded-lg shadow">
      <h2 class="font-bold mb-4">Mon Profil Académique</h2>
      <div class="grid md:grid-cols-2 gap-4 text-sm">
        <div>
          <p><strong>Nom :</strong> <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></p>
          <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>
        <div>
          <p><strong>Classe :</strong> <?= htmlspecialchars($user['classe']) ?></p>
          <p><strong>Statut :</strong> Étudiant</p>
        </div>
      </div>
    </section>

    <!-- COURS -->
    <section id="courses" class="bg-white p-5 rounded-lg shadow">
      <h2 class="font-bold mb-4">Mon Programme</h2>
      <table class="w-full text-sm">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 text-left">Cours</th>
            <th class="p-2 text-left">Professeur</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($courses as $course): ?>
          <tr class="border-t">
            <td class="p-2"><?= htmlspecialchars($course['title']) ?></td>
            <td class="p-2"><?= htmlspecialchars($course['prof_name']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
