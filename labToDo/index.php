<!DOCTYPE html>
<html>
<head>
    <title>Todo Manage</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
$host = "localhost";
$username = "root";
$password = "tanhuy09560";
$database = "qlysinhvien";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Lỗi kết nối !!! " . mysqli_connect_error());
}

// Xử lý thêm công việc mới
if (isset($_POST['addButton'])) {
    $newTask = $_POST['addItem'];

    if (!empty($newTask)) {
        $sql = "INSERT INTO todos (userid, task, completed, created, updated) 
                VALUES (1, '$newTask', 0, NOW(), NOW())";

        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }
    }
}

// Xử lý xóa công việc
if (isset($_POST['deleteButton'])) {
    $taskId = $_POST['taskId'];
    $sql = "DELETE FROM todos WHERE todoid = $taskId";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

// Xử lý chỉnh sửa công việc
if (isset($_POST['editButton'])) {
    $taskId = $_POST['taskId'];
    $newTaskName = $_POST['editedTaskName'];

    $sql = "UPDATE todos SET task = '$newTaskName' WHERE todoid = $taskId";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo</title>
    <style>
        .completed {
            text-decoration: line-through;
        }
    </style>
</head>
<body>
    <div class="container mt-5 col-sm-5 pt-3 border">
        <form method="post" action="index.php">
            <div class="form-group">
                <label for="title" class="col-sm-5 font-weight-bold offset-sm-5">TODO LIST</label>
            </div>
            <hr/>
            <div class="form-group">
                <div class="col-sm-10 offset-sm-1">
                    <input type="text" class="form-control" name="addItem" id="addItem" placeholder="Add Item ...">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 offset-sm-1">
                    <button type="submit" class="btn btn-primary" name="addButton">Add</button>
                </div>
            </div>
            <div class="form-group" id="itemContainer">
                <?php
                // Truy vấn danh sách công việc
                $sql = "SELECT * FROM todos";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $taskStatusClass = ($row['completed'] == 1) ? "completed" : "";
                        $taskId = $row['todoid'];
                        $taskName = $row['task'];
                        echo "<div class='col-sm-10 offset-sm-1'>
                                <div class='input-group mb-3'>
                                    <input type='text' class='form-control' name='editedTaskName' placeholder='Edit Task' value='$taskName'>
                                    <input type='hidden' name='taskId' value='$taskId'>
                                    <div class='input-group-append'>
                                        <button class='btn btn-danger deleteButton' type='submit' name='deleteButton'>Delete</button>
                                        <button class='btn btn-primary editButton' type='submit' name='editButton'>Edit</button>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo "Không có công việc nào.";
                }
                ?>
            </div>
        </form>
    </div>
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>

</body>
</html>
