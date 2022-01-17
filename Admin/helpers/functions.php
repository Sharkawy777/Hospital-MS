<?php

function Clean($input)
{

    return trim(strip_tags(stripslashes($input)));
}


function Validate($input, $flag, $length = 6)
{

    $status = true;

    switch ($flag) {
        case 1:
            # code...
            if (empty($input)) {
                $status = false;
            }
            break;

        case 2:
            # code ....
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $status = false;
            }
            break;


        case 3:
            #code ....
            if (strlen($input) < $length) {
                $status = false;
            }
            break;


        case 4:
            # code ....
            if (!filter_var($input, FILTER_VALIDATE_INT)) {
                $status = false;
            }
            break;


        case 5:
            #code ....
            if (!preg_match('/^01[0-2,5][0-9]{8}$/', $input)) {
                $status = false;
            }
            break;


        case 6:
            #code ....
            if (!preg_match('/^[a-zA-Z\s]*$/', $input)) {
                $status = false;
            }
            break;


        case 7:
            # Code ....
            $allowedExt = ['png', 'jpg'];
            if (!in_array($input, $allowedExt)) {
                $status = false;
            }
            break;

    }

    return $status;

}

function validate_data($name, $gender, $email, $password,$address,$phone,$emergencyPhone,$role_id, $errors){
    if (!Validate($name, 1)) {
        $errors['Name'] = 'Required Field';
    } elseif (!Validate($name, 6)) {
        $errors['Name'] = 'Invalid String';
    }
    if (!Validate($gender, 1)) {
        $errors['gender'] = 'Required Field';
    }
    if (!Validate($address, 1,20)) {
        $errors['address'] = 'Required Field';
    }elseif (!Validate($address, 3)) {
        $errors['addressLength'] = 'Length must be >= 20 chars';
    }

    # Validate Email
    if (!Validate($email, 1)) {
        $errors['Email'] = 'Field Required';
    } elseif (!Validate($email, 2)) {
        $errors['Email'] = 'Invalid Email';
    }


    # Validate Password
    if (!Validate($password, 1)) {
        $errors['Password'] = 'Field Required';
    } elseif (!Validate($password, 3)) {
        $errors['Password'] = 'Length must be >= 6 chars';
    }


    # Validate role_id ....
    if (!Validate($role_id, 1)) {
        $errors['Role'] = 'Field Required';
    } elseif (!Validate($role_id, 4)) {
        $errors['Role'] = "Invalid Id";
    }


    # Validate phone ....
    if (!Validate($phone, 1)) {
        $errors['Phone'] = 'Field Required';
    } elseif (!Validate($phone, 5)) {
        $errors['phone'] = 'InValid Number';
    }
    # Validate $emergencyPhone ....
    if (!Validate($emergencyPhone, 1)) {
        $errors['emergencyPhone'] = 'Field Required';
    } elseif (!Validate($emergencyPhone, 5)) {
        $errors['emergencyPhone'] = 'Invalid Number';
    }

    return $errors;
}

/*function validate_image($errors){
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
            $_SESSION['imageName']=$FinalName;
        }
    }
    return $errors;
}*/
function Messages($Message)
{
    foreach ($Message as $key => $value) {
        # code...
        echo '* ' . $key . ' : ' . $value . '<br>';

    }

}

function Url($url = null){

    return   'http://'.$_SERVER['HTTP_HOST'].'/Hospital-MS/admin/'.$url;

}




?>