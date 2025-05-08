<?php
  require_once "include/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOTES</title>
    <link rel="shortcut icon" href="notes.png" type="image/x-icon">
    <style>
        /* CSS Styles for Notes */
        body {
            font-family: Arial, sans-serif;
         
            margin: 0;
            padding: 0;
        }
        body{
    background: url(ice5.jpg) no-repeat;
    background-size: cover;
 }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
           /*  background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        }
        h1 {
            text-align: center;
            position: relative;
            right: 400px;
           
        }
        h1 img{
        width: 80px;
        height: 70px;
        }
        .btn {
            background-color:#007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: 50px auto;
            border-radius: 50px;
            position: relative;
            right: 400px;

        }
        .btn img {
            vertical-align: middle;
            margin-right: 8px;
            width: 50px;
            height: 50px;
            
        }
        .notes-container {
            margin-top: 20px;
        }
        .note {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .input-box {
            width: 100%;
            height: 100px;
            border: none;
            outline: none;
            padding: 5px;
            font-size: 16px;
        }
        .delete-btn {
            background: none;
            border: none;
            cursor: pointer;
            float: right;
            margin-top: -15px;
            margin-left: 50px;
        }
        .delete-btn img {
            width: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><img src="notes.png">Notes</h1>
        <button class="btn" id="createNoteBtn"><img src="edit.png">Create Notes</button>
        <div class="notes-container" id="notesContainer">
            <!-- New notes will be added here dynamically -->
        </div>
    </div>
<script>
    // Function to save notes to local storage
function saveNotesToLocalStorage() {
    const notes = [];
    const notesContainer = document.getElementById("notesContainer");
    const noteElements = notesContainer.getElementsByClassName("note");
    for (let noteElement of noteElements) {
        const content = noteElement.querySelector(".input-box").innerText;
        notes.push(content);
    }
    localStorage.setItem("notes", JSON.stringify(notes));
}

// Function to load notes from local storage
function loadNotesFromLocalStorage() {
    const notesContainer = document.getElementById("notesContainer");
    const storedNotes = JSON.parse(localStorage.getItem("notes") || "[]");
    storedNotes.forEach(content => {
        createNoteElement(content);
    });
}

// Function to create a note element
function createNoteElement(content = "") {
    const notesContainer = document.getElementById("notesContainer");

    // Create a new div to represent the note
    const newNote = document.createElement("div");
    newNote.classList.add("note");

    // Add an editable input box for the note content
    const noteContent = document.createElement("p");
    noteContent.contentEditable = "true";
    noteContent.classList.add("input-box");
    noteContent.innerText = content;

    // Save notes to local storage on content change
    noteContent.addEventListener("input", saveNotesToLocalStorage);

    // Add a delete button for the note
    const deleteBtn = document.createElement("button");
    deleteBtn.innerHTML = "<img src='delete.png'>";
    deleteBtn.classList.add("delete-btn");

    // Attach the delete functionality
    deleteBtn.addEventListener("click", function () {
        notesContainer.removeChild(newNote);
        saveNotesToLocalStorage();
    });

    // Append the content and delete button to the new note
    newNote.appendChild(noteContent);
    newNote.appendChild(deleteBtn);

    // Append the new note to the notes container
    notesContainer.appendChild(newNote);
}

// Event listener for the "Create Notes" button
document.getElementById("createNoteBtn").addEventListener("click", function () {
    createNoteElement();
    saveNotesToLocalStorage();
});

// Load notes on page load
document.addEventListener("DOMContentLoaded", loadNotesFromLocalStorage);

</script>
   

</body>
</html>
<?php
    require_once "include/footer.php";
?>
