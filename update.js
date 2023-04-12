document.getElementById("update-btn").addEventListener("click", function() {
    // hide the show section
    document.getElementById("announcements-show").style.display = "none";
    // hide the upload section
    document.getElementById("announcements-upload").style.display = "none";
    // show the update section
    document.getElementById("announcements-update").style.display = "block";
});