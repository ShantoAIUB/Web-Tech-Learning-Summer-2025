<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Teacher Schedule</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
 
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #e0ecff, #f3f9ff);
      height: 100vh;
      display: flex;
      flex-direction: column;
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
 
    header h1 {
      font-size: 1.5rem;
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
 
    .header-left {
      display: flex;
      align-items: center;
      height: 100%;
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
      background-color: white;
      color: #004080;
      font-weight: bold;
      cursor: pointer;
    }
 
    .header-right button:hover {
      background-color: #cce0ff;
    }
 
    .dashboard {
      flex: 1;
      display: flex;
    }
 
    .sidediv {
      width: 250px;
      background-color: #003366;
      color: white;
      padding: 2rem 1rem;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }
 
    .sidediv button {
      width: 100%;
      padding: 0.8rem 1rem;
      border: none;
      border-radius: 8px;
      background-color: #004080;
      color: white;
      font-size: 1.1rem;
      text-align: left;
      cursor: pointer;
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
 
    .schedule-container {
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
 
    .schedule-container h2 {
      color: #003366;
      margin-bottom: 1rem;
    }
 
    table.rowsandcoms {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
      background-color: #fff;
      border-radius: 6px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
 
    table.rowsandcoms th,
    table.rowsandcoms td {
      padding: 15px 20px;
      text-align: center;
      border-bottom: 1px solid #ddd;
      font-size: 16px;
      color: #333;
    }
 
    table.rowsandcoms thead {
      background-color: #f0f0f0;
      font-weight: bold;
    }
  </style>
</head>
<body>
 
  <header>
    <div class="header-left">
      <h1>Welcome to the Dashboard</h1>
    </div>
    <div class="header-right">
      <form action="" method="POST" onsubmit="return validateNotifications()">
        <button type="submit">🔔 Notifications</button>
      </form>
      <form action="logout.php" method="POST" onsubmit="return validateLogout()">
        <button type="submit">Logout</button>
      </form>
    </div>
  </header>
 
  <div class="dashboard">
    <div class="sidediv">
      <button onclick="window.location.href='TeacherProfileView.php'">Profile</button>
      <button onclick="window.location.href='TeacherScheduleView.php'">Schedule</button>
      <button onclick="window.location.href='TeacherGradesUploadView.php'">Grades Upload</button>
      <button onclick="window.location.href='TeacherUpassignmentView.php'">Assignments</button>
    </div>
 
    <div class="maindiv">
      <div class="schedule-container">
        <h2>Course Schedule</h2>
        <table class="rowsandcoms">
          <thead>
            <tr>
              <th>Course Name</th>
              <th>Sunday</th>
              <th>Monday</th>
              <th>Tuesday</th>
              <th>Wednesday</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Mathematics</td>
              <td>10:00-11:30</td>
              <td>-</td>
              <td>14:00-15:30</td>
              <td>-</td>
            </tr>
            <tr>
              <td>Physics</td>
              <td>-</td>
              <td>09:00-10:30</td>
              <td>-</td>
              <td>11:00-12:30</td>
            </tr>
            <tr>
              <td>English</td>
              <td>-</td>
              <td>13:00-14:30</td>
              <td>10:00-11:30</td>
              <td>-</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
 
  <script>
    function validateNotifications() {
      // Here you can add any logic for notification validation if necessary
      return true; // Allow the form to be submitted
    }
 
    function validateLogout() {
      // Add any necessary logic for logout validation
      if (confirm('Are you sure you want to log out?')) {
        return true;
      }
      return false; // Prevent form submission if user cancels
    }
  </script>
 
  <?php
    // PHP code to handle session and form validation
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['logout'])) {
        // Perform logout functionality
        session_destroy();
        header("Location: login.php");
        exit();
      }
      if (isset($_POST['notifications'])) {
        // Process notifications logic here
      }
    }
  ?>
 
</body>
</html>