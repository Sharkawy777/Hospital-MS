<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################
# Fetch  User Data .......
echo $username = $_SESSION['user']['id'];
$sql = "select users.*,roles.title  from  users inner join roles on users.role_id = roles.id where roles.title = 'patient'  and users.id = '$username'";
$op = mysqli_query($con, $sql);
################################################################

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard/Patients/display</li>
            <?php

            echo '<br>';
            if(isset($_SESSION['Message'])){
                Messages($_SESSION['Message']);

                # Unset Session ...
                unset($_SESSION['Message']);
            }

            ?>
        </ol>
        <a href='create.php'
           class='btn btn-danger m-r-1em'>Create new patient</a>

        <div class="card mb-4">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>phone</th>
                            <th>role</th>
                            <th>image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>phone</th>
                            <th>role</th>
                            <th>image</th>
                            <th>Action</th>
                        </tfoot>
                        <tbody>

                        <?php
                        # Fetch Data ......
                        while($data = mysqli_fetch_assoc($op)){

                            ?>

                            <tr>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['name']; ?></td>
                                <td><?php echo $data['email']; ?></td>
                                <td><?php echo $data['phone']; ?></td>
                                <td><?php echo $data['title']; ?></td>
                                <td> <img src="./uploads/<?php echo $data['image']; ?>" height="40px" width="40px">  </td>


                                <td>
                                    <a href='delete.php?id=<?php echo $data['id']; ?>'
                                       class='btn btn-danger m-r-1em'>Delete</a>
                                    <a href='edit.php?id=<?php echo $data['id']; ?>' class='btn btn-primary m-r-1em'>Edit</a>
                                </td>

                            </tr>

                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
