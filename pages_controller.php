<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function index()
	{
		$data['week_deal'] = $this->pages_model->get_deal_of_the_week();
		$data['food_category'] = $this->pages_model->get_food_category();
		$data['profile_pic'] = $this->pages_model->get_venue_profile_pic();
		$data['top_deals'] = $this->pages_model->get_top_deals();
		$data['top_venues'] = $this->pages_model->get_top_venues();
		// print_r($data);exit();

		$this->load->view('includes/typ-header');
		$this->load->view('pages/index', $data);
		$this->load->view('includes/typ-footer');
	}

	public function about()
	{
		$this->load->view('includes/typ-header');
		$this->load->view('pages/about');
		$this->load->view('includes/typ-footer');
	}

	public function contact()
	{
		$this->load->view('includes/typ-header');
		$this->load->view('pages/contact');
		$this->load->view('includes/typ-footer');
	}

	public function contact_mail()
	{
		$result = $this->email_model->contact_mail();
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function venues()
	{
		$data['profile_pic'] = $this->pages_model->get_venue_profile_pic();
		$data['all_venues'] = $this->pages_model->get_all_venues();
// print_r($data);exit();
		$this->load->view('includes/typ-header');
		$this->load->view('pages/venues',$data);
		$this->load->view('includes/typ-footer');
	}

	public function top_deals()
	{
		$data['food_category'] = $this->pages_model->get_food_category();
		$data['food_items'] = $this->pages_model->get_food_items();
		$data['all_top_deals'] = $this->pages_model->get_all_top_deals();

		$this->load->view('includes/typ-header');
		$this->load->view('pages/top_deals',$data);
		$this->load->view('includes/typ-footer');
	}

	public function view_venue($venue_id)
	{
		     
		$data['venue_info'] = $this->pages_model->get_venue($venue_id);
		$data['deals'] = $this->pages_model->get_deal_view($venue_id);
		$data['venue_media'] = $this->pages_model->get_venue_media();
		$data['logo'] = $this->pages_model->get_venue_logo($venue_id);
		$data['taxes'] = $this->order_model->get_taxes();
		$data['venue_view'] = $this->pages_model->get_venue_view($venue_id);

		$info['day_availablity'] = $this->pages_model->get_day_availablity($venue_id);

		foreach ($info['day_availablity'] as $day) {
			$data['permanent_days'][] = $day['permanent_deal_type_id'];
		}

		// print_r($data['permanent_days']);exit();
		$data['deal_view'] = 1;

		$this->load->view('includes/typ-header',$data);
		$this->load->view('pages/view_venue',$data);
		$this->load->view('includes/typ-footer');
	}

	public function get_venue_deal_info(){
		$data['info'] = $this->pages_model->get_venue_deal_info();
		$data['fcn'] = $this->pages_model->get_food_category();
		$i=0;
		
		
		
		foreach ($data['info'] as $info) {
			$tfc = array();
			foreach ($data['fcn'] as $test2) {
				if ($info['deal_id']==$test2['deal_id']) {

					$tfc['fcid'][]= $test2['id'];
					$tfc['fcn'][]= $test2['food_category_name'];
					$tfc['fci'][] = $test2['food_category_image'];
					$tfc['fciu'][] = $test2['food_category_image_url'];
				}
			}
			$infom[]= array_merge($data['info'][$i],$tfc);	 		
			$i++;
		}

		// for british barrel 31st passes
		if($info['venue_id'] == '24'){
			$people_or_pass = 'Pass';
		} else {
			$people_or_pass = 'People';
		}
		
		if(!empty($infom))
		{
			$i=0;
			$accor['accordion'] = '';
			$accor['view_menu_modal'] = '';
			foreach ($infom as $info) {
				$deal_desc = preg_replace('/\s+/', '', $info['deal_description']);
				if (empty($deal_desc)) {
					$deal_description = '';
				} else {
					$deal_description = '<h4><strong>Deal Description:</strong></h4><p> '.$info['deal_description'].'</p>';
				}

				$accor['accordion'].= '<div class="panel panel-default"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'"> <div class="panel-heading"> <h4 class="panel-title"> '.$info['deal_title'].' <br class="visible-xs"><span class="pull-right hidden-xs"><i class="fa fa-user"></i> '.$info['min_people_allowed'].' '.$people_or_pass.'</span> <span class="pull-right right_buff"><i class="fa fa-inr"></i> '.$info['deal_price'].' */- '.$info['deal_costing_type_name'].' </span> </h4> </div> </a> <div id="collapse'.$i.'" class="panel-collapse collapse in"> <div class="panel-body deal_menu"> '.$deal_description.' <h4><strong>Deal Includes:</strong> <a href="#" data-toggle="modal" data-target="#viewdeal'.$info['deal_id'].'"> <span class="more">View Menu</span></a></h4> <ul>';

				$accor['view_menu_modal'].= '<div class="modal fade" id="viewdeal'.$info['deal_id'].'" role="dialog"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">'.$info['deal_title'].'</h4> </div> <div class="modal-body"> <div class="row"> <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container"> <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 bhoechie-tab-menu"> <div class="list-group">';

				for($j=0; $j<count($info['fcn']);$j++){

					$accor['accordion'].= '<li> <div class="menu_icon pull-left"><img src="'.base_url().$info['fciu'][$j].$info['fci'][$j].'" class="img-responsive"> </div> <div class="menu_text"> <p>'.$info['fcn'][$j].'</p> </div> </li>';

					$accor['view_menu_modal'].= '<a href="#d'.$info['deal_id'].'-c'.$info['fcid'][$j].'" class="list-group-item text-center ';

					if ($j==0) {
						$accor['view_menu_modal'].= ' first_modal';
					}

					$accor['view_menu_modal'].= ' cat_select" data-deal_id="'.$info['deal_id'].'" data-cat_id="'.$info['fcid'][$j].'"> <center> <input type="image" src="'.base_url().$info['fciu'][$j].$info['fci'][$j].'"  class="img-responsive menu_icon"> <p>'.$info['fcn'][$j].'</p> </center> </a>';

				}

				$accor['accordion'].= '</ul> <br><br> <h4><strong>Deal Limit: </strong></h4> <p> '.$info['deal_slot_time'].' hours</p> <br/> <span class="visible-xs pull-left"><i class="fa fa-user"></i> '.$info['min_people_allowed'].' People min.  </span> <input type="button" id="select_'.$info['deal_id'].'" class="select_deal_button pull-right" value="Select Deal" onClick="book_deal('.$info['deal_id'].');"> </div> </div> </div>';

				$accor['view_menu_modal'].= '</div> </div> <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8"> <div class="tab-content" id="food_items'.$info['deal_id'].'"> </div> </div> </div> </div> </div> </div> </div> </div>';

				$i++;
			}

			$accor['venue_id'] = $infom[0]['venue_id'];
			$accor['venue_address_id'] = $infom[0]['venue_address_id'];
			$accor['venue_tc'] = $infom[0]['venue_tc'];

			echo json_encode($accor); 		

		} else {
			echo "No Data Available";
		}
	}

	public function get_venue_type(){
		$data['info'] = $this->pages_model->get_venue_type();

		if(!empty($data['info']))
		{

			foreach ($data['info'] as $vt) {
				echo '<li> <div class="menu_icon pull-left"><img src="'.base_url().$vt['venue_category_image_url'].$vt['venue_category_image'].'" class="img-responsive"> </div> <div class=""> <p>'.$vt['venue_category_name'].'</p> </div> </li> ';
			}
		}
	}

	public function get_venue_facility(){
		$data['info'] = $this->pages_model->get_venue_facility();

		if(!empty($data['info']))
		{	
			$i=1;
			foreach ($data['info'] as $vt) {
				if ($i!=1) { echo "|&nbsp;&nbsp;";};
				echo '<li> <div class=""> <p>'.$vt['venue_facility_name'].'</p> </div> </li> ';
				$i++;
			}
		}
	}

	public function get_event_category(){
		$data['info'] = $this->pages_model->get_event_category();

		if(!empty($data['info']))
		{
			foreach ($data['info'] as $ec) {
				echo '<li> <div class="menu_icon pull-left"><img src="'.base_url().$ec['event_category_image_url'].$ec['event_category_image'].'" class="img-responsive"> </div> <div class=""> <p>'.$ec['event_category_name'].'</p> </div> </li> ';
			} 		
		}
	}

// getting checking promocode
	public function get_promo_code(){

		if ($this->input->post('pay_amt')=='full') {			

			$data['promo'] = $this->pages_model->get_check_promo_code();

			if(!empty($data['promo'][0]['percentage']))
			{
				$payable_amt = $this->input->post('deal_price')-($this->input->post('deal_price')*($data['promo'][0]['percentage']/100));

				$promo['applied'] = 'Promo code applied with discount of '.$data['promo'][0]['percentage'].'%. Payable amount '.$payable_amt.' INR (excluding taxes).';
				$promo['offer_per'] = $data['promo'][0]['percentage'];
				$promo['after_offer'] = $payable_amt;

				echo json_encode($promo); 		

			}
			else
			{
				echo "No Data Available";
			}
		}
		else
		{
			echo "No Data Available";
		}
	}

	public function get_selected_food_item(){
		$data['fci'] = $this->input->post('food_category_id');
		$data['deal_id'] = $this->input->post('deal_id');

		if(isset($data) && !empty($data)){

			$data['food_items'] = $this->pages_model->get_selected_food_item($data);
			echo '<div role="tabpanel" class="tab-pane active" id="food_items'.$data['deal_id'].'"> <ol>';
			foreach ($data['food_items'] as $food_name) {

				if($food_name['item_type']==1){$item_type = 'Veg';} elseif ($food_name['item_type']==2) {$item_type = 'Non-veg';} elseif ($food_name['item_type']==3) {$item_type = 'Alcohol';} elseif ($food_name['item_type']==4) {$item_type = 'Non-alcohol';} else { $item_type = ''; }

				$item_quan = preg_replace('/\s+/', '', $food_name['item_quantity']);
				if (empty($item_quan)) {
					$item_quantity = '';
				} else {
					$item_quantity = ' - '.$food_name['item_quantity'];
				}

				echo '<li> '.$food_name['food_item_name'].'</li>';
			}
// .$item_quantity.<small>'.$item_type.'</small>
			echo '</ol> </div>';
		}

	}

	public function temp_store()
	{
		if($this->input->post('amount_paying')){
                    // Create session
			$deal_data = array(
				'party_size' => $this->input->post('party_size'),
				'deal_book_date' => $this->input->post('deal_book_date'),
				'deal_book_time' => $this->input->post('deal_book_time'),
				'pay_amt' => $this->input->post('pay_amt'),
				'promo_code' => $this->input->post('promo_code'),
				'venue_id' => $this->input->post('venue_id'),
				'venue_address_id' => $this->input->post('venue_address_id'),
				'deal_id' => $this->input->post('deal_id'),
				'deal_slot_time' => $this->input->post('deal_slot_time'),
				'deal_price_base' => $this->input->post('deal_price_base'),
				'deal_price' => $this->input->post('deal_price'),
				'tax_percentage' => $this->input->post('tax_percentage'),
				'offer_amount' => $this->input->post('offer_amount'),
				'after_offer' => $this->input->post('after_offer'),
				'tax_price' => $this->input->post('tax_price'),
				'deal_total_price' => $this->input->post('amount_paying'),
				'amount_paying' => $this->input->post('amount_paying'),
				'amount_remaining' => $this->input->post('amount_remaining'),
				'deal_session_status' => true
				);

			$this->session->set_userdata($deal_data);
		}

		redirect('register/login');
	}

//********************** CODE FOR SEARCH BAR ***************************
	public function search_result_view()
	{
		$data = $this->input->post();
		$result['all_venue'] = $this->pages_model->get_search_result($data);

		$this->load->view('includes/typ-header');
		$this->load->view('pages/search_result_view',$result);
		$this->load->view('includes/typ-footer');
	}

	/******************************** TEST ****************************************/
}
