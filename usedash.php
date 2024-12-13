<?php
include 'config.php';

$email = $_SESSION['email'];
$sql = "SELECT * FROM `users` WHERE `email` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Octa Invest Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;700&display=swap');
        
        * {
            font-family: "Open Sans", sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-gray-800 w-64 h-screen p-4 fixed inset-y-0 left-0 transition-transform transform -translate-x-full md:translate-x-0">
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
        <div class="flex-1 p-6 md:ml-64">
            <button id="hamburger" class="md:hidden text-white mb-4">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-gray-700 p-4 rounded flex items-center justify-between">
                    <div>
                        <h3 class="text-lg">Deposited</h3>
                        <p>$<?php echo htmlspecialchars($row['Deposited']); ?>.00</p>
                    </div>
                    <i class="fas fa-wallet text-green-500 text-2xl"></i>
                </div>
                <div class="bg-gray-700 p-4 rounded flex items-center justify-between">
                    <div>
                        <h3 class="text-lg">Profit</h3>
                        <p>$<?php echo htmlspecialchars($row['profit']); ?>.00</p>
                    </div>
                    <i class="fas fa-chart-line text-blue-500 text-2xl"></i>
                </div>
                <div class="bg-gray-700 p-4 rounded flex items-center justify-between">
                    <div>
                        <h3 class="text-lg">Bonus</h3>
                        <p>$<?php echo htmlspecialchars($row['bonus']); ?>.00</p>
                    </div>
                    <i class="fas fa-gift text-yellow-500 text-2xl"></i>
                </div>
                <div class="bg-gray-700 p-4 rounded flex items-center justify-between">
                    <div>
                        <h3 class="text-lg">Ref. Bonus</h3>
                        <p>$<?php echo htmlspecialchars($row['refbonus']); ?>.00</p>
                    </div>
                    <i class="fas fa-user-friends text-purple-500 text-2xl"></i>
                </div>
                <div class="bg-gray-700 p-4 rounded flex items-center justify-between">
                    <div>
                        <h3 class="text-lg">Balance</h3>
                        <p>$<?php echo htmlspecialchars($row['balance']); ?>.00</p>
                    </div>
                    <i class="fas fa-wallet text-green-500 text-2xl"></i>
                </div>
                <div class="bg-gray-700 p-4 rounded mb-6">
                    <h3 class="text-lg">Active Packages</h3>
                    <p class="text-xl font-bold"><?php echo htmlspecialchars($row['activepack']); ?></p>
                </div>
            </div>
            <div class="bg-gray-700 p-4 rounded">
                <h3 class="text-lg">Indicators</h3>
                <div class="bg-black h-64 mt-2">
                    <canvas id="myChart" class="h-full"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
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

        // Fetch live Bitcoin data and update the chart
        async function fetchBitcoinData() {
            const response = await fetch('https://api.coingecko.com/api/v3/coins/bitcoin/market_chart?vs_currency=usd&days=1&interval=hourly');
            const data = await response.json();
            const prices = data.prices.map(price => price[1]);
            const timestamps = data.prices.map(price => new Date(price[0]).toLocaleTimeString());

            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: timestamps,
                    datasets: [{
                        label: 'Bitcoin Price (USD)',
                        data: prices,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'hour'
                            }
                        },
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        }

        fetchBitcoinData();
    </script>

</body>
</html>
<?php
}
?>