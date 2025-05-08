<?php
    require_once "include/header.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rich Text Editor Tool</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        <!-- Style CSS -->
        <style>
            /* style.css */
body {
    font-family: 'Verdana', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #e8eff7;
}

.container {
    max-width: 900px;
    margin: 40px auto;
    background: #ffffff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

h3 {
    text-align: center;
    color: #1e2a38;
    margin-bottom: 20px;
}

.options {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
    justify-content: center;
}

.option-button {
    background-color: #ffffff;
    border: 2px solid #d1d9e6;
    border-radius: 6px;
    padding: 10px 14px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s, border-color 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.option-button:hover {
    background-color: #f0f6ff;
    border-color: #6394f8;
    transform: translateY(-2px);
}

.option-button:active {
    background-color: #dce9ff;
    transform: translateY(0);
}

.option-button i {
    font-size: 18px;
    color: #4a576e;
}

#formatBlock, #fontSize, #fontName {
    padding: 8px 12px;
    border-radius: 6px;
    border: 2px solid #d1d9e6;
    background-color: #ffffff;
    cursor: pointer;
    transition: border-color 0.3s;
}

#formatBlock:hover, #fontSize:hover, #fontName:hover {
    border-color: #6394f8;
}

#text-input {
    min-height: 350px;
    border: 2px solid #d1d9e6;
    border-radius: 10px;
    padding: 12px;
    background-color: #f9fbfd;
    overflow-y: auto;
    outline: none;
    font-size: 17px;
    color: #333;
    line-height: 1.6;
}

#text-input:focus {
    border-color: #6394f8;
    background-color: #ffffff;
}

@media (max-width: 600px) {
    .container {
        padding: 20px;
    }

    .option-button {
        padding: 8px 10px;
    }

    #text-input {
        font-size: 15px;
    }
}

        </style>
		
    </head>
    <body>
        <div class="container">
            <h3>Contact Details</h3>
			
            <div class="options">
                <!-- Text Format -->
                <button id="bold" class="option-button format">
                    <i class="fas fa-bold"></i>
                </button>
                <button id="italic" class="option-button format">
                    <i class="fas fa-italic"></i>
                </button>
                <button id="underline" class="option-button format">
                    <i class="fas fa-underline"></i>
                </button>
                <button id="strikethrough" class="option-button format">
                    <i class="fas fa-strikethrough"></i>
                </button>
                <button id="superscript" class="option-button script">
                    <i class="fas fa-superscript"></i>
                </button>
                <button id="subscript" class="option-button script">
                    <i class="fas fa-subscript"></i>
                </button>

                <!-- List -->
                <button id="insertOrderedList" class="option-button">
                    <i class="fas fa-list-ol"></i>
                </button>
                <button id="insertUnorderedList" class="option-button">
                    <i class="fas fa-list-ul"></i>
                </button>

                <!-- Undo/Redo -->
                <button id="undo" class="option-button">
                    <i class="fas fa-undo"></i>
                </button>
                <button id="redo" class="option-button">
                    <i class="fas fa-redo"></i>
                </button>

                <!-- Link -->
                <button id="createLink" class="option-button">
                    <i class="fas fa-link"></i>
                </button>
                <button id="unlink" class="option-button">
                    <i class="fas fa-unlink"></i>
                </button>

                <!-- Alignment -->
                <button id="justifyLeft" class="option-button align">
                    <i class="fas fa-align-left"></i>
                </button>
                <button id="justifyCenter" class="option-button align">
                    <i class="fas fa-align-center"></i>
                </button>
                <button id="justifyRight" class="option-button align">
                    <i class="fas fa-align-right"></i>
                </button>
                <button id="justifyFull" class="option-button align">
                    <i class="fas fa-align-justify"></i>
                </button>
                <button id="indent" class="option-button spacing">
                    <i class="fas fa-indent"></i>
                </button>
                <button id="outdent" class="option-button spacing">
                    <i class="fas fa-outdent"></i>
                </button>

                <!-- Headings -->
                <select id="formatBlock" class="option-button">
                    <option value="H1">H1</option>
                    <option value="H2">H2</option>
                    <option value="H3">H3</option>
                    <option value="H4">H4</option>
                    <option value="H5">H5</option>
                    <option value="H6">H6</option>
                </select>

                <!-- Font Size -->
                <select id="fontSize" class="option-button">
                    <option value="1">Size 1</option>
                    <option value="2">Size 2</option>
                    <option value="3" selected>Size 3</option>
                    <option value="4">Size 4</option>
                    <option value="5">Size 5</option>
                    <option value="6">Size 6</option>
                </select>

                <!-- Font Name -->
                <select id="fontName" class="option-button" style="width: 185px;">
                    <option value="Arial">Arial</option>
                    <option value="Verdana">Verdana</option>
                    <option value="Times New Roman">Times New Roman</option>
                    <option value="Garamond">Garamond</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Courier New">Courier New</option>
                    <option value="cursive">Cursive</option>
                </select>
            </div>
            <div id="text-input" contenteditable="true">Address : India,Tamil Nadu,Madurai.<br>

Phone Number : +911234567898 <br>

Email -id : mybudget@gmail.com
                
            </div>
        </div>

        <!-- Style CSS -->
        <script>
            const optionsButtons = document.querySelectorAll(".option-button");

// Function to modify text based on button click
function modifyText(command, value = null) {
    document.execCommand(command, false, value);
}

// Event listeners for format buttons
optionsButtons.forEach(button => {
    button.addEventListener("click", () => {
        modifyText(button.id);
        button.classList.toggle("active");
    });
});

// Prevent default behavior on link button click
document.getElementById("createLink").addEventListener("click", () => {
    const url = prompt("Enter URL:");
    if (url) modifyText("createLink", url);
});

// Initial settings
document.getElementById("fontSize").addEventListener("change", (e) => {
    modifyText("fontSize", e.target.value);
});

document.getElementById("fontName").addEventListener("change", (e) => {
    modifyText("fontName", e.target.value);
});

document.getElementById("formatBlock").addEventListener("change", (e) => {
    modifyText("formatBlock", e.target.value);
});

document.getElementById("text-input").focus();
        </script>
    </body>
</html>


<?php
    require_once "include/footer.php";
?>