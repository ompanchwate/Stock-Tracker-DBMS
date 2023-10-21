<?php
ob_start();
session_start();
include('inc/header.php');

$registrationError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['pwd'])) {
        include 'Inventory.php';
        $inventory = new Inventory();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['pwd'];

        // You should implement input validation and password hashing for security.

        // Check if the email is already registered.
        $existingUser = $inventory->getUserByEmail($email);

        if (empty($existingUser)) {
            // Register the user.
            $userId = $inventory->registerUser($name, $email, $password);

            if ($userId) {
                $_SESSION['userid'] = $userId;
                $_SESSION['name'] = $name;
                header("Location: index.php");
            } else {
                $registrationError = "Registration failed. Please try again.";
            }
        } else {
            $registrationError = "This email is already registered. Please choose another email.";
        }
    } else {
        $registrationError = "All fields are required.";
    }
}
?>

<!-- Your HTML and CSS code for the registration form -->
<style>
/* Add your CSS styles here */
</style>

<?php include('inc/container.php'); ?>
<div class="col-lg-4 col-md-5 col-sm-10 col-xs-12 container" style="margin-top:90px">
    <div class="card rounded-0 shadow">
        <div class="card-header">
            <div class="card-title h3 text-center mb-0 fw-bold">Register</div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <form method="post" action="">
                    <div class="form-group">
                        <?php if ($registrationError) { ?>
                            <div class="alert alert-danger rounded-0 py-1"><?php echo $registrationError; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="control-label">Full Name</label>
                        <input name="name" id="name" type="text" class="form-control rounded-0" placeholder="Full Name" autofocus="" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="control-label">Email</label>
                        <input name="email" id="email" type="email" class="form-control rounded-0" placeholder="Email address" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" class="form-control rounded-0" id="password" name="pwd" placeholder="Password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="register" class="btn btn-primary rounded-0">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('inc/footer.php'); ?>
