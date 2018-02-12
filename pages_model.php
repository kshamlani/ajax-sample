<?php
class Pages_model extends CI_Model 
{
    public function __construct() {}

    // get admin emails
    public function get_admin_email(){

        $this->db->select('email_id');
        $this->db->from('user');
        $this->db->where('user_type_id', 1);
        $this->db->where('status', 1);
        $result = $this->db->get()->result_array();

        $admin_emails = '';
        foreach ($result as $email) {
            $admin_emails .=  $email['email_id'];
            $admin_emails .=  ',';
        }

        $admin_emails = rtrim($admin_emails,',');
        return $admin_emails;
    }

    public function get_deal_of_the_week(){
    	$this->db->select('*');
    	$this->db->join('venue', 'deal.venue_id = venue.venue_id');
    	$this->db->join('temprary_deal_type', 'deal.temprary_deal_type_id = temprary_deal_type.id');
        $this->db->join('venue_address', 'deal.venue_address_id = venue_address.venue_address_id');
        $this->db->join('area', 'venue_address.area_id = area.area_id');
        $this->db->join('location', 'location.location_id = area.location_id');
        $this->db->join('deal_costing_type', 'deal_costing_type.id = deal.deal_costing_type_id');
        $this->db->where('temprary_deal_type_id', 5);
        $this->db->where('deal.status', 1);
        $this->db->where('deal.IsApproved', 1);
        $this->db->where('deal.deal_end_date>', 'CURRENT_DATE', FALSE);
        $this->db->from('deal');
        return $this->db->get()->result_array();
    }

    public function get_food_category(){
    	$sql = "SELECT *,concat(deal_id,food_category_id) as comb FROM `food_item` JOIN food_category ON food_item.food_category_id = food_category.id where food_item.status=1 GROUP BY comb ORDER BY food_category.fc_order";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_food_items(){
        $this->db->select('*');
        $this->db->from('food_item');
        $this->db->where('status', 1);
        return $this->db->get()->result_array();
    }

    public function get_venue_profile_pic(){
    	$this->db->select('*');
        $this->db->where('set_as_profile', 1);
        $this->db->from('venue_media');
        return $this->db->get()->result_array();
    }

    public function get_venue_logo($venue_id){
        $this->db->select('*');
        $this->db->where('set_as_logo', 1);
        $this->db->where('venue_id', $venue_id);
        $this->db->from('venue_media');
        return $this->db->get()->result_array();
    }

    public function get_venue_media(){
        $this->db->select('*');
        $this->db->order_by("set_as_profile","desc");
        $this->db->from('venue_media');
        return $this->db->get()->result_array();
    }

    public function get_top_deals(){
    	$this->db->select('*');
    	$this->db->join('venue', 'deal.venue_id = venue.venue_id');
    	$this->db->join('temprary_deal_type', 'deal.temprary_deal_type_id = temprary_deal_type.id');
    	$this->db->join('venue_address', 'deal.venue_address_id = venue_address.venue_address_id');
        $this->db->join('area', 'venue_address.area_id = area.area_id');
        $this->db->join('location', 'location.location_id = area.location_id');
        $this->db->join('deal_costing_type', 'deal_costing_type.id = deal.deal_costing_type_id');
        $this->db->where('temprary_deal_type_id', 2);
        $this->db->where('venue.status', 1);
        $this->db->where('deal.IsApproved', 1);
        $this->db->order_by("deal.modified_at","desc");
        $this->db->where('deal.deal_end_date>', 'CURRENT_DATE', FALSE);
        $this->db->limit(3);
        $this->db->from('deal');
        return $this->db->get()->result_array();
    }

    public function get_top_venues(){
        $this->db->select('*');
        $this->db->join('venue', 'deal.venue_id = venue.venue_id');
        $this->db->join('temprary_deal_type', 'deal.temprary_deal_type_id = temprary_deal_type.id');
        $this->db->join('venue_address', 'deal.venue_address_id = venue_address.venue_address_id');
        $this->db->join('area', 'venue_address.area_id = area.area_id');
        $this->db->join('location', 'location.location_id = area.location_id');
        $this->db->join('deal_costing_type', 'deal_costing_type.id = deal.deal_costing_type_id');
        $this->db->where('temprary_deal_type_id', 6);
        $this->db->where('venue.status', 1);
        $this->db->where('deal.IsApproved', 1);
        $this->db->order_by("deal.modified_at","desc");
        $this->db->limit(3);
        $this->db->from('deal');
        return $this->db->get()->result_array();
    }

    public function get_all_top_deals(){
        $this->db->select('*');
        $this->db->join('venue', 'deal.venue_id = venue.venue_id');
        $this->db->join('temprary_deal_type', 'deal.temprary_deal_type_id = temprary_deal_type.id');
        $this->db->join('venue_address', 'deal.venue_address_id = venue_address.venue_address_id');
        $this->db->join('area', 'venue_address.area_id = area.area_id');
        $this->db->join('location', 'location.location_id = area.location_id');
        $this->db->join('deal_costing_type', 'deal_costing_type.id = deal.deal_costing_type_id');
        $this->db->where('temprary_deal_type_id', 2);
        $this->db->where('venue.status', 1);
        $this->db->where('deal.IsApproved', 1);
        $this->db->where('deal.deal_end_date>', 'CURRENT_DATE', FALSE);
        $this->db->order_by("deal.modified_at","desc");
        $this->db->from('deal');
        return $this->db->get()->result_array();
    }

    public function get_all_venues(){
        $this->db->select('*');
        $this->db->select('MIN(cast(deal.deal_price AS UNSIGNED)) as min_deal_price');
        $this->db->join('venue_address', 'venue_address.venue_id = venue.venue_id');
        $this->db->join('location', 'location.location_id = venue_address.city_id');
        $this->db->join('deal', 'deal.venue_id = venue.venue_id');
        $this->db->order_by("venue.modified_at","desc");
        $this->db->from('venue');
        $this->db->where('venue.status', 1);
        $this->db->group_by("venue.venue_id");
        return $this->db->get()->result_array();
    }

    public function get_deal_view($venue_id){
        $this->db->select('*');
        $this->db->from('deal');
        $this->db->where('deal.deal_end_date>', 'CURRENT_DATE', FALSE);
        $this->db->where('deal.venue_id', $venue_id);
        $this->db->where('deal.status', 1);
        $this->db->where('deal.IsApproved', 1);
        $this->db->join('permanent_deal_type', 'permanent_deal_type.id = deal.permanent_deal_type_id');
        $this->db->join('venue', 'deal.venue_id= venue.venue_id');
        $this->db->order_by('cast(deal.deal_price AS UNSIGNED)');
        return $this->db->get()->result_array();
    }

    public function get_venue_view($venue_id){
        $this->db->select('*');
        $this->db->from('venue');
        $this->db->where('venue.venue_id', $venue_id);
        $this->db->where('venue.status', 1);
        $this->db->join('venue_address', 'venue.venue_id = venue_address.venue_id');
        $this->db->join('location', 'location.location_id = venue_address.city_id');
        return $this->db->get()->result_array();
    }

    public function get_venue($venue_id){
        $this->db->select('*');
        $this->db->from('venue');
        $this->db->where('venue.status', 1);
        $this->db->where('venue.venue_id', $venue_id);
        return $this->db->get()->result_array();
    }

    public function get_venue_address($venue_address_id){
        $this->db->select('*');
        $this->db->from('venue_address');
        $this->db->where('venue_address.status', 1);
        $this->db->where('venue_address.venue_address_id', $venue_address_id);
        return $this->db->get()->result_array();
    }

    // check, is day available or not
    public function get_day_availablity($venue_id){
        $this->db->select('*');
        $this->db->from('deal');
        $this->db->where('deal.venue_id', $venue_id);
        $this->db->where('deal.status', 1);
        $this->db->where('deal.IsApproved', 1);
        $this->db->join('venue_address', 'deal.venue_address_id = venue_address.venue_address_id');
        return $this->db->get()->result_array();
    }

// ajax function call: get deals by venue address
    public function get_venue_deal_info(){

        $this->db->select('*');
        $this->db->from('deal');
        $this->db->join('venue_address', 'deal.venue_address_id = venue_address.venue_address_id');
        $this->db->join('venue', 'venue.venue_id = venue_address.venue_id');
        $this->db->join('deal_costing_type', 'deal.deal_costing_type_id = deal_costing_type.id');
        $this->db->where('deal.venue_address_id', $this->input->post('venue_address_id'));
        $this->db->where('deal.status', 1);
        $this->db->where('deal.IsApproved', 1);
        $this->db->where('deal.deal_end_date>', 'CURRENT_DATE', FALSE);
        $this->db->where('deal.permanent_deal_type_id', $this->input->post('day'));
        $this->db->order_by('cast(deal.deal_price AS UNSIGNED)');
        return $this->db->get()->result_array();
    }

    // ajax function call: get venue type by venue address
    public function get_venue_type(){

        $this->db->select('venue_category_id');
        $this->db->from('venue_address');
        $this->db->where('venue_address_id', $this->input->post('venue_address_id'));
        $this->db->where('venue_address.status', 1);
        $result = $this->db->get()->result_array();

        $vtid = explode(',', $result[0]['venue_category_id']);

        $this->db->select('*');
        $this->db->from('venue_category');
        $this->db->or_where_in('venue_category_id', $vtid);
        $this->db->where('venue_category.status', 1);
        return $this->db->get()->result_array();
    }

    // ajax function call: get venue facility by venue address
    public function get_venue_facility(){

        $this->db->select('venue_facilities_id');
        $this->db->from('venue_address');
        $this->db->where('venue_address_id', $this->input->post('venue_address_id'));
        $this->db->where('venue_address.status', 1);
        $result = $this->db->get()->result_array();

        $vfid = explode(',', $result[0]['venue_facilities_id']);

        $this->db->select('*');
        $this->db->from('venue_facility');
        $this->db->or_where_in('venue_facility_id', $vfid);
        $this->db->where('venue_facility.status', 1);
        return $this->db->get()->result_array();

    }

    // ajax function call: get food item by category
    public function get_selected_food_item($data){

        $this->db->select('*');
        $this->db->from('food_item');
        $this->db->where('deal_id', $data['deal_id']);
        $this->db->where('food_category_id', $data['fci']);
        $this->db->where('food_item.status', 1);
        return $this->db->get()->result_array();

    }

    // ajax function call: get event category by venue address
    public function get_event_category(){

        $this->db->select('event_category_id');
        $this->db->from('venue_address');
        $this->db->where('venue_address_id', $this->input->post('venue_address_id'));
        $this->db->where('venue_address.status', 1);
        $result = $this->db->get()->result_array();

        $ecid = explode(',', $result[0]['event_category_id']);

        $this->db->select('*');
        $this->db->from('event_category');
        $this->db->or_where_in('event_category_id', $ecid);
        $this->db->where('event_category.status', 1);
        return $this->db->get()->result_array();

    }

    // ajax function call: get gettin and checking promocode
    public function get_check_promo_code(){
        if ($this->input->post('pay_amt')=='full') {

            $deal_book_time = date("G:i", strtotime($this->input->post('deal_book_time')));

            $this->db->select('*');
            $this->db->from('promocode');
            $this->db->where('promocode', $this->input->post('promocode'));
            $this->db->where('min_total <=', $this->input->post('deal_price'));
            $this->db->where('status', 1);
            $this->db->where('deal_count >', 0);
            $this->db->where('start_date <=', $this->input->post('deal_book_date'));
            $this->db->where('end_date >=', $this->input->post('deal_book_date'));
            $this->db->where('start_time <=', $deal_book_time);
            $this->db->where('end_time >=', $deal_book_time);

            return $this->db->get()->result_array();
        } else {
            return false;
        }
    }

    // book deal
    public function book_deal(){
        if ($this->session->userdata('pay_amt')=='part') {
            $promocode = '';
        } elseif ($this->session->userdata('pay_amt')=='full' && !empty($this->session->userdata('promo_code'))) {

            $this->db->select('promocode_id');
            $this->db->from('promocode');
            $this->db->where('promocode', $this->session->userdata('promo_code'));
            $this->db->where('status', 1);
            $result = $this->db->get()->result_array();
            
            if ($result) {
                $promocode = $result[0]['promocode_id'];
                $this->db->set('deal_count', 'deal_count-1');
                $this->db->where('promocode_id', $promocode);
                $this->db->update('promocode');
            } else {
                $promocode = '0';
            }

        } else {
            $promocode = '0';
        }

        $data = array(
            'user_first_name' => $this->session->userdata('typ_first_name'),
            'user_last_name' => $this->session->userdata('typ_last_name'),
            'user_contact_number' => $this->session->userdata('typ_contact_no'),
            'user_email' => $this->session->userdata('typ_email'),
            'venue_id' => $this->session->userdata('venue_id'),
            'venue_address_id' => $this->session->userdata('venue_address_id'),
            'deal_id' => $this->session->userdata('deal_id'),
            'deal_book_date' => $this->session->userdata('deal_book_date'),
            'deal_book_time' => $this->session->userdata('deal_book_time'),
            'deal_book_datetime' => $this->session->userdata('deal_book_date').' '.$this->session->userdata('deal_book_time'),
            'deal_slot_time' => $this->session->userdata('deal_slot_time'),
            'deal_base_price' => $this->session->userdata('deal_price_base'),
            'party_size' => $this->session->userdata('party_size'),
            'deal_price' => $this->session->userdata('deal_price'),
            'offer_amount' => $this->session->userdata('offer_amount'),
            'tax_price' => $this->session->userdata('tax_price'),
            'deal_total_price' => $this->session->userdata('deal_total_price'),
            'payment_type' => $this->session->userdata('pay_amt'),
            'amount_paid' => $this->input->post("amount"),
            'amount_remain' => $this->session->userdata('amount_remaining'),
            'promo_code_id' => $promocode,
            'payment_details_id' => $this->input->post("txnid"),
            'order_booked_by' => $this->session->userdata('typ_first_name').' '.$this->session->userdata('typ_last_name'),
            'order_status_id' => '6'
            );
        $this->db->insert('order_booking', $data);
        return true;
    }

    public function payment_record(){

        $data = array(
            'mihpayid' => $this->input->post('mihpayid'),
            'mode' => $this->input->post('mode'),
            'status' => $this->input->post('status'),
            'unmappedstatus' => $this->input->post('unmappedstatus'),
            'pum_key' => $this->input->post('key'),
            'txnid' => $this->input->post('txnid'),
            'amount' => $this->input->post('amount'),
            'cardCategory' => $this->input->post('cardCategory'),
            'net_amount_debit' => $this->input->post('net_amount_debit'),
            'addedon' => $this->input->post('addedon'),
            'productinfo' => $this->input->post('productinfo'),
            'firstname' => $this->input->post('firstname'),
            'email' => $this->input->post('email'),
            'hash' => $this->input->post('hash'),
            'payment_source' => $this->input->post('payment_source'),
            'PG_TYPE' => $this->input->post('PG_TYPE'),
            'bank_ref_num' => $this->input->post('bank_ref_num'),
            'bankcode' => $this->input->post('bankcode'),
            'error' => $this->input->post('error'),
            'error_Message' => $this->input->post('error_Message'),
            'name_on_card' => $this->input->post('name_on_card'),
            'cardnum' => $this->input->post('cardnum'),
            'issuing_bank' => $this->input->post('issuing_bank'),
            'card_type' => $this->input->post('card_type')
            );
        $this->db->insert('payment_record', $data);
        return true;
    }


    //************************ CODE FOR SEARCH BAR *******************************
    public function get_search_result($data)
    {
     $qry = "SELECT venue.*,venue_address.*,venue_media.*,location.location_name,area.area_name from venue JOIN venue_address ON venue.venue_id = venue_address.venue_id LEFT JOIN venue_media ON venue_media.venue_id = venue_address.venue_id LEFT JOIN location ON location.location_id = venue_address.city_id LEFT JOIN area ON area.area_id = venue_address.area_id LEFT JOIN event_category ON event_category.event_category_id = venue_address.event_category_id LEFT JOIN venue_category ON venue_category.venue_category_id = venue_address.venue_address_id where venue.status=1 AND";

     if(!empty($data['city_id']))
     {
        $qry .= "(venue_address.city_id = '".$data['city_id']."' AND venue_media.set_as_profile = 1) ";
    }

    if(!empty($data['locality_id']))
    {
        $qry .= "AND (venue_address.area_id = '".$data['locality_id']."' AND venue_media.set_as_profile = 1) ";
    }

    if(!empty($data['event_category_id']))
    {
        $qry .= "AND (venue_address.event_category_id like '%".$data['event_category_id']."%' AND venue_media.set_as_profile = 1) ";
    }

    if(!empty($data['venue_category_id']))
    {
        $qry .= "AND (venue_address.venue_category_id like '%".$data['venue_category_id']."%' AND venue_media.set_as_profile = 1)";
    }

    $query = $this->db->query($qry);
    return $query->result_array();
}
}
