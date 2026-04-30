<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

  <div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-700 text-white min-h-screen p-5 fixed">
      <h2 class="text-xl font-bold mb-6">Admin Dashboard</h2>

      <nav class="space-y-3 text-sm">
        <a href="#users" class="nav-link block p-2 rounded hover:bg-blue-600">Utilisateurs</a>
        <a href="#classes" class="nav-link block p-2 rounded hover:bg-blue-600">Classes</a>
        <a href="#courses" class="nav-link block p-2 rounded hover:bg-blue-600">Cours</a>
        <a href="#enrollments" class="nav-link block p-2 rounded hover:bg-blue-600">Inscriptions</a>
        <a href="#stats" class="nav-link block p-2 rounded hover:bg-blue-600">Statistiques</a>
      </nav>
    </aside>

    <!-- MAIN -->
    <main class="ml-64 flex-1 p-6 space-y-10">

      <!-- HEADER -->
      <div>
        <h1 class="text-2xl font-bold">Dashboard Administrateur</h1>
        <p class="text-gray-500 text-sm">Gestion globale de l’établissement</p>
      </div>

      <!-- GLOBAL STATS (US19) -->
      <section id="stats" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
          <p class="text-sm text-gray-500">Étudiants</p>
          <h2 class="text-xl font-bold">120</h2>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
          <p class="text-sm text-gray-500">Professeurs</p>
          <h2 class="text-xl font-bold">10</h2>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
          <p class="text-sm text-gray-500">Cours</p>
          <h2 class="text-xl font-bold">8</h2>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
          <p class="text-sm text-gray-500">Classes</p>
          <h2 class="text-xl font-bold">5</h2>
        </div>
      </section>

      <!-- US15 : Gestion des Comptes -->
      <section id="users" class="bg-white p-5 rounded-lg shadow">
        <h2 class="font-bold mb-4">Gestion des Comptes</h2>

        <button type="button" onclick="openAddModal()" class="bg-blue-600 text-white px-4 py-2 rounded text-sm mb-4">
          + Ajouter Utilisateur
        </button>

        <table class="w-full text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-2 text-left">Nom</th>
              <th class="p-2 text-left">Email</th>
              <th class="p-2 text-left">Rôle</th>
              <th class="p-2 text-left">Actions</th>
            </tr>
          </thead>

          <?php
          require '../scripts/database.php';
          $stmt = $conn->query("SELECT users.id AS user_id, users.firstname, users.email, roles.label ,users.roles_id 
                      FROM users 
                      LEFT JOIN roles ON users.roles_id = roles.id");
          $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $roles = $conn->query("SELECT * FROM roles")->fetchAll(PDO::FETCH_ASSOC);
          ?>

          <tbody>
            <?php if (!empty($users)): ?>
              <?php foreach ($users as $user): ?>
                <?php



                ?>
                <tr class="border-t">
                  <td class="p-2"><?php echo $user['firstname']; ?></td>
                  <td class="p-2"><?php echo $user['email']; ?></td>
                  <td class="p-2"><?php echo $user['label']; ?></td>
                  <td class="p-2 space-x-2">

                    <form action="gestiondescomptes.php" method="post">

                      <button type="button" onclick="openEditModal(this)"
                        data-id="<?php echo $user['user_id']; ?>"
                        data-firstname="<?php echo htmlspecialchars($user['firstname'] ?? '', ENT_QUOTES); ?>"
                        data-lastname="<?php echo htmlspecialchars($user['lastname'] ?? '', ENT_QUOTES); ?>"
                        data-email="<?php echo htmlspecialchars($user['email'] ?? '', ENT_QUOTES); ?>"
                        data-role="<?php echo $user['roles_id'] ?? ''; ?>"
                        class="bg-yellow-400 px-2 py-1 rounded text-xs">Edit</button>

                    </form>
                    <form action="gestiondescomptes.php" method="post">
                      <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                      <button type="submit" name="delete" class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                        Delete
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="p-2 text-center">No users found</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </section>

      <!-- US16 : Classes -->
      <section id="classes" class="bg-white p-5 rounded-lg shadow">
        <h2 class="font-bold mb-4">Structure Académique</h2>

        <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm mb-4">
          + Ajouter Classe
        </button>

        <table class="w-full text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-2 text-left">ID</th>
              <th class="p-2 text-left">Nom</th>
              <th class="p-2 text-left">Salle</th>
            </tr>
          </thead>

          <tbody>
            <tr class="border-t">
              <td class="p-2">1</td>
              <td class="p-2">L2 INFO</td>
              <td class="p-2">205</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- US17 : Cours -->
      <section id="courses" class="bg-white p-5 rounded-lg shadow">
        <h2 class="font-bold mb-4">Gestion des Cours</h2>

        <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm mb-4">
          + Ajouter Cours
        </button>

        <table class="w-full text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-2 text-left">Cours</th>
              <th class="p-2 text-left">Professeur</th>
            </tr>
          </thead>

          <tbody>
            <tr class="border-t">
              <td class="p-2">Développement Web</td>
              <td class="p-2">Mr. Ali</td>
            </tr>
          </tbody>
        </table>
      </section>


      <!-- US18 : Inscriptions -->
      <section id="enrollments" class="bg-white p-5 rounded-lg shadow">
        <h2 class="font-bold mb-4">Administration des Inscriptions</h2>

        <form class="grid md:grid-cols-3 gap-3 mb-4">
          <input type="text" placeholder="Étudiant" class="border p-2 rounded text-sm">
          <input type="text" placeholder="Cours" class="border p-2 rounded text-sm">
          <button class="bg-green-600 text-white rounded text-sm">Inscrire</button>
        </form>

        <table class="w-full text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-2 text-left">Étudiant</th>
              <th class="p-2 text-left">Cours</th>
              <th class="p-2 text-left">Statut</th>
            </tr>
          </thead>

          <tbody>
            <tr class="border-t">
              <td class="p-2">Amina</td>
              <td class="p-2">Web</td>
              <td class="p-2 text-green-600">Actif</td>
            </tr>
          </tbody>
        </table>
      </section>

    </main>
  </div>

  <!-- ACTIVE LINK SCRIPT -->
  <script>
    const links = document.querySelectorAll('.nav-link');

    links.forEach(link => {
      link.addEventListener('click', function() {
        links.forEach(l => l.classList.remove('bg-blue-900'));
        this.classList.add('bg-blue-900');
      });
    });
  </script>

  <!-- Edit Modal -->
  <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
      <h2 class="text-lg font-semibold mb-4">Edit User</h2>
      <form action="gestiondescomptes.php" method="post">
        <input type="hidden" name="user_id" id="edit_user_id">

        <div class="mb-3">
          <label class="block text-sm font-medium mb-1">First Name</label>
          <input type="text" name="firstname" id="edit_firstname"
            class="w-full border rounded px-3 py-2 text-sm" required>
        </div>

        <div class="mb-3">
          <label class="block text-sm font-medium mb-1">Last Name</label>
          <input type="text" name="lastname" id="edit_lastname"
            class="w-full border rounded px-3 py-2 text-sm" required>
        </div>

        <div class="mb-3">
          <label class="block text-sm font-medium mb-1">Email</label>
          <input type="email" name="email" id="edit_email"
            class="w-full border rounded px-3 py-2 text-sm" required>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Role</label>
          <select name="roles_id" id="edit_role" class="w-full border rounded px-3 py-2 text-sm">
            <?php foreach ($roles as $role): ?>
              <option value="<?php echo $role['id']; ?>">
                <?php echo htmlspecialchars($role['label']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeEditModal()"
            class="px-4 py-2 text-sm rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
          <button type="submit" name="edit_save"
            class="px-4 py-2 text-sm rounded bg-blue-500 text-white hover:bg-blue-600">Save</button>
        </div>
      </form>
    </div>
  </div>

  <button
    onclick="openEditModal(this)"
    data-id="<?php echo $user['user_id']; ?>"
    data-firstname="<?php echo htmlspecialchars($user['firstname'] ?? '', ENT_QUOTES); ?>"
    data-lastname="<?php echo htmlspecialchars($user['lastname'] ?? '', ENT_QUOTES); ?>"
    data-email="<?php echo htmlspecialchars($user['email'] ?? '', ENT_QUOTES); ?>"
    data-role="<?php echo $user['roles_id'] ?? ''; ?>"
    class="bg-yellow-400 px-2 py-1 rounded text-xs">
    Edit
  </button>
  <script>
    function openEditModal(btn) {
      document.getElementById('edit_user_id').value = btn.dataset.id;
      document.getElementById('edit_firstname').value = btn.dataset.firstname;
      document.getElementById('edit_lastname').value = btn.dataset.lastname;
      document.getElementById('edit_email').value = btn.dataset.email;
      document.getElementById('edit_role').value = btn.dataset.role;
      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }

    document.getElementById('editModal').addEventListener('click', function(e) {
      if (e.target === this) closeEditModal();
    });

    function openAddModal() {
      document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
      document.getElementById('addModal').classList.add('hidden');
    }

    document.getElementById('addModal').addEventListener('click', function(e) {
      if (e.target === this) closeAddModal();
    });
  </script>
  <!-- Add User Modal -->
  <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
      <h2 class="text-lg font-semibold mb-4">Ajouter Utilisateur</h2>
      <form action="gestiondescomptes.php" method="post">

        <div class="mb-3">
          <label class="block text-sm font-medium mb-1">First Name</label>
          <input type="text" name="firstname"
            class="w-full border rounded px-3 py-2 text-sm" required>
        </div>

        <div class="mb-3">
          <label class="block text-sm font-medium mb-1">Last Name</label>
          <input type="text" name="lastname"
            class="w-full border rounded px-3 py-2 text-sm" required>
        </div>

        <div class="mb-3">
          <label class="block text-sm font-medium mb-1">Email</label>
          <input type="email" name="email"
            class="w-full border rounded px-3 py-2 text-sm" required>
        </div>

        <div class="mb-3">
          <label class="block text-sm font-medium mb-1">Password</label>
          <input type="password" name="password"
            class="w-full border rounded px-3 py-2 text-sm" required>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Role</label>
          <select name="roles_id" class="w-full border rounded px-3 py-2 text-sm">
            <?php foreach ($roles as $role): ?>
              <option value="<?php echo $role['id']; ?>">
                <?php echo htmlspecialchars($role['label']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeAddModal()"
            class="px-4 py-2 text-sm rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
          <button type="submit" name="add_user"
            class="px-4 py-2 text-sm rounded bg-green-500 text-white hover:bg-green-600">Add</button>
        </div>

      </form>
    </div>
  </div>

</body>

</html>