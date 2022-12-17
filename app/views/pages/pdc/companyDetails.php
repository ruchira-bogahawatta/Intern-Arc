<?php require APPROOT . '/views/includes/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/pdc.css">
<?php require APPROOT . '/views/includes/navbar.php'; ?>

<section class="main-content display-flex-col">
    <div class="company-details-main-container display-flex-row">
        <div class="company-details-container display-flex-col">
            <div class="container-top display-flex-row">
                <h2>Company Details</h2>
                <div class="container-top-update">
                    <div class="common-edit-btn" onclick="toggleProfileUpdate()"><span class="material-symbols-outlined">
                            edit_square
                        </span></div>
                </div>
            </div>

            <div class="container-body">
                <!-- Update Form -->
                <form action="" method="POST">
                    <ul class=" display-flex-col">
                        <li class="display-flex-row">
                            <label for="">Company Name</label>
                            <input type="text" class="common-input" name="company-name" id="company-name">
                        </li>
                        <li class="display-flex-row">
                            <label for="">Contact Person</label>
                            <input type="text" class="common-input" name="username" id="username">
                        </li>
                        <li class="display-flex-row">
                            <label for="">Email</label>
                            <input type="text" class="common-input" name="email" id="email">
                        </li>
                        <li class="display-flex-row">
                            <label for="">Contact Number</label>
                            <input type="number" class="common-input" name="contact" id="contact">
                        </li>
                        <li class="display-flex-row" id="toggleUpdateBtn">
                            <button type="submit" class="common-blue-btn">Update</button>
                        </li>
                    </ul>
                </form>
            </div>

            <div class="container-btns display-flex-row">
                <button id="view-btn"><a href="" id="view-btn">View Profile</a></button>
                <button id="blacklist-btn"><a href="" id="blacklist-btn" class="display-flex-row">
                        <span class="material-symbols-outlined">
                            flag
                        </span> Blacklist</a>
                </button>
                <button id="delete-btn"><a href="" id="delete-btn" class="display-flex-row">
                        <span class="material-symbols-outlined">
                            delete
                        </span>Delete</a>
                </button>
            </div>
        </div>
        <div class="company-details-analysis display-flex-col">
            <h3>Summarized Analysis</h3>
            <div class="display-flex-col analysis-items">
                <div class="display-flex-row">
                    <p>Total Advertisements Listed</p>
                    <span>10</span>
                </div>
                <div class="display-flex-row">
                    <p>Total Students Recruited</p>
                    <span>10</span>
                </div>
                <div class="display-flex-row">
                    <p>Total Students Recruited</p>
                    <span>10</span>
                </div>
            </div>

        </div>
    </div>

</section>


<?php require APPROOT . '/views/includes/footer.php'; ?>