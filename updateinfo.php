<?php
include 'config.php';
$email = $_SESSION['email'];
$sql = "SELECT * FROM `users` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);

if (isset($_POST['updateinfo'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phoneno = $_POST['phoneno'];
    $country = $_POST['country'];
    $sqli = "UPDATE `users` SET `first-name`='$firstname',`last-name`='$lastname',`country`='$country',`email`='$email',`phone-no`='$phoneno' WHERE `email` = '$email'";
    $resulti = mysqli_query($conn, $sqli);
    if ($resulti) {
        echo '<script>alert("Profile Info Updated Successfully")</script>';
        echo '<script>window.location.href = "./updateinfo.php"</script>';
    } else {
        echo '<script>alert("Profile Info Update Error")</script>';
    }
}

while ($row = $result->fetch_assoc()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;700&display=swap');

        * {
            font-family: "Open Sans", sans-serif;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            border-radius: 50%;
            transition: .4s;
        }
        input:checked + .slider {
            background-color: #2196F3;
        }
        input:checked + .slider:before {
            transform: translateX(14px);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-gray-800 w-64 h-full p-4 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out">
            <h1 class="text-xl font-bold mb-6">Octa Invest</h1>
            <div class="mb-4">
                <p class="text-2xl capitalize py-5">Welcome, <?php echo $row['first-name']; ?>!</p>
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
            <button id="hamburger" class="md:hidden text-white">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <h2 class="text-2xl font-bold mb-6">Update Profile Information</h2>
            <form method="post" class="bg-gray-700 p-6 w-70 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="w-16 h-16 bg-gray-600 rounded-full mr-4"></div>
                    <div class="">
                        <h3 class="text-xl font-bold capitalize">
                            <input class="bg-slate-200 text-black rounded-md px-2 py-2 w-full md:w-1/2" name="firstname" placeholder="<?php echo $row['first-name'] ?>" type="text"><br>
                            <input name="lastname" class="bg-slate-200 text-black rounded-md px-2 py-2 w-full md:w-1/2 ml-2" placeholder="<?php echo $row['last-name'] ?>" type="text">
                        </h3>
                        <p class="text-sm text-gray-400">OCTA INVEST USER</p>
                    </div>
                </div>
                <div class="mb-4 flex flex-col gap-2 py-5">
                    <p><strong>Email: </strong> <input name="email" style="color: black;" class="bg-slate-200 rounded-md px-2 py-2 w-full" placeholder="<?php echo $row['email'] ?>" type="text"> </p>
                    <p><strong>Country: </strong> <input name="country" style="color: black;" class="bg-slate-200 rounded-md px-2 py-2 w-full" placeholder="<?php echo $row['country'] ?>" type="text"></p>
                    <p><strong>Phone: </strong> <input name="phoneno" style="color: black;" class="bg-slate-200 rounded-md px-2 py-2 w-full" placeholder="<?php echo $row['phone-no'] ?>" type="text"></p>
                    <p><strong>Date of Birth: </strong><input style="color: black;" class="bg-slate-200 rounded-md px-2 py-2 w-full" placeholder="June 12, 1986" type="text"></p>
                    <button name="updateinfo" type="submit" class="bg-green-600 hover:bg-green-500 text-white py-2 px-4 rounded mt-4">Update Info</button>
                </div>
            </form>
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