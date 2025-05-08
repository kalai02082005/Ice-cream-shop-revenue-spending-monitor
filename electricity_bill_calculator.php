<?php
    require_once "include/header.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Bill Calculator</title>
    <style>

 body{
    background: url(ice5.jpg) no-repeat;
    background-size: cover;
 }

/* Centered Container */
.container {
    width: 100%;
    max-width: 450px;
    margin: 80px auto;
    background-color: #ffffff; /* White background for contrast */
    padding: 30px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px; /* Rounded corners */
    text-align: center;
}

/* Heading Styling */
h1 {
    font-size: 28px;
    color: #333; /* Neutral color */
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Label Styling */
label {
    font-size: 16px;
    color: #555; /* Neutral gray */
    display: block;
    margin-bottom: 10px;
}

/* Input Field Styling */
input {
    padding: 12px;
    font-size: 16px;
    width: 100%;
    margin-bottom: 20px;
    border: 1px solid #ccc; /* Neutral border */
    border-radius: 4px;
    box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease;
}

input:focus {
    border-color: #333; /* Neutral focus */
    outline: none;
}

/* Button Styling - Light Blue Theme */
button {
    padding: 12px 20px;
    font-size: 16px;
    background-color: #87ceeb ; /* Light blue button */
    color: #ffffff; /* White text */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

button:hover {
    background-color: #add8e6; /* Slightly darker light blue on hover */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); /* Shadow on hover */
}

/* Result Display */
h2 {
    margin-top: 20px;
    font-size: 20px;
    color: #333; /* Neutral color */
}

h2 span {
    font-weight: bold;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Electricity Bill Calculator</h1>
        <label for="units">Enter Units Consumed (kWh):</label>
        <input type="number" id="units" placeholder="Enter units">
        
        <button onclick="calculateBill()">Calculate Bill</button>

        <h2 id="billAmount">Bill Amount: ₹0.00</h2>
    </div>

    <script>
        function calculateBill() {
            const units = document.getElementById("units").value;
            let billAmount = 0;

            if (units <= 100) {
                billAmount = units * 0.5; // $0.5 per unit for the first 100 units
            } else if (units <= 200) {
                billAmount = (100 * 0.5) + ((units - 100) * 0.75); // $0.75 per unit for next 100 units
            } else if (units <= 300) {
                billAmount = (100 * 0.5) + (100 * 0.75) + ((units - 200) * 1.0); // $1 per unit for next 100 units
            } else {
                billAmount = (100 * 0.5) + (100 * 0.75) + (100 * 1.0) + ((units - 300) * 1.25); // $1.25 per unit above 300 units
            }

            document.getElementById("billAmount").textContent = "Bill Amount: ₹" + billAmount.toFixed(2);
        }
    </script>
</body>
</html>

<?php
    require_once "include/footer.php";
?>