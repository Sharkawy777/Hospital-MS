<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
$sql = 'select users.* from users join roles on users.role_id = roles.id where roles.title = "doctor"';
$RoleOp = mysqli_query($con, $sql);
#############################################################################
$id = $_GET['id'];

$sql = "select * from appointments_doctor where id = $id";
$op = mysqli_query($con, $sql);

if (mysqli_num_rows($op) == 1) {
    // code .....
    $data = mysqli_fetch_assoc($op);
} else {
    $_SESSION['Message'] = ["Message" => "Invalid Id"];
    header("Location: index.php");
    exit();
}
#############################################################################


# Code .....

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $Day = Clean($_POST['day']);
    $StartTime = $_POST['from_time'];
    $EndTime = $_POST['to_time'];
    $DrId = $_POST['doctors_id'];


    # Validate day
    $errors = [];

    # Validate Title
    if (!Validate($Day, 1)) {
        $errors['Title'] = 'Required Field';
    }

    # Validate Start Time ...
    if (!Validate($StartTime, 1)) {
        $errors['Start Time'] = 'Required Field';
    } /*elseif (Validate($StartTime,8)) {
        $errors['Start Time'] = 'Invalid time Format';
    }*/

    # Validate End Time ...
    if (!Validate($EndTime, 1)) {
        $errors['End Time'] = 'Required Field';
    } /*elseif (Validate($EndTime,8)) {
        $errors['End Time'] = 'Invalid time Format';
    }*/

    # Validate Dr id ....
    if (!Validate($DrId, 1)) {
        $errors['Doctor'] = 'Field Required';
    } elseif (!Validate($DrId, 4)) {
        $errors['Doctor'] = 'Invalid Id';
    }


    if (count($errors) > 0) {
        # Set Session ......
        $_SESSION['Message'] = $errors;
    } else {
        // DB CODE .....
        $sql = "update appointments_doctor set day='$Day' , from_time= '$StartTime' , to_time='$EndTime',  doctors_id= '$DrId' where id = '$id'";
        $op = mysqli_query($con, $sql);

        if ($op) {
            $Message = ["Message" => "Raw Updated"];
        } else {
            $Message = ["Message" => "Error Try Again " . mysqli_error($con)];
        }

        # Set Session ......
        $_SESSION['Message'] = $Message;
        header("Location: index.php");
        exit();

    }
}

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard/Roles/Edit</li>

                <?php
                echo '<br>';
                if (isset($_SESSION['Message'])) {
                    Messages($_SESSION['Message']);

                    # Unset Session ...
                    unset($_SESSION['Message']);
                }

                ?>

            </ol>


            <div class="card mb-4">

                <div class="card-body">

                    <form action="edit.php?id=<?php echo($data['id']); ?>" method="post">

                        <div class="form-group">
                            <label for="exampleInputName">Day</label>
                            <input type="text" class="form-control" id="exampleInputName" name="day"
                                   aria-describedby=""
                                   placeholder="Enter Title" value="<?php echo $data['day']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">Start Time</label>
                            <input type="time" class="form-control" id="exampleInputName" name="from_time"
                                   aria-describedby=""
                                   placeholder="Enter Time" value="<?php echo $data['from_time']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">End Time</label>
                            <input type="time" class="form-control" id="exampleInputName" name="to_time"
                                   aria-describedby=""
                                   placeholder="Enter Time" value="<?php echo $data['to_time']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword">Doctor</label>
                            <select class="form-control" id="exampleInputPassword1" name="doctors_id">

                                <?php
                                while ($data = mysqli_fetch_assoc($RoleOp)) {
                                    ?>

                                    <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>

                                <?php }
                                ?>

                            </select>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php
require '../layouts/footer.php';
?>