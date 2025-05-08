const notesContainer = document.querySelector(".notes-container");
const createBtn = document.querySelector(".btn");

// Function to display notes from localStorage
function showNotes() {
    const storedNotes = localStorage.getItem("notes");
    if (storedNotes) {
        notesContainer.innerHTML = storedNotes;
    }
}
showNotes();

// Function to update localStorage
function updateStorage() {
    localStorage.setItem("notes", notesContainer.innerHTML);
}

// Create a new note
createBtn.addEventListener("click", () => {
    const inputBox = document.createElement("p");
    const img = document.createElement("img");

    inputBox.className = "input-box";
    inputBox.setAttribute("contenteditable", "true");
    img.src = "delete.png";
    img.alt = "Delete Note";

    // Append the note and delete icon to the container
    inputBox.appendChild(img);
    notesContainer.appendChild(inputBox);

    // Update localStorage after adding the note
    updateStorage();
});

// Handle clicks in the notes container
notesContainer.addEventListener("click", (e) => {
    if (e.target.tagName === "IMG") {
        // Remove note when delete icon is clicked
        e.target.parentElement.remove();
        updateStorage();
    } else if (e.target.tagName === "P") {
        // Add event listener for keyup to update storage on text change
        e.target.onkeyup = function () {
            updateStorage();
        };
    }
});

// Prevent default behavior of Enter key in editable notes
document.addEventListener("keydown", (event) => {
    if (event.key === "Enter" && document.activeElement.classList.contains("input-box")) {
        document.execCommand("insertLineBreak");
        event.preventDefault();
    }
});
