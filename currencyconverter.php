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
    <title>Currency Converter</title>
    <style>
       /* General Body Styling */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0; 
    background: url(ice5.jpg) no-repeat;
    background-size: cover;
 

}

/* Centered Container */
.container {
    width: 90%;
    max-width: 450px;
    margin: 80px auto;
    background-color: #ffffff;
    padding: 30px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center;
}

/* Heading Styling */
h1 {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Label Styling */
label {
    font-size: 16px;
    color: #555;
    display: block;
    margin-bottom: 10px;
}

/* Input Field Styling */
input, select {
    padding: 12px;
    font-size: 16px;
    width: 100%;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease;
}

input:focus, select:focus {
    border-color: #333;
    outline: none;
}

/* Button Styling */
button {
    padding: 12px 20px;
    font-size: 16px;
    background-color: #87ceeb;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

button:hover {
    background-color: #add8e6;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

/* Result Display */
h2 {
    margin-top: 20px;
    font-size: 20px;
    color: #333;
}

h2 span {
    font-weight: bold;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Currency Converter</h1>
        <label for="amount">Enter Amount (₹):</label>
        <input type="number" id="amount" placeholder="Enter amount in INR">

        <label for="currency">Select Currency:</label>
        <select id="currency">
            <option value="0.012">USD ($) - 1 INR = 0.012 USD</option>
            <option value="0.011">EUR (€) - 1 INR = 0.011 EUR</option>
            <option value="1.55">JPY (¥) - 1 INR = 1.55 JPY</option>
        </select>

        <button onclick="convertCurrency()">Convert</button>

        <h2 id="convertedAmount">Converted Amount: 0.00</h2>
    </div>

    <script>
        function convertCurrency() {
            const amount = document.getElementById("amount").value;
            const exchangeRate = document.getElementById("currency").value;
            
            if (amount > 0) {
                const convertedAmount = amount * exchangeRate;
                document.getElementById("convertedAmount").textContent = "Converted Amount: " + convertedAmount.toFixed(2);
            } else {
                document.getElementById("convertedAmount").textContent = "Please enter a valid amount.";
            }
        }
    </script>
</body>
</html>

<?php
    require_once "include/footer.php";
?>
