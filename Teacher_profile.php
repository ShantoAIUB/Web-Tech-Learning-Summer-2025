<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data here
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $age = trim($_POST['age']);
    $address = trim($_POST['address']);
 
    // Perform server-side validation
    $errors = [];
    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    }
    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($age)) {
        $errors[] = "Age is required.";
    } elseif (!is_numeric($age) || $age < 16) {
        $errors[] = "Age must be a number and at least 16.";
    }
    if (empty($address)) {
        $errors[] = "Address is required.";
    }
 
    if (count($errors) > 0) {
        $error_message = implode('<br>', $errors);
    } else {
        // Proceed with saving the data
        $success_message = "Profile updated successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
 
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
 
    body {
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      display: flex;
      flex-direction: column;
      background: linear-gradient(to right, #e0ecff, #f3f9ff);
    }
 
    header {
      width: 100%;
      height: 85px;
      background-color: #004080;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 10;
    }
 
    .header-left {
      display: flex;
      align-items: center;
    }
 
    header h1 {
      font-size: 1.5rem;
      color: white;
      cursor: default;
    }
 
    .header-center {
      flex-grow: 1;
      display: flex;
      justify-content: center;
    }
 
    .search-bar {
      display: flex;
      gap: 0.5rem;
    }
 
    .search-bar input[type="text"] {
      padding: 0.5rem;
      border-radius: 4px;
      border: none;
      width: 250px;
    }
 
    .search-bar button {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 4px;
      background-color: #ffffff;
      color: #004080;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }
 
    .search-bar button:hover {
      background-color: #cce0ff;
    }
 
    .header-right button {
      margin-left: 1rem;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 6px;
      background-color: #ffffff;
      color: #004080;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }
 
    .header-right button:hover {
      background-color: #cce0ff;
    }
 
    .dashboard {
      flex: 1;
      display: flex;
      height: calc(100% - 85px);
    }
 
    .sidediv {
      width: 250px;
      background-color: #003366;
      color: white;
      padding: 2rem 1rem;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
    }
 
    .sidediv button {
      width: 100%;
      padding: 0.8rem 1rem;
      border: none;
      border-radius: 8px;
      background-color: #004080;
      color: white;
      font-size: 1.1rem;
      cursor: pointer;
      text-align: left;
      transition: background-color 0.3s, transform 0.2s;
    }
 
    .sidediv button:hover {
      background-color: #0059b3;
      transform: translateX(10px);
    }
 
    .maindiv {
      flex: 1;
      padding: 2rem;
      overflow-y: auto;
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }
 
    /* NEW PROFILE CONTAINER STYLES */
    .profile-container {
      background-color: white;
      padding: 2rem;
      width: 100%;
      max-width: 1500px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }
 
    .profile-header {
      font-size: 1.8rem;
      margin-bottom: 1.5rem;
      color: #004080;
    }
 
    .profile-pic-section {
      display: flex;
      align-items: center;
      margin-bottom: 1.5rem;
    }
 
    .profile-pic-section img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 1rem;
      border: 2px solid #004080;
    }
 
    .profile-pic-section input[type="file"] {
      display: none;
    }
 
    .upload-btn {
      padding: 0.5rem 1rem;
      background-color: #004080;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
 
    .profile-form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem 2rem;
    }
 
    .profile-form label {
      font-weight: bold;
      color: #333;
    }
 
    .profile-form input {
      padding: 0.5rem;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 100%;
    }
 
    .full-width {
      grid-column: span 2;
    }
 
    .edit-btn , .download-btn {
      margin-top: 1.5rem;
      padding: 0.6rem 1.2rem;
      background-color: #004080;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
    }
   
  </style>
</head>
 
<body>
  <header>
    <div class="header-left">
      <h1>Welcome to the Dashboard</h1>
    </div>
    <div class="header-center">
      <div class="search-bar" id="searchBarContainer">
        <input type="text" id="dashboardSearch" placeholder="Search..." />
        <button id="searchButton">Search</button>
      </div>
    </div>
    <div class="header-right">
        <form action="" method="POST">
        <button type="submit">🔔 Notifications</button>
        </form>
    </div>
    <div class="header-right">
        <form action="logout.php" method="POST">
        <button type="submit">Logout</button>
        </form>
    </div>
  </header>
 
  <div class="dashboard">
    <div class="sidediv">
      <button onclick="window.location.href='Teacher_profile.php'">Profile</button>
      <button onclick="window.location.href='Teacherschedule.php'">Schedule</button>
      <button onclick="window.location.href='teachergrades.php'">Grades Upload</button>
      <button onclick="window.location.href='teacherassignment.php'">Assignments</button>
    </div>
 
    <div class="maindiv" id="mainContent">
      <div class="profile-container">
        <div class="profile-header">Hello Sir!!</div>
        <div class="profile-pic-section">
          <img src="https://via.placeholder.com/120" alt="Profile Picture" id="profileImage" />
          <label class="upload-btn">
            Upload Photo
            <input type="file" id="photoUpload" accept="image/*" />
          </label>
        </div>
 
        <form class="profile-form" id="profileForm">
          <div>
            <label>First Name</label>
            <input type="text" id="firstName" value="Shanto" disabled />
          </div>
          <div>
            <label>Last Name</label>
            <input type="text" id="lastName" value="Shahadat" disabled />
          </div>
          <div>
            <label>Email</label>
            <input type="email" id="email" value="raihan@example.com" disabled />
          </div>
          <div>
            <label>Department</label>
            <input type="text" id="department" value="CSE" disabled />
          </div>
          <div>
            <label>Age</label>
            <input type="number" id="age" value="201" disabled />
          </div>
          <div>
            <label>Blood Group</label>
            <input type="text" id="bloodGroup" value="A+" disabled />
          </div>
          <div class="full-width">
            <label>Address</label>
            <input type="text" id="address" value="123 Street, City" disabled />
          </div>
          <div class="full-width">
            <button type="button" class="edit-btn" onclick="toggleEdit()">Edit Profile</button>
            <button type="button" class="download-btn" onclick="downloadProfile()">Download Profile</button>
          </div>
        </form>
      </div>
    </div>
  </div>
 
  <script>
    function toggleEdit() {
      const inputs = document.querySelectorAll("#profileForm input");
      const button = document.querySelector(".edit-btn");
      let valid = true;
 
      if (button.textContent === "Edit Profile") {
        // Enable inputs for editing
        inputs.forEach(input => input.disabled = false);
        button.textContent = "Save Profile";
      } else {
        // Validate each field
        inputs.forEach(input => {
          if (input.id === "email") {
            const email = input.value.trim();
            if (email === "") {
              valid = false;
              input.style.border = "2px solid red";
            } else if (!validateEmail(email)) {
              valid = false;
              input.style.border = "2px solid red";
              alert("Please enter a valid email.");
            } else {
              input.style.border = "1px solid #ccc";
            }
          } else if (input.value.trim() === "") {
            valid = false;
            input.style.border = "2px solid red";
          } else {
            input.style.border = "1px solid #ccc";
          }
        });
 
        // If validation passes, disable fields and alert success
        if (valid) {
          inputs.forEach(input => input.disabled = true);
          button.textContent = "Edit Profile";
          alert("Profile updated successfully!");
        } else {
          alert("Please fill in all fields with valid data.");
        }
      }
    }
 
    // Email validation function
    function validateEmail(email) {
      const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      return re.test(email);
    }
 
    document.getElementById("photoUpload").addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById("profileImage").src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
 
    function downloadProfile() {
      const inputs = document.querySelectorAll('#profileForm input');
      let textData = "User Profile Info:\n\n";
      inputs.forEach(input => {
        textData += `${input.name}: ${input.value}\n`;
      });
 
      const blob = new Blob([textData], { type: "text/plain" });
      const link = document.createElement("a");
      link.href = URL.createObjectURL(blob);
      link.download = "profile_info.txt";
      link.click();
    }
  </script>
</body>
</html>