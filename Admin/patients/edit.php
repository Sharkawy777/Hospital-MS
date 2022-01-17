<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

############################################################################# 
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $sql = "select * from roles where roles.title = 'patient'";
    $RoleOp = mysqli_query($con, $sql);

    $sql = "select * from users where id = '$id'";
    $op = mysqli_query($con, $sql);

    if (mysqli_num_rows($op) == 1) {
        $data = mysqli_fetch_assoc($op);
    } else {
        $_SESSION['Message'] = ["Message" => "Invalid Id"];
        header("Location: index.php");
        exit();
    }
}
#############################################################################

# Code ..... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = Clean($_POST['name']);
    $gender = Clean($_POST['gender']);
    $email = Clean($_POST['email']);
    $password = Clean($_POST['password']);
    $address = Clean($_POST['address']);
    $phone = Clean($_POST['phone']);
    $emergencyPhone = Clean($_POST['emergencyPhone']);
    $role_id = Clean($_POST['role_id']);

    $errors = [];

    $errors = validate_data($name, $gender, $email, $password, $address, $phone, $emergencyPhone, $role_id, $errors);

    # Validate Image
    if (!Validate($_FILES['image']['name'], 1)) {
        $errors['Image'] = 'Field Required';
    } else {

        $ImgTempPath = $_FILES['image']['tmp_name'];
        $ImgName = $_FILES['image']['name'];

        $extArray = explode('.', $ImgName);
        $ImageExtension = strtolower(end($extArray));

        if (!Validate($ImageExtension, 7)) {
            $errors['Image'] = 'Invalid Extension';
        } else {
            $FinalName = time() . rand() . '.' . $ImageExtension;

        }
    }
    if (count($errors) > 0) {
        # Set Session ......
        $_SESSION['Message'] = $errors;
    } else {

        $password = md5($password);
        if ($gender == 'male')
            $gender = 1;
        elseif ($gender == 'female')
            $gender = 2;
        $sql = "update users set name='$name',gender='$gender',email='$email',password='$password',address='$address',phone='$phone',emergencyPhone='$emergencyPhone',image='$FinalName',role_id='$role_id' where id = '$id'";
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
            <li class="breadcrumb-item active">Dashboard/Patient/Edit</li>

            <?php
            echo '<br>';
            if (isset($_SESSION['Message'])) {
                Messages($_SESSION['Message']);

                # Unset Session ...
                unset($_SESSION['Message']);
            }
            ?>
        </ol>
        <a href='index.php'
           class='btn btn-danger m-r-1em'>Back</a>

        <div class="card mb-4">

            <div class="card-body">
                <form action="edit.php?id=<?php if ($data['id'] == $_SESSION['user']['id']) echo($data['id']); else {exit();}?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" name="name"
                               aria-describedby="" value="<?php echo $data['name']; ?>">
                    </div>


                    <label for="gender">Gender</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender"
                               value="male" <?php if ($data['gender'] == "1") {
                            echo 'checked';
                        } ?>>
                        <label class="form-check-label" for="male">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender"
                               value="female" <?php if ($data['gender'] == "2") {
                            echo 'checked';
                        } ?>>
                        <label class="form-check-label" for="female">
                            Female
                        </label>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                               aria-describedby="emailHelp"
                               value="<?php echo $data['email']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                               placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                               value="<?php echo $data['address']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="number" class="form-control" id="phone" name="phone"
                               value="<?php echo $data['phone']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="emergencyPhone">Emergency Phone</label>
                        <input type="number" class="form-control" id="emergencyPhone" name="emergencyPhone"
                               value="<?php echo $data['phone']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="image">Profile Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <img src="./uploads/<?php echo $data['image']; ?>" alt="" height="50px" width="50px"> <br>

                    <div class="form-group">
                        <label for="exampleInputPassword">Role</label>
                        <select class="form-control" id="exampleInputPassword1" name="role_id">

                            <?php
                            $data = mysqli_fetch_assoc($RoleOp)
                            ?>
                            <option value="<?php echo $data['id']; ?>" <?php if ($data['id'] == $data['title']) {
                                echo 'selected';
                            } ?>><?php echo $data['title']; ?></option>


                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>

                </form>

            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
