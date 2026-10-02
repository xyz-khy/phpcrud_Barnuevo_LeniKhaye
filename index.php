<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-pro-dark shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <div class="pro-nav-icon me-2">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                Student Management System
            </a>
            <div class="d-flex align-items-center">
                <span class="text-light me-3 small d-none d-md-inline">Welcome, <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm px-3 fw-semibold">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">Student Records</h3>
                <p class="text-muted small mb-0">Manage and oversee all registered student information.</p>
            </div>
            <button type="button" class="btn btn-dark shadow-sm px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#add">
                <i class="fa-solid fa-user-plus me-1"></i> Add Student
            </button>
        </div>

        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <form action="insert.php" method="post">
                        <div class="modal-header bg-pro-dark text-white">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-user-plus me-2"></i>Add New Student</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small text-uppercase">First Name</label>
                                <input type="text" name="firstname" class="form-control py-2" placeholder="Enter first name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small text-uppercase">Last Name</label>
                                <input type="text" name="lastname" class="form-control py-2" placeholder="Enter last name" required>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark px-4">Save Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                       
                        <thead class="table-dark text-uppercase fs-7">
                            <tr>
                                <th class="py-3 ps-4">First Name</th>
                                <th class="py-3">Last Name</th>
                                <th class="py-3 text-center" style="width: 220px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT id, firstname, lastname FROM students";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_result($id, $firstname, $lastname);
                            $stmt->execute();
                            $stmt->store_result();

                            if ($stmt->num_rows > 0) {
                                while ($stmt->fetch()) {
                            ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark"><?php echo htmlspecialchars($firstname); ?></td>
                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($lastname); ?></td>
                                    <td class="text-center py-3">
                                        <button type="button" class="btn btn-sm btn-success px-3 py-1.5 me-1 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#edit<?php echo $id; ?>">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                        </button>

                                        <div class="modal fade" id="edit<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered text-start">
                                                <div class="modal-content border-0 shadow">
                                                    <form action="update.php" method="post">
                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Student</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-secondary small text-uppercase">First Name</label>
                                                                <input type="text" value="<?php echo htmlspecialchars($firstname); ?>" name="firstname" class="form-control py-2" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-secondary small text-uppercase">Last Name</label>
                                                                <input type="text" value="<?php echo htmlspecialchars($lastname); ?>" name="lastname" class="form-control py-2" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light border-0">
                                                            <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success px-4">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-sm btn-danger px-3 py-1.5 fw-semibold shadow-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                                            <i class="fa-solid fa-trash me-1"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No student records found in the database.</td>
                                </tr>
                            <?php
                            }
                            $stmt->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>