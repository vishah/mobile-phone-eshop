<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myphone extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->pathroute = array();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('table');
        $this->load->library('pagination');
        $this->load->database();
        $this->load->library('session');
        $this->load->library('email');
        // $this->output->enable_profiler(TRUE);

		$phoneno = $this->session->userdata('phoneno');
        $password = $this->session->userdata('password');
		$email = $this->session->userdata('email');

		$sql_login= $this->db->query("SELECT * FROM users WHERE phoneno='$phoneno' AND password=PASSWORD('$password')");
		$this->loggedIn = $sql_login->num_rows();
    }

    public function index()
    {
        redirect('/home', 'location');
    }

    public function home()
    {
        $data=array();
        $browseByBrand = array();
        $browseByFeature = array();
        $browseByPrice = array();
        $bestSellers = array();
        $featuredCategories = array();
        $banners = array();

        //Populate $banners array
        $bsQuery = $this->db->query("select * from banners where to_display=1");
        foreach($bsQuery->result() as $row){
            $banner_id = $row->id;
            $banner_name = $row->banner_name;
            $banner_description = $row->banner_description;
            $banner_pic = $row->banner_pic;
            $link = $row->link;
            array_push($banners, array("id"=>$banner_id, "banner_name"=>$banner_name, "banner_description"=>$banner_description,
                                       "banner_pic"=>$banner_pic, "link"=>$link));
        }
        $data['banners']=$banners;

        //Populate $bestSellers array
        $bsQuery = $this->db->query("select * from phones group by phone_name order by number_sold desc limit 20");

        foreach($bsQuery->result() as $row){
            $phoneName = $row->phone_name;
            $brand = $row->brand;
            $displayName = $row->display_name;
            $price = $row->price;
            $thumb = $row->thmb1;
            $internalReferece = $row->internal_reference;
            array_push($bestSellers, array("phoneName"=>$phoneName, "brand"=>$brand, "displayName"=>$displayName, "price"=>$price, "thumb"=>$thumb, "internalReference"=>$internalReferece));
        }
        $data['bestSellers']=$bestSellers;

        //Populate $browseByBrand array
        $bbbQuery = $this->db->query("select * from categories where brand=1");
        foreach($bbbQuery->result() as $row){
            $name = $row->name;
            $caption = $row->caption;
            $thumb = $row->thumb;
            array_push($browseByBrand, array("name"=>$name, "caption"=>$caption, "thumb"=>$thumb));
        }
        $data['browseByBrand']=$browseByBrand;

        //Populate $browseByFeature array
        $bbfQuery = $this->db->query("select * from categories where feature=1");
        foreach($bbfQuery->result() as $row){
            $name = $row->name;
            $caption = $row->caption;
            $thumb = $row->thumb;
            array_push($browseByFeature, array("name"=>$name, "caption"=>$caption, "thumb"=>$thumb));
        }
        $data['browseByFeature']=$browseByFeature;

        //Populate $browseByPrice array
        $bbpQuery = $this->db->query("select * from categories where price_range=1 order by id desc");
        foreach($bbpQuery->result() as $row){
            $name = $row->name;
            $caption = $row->caption;
            $thumb = $row->thumb;
            array_push($browseByPrice, array("name"=>$name, "caption"=>$caption, "thumb"=>$thumb));
        }
        $data['browseByPrice']=$browseByPrice;
        $data['navBarLinks'] = $this->getNavBarLinksArr();
        $data['searchRecommendations'] = $this->getSearchRecommendations();
        $this->load->view('view_home',$data);
    }
    
    public function register(){
        $data = array();
        $data['navBarLinks'] = $this->getNavBarLinksArr();
        $data['searchRecommendations'] = $this->getSearchRecommendations();        
		$this->form_validation->set_rules('phoneno', 'Mobile Number', 'required|numeric|exact_length[7]|callback_unique_phoneno_check');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('view_register',$data);
        }
		else
		{
            $phoneno = $this->input->get_post('phoneno');
            $email = $this->input->get_post('email');
            $registerCode = rand(1000,9999);
            $this->session->set_userdata(array(
                "code"=>$registerCode,
                "email"=>$email,
                "phoneno"=>$phoneno
            ));
            //send registration code to users phone no
            $this->email->from('','');
            $this->email->to('960' . $phoneno . '@bulksms.net');
 
            $this->email->subject('Registraton Code ');
            $this->email->message('Your registration Code is:' . $registerCode );
            if($this->email->send()){
                redirect('/confirm_code','location');
            }else{
                 $this->form_validation->set_message('Unable to Register. Please try again later.');
                 $this->load->view('view_register',$data);
            }
        }
    }
    
    public function confirm_code(){
        if( (! $this->session->code) || (! $this->session->phoneno) || (! $this->session->email) ){
            redirect('/register','location');
        }

        $data = array();
        $data['message'] = "";        
        
        $code = $this->session->code;
        $phoneno = $this->session->phoneno;
        $email = $this->session->email;
        $this->form_validation->set_rules('code', 'Registration Code', 'required|numeric|exact_length[4]');
        if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('view_confirm_registration_code', $data);
        }
        else
        {
            $submittedCode = $this->input->get_post('code');

            if($submittedCode!=$code){
                $data['message'] = "Incorrect Code Submitted";
                $this->load->view('view_confirm_registration_code', $data);
            }
            else{
                $this->session->set_userdata('code_confirmed','true');
                redirect('/password_setup','location');
            }
        }
    }
    
    public function password_setup(){
        $data = array();
        $data['message'] = "";
        if( (! $this->session->code_confirmed) || (! $this->session->phoneno) || (!$this->session->email) ){
            redirect('/register','location');
        }
        $this->form_validation->set_rules('password', 'Password', 'required|matches[password2]|min_length[6]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'required|min_length[6]');
        if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('view_registration_password',$data);
        }
		else
		{
            $phoneno = $this->session->phoneno;
            $email = $this->session->email;
            $password = $this->input->get_post('password');
            $insertSql = "INSERT INTO users VALUES(?,PASSWORD(?),?)";
            $this->db->query($insertSql, array($phoneno, $password, $email));
            if($this->db->affected_rows()==1){
                $userInfo = array(
                    "phoneno" => $phoneno,
                    "email" => $email,
                    "password" => $password
                );
                $this->session->set_userdata($userInfo);
                redirect('/','location');
            }else{
                $data['message']='Unable to Register. Please try again later.';
                $this->load->view('view_registration_password', $data);
            }
        }
    }

    public function account(){
        $data = array();
        $sessionPhoneno = $this->session->userdata('phoneno');        
        $data['navBarLinks'] = $this->getNavBarLinksArr();
        $data['searchRecommendations'] = $this->getSearchRecommendations();        
		$this->form_validation->set_rules('phoneno', 'Mobile Number', 'required|numeric|exact_length[7]');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[password2]|min_length[6]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'required|min_length[6]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE)
		{
            $getAccountDetailsSql = "SELECT * FROM users WHERE phoneno=?";
            $getAccountDetailsQuery = $this->db->query($getAccountDetailsSql, array($sessionPhoneno));
            if($getAccountDetailsQuery->num_rows()==1){
                $row = $getAccountDetailsQuery->row();
                $data['phoneno'] = $row->phoneno;
                $data['email'] = $row->email;
                $this->load->view('view_account',$data);
            } else {
                redirect('/','location');
            }
           
        }
		else
		{
            $phoneno = $this->input->get_post('phoneno');
            $email = $this->input->get_post('email');
            $password = $this->input->get_post('password');
            $updateSql = "UPDATE users SET phoneno=?, password=PASSWORD(?), email=? WHERE phoneno=?";
            $this->db->query($updateSql, array($phoneno, $password, $email, $sessionPhoneno));
            if($this->db->affected_rows()==1){
                $userInfo = array(
                    "phoneno" => $phoneno,
                    "email" => $email,
                    "password" => $password
                );
                $this->session->set_userdata($userInfo);
                redirect('/','location');
            }else{
                $this->form_validation->set_message('Unable to update account information. Please try again later.');
            }
        }
    }
    
    public function login(){
        $data=array();
		$this->form_validation->set_rules('phoneno', 'Phone No.', 'required|numeric|exact_length[7]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('view_login',$data);
        }
        else
        {
            $phoneno = $this->input->get_post('phoneno');
            $password = $this->input->get_post('password');
            $loginCheckSql = "SELECT * FROM users where phoneno=? AND password=PASSWORD(?)";
            $loginQuery = $this->db->query($loginCheckSql, array($phoneno, $password));
            if($loginQuery->num_rows()==0){
                $this->form_validation->set_message("Phone number or Password was entered incorrectly.");
                $this->load->view('view_login',$data);
            }
            else
            {
                $row = $loginQuery->row();
                $resultEmail = $row->email;
                $userInfo = array(
                    "phoneno" => $phoneno,
                    "email" => $resultEmail,
                    "password" => $password
                );
                $this->session->set_userdata($userInfo);
                redirect('/','location');
            }
        }
    }

    public function recover(){
        $data=array();
		$this->form_validation->set_rules('phoneno', 'Mobile Number', 'required|numeric|exact_length[7]');
        if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('view_recover',$data);
        }
        else
        {
            if(isset($_POST['phoneno'])){
                $phoneno = $this->input->get_post('phoneno');

                $phonenoCheckSql = "SELECT * FROM users where phoneno=?";
                $phonenoCheckQuery = $this->db->query($phonenoCheckSql, array($phoneno));
                if($phonenoCheckQuery->num_rows()==0){
                    $this->form_validation->set_message("Please try again.");
                    $this->load->view('view_recover',$data);
                }
                else
                {
                    $row=$phonenoCheckQuery->row();
                    $email = $row->email;
                    $newPassword = rand(100000,9999999);
                    $recoverSql = "UPDATE users SET password=PASSWORD(?) WHERE phoneno=?";
                    $recoverQuery = $this->db->query($recoverSql, array($newPassword, $phoneno));
                    if($this->db->affected_rows()==1){
                        $headers   = array();
                        $headers[] = "MIME-Version: 1.0";
                        $headers[] = "Content-type: text/plain; charset=iso-8859-1";
                        $headers[] = "From: ";
                        $headers[] = "Reply-To: $email <$email>";
                        $headers[] = "Subject: {New  Password}";
                        $headers[] = "To: <$email>";
                        $msg = "Your new password is:\r\n$newPassword\r\n\r\nPlease reset password once logged in.";
                        if(mail($email, "New password", $msg, implode("\r\n",$headers))){
                            $data['message']="New password has been sent to the email associated with your account";
                            $this->load->view('view_information',$data);
                        }else{
                            $this->form_validation->set_message("Please try again.");
                            $this->load->view('view_recover',$data);
                        }
                    }else{
                        $this->form_validation->set_message("Please try again.");
                        $this->load->view('view_recover',$data);
                    }

                }
            }else{
                $this->form_validation->set_message("Please provide Mobile Number.");
                $this->load->view('view_recover',$data);
            }
        }
    }

    public function logout(){
        $this->session->unset_userdata('phoneno');
        $this->session->unset_userdata('password');
        $this->session->unset_userdata('email');
        redirect('/home', 'location');
    }
    public function unique_phoneno_check($phoneno){
        $uniquePhoneNoSql = "select * from users where phoneno=?";
        $uniquePhoneNoQuery = $this->db->query($uniquePhoneNoSql,$phoneno);
        if($uniquePhoneNoQuery->num_rows()==0){
            return TRUE;
        }else{
            $this->form_validation->set_message('unique_phoneno_check', 'An account with the provided phone no. already exists.');
            return FALSE;
        }
    }
    private function getSearchRecommendations(){
        $searchRecommendations=array();
        $searchRecommendationsSql = "SELECT DISTINCT(display_name) as display_name, internal_reference FROM myphjpob_db.phones;";
        $searchRecommendationsQuery = $this->db->query($searchRecommendationsSql);
        if($searchRecommendationsQuery->num_rows()>0){
            foreach($searchRecommendationsQuery->result() as $row){
                $internalReference = $row->internal_reference;
                $displayName = $row->display_name;
                array_push($searchRecommendations, array("displayName"=>$displayName, "internalReference"=>$internalReference));
            }
        }
        return($searchRecommendations);
    }
    private function getBrowseByBrandArr(){
        $browseByBrand=array();
        //Populate $browseByBrand array
        $bbbQuery = $this->db->query("select * from categories where brand=1");
        foreach($bbbQuery->result() as $row){
            $name = $row->name;
            $caption = $row->caption;
            $thumb = $row->thumb;
            array_push($browseByBrand, array("name"=>$name, "caption"=>$caption, "thumb"=>$thumb));
        }
        return $browseByBrand;
    }
    private function getNavBarLinksArr(){
        $browseByBrand=array();
        //Populate $browseByBrand array
        $bbbQuery = $this->db->query("select * from categories where display_on_navbar=1");
        foreach($bbbQuery->result() as $row){
            $name = $row->name;
            $caption_navbar = $row->caption_navbar;
            $thumb = $row->thumb;
            array_push($browseByBrand, array("name"=>$name, "caption_navbar"=>$caption_navbar, "thumb"=>$thumb));
        }
        return $browseByBrand;
    }
    public function details($internal_reference)
    {
        $data = array();
        $similarPhones = array();
        $phoneQuery = $this->db->query("select * from phones where internal_reference='$internal_reference' limit 1");
        $phoneRow = $phoneQuery->row();
        $data['display_name'] = $phoneRow->display_name;
        $data['price'] = number_format($phoneRow->price);
        $data['discount'] = $phoneRow->discount;
        if($phoneRow->in_stock==1){
            $data['in_stock'] = "In Stock";
        }
        elseif($phoneRow->in_stock==0){
            $data['in_stock'] = "Out of Stock";
        }
        elseif($phoneRow->in_stock==2){
            $data['in_stock'] = "Pre-Order";
        }

        if($phoneRow->in_stock==1){
            $data['in_stock_class'] = "text-success";
        }
        elseif($phoneRow->in_stock==0){
            $data['in_stock_class'] = "text-muted";
        }
        elseif($phoneRow->in_stock==2){
            $data['in_stock_class'] = "text-warning";
        }

        $data['in_stock_class'] = ($phoneRow->in_stock==1)?"text-success":"text-danger";
        $data['number_sold'] = $phoneRow->number_sold;
        $data['brand'] = $phoneRow->brand;
        $data['series'] = $phoneRow->series;
        $data['model_number'] = $phoneRow->model_number;
        $data['phone_name'] = $phoneRow->phone_name;
        $data['internal_storage'] = $phoneRow->internal_storage;
        $data['colour'] = $phoneRow->colour;
        $data['sim_type'] = $phoneRow->sim_type;
        $data['ram'] = $phoneRow->ram;
        $data['camera'] = $phoneRow->camera;
        $data['dimension'] = $phoneRow->dimension;
        $data['screen'] = $phoneRow->screen;
        $data['released_date'] = $phoneRow->released_date;
        $data['os_type'] = $phoneRow->os_type;
        $data['os'] = $phoneRow->os;
        $data['style'] = $phoneRow->style;
        $data['short_summary'] = $phoneRow->short_summary;
        $data['description'] = $phoneRow->description;
        $data['rating'] = $phoneRow->rating;
        $data['box_items'] = $phoneRow->box_items;
        $data['pic1'] = $phoneRow->pic1;
        $data['pic2'] = $phoneRow->pic2;
        $data['pic3'] = $phoneRow->pic3;
        $data['pic4'] = $phoneRow->pic4;
        $data['pic5'] = $phoneRow->pic5;
        $data['pic6'] = $phoneRow->pic6;
        $data['pic7'] = $phoneRow->pic7;
        //fetch similar colors
        $similarPhonesQuery = $this->db->query("select * from phones where phone_name='" .$phoneRow->phone_name . "' ");
        foreach($similarPhonesQuery->result() as $row){
            array_push($similarPhones,array($row->thmb1, $row->display_name, $row->internal_reference));
        }
        $data['similarPhones'] = $similarPhones;
        $data['browseByBrand'] = $this->getBrowseByBrandArr();
        $data['navBarLinks'] = $this->getNavBarLinksArr();
        $data['searchRecommendations'] = $this->getSearchRecommendations();        
        $this->load->view('view_details',$data);
    }

    public function catalogue()
    {
        $data=array();
        //Parse passed parameters
        $paramList = array('category','price','display_size','internal_storage','cust_review', 'search');
        $params = $this->uri->uri_to_assoc(2, $paramList);
        //End Parse passed parameters
        $allCatPhones = array();
        $bestSellers = array();
        $newAndNotable = array();
        $featuredCategories = array();
        $submitted = 0;
        $sql="";

        if($params['category']!=NULL){
            $data['category']=$params['category'];
            $category=$params['category'];
            $catQuery = $this->db->query("select * from categories where name='$category' limit 1");
            $catRow = $catQuery->row();
            $data['name'] = $catRow->name;
            $data['caption'] = $catRow->caption;
            $data['parent'] = $catRow->parent;
            if($catRow->parent != 0){
                $parentNameQuery = $this->db->query("select * from categories where id='$catRow->parent' limit 1");
                $parentNameRow = $parentNameQuery->row();
                $data['parent'] = $parentNameRow->name;
            }

            $data['thumb'] = $catRow->thumb;
            $sql = $catRow->sql;
            $id = $catRow->id;
        }
        else{

            $data['name'] = "All";
            $data['parent'] = 0;
            $search = $params['search'];
            if($search){
                $searchEscaped = $this->db->escape_like_str(urldecode($search));
                $data['caption'] = "Search Results for '$searchEscaped'";
                $data['search'] = $searchEscaped;                                
                $sql="select * from phones where display_name LIKE '%$searchEscaped%'";
            } else {
                $data['caption'] = "All Phones & Tablets";                
                $sql="select * from phones";
            }
        }

        //Populate $allCatPhones array
        $allCatPhonesQuery = NULL;
        $sqlAllCatPhonesQuery = $sql;
        //Refine by display size
        $data['display_size'] = array();
        if($params['display_size']!=NULL){
            $submitted=1;
            $displaySizeArray = explode("~",$params['display_size']);
            $data['display_size'] = $displaySizeArray;
            $displaySizeSQLArray = array();

            foreach($displaySizeArray as $displaySize){
                switch($displaySize){
                case "lt3.9":
                    array_push($displaySizeSQLArray, " screen<3.9 ");
                    break;
                case "4.0-4.4":
                    array_push($displaySizeSQLArray, " screen BETWEEN 4.0 and 4.4 ");
                    break;
                case "4.5-4.9":
                    array_push($displaySizeSQLArray, " screen BETWEEN 4.5 and 4.9");
                    break;
                case "5.0-5.4":
                    array_push($displaySizeSQLArray, " screen BETWEEN 5.0 AND 5.4 ");
                    break;
                case "gt5.5":
                    array_push($displaySizeSQLArray, " screen>=5.5 ");
                    break;
                }
            }
            if($sqlAllCatPhonesQuery=="select * from phones"){
                $concatSQL = " WHERE (" . implode(" OR ", $displaySizeSQLArray) . ") ";
            }
            else{
                $concatSQL = " AND(" . implode(" OR ", $displaySizeSQLArray) . ") ";
            }
            $sqlAllCatPhonesQuery .= $concatSQL;
        }
        //Refine by price
        $data['price'] = array();
        if($params['price']!=NULL){
            $submitted=1;
            $priceArray = explode("~",$params['price']);
            $data['price'] = $priceArray;
            $priceSQLArray = array();
            foreach($priceArray as $price){
                switch($price){
                case "top-notch":
                    array_push($priceSQLArray, " price_range='Top-Notch (Above 10000)' ");
                    break;
                case "budget":
                    array_push($priceSQLArray, " price_range='Budget (1000-4000)' ");
                    break;
                case "mid-range":
                    array_push($priceSQLArray, " price_range='Mid-Range (4000-7000)' ");
                    break;
                case "high-end":
                    array_push($priceSQLArray, " price_range='High-End (7000-10000)' ");
                    break;
                case "all":
                    array_push($priceSQLArray, " price_range IN (
                    'Top-Notch (Above 10000)',
                    'Budget (1000-4000)',
                    'Mid-Range (4000-7000)',
                    'High-End (7000-10000)'
                    )");
                    break;
                }
            }
            if($sqlAllCatPhonesQuery=="select * from phones"){
                $concatSQL = " WHERE (" . implode(" OR ", $priceSQLArray) . ") ";
            }
            else{
                $concatSQL = " AND(" . implode(" OR ", $priceSQLArray) . ") ";
            }
            $sqlAllCatPhonesQuery .= $concatSQL;
        }
        //Refine by cust-review
        $data['cust_review'] = array();
        if($params['cust_review']!=NULL){
            $submitted=1;
            $custReviewArray = explode("~",$params['cust_review']);
            $data['cust_review'] = $custReviewArray;
            $custReviewSQLArray = array();
            foreach($custReviewArray as $custReview){
                switch($custReview){
                case "4":
                    array_push($custReviewSQLArray, " review>=4 ");
                    break;
                case "3":
                    array_push($custReviewSQLArray, " review>=3 ");
                    break;
                case "2":
                    array_push($custReviewSQLArray, " review>=2 ");
                    break;
                case "1":
                    array_push($custReviewSQLArray, " review>=1 ");
                    break;
                }
            }
            if($sqlAllCatPhonesQuery=="select * from phones"){
                $concatSQL = " WHERE (" . implode(" OR ", $custReviewSQLArray) . ") ";
            }
            else{
                $concatSQL = " AND(" . implode(" OR ", $custReviewSQLArray) . ") ";
            }
            $sqlAllCatPhonesQuery .= $concatSQL;
        }        
        //Refine by internal storage
        $data['internal_storage'] = array();
        if($params['internal_storage']!=NULL){
            $submitted=1;
            $internalStorageArray = explode("~",$params['internal_storage']);
            $data['internal_storage'] = $internalStorageArray;
            $internalStorageSQLArray = array();
            foreach($internalStorageArray as $internalStorage){
                switch($internalStorage){
                case "4":
                    array_push($internalStorageSQLArray, " internal_storage=4 ");
                    break;
                case "8":
                    array_push($internalStorageSQLArray, " internal_storage=8 ");
                    break;
                case "16":
                    array_push($internalStorageSQLArray, " internal_storage=16 ");
                    break;
                case "32":
                    array_push($internalStorageSQLArray, " internal_storage=32 ");
                    break;
                case "64":
                    array_push($internalStorageSQLArray, " internal_storage=64 ");
                    break;
                case "128":
                    array_push($internalStorageSQLArray, " internal_storage=128 ");
                    break;
                }
            }
            if($sqlAllCatPhonesQuery=="select * from phones"){
                $concatSQL = " WHERE(" . implode(" OR ", $internalStorageSQLArray) . ") ";
            }
            else{
                $concatSQL = " AND(" . implode(" OR ", $internalStorageSQLArray) . ") ";
            }
            $sqlAllCatPhonesQuery .= $concatSQL;
        }

        //        echo $sqlAllCatPhonesQuery;

        $allCatPhonesQuery = $this->db->query($sqlAllCatPhonesQuery);
        foreach($allCatPhonesQuery->result() as $row){
            $phoneName = $row->phone_name;
            $brand = $row->brand;
            $displayName = $row->display_name;
            $price = $row->price;
            $thumb = $row->thmb1;
            $releasedDate = $row->released_date;
            $review = $row->review;
            $internalReference = $row->internal_reference;
            array_push($allCatPhones, array("phoneName"=>$phoneName, "brand"=>$brand, "displayName"=>$displayName, "price"=>$price, "thumb"=>$thumb, "internalReference"=>$internalReference, "releasedDate"=>$releasedDate, "review"=>$review));
        }
        $data['allCatPhones']=$allCatPhones;

        //Populate $bestSellers array
        $bsQuery = $this->db->query($sql . " group by phone_name order by number_sold desc limit 10");

        foreach($bsQuery->result() as $row){
            $phoneName = $row->phone_name;
            $brand = $row->brand;
            $displayName = $row->display_name;
            $price = $row->price;
            $thumb = $row->thmb1;
            $internalReference = $row->internal_reference;
            array_push($bestSellers, array("phoneName"=>$phoneName, "brand"=>$brand, "displayName"=>$displayName, "price"=>$price, "thumb"=>$thumb, "internalReference"=>$internalReference));
        }
        $data['bestSellers']=$bestSellers;

        //Populate New and Notable Array
        $newAndNotableSql = "SELECT m.* " .
                          "FROM ( " .
                          $sql .
                          " ) m" .
                          "INNER JOIN " .
                          "SELECT MIN(price) AS price, phone_name " .
                          "FROM phones " .
                          "GROUP BY phone_name) minprice ON m.price = minprice.price AND m.phone_name = minprice.phone_name " .
                          "GROUP BY phone_name ";

        $newAndNotableQuery = $this->db->query($newAndNotableSql);
        $newAndNotableSql = "SELECT m.* " .
                          "FROM ( " .
                          $sql .
                          " ) m " .
                          "INNER JOIN " .
                          "( " .
                          "SELECT MIN(price) AS price, phone_name " .
                          "FROM phones " .
                          "GROUP BY phone_name) minprice ON m.price = minprice.price AND m.phone_name = minprice.phone_name " .
                          "GROUP BY phone_name " .
                          "ORDER BY rating  DESC, released_date DESC, phone_name ASC " .
                          "LIMIT 12 ";
        $newAndNotableQuery = $this->db->query($newAndNotableSql);
        
        foreach($newAndNotableQuery->result() as $row){
            $phoneName = $row->phone_name;
            $brand = $row->brand;
            $displayName = $row->display_name;
            $price = $row->price;
            $thumb = $row->thmb1;
            $internalReference = $row->internal_reference;
            array_push($newAndNotable, array("phoneName"=>$phoneName, "brand"=>$brand, "displayName"=>$displayName, "price"=>$price, "thumb"=>$thumb, "internalReference"=>$internalReference));
        }
        $data['newAndNotable']=$newAndNotable;
        if($params['category']!=NULL){
            //Populate Featured Categories Array
            $featuredCategoriesQuery = $this->db->query("select * from categories where parent=$id");
            foreach($featuredCategoriesQuery->result() as $row){
                $name = $row->name;
                $caption = $row->caption;
                $thumb = $row->thumb;
                array_push($featuredCategories, array("name"=>$name, "caption"=>$caption, "thumb"=>$thumb));
            }
            $data['featuredCategories']=$featuredCategories;
        }else{
            $data['featuredCategories']=NULL;
        }
        $data['browseByBrand'] = $this->getBrowseByBrandArr();
        $data['navBarLinks'] = $this->getNavBarLinksArr();
        $data['searchRecommendations'] = $this->getSearchRecommendations();        
        $data['submitted']=$submitted;

        $this->load->view('view_catalogue',$data);
    }

    public function junaidmobile()
    {
        $phoneno = $this->session->phoneno;
        $email = $this->session->email;
        $password = $this->session->password;

        if($phoneno && $email && $password){

            if( ($phoneno='7981665' && $email='mvishah@gmail.com') || ($phoneno=='7970034' && $email=='junaidmahid@gmail.com') )
            {

                $this->form_validation->set_rules('internal_reference', 'Internal Reference', 'alpha_dash');
                $this->form_validation->set_rules('in_stock', 'In Stock', 'integer');

                if ($this->form_validation->run() == FALSE) {
                    $data = array();
                    $data['results'] = array();
                    $getPhonesSql = "SELECT internal_reference,in_stock from phones order by internal_reference ";
                    $getPhonesQuery = $this->db->query($getPhonesSql);
                    foreach($getPhonesQuery->result() as $row){
                        $currRow = array();
                        $currRow['internal_reference'] = $row->internal_reference;
                        $currRow['in_stock'] = $row->in_stock;
                        $data['results'][]=$currRow;
                    }
                    $this->load->view('view_junaidmobile', $data);
                }
                else {
                    $updateQuery="update phones set in_stock=? where internal_reference=?";

                    $queryResult = $this->db->query($updateQuery,array($this->input->get_post('in_stock'), $this->input->get_post('internal_reference')));
                    if($queryResult){
                        echo "success";
                    }
                    else {
                        echo "fail";
                    }
                }
            }
            else {
                redirect('/home', 'location');
            }
        
        }
        else {
            redirect('/home', 'location');
            
        }
        
    }
}

