<?php
session_start();

if (!isset($_SESSION[""]) && $_SESSION[""]) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [
        1 => ['fullname' => 'ESCOSIO','course' => 'BSIT'],
        2 => ['fullname' => 'RAC','course' => 'BSN'],
        3 => ['fullname' => 'DISO','course' => 'BSTM'],
        4 => ['fullname' => 'MARTINEZ','course' => 'BSHM'],
        5 => ['fullname' => 'GAMUZARAN','course' => 'BEED']
    ];
}

if (isset($_POST['save'])) {
    $fullname = $_POST['fullname'];
    $course = $_POST['course'];
    $id = $_POST['id'];

    if ($id == "") {
        $newId = count($_SESSION['students']) > 0
            ? max(array_keys($_SESSION['students'])) +1
            : 1;
            
            $_SESSION['students'][$newId] = [
                'fullname' => $fullname,
                'course'=> $course,
            ];
    }else{
            $_SESSION['students'][$id] = [
                'fullname' => $fullname,
                'course'=> $course,
            ];
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    if(isset($_SESSION['students'][$id])){
        unset($_SESSION['students'][$id]);
    }

    $_SESSION['success']="Student record deleted successfully";
    header("Location:".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <?php include("navbar.php")?>
        <?php include("sidenav.php")?>
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>

                        </ol>
                        <button type="button" class="btn btn-success ms-auto d-flex" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>

                    <div class= "card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">ID</th>
                                    <th>Full Name</th>
                                    <th>Course</th>
                                    <th style="width: 150px">Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                     <?php foreach($_SESSION['students'] as $id => $student): ?>
                                <tr>
                                    <td><?= $id ?></td>
                                    <td><?= htmlspecialchars($student['fullname']) ?></td>
                                    <td><?= htmlspecialchars($student['course']) ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="confirmDelete(<?=$id?>)">
                                        <i class="fa-solid fa-trash"></i></button>
                                     </a>
                                    </td>
                                </tr>
        <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data Entry</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">

                                    <form method="POST">
                                    <input type="hidden" name="id" value="">
                                        <div class="row">
                                            <div class="mb-2 w-50">
                                                <input type="text" name="fullname"
                                                class="form-control" placeholder="Full name" required>
                                                </div>
                                            <div class="mb-2 w-50">
                                                <input type="text" name="course"
                                                class="form-control" placeholder="Course" required>
                                        </div>
                                </div>
                                    <div class="modal-footer">
                                        <button name="save" class="btn btn-primary">Save</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                     </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <?php include("footer.php")?>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>

        <script>
            function confirmDelete(id){
                Swal.fire({
                    title: "Are you Sure?",
                    text:"This record will be permanently deleted",
                    icon:'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    CancelButtonColor: '#6c757d',
                    confirmButtonText:'Yes',
                    CancelButtonText:'Cancel'

                }).then((result)=>{
                    if(result.isConfirmed){
                        window.location.href ="?delete="+id;
                    }
                });
                
            }
        </script>
    </body>
</html>
