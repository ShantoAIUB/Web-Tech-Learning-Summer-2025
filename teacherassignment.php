<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $allowedFileTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
 
  // File upload for each course
  $uploads = ['mathFile', 'sciFile', 'histFile'];
  foreach ($uploads as $file) {
    if (isset($_FILES[$file])) {
      $fileType = $_FILES[$file]['type'];
      $fileName = $_FILES[$file]['name'];
 
      if (!in_array($fileType, $allowedFileTypes)) {
        die("Invalid file type for $file. Allowed types are: PDF, DOCX.");
      }
 
      // Move the uploaded file to the server (example: to the "uploads" folder)
      $targetDirectory = 'uploads/';
      $targetFile = $targetDirectory . basename($fileName);
     
      if (!move_uploaded_file($_FILES[$file]['tmp_name'], $targetFile)) {
        die("Sorry, there was an error uploading your file for $file.");
      }
    }
  }
 
  // Validation for total marks
  $marksInputs = ['mathMarks', 'sciMarks', 'histMarks'];
  foreach ($marksInputs as $marks) {
    if (empty($_POST[$marks]) || $_POST[$marks] <= 0) {
      die("Please enter valid marks for $marks.");
    }
  }
 
  echo "Assignments uploaded successfully!";
}
?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Assignments Upload</title>
 
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
      height: 100%;
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
      height: 100%;
      align-items: center;
    }
 
    .search-bar {
      display: flex;
      gap: 0.5rem;
      height: 40px;
    }
 
    .search-bar input[type="text"] {
      padding: 0.5rem;
      border-radius: 4px;
      border: none;
      width: 250px;
      height: 100%;
    }
 
    .search-bar button {
      padding: 0 1rem;
      border: none;
      border-radius: 4px;
      background-color: #ffffff;
      color: #004080;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
      height: 100%;
    }
 
    .search-bar button:hover {
      background-color: #cce0ff;
    }
 
    .header-right {
      height: 100%;
      display: flex;
      align-items: center;
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
      height: calc(100% - 100px);
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
      background-color: #ffffff;
      overflow-y: auto;
    }
 
    .assignment-upload-container {
      background-color: #f0f8ff;
      border-radius: 12px;
      padding: 1.5rem;
      max-width: 1500px;
      margin: auto;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
 
    .assignment-upload-container h2 {
      margin-bottom: 1.5rem;
      color: #004080;
      text-align: center;
    }
 
    .course-assignment {
      margin-bottom: 2rem;
      padding: 1rem;
      border: 1px solid #cce0ff;
      border-radius: 8px;
      background-color: #ffffff;
    }
 
    .course-assignment h3 {
      margin-bottom: 1rem;
      color: #003366;
    }
 
    .course-assignment label {
      display: block;
      margin: 0.5rem 0 0.3rem;
      font-weight: 500;
    }
 
    .course-assignment input[type="file"],
    .course-assignment input[type="number"] {
      width: 100%;
      padding: 0.5rem;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 1rem;
    }
 
    .course-assignment button {
      padding: 0.6rem 1.2rem;
      border: none;
      border-radius: 6px;
      background-color: #004080;
      color: white;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }
 
    .course-assignment button:hover {
      background-color: #0059b3;
    }
 
  </style>
</head>
 
<body>
 
  <header>
    <div class="header-left">
      <h1>Welcome to the Dashboard</h1>
    </div>
    <div class="header-right">
      <form action="" method="POST">
        <button type="submit">🔔 Notifications</button>
        </form>
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
      <div class="assignment-upload-container">
        <h2>Upload Assignments</h2>
 
        <div class="course-assignment">
          <h3>Course: Mathematics</h3>
          <label for="mathFile">Upload Assignment:</label>
          <input type="file" id="mathFile" name="mathFile" required>
 
          <label for="mathMarks">Total Marks:</label>
          <input type="number" id="mathMarks" name="mathMarks" placeholder="Enter total marks" required>
 
          <button type="submit">Upload</button>
        </div>
 
        <div class="course-assignment">
          <h3>Course: Science</h3>
          <label for="sciFile">Upload Assignment:</label>
          <input type="file" id="sciFile" name="sciFile" required>
 
          <label for="sciMarks">Total Marks:</label>
          <input type="number" id="sciMarks" name="sciMarks" placeholder="Enter total marks" required>
 
          <button type="submit">Upload</button>
        </div>
 
        <div class="course-assignment">
          <h3>Course: History</h3>
          <label for="histFile">Upload Assignment:</label>
          <input type="file" id="histFile" name="histFile" required>
 
          <label for="histMarks">Total Marks:</label>
          <input type="number" id="histMarks" name="histMarks" placeholder="Enter total marks" required>
 
          <button type="submit">Upload</button>
        </div>
 
      </div>
    </div>
  </div>
 
  <script>
    // JavaScript validation
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function(e) {
        const mathFile = document.getElementById('mathFile');
        const sciFile = document.getElementById('sciFile');
        const histFile = document.getElementById('histFile');
        const mathMarks = document.getElementById('mathMarks');
        const sciMarks = document.getElementById('sciMarks');
        const histMarks = document.getElementById('histMarks');
       
        const allowedFileTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
       
        if (![mathFile, sciFile, histFile].every(fileInput => fileInput.files.length > 0)) {
          alert('Please upload all assignments.');
          e.preventDefault();
          return;
        }
 
        if (![mathMarks, sciMarks, histMarks].every(marksInput => marksInput.value > 0)) {
          alert('Please enter valid marks for all courses.');
          e.preventDefault();
          return;
        }
 
        // Check file types
        [mathFile, sciFile, histFile].forEach(fileInput => {
          if (!allowedFileTypes.includes(fileInput.files[0]?.type)) {
            alert('Please upload a valid file type (PDF, DOCX).');
            e.preventDefault();
          }
        });
      });
    });
  </script>
 
</body>
</html>