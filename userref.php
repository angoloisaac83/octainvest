<?php
include 'config.php';
$email = $_SESSION['email'];
$sql = "SELECT * FROM `users` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);
while ($row = $result->fetch_assoc()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Octa Invest Referrals</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Anek+Devanagari:wght@100..800&family=Faculty+Glyphic&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Orbitron:wght@400..900&family=SUSE:wght@100..800&display=swap');

        *{
          font-family: "Open Sans", sans-serif;
          font-optical-sizing: auto;
          font-weight: 500;
          font-style: normal;
          font-size: 17px;
          font-variation-settings:
            "wdth" 100;
        }
</style>
<body class="bg-gray-900 text-white">

    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" style="z-index: 100;" class="bg-gray-800 w-64 h-fit p-4 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out">
            <h1 class="text-xl font-bold mb-6">Octa Invest</h1>
            <div class="mb-4">
                <p class="text-2xl capitalize py-5">Welcome, angolo!</p>
            </div>
            <nav>
                <ul class="flex flex-col gap-5 pt-10">
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./usedash.php" class="flex items-center hover:text-gray-400"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="#" class="flex items-center hover:text-gray-400"><i class="fas fa-file-alt mr-2"></i> P/L record</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./usertrac.php" class="flex items-center hover:text-gray-400"><i class="fas fa-history mr-2"></i> Transactions history</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./funds.html" class="flex items-center hover:text-gray-400"><i class="fas fa-dollar-sign mr-2"></i> Deposit/Withdraw</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./invplan.html" class="flex items-center hover:text-gray-400"><i class="fas fa-dollar-sign mr-2"></i> Investment Plans</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="#" class="flex items-center hover:text-gray-400"><i class="fas fa-link mr-2"></i> Referral Links</a></li>
                    <li class="mb-2 pb-3 border-b-2 border-white"><a href="./accsettings.php" class="flex items-center hover:text-gray-400"><i class="fas fa-gear mr-2"></i> Settings</a></li>
                </ul>
            </nav>
        </div>

        <!-- Overlay -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 p-6 md:ml-64"> 
            <button id="hamburger" class="md:hidden text-white">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <h2 class="text-2xl font-bold mb-6">Your Referrals</h2>
            <div class="mb-4">
                <p class="text-green-400">You can refer users by sharing your referral link:</p>
                <a href="https://octainvest.org/register.php?ref=<?php echo $row['email'] ?>" class="text-blue-400 underline">https://octainvest.org/register.php?ref=<?php echo $row['email'] ?></a>
            </div>
            <br>
            <div class="mb-6">
                <h3 class="text-lg font-bold">Your Sponsor: <span class="text-gray-400">null</span></h3>
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                </div>
            </div>
            <div class="mb-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-600">Client Name</th>
                                <th class="py-2 px-4 border-b border-gray-600">Ref. Level</th>
                                <th class="py-2 px-4 border-b border-gray-600">Parent</th>
                                <th class="py-2 px-4 border-b border-gray-600">Client Status</th>
                                <th class="py-2 px-4 border-b border-gray-600">Date Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-600 text-center" colspan="5">No data available in table</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <span>Showing 0 to 0 of 0 entries</span>
                <div>
                    <button class="bg-gray-600 hover:bg-gray-500 text-white py-1 px-4 rounded-l">Previous</button>
                    <button class="bg-gray-600 hover:bg-gray-500 text-white py-1 px-4 rounded-r">Next</button>
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
    </script>

</body>
</html>
<?php
}
?>