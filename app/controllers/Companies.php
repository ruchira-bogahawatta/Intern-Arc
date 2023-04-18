<?php

class Companies extends BaseController
{
    public $companyModel;
    public $userModel;
    public $advertisementModel;
    public $listCompanies;

    public function __construct()
    {
        $this->companyModel = $this->model('Company');
        $this->userModel = $this->model('User');
        $this->advertisementModel = $this->model('Advertisement');
        
    }

    //COMPANY USER DASHBOARD 
    public function index()
    {
        $companyId = $this->userModel->getCompanyUserId($_SESSION['user_id']);
        $dashboardData = $this->companyModel->getRequestsbyCompany($companyId);

        $data = [
            'companyId' => $companyId,
            'dashboard' => $dashboardData,
        ];

    

        $this->view('company/dashboard', $data);
    }

    // Manage Company- PDC - Ruchira
    public function manageCompany($pg = NULL)
    {
        $companyList = $this->companyModel->getCompanyList();

        if ($pg == 'blacklisted') {

            $blacklistedCompanyList = $this->companyModel->getBlacklistedCompanyList();
            $data = [
                'blacklisted_modal_class' => '',
                'company_list' => $companyList,
                'blacklisted_list' => $blacklistedCompanyList
            ];

            $this->view('pdc/manageCompany', $data);

        } else {

            $data = [
                'blacklisted_modal_class' => 'hide-element',
                'company_list' => $companyList,
                'blacklisted_list' => NULL
            ];

            $this->view('pdc/manageCompany', $data);
        }
    }

    // Company Details Company- PDC
    public function CompanyDetails()
    {
        $this->view('pdc/companyDetails');
    }

    //View Company List - STUDENT
    public function viewCompanyList()
    {
        $listCompanies = $this->companyModel->getCompanyList();
        
        $data = [
            'listCompanies' => $listCompanies
        ];

        $this->view('student/viewcompanies', $data);
    }

    public function SearchCompanies()
    {
        $search_res = null;
        $output = null;
        if(isset($_POST['query'])){
            $search = $_POST['query'];
            $search_res = $this->companyModel->searchCompanyList($search);
        }
        else{
            $search_res = $this->companyModel->getCompanyList();
        }

        if($search_res){
            $output = '<table class="view-companies-table" id="view-companies-table">
                <thead>
                <tr>
                    <th class="view-companies-table-header">Company Name</th>
                    <th class="view-companies-table-header"></th>
                </tr>
                </thead>
                <tbody>';

            foreach ($search_res as $res) {
            
                $output .= '<tr>
                        <td class="view-companies-table-data">' . $res->company_name .'</td>
                        <td class="view-companies-table-data"> <a href='. URLROOT.'students/company-profile'.'><button>view</button></a></td>
                        </tr>';
            };
            $output .= '</tbody> </table>';
            
        }
        else{
            $output = '<h3>No search results<h3>';
        }
        echo $output;
        
    }

    //View Applied Company List - STUDENT
    public function viewAppliedCompanyList()
    {
        $this->view('student/appliedcompanies');
    }

    //View Applied Company List - STUDENT
    public function viewCompanyDetails()
    {
        $this->view('student/appliedcompanies');
    }

    public function shortlistedStudents()
    {
        $this->view('company/shortlistedStudents');
    }

    public function InterviewScheduleList()
    {
        $this->view('company/InterviewScheduleList');
    }

    public function InterviewScheduleCreate()
    {
        $this->view('company/InterviewScheduleCreate');
    }

    public function InterviewSchedule()
    {
        $this->view('company/InterviewSchedule');
    }

   //SHORTLIST STUDENTS
   public function shortlistStudent($id){
    if(isset($_POST["status"])){
        //Handling changing status to shortist or reject
        $data = [
            'request_id' => trim($_POST['request_id']),
            'status' => trim($_POST['status'])
        ];

        $this->companyModel->shortlistStudent($data);
        flashMessage('shortlist_student_msg', 'Student Added to Shortlist');
        redirect('requests/showRequestsByAd/'.$id);
    }
   }

   //DISPLAY ADVERTISEMENT LIST WITH RELEVENT SHORTLISTED STUDENTS COUNT
   public function getAdvertisementByStatus(){
    $companyId = $this->userModel->getCompanyUserId($_SESSION['user_id']);
    $advertisements = $this->advertisementModel->getAdvertisementsByCompany($companyId);
    
    $shortlistedCounts = array();
    $x=0;
    foreach($advertisements as $advertisement)
    {
        $shortlists = $this->companyModel->getAdvertisementByStatus($advertisement->advertisement_id);
        $shortlistedCounts[$x] = count($shortlists);
        $positions[$x] = $advertisement->position;
        $intern_counts[$x] = $advertisement->intern_count;
        $x++;
    }
    
    
    $data = [
        'count' => $shortlistedCounts,
        'length' => count($shortlistedCounts),
        'positions' => $positions,
        'intern_counts' => $intern_counts,
        'advertisements' =>$advertisements,
        
    ];

    $this->view('company/shortlist', $data);

}


   //GET SHORTLISTED STUDENTS FOR RELEVENT ADVERTISEMENT
   public function getShortlistedStudents($advertisementId){
    $students = $this->companyModel->getShortlistedStudents($advertisementId);

    $data = [
        'advertisement_id' => $advertisementId,
        'student_name' => $students,
    ];
    
    if ($this->companyModel->getShortlistedStudents($advertisementId)) {

        $this->view('company/shortlistedStudents', $data);
    } else {
        die('Something went wrong');
    }

   }

   //RECRUIT OR REJECT STUDENT FROM DROP DOWN
   public function recruitStudent($id){
    if(isset($_POST["recruit_status"])){
        //Handling changing status to shortist or reject
        $data = [
            'request_id' => trim($_POST['request_id']),
            'recruit_status' => trim($_POST['recruit_status'])
        ];

        $this->companyModel->recruitStudent($data);
        flashMessage('recruit_student_msg', 'Student Recruited');
        redirect('companies/get-shortlisted-students/'.$id);
    }

   }

}
