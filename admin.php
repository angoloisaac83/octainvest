<?php
include 'config.php';
// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-5">
        <h1 class="text-2xl font-bold mb-5">Admin Dashboard</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Balance</th>
                        <th class="py-2 px-4 border-b">Profit</th>
                        <th class="py-2 px-4 border-b">Deposit</th>
                        <th class="py-2 px-4 border-b">Bonus</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="text-center">
                                <td class="py-2 px-4 border-b"><?php echo $row['id']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $row['first-name']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $row['email']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $row['balance']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $row['profit']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $row['Deposited']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo $row['bonus']; ?></td>
                                <td class="py-2 px-4 border-b">
                                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="text-blue-500">Edit</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="py-2 px-4 border-b text-center">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>