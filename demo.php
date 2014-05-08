<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class blogs extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('blog_model');
	}

	public function index()
	{
		//$this->load->view('home');
		$this->blogs();
	}
	public function blogs(){
		$page=(isset($_GET["per_page"]) && $_GET["per_page"]!="")?$_GET["per_page"]:""; //$this->input->get("page");
		
		if($page == ''){
            $page = '0';
        }else{
            if(!is_numeric($page)){
            	redirect(BASEURL.'404');
            }else{
            	$page = $page;
            }
        }
		
		$config["per_page"] = $this->config->item("perpageitem"); 
		$config['base_url']=base_url()."blogs/?".$this->common->removeUrl("per_page",$_SERVER["QUERY_STRING"]);
		$countdata=array();
		$countdata=$_GET;
		$countdata["countdata"]="yes";	
		
		$config['total_rows']=count($this->blog_model->getBlogData($countdata));   
		$config["uri_segment"]=(isset($_GET["per_page"]) && $_GET["per_page"]!="")?$_GET["per_page"]:"0";
		$this->pagination->initialize($config);
/*--------------------------Paging code ends---------------------------------------------------*/
		$searcharray=array();
		$searcharray=$_GET;
		$searcharray["per_page"]=$config["per_page"];
		$searcharray["page"]=$config["uri_segment"];
		$data["resultset"]=$this->blog_model->getBlogData($searcharray);
		$data["item"]="Blogs";
		$data["master_title"]="Blogs | ". $this->config->item('sitename'); 
		$data["master_body"]="blogs";
		$this->load->theme('home_layout',$data);
		
	}
	
	
	//for blog details 
	public function blog_detail(){
		$blog_id=$this->uri->segment('3');
		$data["item"]="Vo Notes";
		$data["master_title"]="Blogs | ". $this->config->item('sitename'); 
		//$data['active'] = $pagedata;
		$data["resultset"]=$this->blog_model->getIndividualBlog($blog_id);	
		$data['master_body'] = 'blog_detail';
		$this->load->theme("home_layout",$data);	
	}
	
}

