<?php require APPROOT . '/views/includes/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/pdc.css">
<script src="<?php echo URLROOT; ?>js/pdc.js" defer></script>
<?php require APPROOT . '/views/includes/navbar.php'; ?>

<section class="main-content display-flex-col">
    <div class="display-flex-row register-student-top">
        <div class="display-flex-row">Batch
            <p>2022 Batch</p>
        </div>
        <span class="material-symbols-outlined " id="add-student-top-icon">
            keyboard_double_arrow_right
        </span>
        <div class="display-flex-row">Stream
            <p>Information System</p>
        </div>
    </div>
    <div class="add-student-container add-company-container display-flex-row">
        <div class="register-company display-flex-col">
            <h2>Register a Student</h2>
            <form action="<?php echo URLROOT . "register/register-student"; ?>" method="POST" class="display-flex-col">
                <ul class="display-flex-col">
                    <li class="display-flex-col">
                        <label for="username">Student Name</label>
                        <input type="text" name="username" id="username" class="common-input" value="<?php echo $data['username']; ?>" required>
                    </li>
                    <li class="display-flex-col">
                        <div class="display-flex-col">
                            <label for="email">Student Email</label>
                            <input type="text" name="email" id="email" class="common-input" required value="<?php echo $data['email']; ?>">
                        </div>
                        <span class="input-validate-error"><?php echo $data['email_error']; ?></span>
                    </li>
                    <li class="display-flex-col">
                        <div class="display-flex-col">
                            <label for="registration_number">Registration Number</label>
                            <input type="text" name="registration_number" id="registration_number" class="common-input" value="<?php echo $data['registration_number']; ?>" required>
                        </div>

                    </li>

                    <li class="display-flex-col ">
                        <div class="display-flex-col">
                            <label for="index_number">Index Number</label>
                            <input type="text" name="index_number" id="index_number" class="common-input" required value="<?php echo $data['index_number']; ?>">
                        </div>
                        <span class="input-validate-error"> <?php echo $data['credential_error']; ?></span>
                    </li>
                </ul>
                <button type="submit" class="common-blue-btn">Register Student</button>
            </form>
        </div>
        <div class="csv-company display-flex-col">
            <h2>Upload CSV</h2>
            <div class="csv-company-middle display-flex-col">
                <div class="csv-instructions display-flex-row">
                    <span class="material-symbols-outlined">
                        help
                    </span>
                    Instructions
                </div>
                <p><span>Step 1 : </span>
                    Download this CSV template and enter the details accordingly.
                </p>
                <a href="<?php echo URLROOT . "templates/studentListTemplate.csv"; ?>" class="display-flex-row">
                    <span class="material-symbols-outlined">
                        downloading
                    </span>
                    Download CSV Template
                </a>
            </div>
            <div class="display-flex-col">

                <p><span>Step 2 : </span> Enter student details without changing the layout of the csv.</p>
            </div>
            <div class="display-flex-col">

                <p><span>Step 3 : </span> Upload and press submit to complete the registration.</p>
            </div>
            <div class="csv-company-bottom">
                <form action="<?php echo URLROOT . "register/register-students"; ?>" name="uploadCsv" enctype="multipart/form-data" method="POST" class="display-flex-col">
                    <label for="company-csv" class="display-flex-row">
                        <span class="material-symbols-outlined">
                            drive_folder_upload
                        </span>
                        Choose a File</label>
                    <p id="register-csv-file">No file Choosen</p>
                    <input type="file" name="company-csv" id="company-csv" accept=".csv">
                    <button type="submit" class="common-blue-btn">Register</button>
                </form>
            </div>
        </div>
    </div>
</section>


<?php require APPROOT . '/views/includes/footer.php'; ?>