<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

############################################################################# 
$id = $_GET['id'];

$sql = "select * from roles where id = $id";
$op = mysqli_query($con,$sql);

if(mysqli_num_rows($op) == 1){
    // code ..... 
    $data = mysqli_fetch_assoc($op);
}else{
    $_SESSION['Message'] = ["Message" => "Invalid Id"];
    header("Location: index.php");
    exit();
}
############################################################################# 







# Code ..... 

if($_SERVER['REQUEST_METHOD'] == "POST"){

   $title = Clean($_POST['title']);

   # Validate Title .... 
   $errors = [];

   if(!Validate($title,1)){
      $errors['Title'] = "Required Field";
   }elseif(!Validate($title,6)){
      $errors['Title'] = "Invalid String"; 
   }


     if(count($errors) > 0){
          # Set Session ...... 
       $_SESSION['Message'] = $errors;
     }else{
        // DB CODE ..... 
        $sql = "update roles set title='$title' where id = $id";
        $op  = mysqli_query($con,$sql);

        if($op){
            $Message = ["Message" => "Raw Updated"];
        }else{
            $Message = ["Message" => "Error Try Again ".mysqli_error($con)];
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
              if(isset($_SESSION['Message'])){
                Messages($_SESSION['Message']);
             
                 # Unset Session ... 
                 unset($_SESSION['Message']);
            }
           
           ?>

        </ol>


        <div class="card mb-4">

            <div class="card-body">

                <form action="edit.php?id=<?php echo ($data['id']); ?>" method="post">

                    <div class="form-group">
                        <label for="exampleInputName">Title</label>
                        <input type="text" class="form-control" id="exampleInputName" name="title" aria-describedby=""
                            placeholder="Enter Title"  value="<?php echo $data['title'];?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>





            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
