<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

#########################################################################
# Fetch Roles .... 
$sql = "select * from roles";
$RoleOp = mysqli_query($con, $sql);

#########################################################################


# Code .....

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
//    $errors = validate_image($errors);
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
        $Message = $errors;
    } else {
        // DB CODE .....
        $disPath = './uploads/' . $FinalName;

        if (move_uploaded_file($ImgTempPath, $disPath)) {

            $password = md5($password);
            if ($gender == 'male')
                $gender = 1;
            elseif ($gender == 'female')
                $gender = 2;
            $sql = "insert into users (`name`, `gender`, `email`, `password`,`address`,`phone`,`emergencyPhone`,`image`,`role_id`) values ('$name','$gender','$email','$password','$address','$phone','$emergencyPhone','$FinalName','$role_id')";
            $op = mysqli_query($con, $sql);

            if ($op) {
                $Message = ['Message' => 'Raw Inserted'];
            } else {
                $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
            }

        } else {
            $Message = ['Message' => 'Error  in uploading Image  Try Again '];
        }

    }
    # Set Session ......
    $_SESSION['Message'] = $Message;
    header("Location: index.php");
    exit();
}

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>


<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard/Users/Create</li>

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

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" name="name" aria-describedby=""
                               placeholder="Enter Name">
                    </div>

                    <label for="gender">Gender</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="male">
                        <label class="form-check-label" for="male">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="female">
                        <label class="form-check-label" for="female">
                            Female
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                               aria-describedby="emailHelp"
                               placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                               placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                               placeholder="Enter your address">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="number" class="form-control" id="phone" name="phone"
                               placeholder="01xxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label for="emergencyPhone">Emergency Phone</label>
                        <input type="number" class="form-control" id="emergencyPhone" name="emergencyPhone"
                               placeholder="01xxxxxxxxx">
                    </div>

                    <div class="form-group">
                        <label for="image">Profile Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword">Role</label>
                        <select class="form-control" id="exampleInputPassword1" name="role_id">

                            <?php
                            while ($data = mysqli_fetch_assoc($RoleOp)) {
                                ?>
                                <option value="<?php echo $data['id']; ?>"><?php echo $data['title']; ?></option>
                            <?php }
                            ?>

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
