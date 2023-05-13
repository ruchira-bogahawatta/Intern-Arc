<?php

class Admin extends BaseController
{
    public $adminModel, $userModel, $companyModel, $studentModel;

    public function __construct()
    {
        $this->adminModel = $this->model('Admin');
        $this->studentModel = $this->model('Student');
        $this->userModel = $this->model('User');
        $this->companyModel = $this->model('Company');
    }

    public function index() //default method and view
    {

        $this->view('admin/dashboard');
    }


    public function company() //View main company list - Ruchira
    {
        $companyList = $this->companyModel->getCompanyList();

        $data = [
            'company_list' => $companyList
        ];

        $this->view('admin/company', $data);
    }

    public function mainCompanyDetails($user_id = NULL, $blacklist = NULL) //View company main details - Ruchira
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //update Company Details
            stripTags();
            $data = [
                'user_id' => $user_id,
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'contact' => trim($_POST['contact']),
                'company_name' => trim($_POST['company_name']),
                'old_email' => trim($_POST['old_email'])
            ];

            //Check for User Availability with the same email
            $user = $this->userModel->getUserByEmail(trim($_POST['email']));

            if ($user && $user->email != trim($_POST['old_email'])) {
                flashMessage('main_details_msg', 'Entered Email is already available, Please check again!', 'danger-alert');
                redirect('admin/main-company-details/' . $user_id);
            }

            $this->companyModel->updateMainCompanyDetails($data);
            flashMessage('main_details_msg', 'Company Details Updated Successfully!');
            redirect('admin/main-company-details/' . $user_id);
        } else {

            //Get the companyID
            $companyID = $this->userModel->getCompanyUserId($user_id);
            //Check whether a company have posted any advertisements
            $advertisementDetails = $this->adminModel->getAdvertisementCountByCompany($companyID);

            if ($advertisementDetails->advertisement_count == 0) {
                //Can delete the company
                $elementStatus = "";
                $elementMsg = "Delete Company? Press here";
            } else {

                $elementStatus = "disabled";
                $elementMsg = "Cannot delete: Company has posted advertisements";
            }

            //view main comapny details
            $companyDetails = $this->companyModel->mainCompanyDetails($user_id);
            $account_status = $this->userModel->getUserAccountStatus($user_id);
            if ($user_id != NULL && $blacklist == NULL) {
                $data = [
                    'username' => $companyDetails->username,
                    'user_id' => $companyDetails->user_id,
                    'company_name' => $companyDetails->company_name,
                    'contact' => $companyDetails->contact,
                    'email' => $companyDetails->email,
                    'account_status' => $account_status->account_status,
                    'modal_class' => 'hide-element',
                    'element_status' => $elementStatus,
                    'element_msg' => $elementMsg
                ];

                $this->view('admin/viewCompany', $data);
            } else if ($user_id != NULL && $blacklist == 'delete') {
                $data = [
                    'username' => $companyDetails->username,
                    'user_id' => $companyDetails->user_id,
                    'company_name' => $companyDetails->company_name,
                    'contact' => $companyDetails->contact,
                    'email' => $companyDetails->email,
                    'account_status' => $account_status->account_status,
                    'modal_class' => '',
                    'element_status' => $elementStatus,
                    'element_msg' => $elementMsg
                ];
                $this->view('admin/viewCompany', $data);
            } else {
                redirect('admin/company');
            }
        }
    }

    //Deactivate or re-activate a Company and Student- Admin - Ruchira
    public function updateUserAccountStatus($userType = NULL, $user_id = NULL)
    {
        if ($user_id != NULL || $userType != NULL) {

            if ($this->userModel->checkForUserById($user_id)) {
                //user exists and can deactivate or activate

                $account_status = trim($_POST['account_status']);
                $this->userModel->updateUserAccountStatusById($user_id, $account_status);

                if ($userType == 'company') {
                    flashMessage('company_list_msg', 'Company Account Status Changed Successfully!');
                    redirect('admin/main-company-details/' . $user_id);
                } else {
                    flashMessage('main_details_msg', 'Student Account Status Changed Successfully!');
                    redirect('admin/main-student-details/' . $user_id);
                }
            } else {
                //user does not exist
                if ($userType == 'company') {
                    flashMessage('company_list_msg', 'Company does not exist, Please check again!', 'danger-alert');
                    redirect('admin/company');
                } else {
                    flashMessage('student_batch_msg', 'Student does not exist, Please check again!', 'danger-alert');
                    redirect('admin/student');
                }
            }
        } else {
            if ($userType == 'company') {
                redirect('admin/company');
            } else {
                redirect('admin/student');
            }
        }
    }

    //deactivated Companies  same as blacklisted companies
    // INcase of having advertisements
    public function deactivatedCompanies($userID = NULL)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //DELETE COMPANY
            $this->companyModel->deleteCompany($userID);
            redirect('admin/company');
        } else {
            //Display Deactivated Companies
            $deactivatedCompanies = $this->companyModel->getDeativatedCompanyList();
            $data = [
                'deactivated_companies' => $deactivatedCompanies
            ];
            $this->view('admin/deactivatedCompanies', $data);
        }
    }

    public function student($pg = NULL, $year = NULL)
    {
        //Get Batch List and respective student count of each IS and CS
        $batchList = $this->studentModel->getStudentBatches();
        if ($pg != NULL && $year != NULL) {
            //View Student Batch Model
            $data = [
                'add_modal_class' => 'hide-element',
                'change_access_modal_class' => 'hide-element',
                'view-modal-class' => '',
                'batch_list' => $batchList,
                'batch_year' => $year
            ];
            $this->view('admin/studentBatches', $data);
        } else {
            //Student Batches

            $data = [
                'add_modal_class' => 'hide-element',
                'change_access_modal_class' => 'hide-element',
                'view-modal-class' => 'hide-element',
                'batch_list' => $batchList
            ];

            $this->view('admin/studentBatches', $data);
        }
    }

    //Get Main Student List-Admin - Ruchira 
    public function studentList($year = NULL, $stream = NULL)
    {
        if ($year == NULL || $stream == NULL) {
            redirect('admin/student'); //If no value is passed for atleast one of the variables
        }

        $data = [
            'batch_year' => $year,
            'stream' => $stream
        ];

        $studentList = $this->studentModel->getStudentList($data);

        $data = [
            'batch_year' => $year,
            'stream' => $stream,
            'student_list' => $studentList
        ];

        $this->view('admin/studentList', $data);
    }

    // Update Main student Details - PDC
    //Update Main Student Details -PDC - Ruchira
    public function mainStudentDetails($user_id = NULL)
    {
        if ($user_id != NULL) {

            $batch_list = $this->studentModel->getStudentBatches();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                stripTags();
                $data = [
                    'user_id' => $user_id,
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'reg_num' => trim($_POST['registration_number']),
                    'index_num' => trim($_POST['index_number']),
                    'batch_year' => trim($_POST['batch_year']),
                    'stream' => trim($_POST['stream']),
                    'old_email' => trim($_POST['old_email'])
                ];

                //Check for User Availability with the same email
                $user = $this->userModel->getUserByEmail(trim($_POST['email']));

                if ($user && $user->email != trim($_POST['old_email'])) {
                    flashMessage('main_details_msg', 'Entered Email is already available, Please check again!', 'danger-alert');
                    redirect('admin/main-student-details/' . $user_id);
                }
                $this->studentModel->updateMainStudentDetails($data);
                flashMessage('main_details_msg', 'Student Details Updated Successfully!');
                redirect('admin/main-student-details/' . $user_id);
            } else {
                //Displaying Data
                $account_status = $this->userModel->getUserAccountStatus($user_id);
                $studentDetails = $this->studentModel->getMainStudentDetails($user_id);
                $data = [
                    'username' => $studentDetails->username,
                    'registration_number' => $studentDetails->registration_number,
                    'index_number' => $studentDetails->index_number,
                    'email' => $studentDetails->email,
                    'user_id' => $user_id,
                    'batch_list' => $batch_list,
                    'std_batch' => $studentDetails->batch_year,
                    'stream' => $studentDetails->stream,
                    'account_status' => $account_status->account_status
                ];
                $this->view('admin/studentDetails', $data);
            }
        } else {
            redirect('admin/student');
        }
    }

    public function pdcStaff()
    {
        $staff = $this->adminModel->getPdcStaff();
        $data = [
            'staff' => $staff
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        }else{
            $this->view('admin/pdcStaff',$data);
        }
        
        
    }

    public function test(){

        
        $this->view('admin/viewPdcUser');

    }
}

    // public function complaint() //default method and view
    // {
    //     $this->view('admin/adminComplaint');
    // }

    // public function viewcomplaint() //default method and view
    // {
    //     $this->view('admin/viewComplaint');
    // }


    // public function viewbatches() //default method and view
    // {
    //     $this->view('admin/viewBatches');
    // }

    // public function viewstudentlist() //default method and view
    // {
    //     $this->view('admin/viewStudentList');
    // }

    // public function viewstudent() //default method and view
    // {
    //     $this->view('admin/viewStudent');
    // }

    // public function viewpdcstaff() //default method and view
    // {
    //     $staff = $this->adminModel->getstaffdetails();
    //     $data = [
    //         'staff' => $staff,
    //     ];
    //     $this->view('admin/viewPdcStaff', $data);
    // }

    // public function viewpdcuser($id) //default method and view
    // {
    //     $staff = $this->adminModel->getuserdetails($id);
    //     $data = [
    //         'staff' => $staff,
    //     ];
    //     $this->view('admin/viewPdcUser', $data);
    // }

    // public function report() //default method and view
    // {
    //     $this->view('admin/report');
    // }

    // public function registrationreport() //default method and view
    // {
    //     $this->view('admin/registrationReport');
    // }

    // public function advertisementreport() //default method and view
    // {
    //     $this->view('admin/advertisementReport');
    // }

    // public function viewprofile() //default method and view
    // {
    //     $this->view('admin/updateProfile');
    // }

    // public function addpdcuser()
    // {


    //     // Check if POST
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //         // Strip Tags
    //         stripTags();



    //         $data = [
    //             'username' => trim($_POST['name']),
    //             'email' => trim($_POST['email']),
    //             'password' => trim($_POST['name']),
    //             'hashed_password' => '',
    //             'username_err' => '',
    //             'email_error' => '',
    //         ];

    //         if (empty($data['username'])) {
    //             $data['username_err'] = 'Please enter a username';
    //         }

    //         if (empty($data['email'])) {
    //             $data['email_err'] = 'Plase enter a email';
    //         }

    //         if (empty($data['username_err'] && $data['email_err'])) {
    //             // Hash Password
    //             $data['hashed_password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    //             if ($this->adminModel->addStaff($data)) {
    //                 redirect('admin/addPdcUser');
    //             } else {
    //                 die('Something went wrong');
    //             }
    //         } else {
    //             //load with errors
    //             $this->view('admin/addPdcUser', $data);
    //         }

    //         //     if ($user_id) {
    //         //         //User available -  Cant register
    //         //         $data = [
    //         //             'username' => trim($_POST['username']),
    //         //             'email' => trim($_POST['email']),
    //         //             'email_error' => '*Email already exists! Please check again',
    //         //             'credential_error' => '',
    //         //         ];
    //         //         //$this->view('pdc/registerStudent', $data);
    //         //     } else {
    //         //         //Check for Index Numbers and Reg Numbers duplication before adding to DB
    //         //         if ($this->studentModel->checkIndexNumber(trim($_POST['index_number'])) || $this->studentModel->checkRegistrationNumber(trim($_POST['registration_number']))) {
    //         //             $data = [
    //         //                 'username' => trim($_POST['username']),
    //         //                 'email' => trim($_POST['email']),
    //         //                 'registration_number' => trim($_POST['registration_number']),
    //         //                 'index_number' => trim($_POST['index_number']),
    //         //                 'email_error' => '',
    //         //                 'year' => $year,
    //         //                 'stream' => $stream,
    //         //                 'credential_error' => '*Either Registration Number or Index Number already exists! Please check again '
    //         //             ];
    //         //             $this->view('pdc/registerStudent', $data);
    //         //         } else {
    //         //             //Random Password
    //         //             $password = generatePassword();

    //         //             // Hash Password
    //         //             $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    //         //             $email = new Email();

    //         //             if ($email->sendLoginEmail(trim($_POST['email']), $password, $_POST['username'])) {
    //         //                 $data = [
    //         //                     'username' => trim($_POST['username']),
    //         //                     'email' => trim($_POST['email']),
    //         //                     'password' => $hashPassword,
    //         //                     'user_role' => 'student'
    //         //                 ];

    //         //                 //Execute
    //         //                 $this->registerModel->registerUser($data);

    //         //                 //Get that User_Id
    //         //                 $user_id = $this->userModel->getUserId($data['email']);
    //         //                 $data = [
    //         //                     'user_id' => $user_id,
    //         //                     'registration_number' => trim($_POST['registration_number']),
    //         //                     'index_number' => trim($_POST['index_number']),
    //         //                     'stream' => trim($_POST['stream']),
    //         //                     'batch_year' => trim($_POST['year'])
    //         //                 ];
    //         //                 $email->sendLoginEmail(trim($_POST['email']), $password, $_POST['username']);
    //         //                 $this->registerModel->registerStudent($data);
    //         //                 flashMessage('std_register_msg', 'Student Registered Successfully!');
    //         //                 redirect('register/register-student/' . $year . '/' . $stream);
    //         //             } else {
    //         //                 flashMessage('std_register_msg', 'Error Occured!, Email is not sent', 'danger-alert');
    //         //                 redirect('register/register-student/' . $year . '/' . $stream);
    //         //             }
    //         //         }
    //         //     }
    //     } else {

    //         $data = [
    //             'username' => '',
    //             'email' => '',
    //             'password' => '',
    //             'hashed_password' => '',
    //             'username_err' => '',
    //             'email_error' => '',
    //         ];

    //         // Load View
    //         $this->view('admin/addPdcUser', $data);
    //     }
    // }