document.getElementById("upload-btn").addEventListener("click", function() {
  document.getElementById("announcements-show").style.display = "none";
  document.getElementById("announcements-upload").style.display = "block";
  document.getElementById("announcements-update").style.display = "none";
});

// get references to the sections
const showSection = document.getElementById("announcements-show");
const uploadSection = document.getElementById("announcements-upload");
const updateSection = document.getElementById("announcements-update");

// get references to the buttons
const uploadBtn = document.querySelector('button[name="upload"]');
const cancelBtn = document.querySelector('button[name="cancel"]');
const updateBtn = document.querySelector('button[name="update"]');

// add event listener to the upload button
uploadBtn.addEventListener('click', () => {
  // hide the show section
  showSection.style.display = 'none';
  // show the upload section
  uploadSection.style.display = 'block';
  // hide the update section
  updateSection.style.display = 'none';
});

// add event listener to the cancel button
cancelBtn.addEventListener('click', () => {
  // show the show section
  showSection.style.display = 'block';
  // hide the upload section
  uploadSection.style.display = 'none';
  // hide the update section
  updateSection.style.display = 'none';
});

