<?php
session_start();
include '../scripts/database.php';



// --- ADD USER ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {

    $firstname = $_POST['firstname'] ?? null;
    $lastname  = $_POST['lastname']  ?? null;
    $email     = $_POST['email']     ?? null;
    $password  = $_POST['password']  ?? null;
    $roles_id  = $_POST['roles_id']  ?? null;

    
    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        die("A user with this email already exists.");
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("
            INSERT INTO users (firstname, lastname, email, password, roles_id) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$firstname, $lastname, $email, $hashedPassword, $roles_id]);

        header("Location: admin_dashboard.php#users");
        exit();

    } catch (PDOException $e) {
        die("Failed to add user: " . $e->getMessage());
    }
}

// --- EDIT ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_save'])) {

    $id        = $_POST['user_id']   ?? null;
    $firstname = $_POST['firstname'] ?? null;
    $lastname  = $_POST['lastname']  ?? null;
    $email     = $_POST['email']     ?? null;
    $roles_id  = $_POST['roles_id']  ?? null;

    if (!$id) die("No user ID provided.");

    try {
        $stmt = $conn->prepare("
            UPDATE users 
            SET firstname = ?, lastname = ?, email = ?, roles_id = ?
            WHERE id = ?
        ");
        $stmt->execute([$firstname, $lastname, $email, $roles_id, $id]);

        header("Location: admin_dashboard.php");
        exit();

    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    $id = $_POST['user_id'] ?? null;

    if (!$id) {
        die("No user ID provided.");
    }

    try {
        $conn->beginTransaction();

        // 1. Delete enrollments linked to this user's students records
        $conn->prepare("
            DELETE enrollments FROM enrollments 
            INNER JOIN students ON enrollments.students_id = students.id 
            WHERE students.users_id = ?
        ")->execute([$id]);

        // 2. Delete enrollments linked to this user's courses
        $conn->prepare("
            DELETE enrollments FROM enrollments 
            INNER JOIN courses ON enrollments.courses_id = courses.id 
            WHERE courses.user_id = ?
        ")->execute([$id]);

        // 3. Delete students record linked to this user
        $conn->prepare("DELETE FROM students WHERE users_id = ?")->execute([$id]);

        // 4. Delete courses created by this user
        $conn->prepare("DELETE FROM courses WHERE user_id = ?")->execute([$id]);

        // 5. Finally delete the user
        $conn->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);

        $conn->commit();
        header("Location: admin_dashboard.php");
        exit();

    } catch (PDOException $e) {
        $conn->rollBack();
        die("Deletion failed: " . $e->getMessage());
    }
}








?>







