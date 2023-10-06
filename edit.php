<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "customerdb";

    //create connection
    $connection = new mysqli($servername,$username,$password,$database);

    $id     ="";
    $name   ="";
    $email  ="";
    $phone  ="";
    $address="";

    $errorMessage ="";
    $successMessage ="";

    // GET method: Show the data of clients
    if ( $_SERVER['REQUEST_METHOD'] == 'GET'){
        // if id of client does not exist 
        if( !isset($_GET["id"])){
            header("location: /Customer_Info/index.php");
                exit;
        }

        $id   = $_GET["id"];

        // read the row of the selected client from database table
        $sql = "SELECT * FROM clients WHERE id=$id ";
        $result = $connection -> query($sql);
        //read data
        $row = $result -> fetch_assoc();

        if(!$row){
            header("location: /Customer_Info/index.php");
                exit;
        }

    //update data
        $name   = $row["name"];
        $email  = $row["email"];
        $phone  = $row["phone"];
        $address= $row["address"];
    }else{
        //************************************************************************** */
        //POST mthod : Update the data of client
        $id     = $_POST["id"];
        $name   = $_POST["name"];
        $email  = $_POST["email"];
        $phone  = $_POST["phone"];
        $address= $_POST["address"];

        do{
            if(empty($name) || empty($email) || empty($phone) || empty($address)){
                $errorMessage = "All the field are required";
                //exit loop
                break;
            }

            //UPDATE DATA
            $sql = "UPDATE clients SET name ='$name', email ='$email', phone='$phone', address='$address WHERE id =$id ";
            
            $result = $connection ->query($sql);

            //if inserting fail show error
            if(!$result){
                $errorMessage = "Invalid query : " .$connection-> error;
                break;
            }

            $successMessage ="Client updated coreectly";
            
            header("location: /Customer_Info/index.php");
            exit;

        }while(false);
    }
?>


<!-- Body copt from create.php modify -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New Client </h2>

        <!-- if error message not empty then display error -->
        <?php 
            if(!empty($errorMessage)){
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }
        ?>

        <form method="post">


            <div class="post">


                <!-- HIDDEN id for refer -->
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                    </div>
                </div>


                <?php 
                    if(!empty($successMessage)){
                        echo "
                        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        ";
                    }
                ?>

                <!-- BUTTON -->
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="/Customer_info/index.php" role="button">Cancel</a>
                    </div>

            </div>
        </form>
    </div>
</body>
</html>