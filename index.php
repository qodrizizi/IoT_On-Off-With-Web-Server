<?php
include 'koneksi.php';

$isi_text = "OFF";

// Fetch the initial status from the database
$sql = "SELECT isi FROM tb_lampu WHERE id = 1";
$result = $koneksi->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $isi_text = $row['isi'] == 1 ? "ON" : "OFF";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isi = isset($_POST['isi']) ? 1 : 0;

    $sql_update = "UPDATE tb_lampu SET isi = $isi WHERE id = 1";
    
    if ($koneksi->query($sql_update) === TRUE) {
        $isi_text = $isi == 1 ? "ON" : "OFF";
    } else {
        echo "Error updating record: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button ON/OFF with Database</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            transition: background 2s ease-in-out; /* Smooth transition effect */
        }

        /* Initial background color */
        body.off {
            background: linear-gradient(45deg, #4e54c8, #8f94fb, #34e89e, #0f3443);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
        }

        /* Background color for ON state */
        body.on {
            background: linear-gradient(45deg, #ff512f, #f09819, #ff9a9e, #fad0c4);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
        }

        /* Animation keyframes */
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
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
            transition: background-color 0.4s, transform 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: transform 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #4CAF50;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .isi-text {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        /* Modern button styling */
        .modern-button {
            margin-top: 20px;
            padding: 10px 25px;
            background-color: #4e54c8;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 6px 15px rgba(78, 84, 200, 0.4);
            transition: background-color 0.3s, transform 0.2s;
        }

        .modern-button:hover {
            background-color: #6b6dff;
            transform: translateY(-2px);
        }

        .modern-button:active {
            transform: translateY(0);
        }
    </style>
    <script>
        // JavaScript to toggle the background color based on the status
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const status = "<?php echo $isi_text; ?>";

            // Set the initial background class
            if (status === "ON") {
                body.classList.add('on');
            } else {
                body.classList.add('off');
            }

            // Add an event listener for the form submission to change the background
            document.querySelector('form').addEventListener('submit', function() {
                if (document.querySelector('input[name="isi"]').checked) {
                    body.classList.remove('off');
                    body.classList.add('on');
                } else {
                    body.classList.remove('on');
                    body.classList.add('off');
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Switch ON/OFF</h2>
        <form method="POST" action="">
            <!-- Toggle Button -->
            <label class="switch">
                <input type="checkbox" name="isi" value="1" <?php if ($isi_text == "ON") echo "checked"; ?>>
                <span class="slider"></span>
            </label>
            <div class="isi-text">
                <?php echo "Status: " . $isi_text; ?>
            </div>
            <br>
            <button type="submit" class="modern-button">Submit</button>
        </form>
    </div>
</body>
</html>
