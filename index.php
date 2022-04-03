<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <title>iNotes | World's best note taking app</title>
</head>

<body>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Title</label>
                            <input type="text" name="editTitle" class="form-control" id="editTitle" placeholder="e.g. Visit Supermarket">
                        </div>
                        <div class="mb-3">
                            <label for="editDesc" class="form-label">Description</label>
                            <textarea class="form-control" name="editDesc" id="editDesc" cols="30" rows="6" placeholder="e.g. I have to visit supermarket tomorrow for shopping..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Don't Save</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Delete Modal
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                    <a class="nav-link" href="#">About</a>
                    <a class="nav-link" href="#">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <?php
    if (isset($_GET["delete"])) {
        $sno = $_GET["delete"];
        $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
        include "./conn.php";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Congratulations.</strong> Your note has been deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Sorry.</strong> Note did not deleted.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["snoEdit"])) {
            // Update Note Records
            $sno = $_POST["snoEdit"];
            $title = $_POST["editTitle"];
            $desc = $_POST["editDesc"];
            $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$desc' WHERE `notes`.`sno` = $sno";
            include "./conn.php";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congratulations.</strong> Your note has been updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Sorry.</strong> Note did not updated.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
        } else {
            // Add New Note
            $title = $_POST["title"];
            $desc = $_POST["desc"];

            // Database Connection
            include "./conn.php";

            // Checking Connection
            if (!$conn) {
                die("Connection error: " . mysqli_connect_error());
            } else {
                // Inserting Notes Data into Database
                $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$desc');";
                $result = mysqli_query($conn, $sql);
                // Success and Failure Message
                if ($result) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Congratulations.</strong> Your note has been created successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Sorry.</strong> Note did not created.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
            }
        }
    }
    ?>

    <div class="container my-4">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-3">
                <h2>Create Note</h2>
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="e.g. Visit Supermarket">
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Description</label>
                <textarea class="form-control" name="desc" id="desc" cols="30" rows="6" placeholder="e.g. I have to visit supermarket tomorrow for shopping..."></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add Note</button>
        </form>
    </div>

    <div class="container my-4">
        <h2 class="text-center bg-dark p-2">All Notes</h2>
        <table class="table table-striped table-hover" id="notesTable">
            <thead>
                <tr>
                    <th scope="col">S. No.</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database Connection
                include "./conn.php";

                $sql = "SELECT * FROM `notes`;";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $no = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $no = $no + 1;
                        echo "<tr>
                        <th scope='row'>" . $no . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>
                            <button type='button' id=" . $row['sno'] . " class='edit btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editModal'>
                                Edit
                            </button>
                            <button type='button' id=d" . $row['sno'] . " class='delete btn btn-sm btn-danger'>
                                Delete
                            </button>
                        </td>
                        </tr>";
                    }
                } else {
                    echo "0 Records Found";
                }
                ?>

            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#notesTable').DataTable();
        });
    </script>
    <script>
        edits = document.getElementsByClassName("edit")
        Array.from(edits).forEach(element => {
            element.addEventListener("click", (e) => {
                // console.log("edit", e.target.parentNode.parentNode)
                tr = e.target.parentNode.parentNode
                title = tr.getElementsByTagName("td")["0"].innerText
                description = tr.getElementsByTagName("td")["1"].innerText
                // console.log("Title: ", title, "Description: ", description)
                snoEdit.value = e.target.id
                console.log(e.target.id)
                editTitle.value = title
                editDesc.value = description
            })
        });

        deletes = document.getElementsByClassName("delete")
        Array.from(deletes).forEach(element => {
            element.addEventListener("click", (e) => {
                sno = e.target.id.substr(1, )
                if (confirm("Are you sure you want to delete?")) {
                    window.location = `/crud/index.php?delete=${sno}`
                }
            })
        });
    </script>
</body>

</html>