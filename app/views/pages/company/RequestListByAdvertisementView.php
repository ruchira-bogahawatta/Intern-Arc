<?php require APPROOT . '/views/includes/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/company.css">
<?php require APPROOT . '/views/includes/navbar.php'; ?>

<section class="main-content">
  <div class="common_list">
    <div class="common-list-topbar">
    <form action="" class="common-search-bar display-flex-row">
                <span class="material-symbols-rounded">
                    search
                </span>
                <input class="common-input" type="text" name="search-item" placeholder="Search Advertisement">
      </form>
      <div class="common-filter">
        <span class="material-symbols-rounded">
          filter_alt
        </span>
        <select name="filter-list" id="filterlist">
          <option value="all" selected>All</option>
          <option value="name">name</option>
          <option value="name">name</option>
          <option value="name">name</option>
        </select>
      </div>
    </div>

    <div class="common_list_content">
      
      <div class="addBtn">
      <h3>Student Requests</h3>
</div>
      <table class="common-table">
        <tr>
          <th>Student Name</th>
          <th>Student Email</th>
          <th>View</th>
          <th>Status</th>
          
       
        </tr>
        <?php foreach ($data['student_name'] as $students) : ?>
            <tr>
            <td><?php echo $students->profile_name ?></p></td>
            <td><?php echo $students->personal_email ?></td>
            <td>
             <a class="common-view-btn" href="<?php echo URLROOT; ?>requests/view-student-request" >View</a>
            </td>
            <td>
            <label for="status"></label>
              <select id="status" name="status">
              <option value="<?php echo $students->status ?>"><?php echo $students->status ?></option>
                <option value="<?php echo $students->status ?>">Shortlist</option>
                <option value="<?php echo $students->status ?>t">Reject</option>
              </select>
            </td>

          </tr>
        
        <?php endforeach; ?>
       
      </table>
    </div>

  </div>

</section>

<?php require APPROOT . '/views/includes/footer.php'; ?>