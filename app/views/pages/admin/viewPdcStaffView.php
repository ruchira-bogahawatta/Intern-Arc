<?php require APPROOT . '/views/includes/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/admin.css">
<?php require APPROOT . '/views/includes/navbar.php'; ?>

<section class="viewpdcstaff-content">

<br>
        <div class="pdctop">
	
            <div class="pflex-container">
            
                <div class="pflex-wrap2">
                    <div>
                        <h3>PDC User</h3>
                    </div>
                    <div>
                        <form id="pdcform">
                            <input type="text" placeholder="Search User" name="search">
                        </form>
                    </div>
                </div>
            
                <table class="pdc-table" >
                    <tr>
                      <th class="pdc-table-header">Name</th>
                      <th class="pdc-table-header">Email</th>
                      <th class="pdc-table-header"></th>
                    </tr>
            
                    <tr>
                      <td class="pdc-table-data">Ruchira Bogahawatta</td>
                      <td class="pdc-table-data">ruchira@ucsc.cmb.lk</td>
                      <td class="pdc-table-data"><button>view</button></td>
                    </tr>
            
                    <tr>
                        <td class="pdc-table-data">Geeth Weerasinghe</td>
                        <td class="pdc-table-data">geeth@ucsc.cmb.lk</td>
                        <td class="pdc-table-data"><button>view</button></td>
                    </tr>
            
                    <tr>
                        <td class="pdc-table-data">Namadee Shakya</td>
                        <td class="pdc-table-data">namadee@ucsc.cmb.lk</td>
                        <td class="pdc-table-data"><button>view</button></td>
                    </tr>
            
                    <tr>
                        <td class="pdc-table-data">Ravindu Viranga</td>
                        <td class="pdc-table-data">ravindu@ucsc.cmb.lk</td>
                        <td class="pdc-table-data"><button>view</button></td>
                    </tr>
            
                    <tr>
                        <td class="pdc-table-data">Ruchira Bogahawatta</td>
                        <td class="pdc-table-data">ruchira@ucsc.cmb.lk</td>
                        <td class="pdc-table-data"><button>view</button></td>
                    </tr>
            
                    <tr>
                        <td class="pdc-table-data">Ruchira Bogahawatta</td>
                        <td class="pdc-table-data">ruchira@ucsc.cmb.lk</td>
                        <td class="pdc-table-data"><button>view</button></td>
                    </tr>
            
                    <tr>
                        <td class="pdc-table-data">Ruchira Bogahawatta</td>
                        <td class="pdc-table-data">ruchira@ucsc.cmb.lk</td>
                        <td class="pdc-table-data"><button>view</button></td>
                    </tr>
                    
                  </table>

                  <input class="pdc-staff-add-button" type="submit" value="Add">
                       
            </div>
            </div>

</section>
<?php require APPROOT . '/views/includes/footer.php'; ?>