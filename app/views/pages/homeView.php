<?php require APPROOT . '/views/includes/header.php'; ?>


<section class="home-user-container">
  <div class="home-user-img">
    <img src="<?php echo URLROOT . 'img/home-user-img.svg' ?>" alt="Intern Arc Logo">
  </div>
  <div class="home-select-user display-flex-col ">
    <h1>Select a User</h1>
    <ul class="home-user-list display-flex-col ">
      <li>
        <a href="<?php echo URLROOT . 'login/pdc-login'; ?>"> <span class="material-symbols-rounded">
            person
          </span> PDC </a>
      </li>
      <li>
        <a href="<?php echo URLROOT . 'login/company-login'; ?>">
          <span class="material-symbols-rounded">
            person
          </span> Company </a>
      </li>
      <li>
        <a href="<?php echo URLROOT . 'login/student-login'; ?>"> <span class="material-symbols-rounded">
            person
          </span> Student </a>
      </li>
      <li>
        <a href="<?php echo URLROOT . 'login/admin-login'; ?>"> <span class="material-symbols-rounded">
            person
          </span> Admin </a>
      </li>
    </ul>
  </div>
</section>

<?php require APPROOT . '/views/includes/footer.php'; ?>