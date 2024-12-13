<?php
include 'config.php';

$email = $_SESSION['email'];

// Use prepared statement for security
$stmt = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Octa Invest Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap');
    * {
        font-family: "Open Sans", sans-serif;
    }
</style>
<body class="bg-gray-900 text-white">

    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" style="z-index: 100;" class="bg-gray-800 w-64 h-fit p-4 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out">
            <h1 class="text-xl font-bold mb-6">Octa Invest</h1>
            <div class="mb-4">
                <p class="text-2xl capitalize py-5">Welcome, <?php echo htmlspecialchars($row['first-name']); ?>!</p>
            </div>
            <nav>
                <ul class="flex flex-col gap-5 pt-10">
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./usedash.php" class="flex items-center hover:text-gray-400"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="#" class="flex items-center hover:text-gray-400"><i class="fas fa-file-alt mr-2"></i> P/L record</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./usertrac.php" class="flex items-center hover:text-gray-400"><i class="fas fa-history mr-2"></i> Transactions history</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./funds.html" class="flex items-center hover:text-gray-400"><i class="fas fa-dollar-sign mr-2"></i> Deposit/Withdraw</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./invplan.html" class="flex items-center hover:text-gray-400"><i class="fas fa-dollar-sign mr-2"></i> Investment Plans</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./userref.php" class="flex items-center hover:text-gray-400"><i class="fas fa-link mr-2"></i> Referral Links</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./accsettings.php" class="flex items-center hover:text-gray-400"><i class="fas fa-gear mr-2"></i> Settings</a></li>
                </ul>
            </nav>
        </div>

        <!-- Overlay -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden"></div>

        <!-- Main Content -->
        <section class="flex-1 p-6 md:ml-64">
            <button id="hamburger" class="md:hidden text-white">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <h2 class="text-2xl font-bold mb-6">Transactions on your account</h2>

            <div class="mb-6">
                <h3 class="text-lg font-bold pb-4">Deposits</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-600">ID</th>
                                <th class="py-2 px-4 border-b border-gray-600">Amount</th>
                                <th class="py-2 px-4 border-b border-gray-600">Payment mode</th>
                                <th class="py-2 px-4 border-b border-gray-600">Status</th>
                                <th class="py-2 px-4 border-b border-gray-600">Date created</th>
                            </tr>
                        </thead>
                        <tbody id="deposits-table-body"></tbody>
                    </table>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-bold pb-4">Withdrawals</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-600">ID</th>
                                <th class="py-2 px-4 border-b border-gray-600">Amount</th>
                                <th class="py-2 px-4 border-b border-gray-600">Payment mode</th>
                                <th class="py-2 px-4 border-b border-gray-600">Status</th>
                                <th class="py-2 px-4 border-b border-gray-600">Date created</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center; text-transform: capitalize;" id="withdrawals-table-body"></tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>

    <script>
        const email = '<?php echo htmlspecialchars($row['email']); ?>';

        function fetchData(email, type, tableBodyId) {
            fetch('data.json')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const filteredData = data.filter(item => item.email === email && item.type === type);
                    const tableBody = document.getElementById(tableBodyId);
                    tableBody.innerHTML = '';

                    if (filteredData.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No data available in table</td></tr>';
                        return;
                    }

                    filteredData.forEach((item, index) => {
                        const row = `
                            <tr style="text-align: center;text-transform: capitalize;">
                                <td class="py-2 px-4 border-b border-gray-600">${index + 1}</td>
                                <td class="py-2 px-4 border-b border-gray-600">$${item.amount}</td>
                                <td class="py-2 px-4 border-b border-gray-600">${item.paymentmode}</td>
                                <td class="${item.status === 'Completed' ? 'text-green-500 py-2 px-4 border-b border-gray-600' : 'text-red-500 py-2 px-4 border-b border-gray-600'}">${item.status}</td>
                                <td class="py-2 px-4 border-b border-gray-600">${item.date}</td>
                            </tr>`;
                            // const row = `
                            //                     <tr class="pl-5">
                            //                         <td class="py-2 px-4 border-b border-gray-600">${deposit.id}</td>
                            //                         <td class="py-2 px-4 border-b border-gray-600">$${deposit.amount}</td>
                            //                         <td class="py-2 px-4 border-b border-gray-600">${deposit.paymentmode}</td>
                            //                         <td class="py-2 px-4 border-b border-gray-600 text-green-500">${deposit.status}</td>
                            //                         <td class="py-2 px-4 border-b border-gray-600">${deposit.date}</td>
                            //                     </tr>`;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                    document.getElementById(tableBodyId).innerHTML = '<tr><td colspan="5" class="text-center">Error loading data</td></tr>';
                });
        }

        fetchData(email, 'deposited', 'deposits-table-body');
        fetchData(email, 'withdrawn', 'withdrawals-table-body');

        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>

</body>
</html>
<?php
}
?>
