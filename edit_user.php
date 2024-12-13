<?php
include 'config.php';

// Fetch user details if ID is provided
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    die("User ID not provided.");
}

// Update user details if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $balance = $_POST['balance'];
    $profit = $_POST['profit'];
    $deposit = $_POST['deposit'];
    $bonus = $_POST['bonus'];

    $stmt = $conn->prepare("UPDATE users SET `first-name` = ?, balance = ?, profit = ?, Deposited = ?, bonus = ? WHERE id = ?");
    $stmt->bind_param("sddssi", $name, $balance, $profit, $deposit, $bonus, $userId);
    
    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating user.');</script>";
    }
    $stmt->close();
}

// Fetch pending transactions from JSON file
$jsonFile = 'data.json';
$transactions = json_decode(file_get_contents($jsonFile), true);

// Filter pending transactions for the user being edited
$pendingTransactions = array_filter($transactions, function($transaction) use ($user) {
    return $transaction['email'] === $user['email'] && $transaction['status'] === 'pending';
});

// Approve or delete transactions
if (isset($_GET['action']) && isset($_GET['trans_id'])) {
    $transactionId = $_GET['trans_id'];
    
    if ($_GET['action'] === 'approve') {
        foreach ($transactions as &$transaction) {
            if ($transaction['ID'] == $transactionId) {
                $transaction['status'] = 'Completed'; // Approving the transaction
                break;
            }
        }
        file_put_contents($jsonFile, json_encode($transactions));
    } elseif ($_GET['action'] === 'delete') {
        $transactions = array_filter($transactions, function($transaction) use ($transactionId) {
            return $transaction['ID'] != $transactionId; // Deleting the transaction
        });
        file_put_contents($jsonFile, json_encode($transactions));
    }

    header("Location: edit_user.php?id=" . $userId);
    exit();
}

// Filter active transactions
$activeTransactions = array_filter($transactions, function($transaction) use ($user) {
    return $transaction['email'] === $user['email'] && $transaction['status'] === 'Completed';
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;700&display=swap');
        * {
            font-family: "Open Sans", sans-serif;
        }
        .bg-primary {
            background-color: #4a90e2; /* Primary color */
        }
        .btn {
            background-color: #4a90e2;
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #357ABD; /* Darker shade on hover */
        }
        .table-header {
            text-align: center;
            background-color: #f3f4f6; /* Light gray for header */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-5">
        <h1 class="text-3xl font-bold mb-5 text-primary">Edit User</h1>
        <form method="POST" class="bg-white p-5 rounded-lg shadow mb-5">
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['first-name']); ?>" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-primary" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Balance</label>
                <input type="number" name="balance" value="<?php echo htmlspecialchars($user['balance']); ?>" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-primary" step="0.01" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Profit</label>
                <input type="number" name="profit" value="<?php echo htmlspecialchars($user['profit']); ?>" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-primary" step="0.01" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Deposit</label>
                <input type="number" name="deposit" value="<?php echo htmlspecialchars($user['Deposited']); ?>" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-primary" step="0.01" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Bonus</label>
                <input type="number" name="bonus" value="<?php echo htmlspecialchars($user['bonus']); ?>" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-primary" step="0.01" required>
            </div>
            <button type="submit" class="btn px-4 py-2 rounded">Update User</button>
        </form>

        <h2 class="text-2xl font-bold mb-5 text-primary">Pending Transactions</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 mb-5 rounded-lg overflow-hidden shadow-lg">
                <thead class="text-center">
                    <tr class="table-header text-center">
                        <th class="py-3 px-4 border-b text-left">ID</th>
                        <th class="py-3 px-4 border-b text-left">Email</th>
                        <th class="py-3 px-4 border-b text-left">Amount</th>
                        <th class="py-3 px-4 border-b text-left">Payment Mode</th>
                        <th class="py-3 px-4 border-b text-left">Date</th>
                        <th class="py-3 px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pendingTransactions) > 0): ?>
                        <?php foreach ($pendingTransactions as $transaction): ?>
                            <tr class="text-center">
                                <td class="py-2 px-4 border-b"><?php echo $transaction['ID']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($transaction['email']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($transaction['paymentmode']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($transaction['date']); ?></td>
                                <td class="py-2 px-4 border-b">
                                    <a href="?id=<?php echo $userId; ?>&action=approve&trans_id=<?php echo $transaction['ID']; ?>" class="text-green-500 hover:text-green-700 mr-2">Approve</a>
                                    <a href="?id=<?php echo $userId; ?>&action=delete&trans_id=<?php echo $transaction['ID']; ?>" class="text-red-500 hover:text-red-700">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-2 px-4 border-b text-center">No pending transactions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-bold mb-5 text-primary">Active Transactions</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 mb-5 rounded-lg overflow-hidden shadow-lg">
                <thead>
                    <tr style="text-align: center;" class="table-header text-center">
                        <th class="py-3 px-4 border-b text-left">ID</th>
                        <th class="py-3 px-4 border-b text-left">Email</th>
                        <th class="py-3 px-4 border-b text-left">Amount</th>
                        <th class="py-3 px-4 border-b text-left">Payment Mode</th>
                        <th class="py-3 px-4 border-b text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($activeTransactions) > 0): ?>
                        <?php foreach ($activeTransactions as $transaction): ?>
                            <tr class="text-center">
                                <td class="py-2 px-4 border-b"><?php echo $transaction['ID']; ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($transaction['email']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($transaction['paymentmode']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($transaction['date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-2 px-4 border-b text-center">No active transactions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>