<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: ../../index.php');
    exit();
}

$contact_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ? AND user_id = ?");
    $stmt->execute([$contact_id, $user_id]);
    $contact = $stmt->fetch();

    if (!$contact) {
        $_SESSION['error'] = "Kontak tidak ditemukan atau Anda tidak memiliki akses.";
        header('Location: ../../index.php');
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kontak - MyContacts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <div class="max-w-2xl mx-auto mt-10 px-4">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Edit Kontak</h2>
                <a href="../../index.php" class="text-slate-500 hover:text-blue-600 transition">
                    &larr; Batal
                </a>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="../../actions/contacts/update.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="id" value="<?= htmlspecialchars($contact['id']); ?>">
                <input type="hidden" name="old_photo" value="<?= htmlspecialchars($contact['photo']); ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($contact['name']); ?>" required 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor HP</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($contact['phone']); ?>" required 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($contact['email']); ?>"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Ganti Foto (Opsional)</label>
                    <div class="flex items-center gap-4 mb-2">
                        <?php if ($contact['photo']): ?>
                            <img src="../../public/uploads/<?= htmlspecialchars($contact['photo']); ?>" alt="Current" class="w-12 h-12 rounded-full object-cover border">
                            <span class="text-xs text-slate-500">Foto Saat Ini</span>
                        <?php endif; ?>
                    </div>
                    <input type="file" name="photo" accept=".jpg,.jpeg,.png,.heic"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition shadow-lg">
                        Update Kontak
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>