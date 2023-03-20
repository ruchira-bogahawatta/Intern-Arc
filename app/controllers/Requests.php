<?php

class Requests extends BaseController
{

    public $requestModel;
    public $requestList;
    public $userModel;
    public $advertisementModel;
    
    public function __construct()
    {
        $this->requestModel = $this->model('Request');
        $this->userModel = $this->model('User');
        $this->advertisementModel = $this->model('Advertisement');
    }

    public function index()

    {
        $requests = $this->requestModel->getStudentRequests();
        //view pass data values $data

        $data = [

            'requests' => $requests,

        ];

        $this->view('company/studentRequestList', $data);
    }

    //Applying to advertisement
    public function addStudentRequest($advertisementId){
        // $advertisementId = $_GET['adId'];
        $studentId =  $this->userModel->getStudentUserId($_SESSION['user_id']);
        $data = [
            'advertisement_id' => $advertisementId,
            'student_id' => $studentId
        ];

        //Execute
        if($this->requestModel->checkStudentRequest($advertisementId, $studentId))
        {
            flashMessage('student_request_msg' , 'You have already applied to this advertisement!', 'danger-alert');
            redirect('advertisements/viewAdvertisement/'. $advertisementId);
            
        }else if($this->requestModel->addStudentRequest($data)) {
            flashMessage('student_request_msg' , 'Applied successfully');
            redirect('advertisements/viewAdvertisement/'. $advertisementId);
        } else {
            die('Something went wrong');
        }
    }

    public function allRequests() 
    {
        // $requests = $this->requestModel->getRequests();
        // $data = [
        //     'requests' => $requests,
        // ];
        $this->view('pdc/studentRequest');
    }

    public function shortlistedList() 
    {
        $this->view('company/shortlist');
    }

    public function showRequestsByAd($advertisementId){
        // $advertisementId = $_GET['adId']; 
        $students = $this->requestModel->getStudentByRequest($advertisementId);

        $data = [
            'student_name' => $students,
        ];
        
        if ($this->requestModel->getStudentByRequest($advertisementId)) {

            $this->view('company/RequestListByAdvertisement', $data);
        } else {
            die('Something went wrong');
        }

    }

    //DISPLAY ADVERTISEMENT LIST WITH RELEVENT REQUEST COUNT
    public function AdvertisementListRequests(){
        //loop through advertisements 
        //if ad_id = ad_id display advertisement details and count
        $companyId = $this->userModel->getCompanyUserId($_SESSION['user_id']);
        $advertisements = $this->advertisementModel->getAdvertisementsByCompany($companyId);
        
        $requestCounts = array();
        $x=0;
        foreach($advertisements as $advertisement)
        {
            $requests = $this->requestModel->getAdvertisementByRequest($advertisement->advertisement_id);
            $requestCounts[$x] = count($requests);
            $positions[$x] = $advertisement->position;
            $intern_counts[$x] = $advertisement->intern_count;
            $x++;
        }
        
        
        $data = [
            'count' => $requestCounts,
            'length' => count($requestCounts),
            'positions' => $positions,
            'intern_counts' => $intern_counts,
            'advertisements' =>$advertisements,
            
        ];

        $this->view('company/studentRequestList', $data);

    }

}
?>
