<?php

// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Go to buy shoe', 'kazi go to bata shop and buya a shoe in the range of 1500-2000 taka', current_timestamp());
$insert = false;
$server = "localhost";
$username = "root";
$password = "1260";
$database = "notes";

$conn = mysqli_connect($server,$username,$password,$database);

if(!$conn){
    die("Connection to the database failed due to: " . mysqli_connect_error());
}
// echo $_SERVER['REQUEST_METHOD'];

if($_SERVER['REQUEST_METHOD'] == "POST"){

  $title = $_POST["title"];
  $description = $_POST["description"];

  $sql = "INSERT INTO `notes`(`title`, `description`) values ('$title', '$description')";

  $result = mysqli_query($conn , $sql);

  if($result){
    // echo "The record has been inserted! <br>";
    $insert = true;

  }
  else{
    echo "The record failed to inserted! <br>" . mysqli_error($conn);
  }



}



 ?>














<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes --Notes taking make easy </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>



</head>



<body>

<!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModel">
  Edit Modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModel" tabindex="-1" aria-labelledby="editModelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/php_crud/index.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" name="titleEdit" id="titleEdit" aria-describedby="emailHelp">

            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" rows="3"></textarea>
            </div>


            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                    </li>

                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>


    <?php

      if($insert ){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your Record has been inserted succesfully!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }

      ?>

    <div class="container my-4">

        <h2>Add your Note</h2>

        <form action="/php_crud/index.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">

            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>


            <button type="submit" class="btn btn btn-success">Add Note</button>
        </form>

    </div>

    <div class="container my-4">


        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php

          $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn , $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;

            echo "
            <tr>
      <th scope='row'>".$sno."</th>
      <td>".$row['title']."</td>
      <td>".$row['description'] ."</td>
      <td><button class='edit btn btn-sm btn btn-success'>Edit</button> <button class='delete btn btn-sm btn btn-danger'>Delete</button> </td>
    </tr>";
    

          }
?>


            </tbody>
        </table>
    </div>
    <hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
        <script>
            edits = document.getElementsByClassName('edit');
            Array.from(edits).forEach((element) =>{
                element.addEventListener("click" ,(e) =>{
                    console.log('edit' , );
                    tr = e.target.parentNode.parentNode;
                    title = tr.getElementsByTagName("td")[0].innerText;
                    description= tr.getElementsByTagName("td")[1].innerText;
                    console.log(title ,description);
                    titleEdit.value = title;
                    descriptionEdit.value = description;

                    $("#editModel").model();

                    
                })
            })
        </script>
</body>

</html>