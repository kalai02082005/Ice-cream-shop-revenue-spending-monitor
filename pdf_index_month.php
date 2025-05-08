<?php
require_once "include/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report</title>
    <style>
    /* Background Styling */
body {
    background: url('ice2.jpg') no-repeat center center fixed;
    background-size: cover;
  
}

/* Centering the Form with a Slight Upward Shift */
.center-container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    height: 100vh;
    padding-top: 10vh;
}

/* General Styling */
h2 {
    font-size: 28px;
    color: black;
    margin-bottom: 20px;
    text-align: center;

    padding: 10px;
    border-radius: 6px;
}

/* Form Container */
form {
 
    padding: 25px;
   
    max-width: 450px;
    width: 100%;
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
input[type="month"], select {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 2px solid #ddd;
    border-radius: 6px;
    margin-bottom: 15px;
    outline: none;
    transition: 0.3s;
    background: #fff;
}

/* Focus Effect */
input[type="month"]:focus, select:focus {
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
        padding-top: 5vh;
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
        <h2>Generate Month-wise Report</h2>
        <form action="generate_pdf_month.php" method="GET">
            <label for="report_type">Select Report Type:</label>
            <select name="type" id="report_type" required>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
                <option value="both">Both</option>
            </select>

            <label for="selected_month">Select Month & Year:</label>
            <input type="month" name="selected_month" id="selected_month" required>

            <button type="submit">Download PDF</button>
        </form>
    </div>
</div>

</body>
</html>

<?php 
require_once "include/footer.php"; 
?>
