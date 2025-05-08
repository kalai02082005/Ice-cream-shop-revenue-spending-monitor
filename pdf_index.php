<?php
require_once "include/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Report</title>
    <style>
        body{
            background: url(ice2.jpg) no-repeat;
            background-size: cover;
        }
/* Centering the Form with a Slight Upward Shift */
.center-container {
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Aligns content to the top */
    height: 100vh; /* Full viewport height */
    padding-top: 7vh; /* Moves the form slightly more up */
}

/* General Styling */
h2 {
    font-size: 28px;
    color: black;
    margin-bottom: 25px;
    text-align: center;
}

/* Form Container */
form {

    padding: 25px;

    display: inline-block;
    width: 100%;
    max-width: 450px;
    text-align: left;
}

/* Label Styling */
label {
    font-size: 16px;
    font-weight: 600;
    color: black;
    display: block;
    margin-bottom: 8px;
}

/* Input Fields & Select Box */
input[type="date"], select {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 2px solid #ddd;
    border-radius: 6px;
    margin-bottom: 20px;
    outline: none;
    transition: 0.3s;
    background: #fff;
}

/* Focus Effect */
input[type="date"]:focus, select:focus {
    border-color: #007bff;
    box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.3);
}

/* Select Box */
select {
    cursor: pointer;
}

/* Submit Button */
button {
    width: 100%;
    background-color: #28a745;
    color: white;
    border: none;
    padding: 12px;
    font-size: 18px;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.3s ease-in-out;
}

/* Button Hover Effect */
button:hover {
    background-color: #218838;
}

/* Responsive Design */
@media (max-width: 600px) {
    .center-container {
        padding-top: 4vh; /* Adjusting for smaller screens */
        padding: 20px;
    }
    form {
        width: 90%;
    }
}

    </style>
</head>
<body>

<div class="center-container">
    <div>
        <h2>Generate Day-wise Report</h2>
        <form action="generate_pdf.php" method="GET">
            <label for="report_type">Select Report Type:</label>
            <select name="type" id="report_type" required>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
                <option value="both">Both</option>
            </select>

            <label for="selected_date">Select Date:</label>
            <input type="date" name="selected_date" id="selected_date" required>

            <button type="submit">Download PDF</button>
        </form>
    </div>
</div>



</body>
</html>

<?php 
require_once "include/footer.php"; 
?>
