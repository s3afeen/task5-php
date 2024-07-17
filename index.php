<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h2>Student information</h2>
    <!-- Form لإضافة طالب جديد -->
    <form action="index.php" method="post">
        <label>First Name:</label><br>
        <input type="text" name="first_name"><br>
        <label>Last Name:</label><br>
        <input type="text" name="last_name"><br>
        <label>Email:</label><br>
        <input type="text" name="email"><br>
        <label>Phone Number:</label><br>
        <input type="text" name="phone_number"><br><br>
        <input type="submit" name="add" value="Add Student">
    </form>

    <h2>Student List</h2>
    <table >
        <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </tr>
        <?php
        // الاتصال بقاعدة البيانات
        $conn = new mysqli("localhost", "root", "", "task5");

        // التحقق من الاتصال
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // إضافة طالب جديد
        if (isset($_POST['add'])) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];

            $sql = "INSERT INTO student (first_name, last_name, email, phone_number) VALUES ('$first_name', '$last_name', '$email', '$phone_number')";

            if ($conn->query($sql) === TRUE) {
                echo "The student has been added successfully";
            } else {
                echo "خطأ: " . $sql . "<br>" . $conn->error;
            }
        }

        // حذف طالب
        if (isset($_GET['delete'])) {
            $student_id = $_GET['delete'];
            $sql = "DELETE FROM student WHERE student_id=$student_id";

            if ($conn->query($sql) === TRUE) {
                echo "Student has been deleted successfully";
            } else {
                echo "خطأ: " . $sql . "<br>" . $conn->error;
            }
        }

        // جلب البيانات لعرضها في الجدول
        $sql = "SELECT * FROM student";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // عرض البيانات
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["student_id"]. "</td>
                        <td>" . $row["first_name"]. "</td>
                        <td>" . $row["last_name"]. "</td>
                        <td>" . $row["email"]. "</td>
                        <td>" . $row["phone_number"]. "</td>
                        <td><a href='index.php?delete=" . $row["student_id"] . "'>Delete</a></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>There are no students</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
