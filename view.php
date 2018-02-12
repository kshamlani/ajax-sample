<?php 
if (!$deals) {
  $deals[0]['deal_end_date']='0';
}
if (!$logo) {
  $logo[0]['image_url']='assets/images/';
  $logo[0]['image_name']='no_image_available.png';
}
?>

<div class="container">
  <div class="row">

    <?php foreach ($venue_info as $venue): ?>
<?php $curr_venue_id = $venue['venue_id']; ?>

      <div class="col-md-12">
        <div class="row">
          <div class="venue_name col-md-4">
            <img src="<?php echo base_url().$logo[0]['image_url'].$logo[0]['image_name']; ?>" class="img-responsive col-md-4 col-sm-2 col-xs-4 pull-left">
            <h3 class="up"><?php echo $venue['venue_name'] ?> </small></h3>
            <h4><?php echo get_location_name($venue_view[0]['city_id']); ?></h4>
          </div>
          <div class="bottom_buffer visible-xs"></div>
          <div class="col-md-8 bottom_buffer" id="wrap_about">
            <h4 class="up">About the Venue</h4>
            <p><?php echo character_limiter($venue['venue_description'], 190); ?>
              <a href="#"><span id="readmore">&nbsp;&nbsp;&nbsp;Show More</span></a>
            </p>
          </div>
        </div>
        <div class="clearfix"></div>
        <!-- Start About the venue text -->
        <div id="full_about" hidden="">
          <div class="col-md-12 about_venue">
           <?php echo $venue['venue_description']; ?>
         </div>
         <a href="#"><span id="readless">&nbsp;&nbsp;&nbsp;Show Less</span></a>
       </div>
       <!-- End About the venue text -->
       <!-- Start Carousel -->
       <div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="0">
        <div class="row clearfix">

          <div class="col-md-10 col-sm-10 col-xs-12 column">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
              <?php foreach ($venue_media as $media): ?>
                <?php if ($media['venue_id']==$venue['venue_id']): ?>
                  <?php if ($media['set_as_profile']==1): ?>
                    <div class="item active">
                      <div class="graph">
                        <div class="graph-content"> <img src="<?php echo base_url().$media['image_url'].$media['image_name']; ?>" class="img-responsive" width="918" alt="Venue">
                        </div>
                      </div>
                    </div>
                  <?php endif ?>
                  <?php if ($media['set_as_profile']!=1 && $media['set_as_logo']!=1): ?>
                    <div class="item">
                      <div class="graph">
                        <div class="graph-content"> <img src="<?php echo base_url().$media['image_url'].$media['image_name']; ?>" class="img-responsive" width="918" alt="Venue">
                        </div>
                      </div>
                    </div>
                  <?php endif ?>
                <?php endif ?>            
              <?php endforeach; ?>

              <!-- End Item -->
            </div>
            <!-- End Carousel Inner -->
          </div>

          <div class="col-md-2 col-sm-2 col-xs-12 column">
            <div class="controls">
              <ul class="nav">
                <?php $i=1;foreach ($venue_media as $media): ?>
                <?php if ($media['venue_id']==$venue['venue_id']): ?>
                  <?php  if ($media['set_as_profile']!=1 && $media['set_as_logo']!=1): ?>
                    <li data-target="#custom_carousel" data-slide-to="<?php echo $i; ?>">
                      <a href="#"><img src="<?php echo base_url().$media['image_url'].$media['image_name']; ?>"><small class="hidden-xs hidden-sm">Venue Image</small>
                      </a>
                    </li>
                    <?php $i++;  ?>
                  <?php endif ?>
                <?php endif ?>            
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<div class="row upper-buff">
  <div class="col-md-2 col-sm-5 col-xs-12 deals">
    <div class="form-group">
      <!-- Location input 
      <a href="#view_map" data-toggle="modal" data-target="#view_map" class="pull-right"><span class="more"><small>View Map</small></span></a> -->
      <label class="control-label" for="date"><small>Select Location: </small></label>
      <div class="search-filter-deal">
        <select name="venue_address" class="contact_form_email" id="venue_address">
          <?php $i=1;foreach ($venue_view as $venue): ?>
          <option value="<?php echo $venue['venue_address_id'] ?>" <?php if ($i==1) {echo "selected"; } ?>><?php echo get_area_name_from_address($venue['venue_address_id']) ?></option>
          <?php $i++; endforeach; ?>
        </select>
      </div>
    </div>
  </div>
  <!-- hide button if one area -->
  
  <!-- show buttons only if their permanent deal type present -->
  <?php if (in_array("3", $permanent_days)): ?>
    <?php if (count(array_unique($permanent_days))>1 || count($venue_view)>1):?>
      <div class="col-md-2 col-sm-3 col-xs-6 deals deals_upper_buffer" align="right">
        <button class="deal_day right_buff active" data-day='3'><i class="fa fa-calendar"></i> All Deals</button>
      </div>
    <?php endif; ?>
    <input type="hidden" name="day_3" id="day_3" value="3">
  <?php endif ?>

  <?php if (in_array("1", $permanent_days)): ?>
    <?php if (count(array_unique($permanent_days))>1 || count($venue_view)>1):?>
      <div class="col-md-2 col-sm-3 col-xs-6 deals deals_upper_buffer" align="right">
        <button class="deal_day right_buff" data-day='1'><i class="fa fa-calendar"></i> Weekday Deals</button>
      </div>
    <?php endif; ?>
    <input type="hidden" name="day_1" id="day_1" value="1">
  <?php endif ?>

  <?php if (in_array("2", $permanent_days)): ?>
    <?php if (count(array_unique($permanent_days))>1 || count($venue_view)>1):?>
      <div class="col-md-2 col-sm-3 col-xs-6 deals deals_upper_buffer" align="right">
        <button class="deal_day" data-day='2'><i class="fa fa-calendar-check-o"></i> Weekend Deals</button>
      </div>
    <?php endif; ?>
    <input type="hidden" name="day_2" id="day_2" value="2">
  <?php endif ?>
</div>
<div class="clearfix"></div>

<!-- Viw Map Modal -->
<!-- <div class="modal fade" id="view_map" role="dialog">
  <div class="modal-dialog">    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Venue Name: <span id="venue_name"></span></h4>
      </div>
      <div class="modal-body">
        <span id="view_map_show"  style="width:400px;height:400px"></span>
      </div>
    </div>      
  </div>
</div> -->

<div class="row top_buffer">
  <div class="col-md-8">
  	<div class="row">
    	<div class="col-md-12">
            <!-- Weekday package deals column start -->
            <h3 id="deal_day">Package Deals</h3>
            <div class="under_line"></div>
            <div class="panel-group" id="accordion">
              <!-- data from ajax -->
            </div>
    	</div>
        
        <div class="col-md-12 upper-buff">
          <div class="deal_menu" id="vt_div">
            <h3>Venue Type</h3>
            <div class="under_line"></div>
            <ul id="vt">
            </ul>
          </div>
          <hr>
          <div class="deal_menu" id="ec_div">
            <h3>Best Suited for </h3>
            <div class="under_line"></div>
            <ul id="ec">
            </ul>
          </div>
             <!-- <hr>
             <div class="deal_menu" id="vf_div" hidden="">
                <h3>Facilities </h3>
                <div class="under_line"></div>
                <ul id="vf">
                </ul>
        
              </div>-->
    	</div>
    <!-- facilities column end -->

    </div>
  </div>

  <!-- Weekday package deals column end -->

  <div class="col-md-4 col-sm-12 col-xs-12">
    <!-- book deals column start -->
    <h3>Book Deal</h3>
    <div class="under_line"></div>
    <?php if ($this->session->userdata('typ_logged_in')): ?>
      <?php echo form_open('transaction/index'); ?>
    <?php endif; ?>
    <?php if (!$this->session->userdata('typ_logged_in')): ?>
      <?php echo form_open('pages/temp_store'); ?>
    <?php endif; ?>

    <div class="row">
      <div class="form-group col-md-12 col-sm-4 col-xs-12">
        <!-- Party Size input <?php echo $curr_venue_id; ?> -->

        <label class="control-label" for="date">Select Party Size: <strong><span id="show_size"></span></strong></label>
        <div>       
          <input type="range" name="party_size" id="party_size" min="0" max="20" value="0">
        </div>
      </div>
      <div class="form-group col-md-12 col-sm-4 col-xs-12">
        <!-- Date input -->
        <label class="control-label" for="date">Select Date: </label>
        <?php if ($curr_venue_id == 24){ ?>
        <input type="text" class="contact_form_email" name="deal_book_date"  value="2017/12/31" readonly>
        <?php } else { ?>
        <input type="text" placeholder="YYYY-MM-DD" id="example" class="contact_form_email" name="deal_book_date"  value="" required="required">
        <?php } ?>
        <span id="example_message"></span>
      </div>
      <div class="form-group col-md-12 col-sm-4 col-xs-12">
        <!-- Party Size input -->
        <label class="control-label" for="date">Select Time: </label>
        
         <?php if ($curr_venue_id == 24){ ?>
         <span><input type="text" placeholder="Party Time" class="contact_form_email" name="deal_book_time" value="8:00 PM" readonly></span>
        <?php } else { ?>
        <span><input type="text" placeholder="Party Time" id="timepicker" class="contact_form_email" name="deal_book_time" required="required"></span>
	<?php } ?>
	
      </div>
    </div>
    <div class="clearfix"></div>
    <hr>
    <div class="row">
      <div class="col-md-6 col-sm-3 col-xs-6 deals_details">Deal Cost:</div>
      <div class="col-md-6 col-sm-3 col-xs-6 deals_details"><i class="fa fa-inr"></i> <span id="deal_price_span">0</span>/-</div>
    </div>
    <div class="row deals">
      <div class="col-md-6 col-sm-3 col-xs-6 payment">
        <label>
          <input type="radio" class="option-input radio" name="pay_amt" value="full" checked />
          <i class="fa fa-money"></i> Full Payment
        </label>
      </div>
      <div class="col-md-6 col-sm-3 col-xs-6 payment">
        <label data-tooltip="Pay 15% now and the remaining amount to the venue">
          <input type="radio" class="option-input radio" name="pay_amt" value="part" />
          <i class="fa fa-database"></i> Part Payment
        </label>
      </div>
    </div>
    <div class="row deals" id="promo_code">
      <hr>
      <div class="clearfix"></div>    
      <div class="deals">
        <div class="col-md-8 deals">
          <input type="text" class="contact_form_email" name="promo_code" placeholder="Enter Promo Code">
        </div>
        <div class="col-md-4 deals">
          <input type="button" class="select_deal_button" id="promo_code_button" value="Apply">
        </div>
      </div> 
      <span class="col-md-12 typ_text" id="promo_code_span"></span>
    </div>
    <div class="clearfix"></div>
    <hr>
    <div class="row top_buffer">
      <div class="col-md-6 col-sm-3 col-xs-7 deals_details">Total Deal Cost:</div>
      <div class="col-md-6 col-sm-3 col-xs-5 deals_details"><i class="fa fa-inr"></i> <span id="deal_total_span">0</span>/-</div>

      <?php foreach ($taxes as $tax):?>
        <!-- *************************** hidden fields open **********************-->
        <!-- // geting tax charges -->
        <input type="hidden" class="charge_tax" name="charge_tax_<?php echo $tax['tax_id']; ?>" value="<?php echo $tax['charges']; ?>" readonly>
        <!-- *************************** hidden fields close **********************-->
        <?php
        $tax_data_array[] = $tax['tax_name'].' @'.$tax['charges'].'%';
        $tax_data = implode(', ', $tax_data_array);
        endforeach;?>    
      </div>
      <div class="row">
        <div class="col-md-3 col-sm-2 col-xs-12 deals_details_tax pull-right" data-tooltip="<?php echo $tax_data; ?>"> incl. taxes</div>
      </div>
      <div class="clearfix"></div>
      <div class="row top_buffer">
        <div class="col-md-6 col-sm-3 col-xs-6">Booking Amount:</div>
        <div class="col-md-6 col-sm-3 col-xs-6"><i class="fa fa-inr"></i> <span id="amount_paying_span">0</span>/-</div>
        <div id="pay_to_venue" hidden="">
          <div class="col-md-6 col-sm-3 col-xs-6">Pay to Venue:</div>
          <div class="col-md-6 col-sm-3 col-xs-6"><i class="fa fa-inr"></i> <span id="amount_remaining_span">0</span>/-</div>
        </div>
      </div>

      <!-- *********************** hidden fields start *********************************-->

      <div class="form-group" hidden="">
        <input type="text" name="venue_id" class="form-control" readonly required="">
        <input type="text" name="deal_end_date" class="form-control" readonly required="">
        <input type="text" name="venue_address_id" class="form-control" readonly required="">
        <input type="text" name="deal_id" class="form-control" readonly required="">
        <input type="text" name="deal_slot_time" class="form-control" readonly required="">
        <input type="text" name="deal_price_base" class="form-control" readonly required="">
        <input type="text" name="deal_price" class="form-control charge_deal" readonly required="">
        <input type="text" name="tax_percentage" class="form-control" readonly required="" id="percentage_id">
        <input type="text" name="offer_amount" class="form-control" readonly required="" id="offer_amount">
        <input type="text" name="after_offer" class="form-control" readonly required="" id="after_offer">
        <input type="text" name="tax_price" class="form-control charge_deal" readonly required>
        <input type="text" name="deal_total_price" class="form-control" readonly required>
        <input type="text" name="amount_paying" class="form-control" readonly required>
        <input type="text" name="amount_remaining" class="form-control" readonly required>
      </div>

      <!-- *********************** hidden fields end *********************************-->
      <div class="top_buffer">
        <input type="checkbox" name="checkbox" value="check" id="agree" required="" /> I have read and agree to the Terms & Conditions and Privacy Policy
      </div>
      <div class="col-xs-12 col-sm-3 col-md-12 search-field-cont top_buffer">
        <input type="submit" id="save" class="btn butn" value="Book Deal">
      </div>
      <?php echo form_close(); ?>
    </div>
    <!-- book deals column end -->
    
  </div>
  <div class="clearfix"></div>
  <hr>

<?php 
	if($deal_view==1)
	{
?>
	<div class="row customise"> 
	    <div class="col-md-12 col-sm-12 col-xs-12">
	  	<h3 class="text-center">Call Us On +91 7378840340 To Customize Your Party.</h3>
	    </div>
	</div>	
<?php
	}
 ?>		

  <?php if(!empty($deals[0]['deal_term_condition'])):?>
    <div class="row upper-buff">
      <div class="col-md-12" id="deal_tc_div">
        <h3>Deal Terms & Conditions</h3>
        <div class="under_line"></div>
        <p id="deal_tc">
          <?php echo $deals[0]['deal_term_condition'] ?>
        </p>
      </div>
    </div>  
  <?php endif; ?>
  <hr>
  <div class="row upper-buff">
    <div class="col-md-12" id="venue_tc_div">
      <h3>Venue Terms & Conditions</h3>
      <div class="under_line"></div>
      <p id="venue_tc">
      </p>
    </div>

  <?php endforeach ?>
</div>

</div>
<div id="view_menu_modal"></div>


<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-2.2.3.min.js';?>"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap-timepicker.min.js'?>"></script>
<script src="<?php echo base_url(); ?>assets/typ_web/js/datepicker.js"></script> 


<script>
  function myMap() {
    var mapOptions = {
      center: new google.maps.LatLng(51.5, -0.12),
      zoom: 10,
      mapTypeId: google.maps.MapTypeId.HYBRID
    }
    var map = new google.maps.Map(document.getElementById("view_map_show"), mapOptions);
  }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>

<script>
  var deal_end_date = $('input[name=deal_end_date]').val();
  console.log(deal_end_date);

  $('#timepicker').timepicker({
  });

  $('#example').datepicker({
    format: "yyyy/mm/dd",
    startDate: new Date(),
    endDate: '+15d',
    autoclose: true
  });

  $('#example').on('change',function(){
        var sdate= $('#example').val();
        if((sdate=='2017/12/24')||(sdate=='2017/12/25')||(sdate=='2017/12/31'))
        {
            $('#example').val(" ");
            $('#example_message').html("<b style='color:red';> Deals are not available on this date.</b>");
            $('#save').attr("disabled", "disabled");
        }
        else
        {
            $('#example_message').val(" ");
            $('#example_message').html('&nbsp;');
            $('#save').prop("disabled", false);
        }
  });


// Venue change ajax open
// On load
var venue_address = $('#venue_address').val();
if ($('#day_1').length>0) {
  var day = 1;
} else if ($('#day_2').length>0) {
  var day = 2;
} else {
  var day = 3;
}

$.ajax({
  url : "<?php echo base_url(); ?>pages/get_venue_deal_info",
  type : "POST",
  data : {'venue_address_id':venue_address, 'day':day},
  success : function(data) 
  {
    if(data!="No Data Available")
    {
      data = jQuery.parseJSON(data);

      var scntDiv = $('#accordion');

      $(data['accordion']).appendTo(scntDiv); 

      if (data['venue_tc'].length == 0) {
        $("#venue_tc_div").css("display", "none");
      }

      $("#venue_tc").html(data['venue_tc']);
      $("#view_menu_modal").html(data['view_menu_modal']);
      $("input[name=venue_id]").val(data['venue_id']); 
      $("input[name=venue_address_id]").val(venue_address);

      $("#collapse1,#collapse2, #collapse3, #collapse4, #collapse5, #collapse6, #collapse7, #collapse8, #collapse9, #collapse10").css("height", "0px");
      $("#collapse1,#collapse2, #collapse3, #collapse4, #collapse5, #collapse6, #collapse7, #collapse8, #collapse9, #collapse10").removeClass("in");
    }
  },
  error : function(data) 
  {
    console.log('No data found');
  }
});

  // venue type
  $.ajax({
    url : "<?php echo base_url(); ?>pages/get_venue_type",
    type : "POST",
    data : {'venue_address_id':venue_address},
    success : function(data) 
    {
      if(data!="No Data Available")
      {
     // console.log(data);
     $("#vt").html(data);
   }
 },
 error : function(data) 
 {
  console.log('No data found');
}
});

// venue facilities
$.ajax({
  url : "<?php echo base_url(); ?>pages/get_venue_facility",
  type : "POST",
  data : {'venue_address_id':venue_address},
  success : function(data) 
  {
    if(data!="No Data Available")
    {
     $("#vf").html(data);
   }
 },
 error : function(data) 
 {
  console.log('No data found');
}
});

// event category
$.ajax({
  url : "<?php echo base_url(); ?>pages/get_event_category",
  type : "POST",
  data : {'venue_address_id':venue_address},
  success : function(data) 
  {
    if(data!="No Data Available")
    {
     $("#ec").html(data);
   }
 },
 error : function(data) 
 {
  console.log('No data found');
}
});

// view menu modal on load
// On Click
// view menu modal on click
$( document ).ajaxComplete(function() {
  $('.first_modal').trigger('click');
  $(document).on('click','.cat_select',function(){
    var deal_id = $(this).data("deal_id");
    var cat_id = $(this).data("cat_id");
    if(cat_id)
    {
      $.ajax({
        url : "<?php echo base_url(); ?>pages/get_selected_food_item",
        type : "POST",
        data : {'food_category_id' : cat_id,'deal_id' : deal_id },
        success : function(data) 
        {
          if(data!="No Data Available")
          {
                // alert(data);
                $('#food_items'+deal_id).html(data);
              }
            },
            error : function(data) 
            {
              console.log('No data found');
            }
          });
    }else{
      $('#food_items'+deal_id).html('No food items found.');
    }
  });
});

$('.deal_day').on('click',function(){

  $("#promo_code_button").val('Apply'); 
  $('#promo_code_button').removeClass('promo_code_applying');
  $('#promo_code_button').addClass('select_deal_button');
  $("input[name=promo_code]").val('');
  $("input[name=promo_code]").attr('placeholder', 'Enter Promo Code');
  $('#promo_code_span').html('');

  $("#accordion").html('');
  $('.deal_day').removeClass("active");
  $(this).addClass("active");

  var day = $(this).attr("data-day");
  var venue_address = $('#venue_address').val();

  if (day==1) {
    $("#deal_day").html('<span>Weekday Package Deals</span>');
  } else if (day==2){
    $("#deal_day").html('<span>Weekend Package Deals</span>');
  } else {
    $("#deal_day").html('<span>All Package Deals</span>');
  }

  if(venue_address)
  {

      // deal select by venue address
      $.ajax({
        url : "<?php echo base_url(); ?>pages/get_venue_deal_info",
        type : "POST",
        data : {'venue_address_id':venue_address, 'day':day},
        success : function(data) 
        {
          if(data!="No Data Available")
          {
            data = jQuery.parseJSON(data);

            var scntDiv = $('#accordion');

            $(data['accordion']).appendTo(scntDiv); 
            $("#venue_tc").html(data['venue_tc']);
            $("#view_menu_modal").html(data['view_menu_modal']);
            $("input[name=venue_id]").val(data['venue_id']); 
            $("input[name=venue_address_id]").val(venue_address);

            $("#collapse1,#collapse2, #collapse3, #collapse4, #collapse5, #collapse6, #collapse7, #collapse8, #collapse9, #collapse10").css("height", "0px");
            $("#collapse1,#collapse2, #collapse3, #collapse4, #collapse5, #collapse6, #collapse7, #collapse8, #collapse9, #collapse10").removeClass("in");

          } else {
           $("#accordion").html('Deal not found');
            // console.log('Deal not found');
          }
        },
        error : function(data) 
        {
          console.log('Deal not found');
        }
      });

// venue type
$.ajax({
  url : "<?php echo base_url(); ?>pages/get_venue_type",
  type : "POST",
  data : {'venue_address_id':venue_address},
  success : function(data) 
  {
    if(data!="No Data Available")
    {
     // console.log(data);
     $("#vt").html(data);
   }
 },
 error : function(data) 
 {
  console.log('No data found');
}
});

// venue facilities
$.ajax({
  url : "<?php echo base_url(); ?>pages/get_venue_facility",
  type : "POST",
  data : {'venue_address_id':venue_address},
  success : function(data) 
  {
    if(data!="No Data Available")
    {
     $("#vf").html(data);
   }
 },
 error : function(data) 
 {
  console.log('No data found');
}
});

// event category
$.ajax({
  url : "<?php echo base_url(); ?>pages/get_event_category",
  type : "POST",
  data : {'venue_address_id':venue_address},
  success : function(data) 
  {
    if(data!="No Data Available")
    {
     $("#ec").html(data);
   }
 },
 error : function(data) 
 {
  console.log('No data found');
}
});

}
});

// Venue change ajax close

// Deal change ajax open

function book_deal(deal_id)
{

 if(deal_id)
 {
  $("#promo_code_button").val('Apply'); 
  $('#promo_code_button').removeClass('promo_code_applying');
  $('#promo_code_button').addClass('select_deal_button');
  $("input[name=promo_code]").val('');
  $("input[name=promo_code]").attr('placeholder', 'Enter Promo Code');
  $('#promo_code_span').html('');

  $('.deal_selected').addClass('select_deal_button');  
  $('.deal_selected').removeClass('deal_selected');
  $('#select_'+deal_id).addClass('deal_selected');
  $('#select_'+deal_id).removeClass('select_deal_button');
  $('#select_'+deal_id).val('Selected');

  $.ajax({
    url : "<?php echo base_url(); ?>order/get_deal_info",
    type : "POST",
    data : 'deal_id='+deal_id,
    success : function(data) 
    {
      if(data!="No Data Available")
      {
        data = jQuery.parseJSON(data);

       // console.log(data);
       $('#party_size').attr('value', data[0]['min_people_allowed']);
       $('#party_size').attr('slider', data[0]['min_people_allowed']);
       $('#party_size').attr('min', data[0]['min_people_allowed']);
       $('#party_size').attr('max', data[0]['max_people_allowed']);
       $("#show_size").html(data[0]['min_people_allowed']);
       $('input[name=deal_slot_time]').attr('value', data[0]['deal_slot_time']);
       $('input[name=deal_end_date]').attr('value', data[0]['deal_end_date']);
       $('input[name=deal_id]').attr('value', deal_id);

       var deal_price = data[0]['deal_price']*data[0]['min_people_allowed'];
       $('input[name=deal_price_base]').attr('value', data[0]['deal_price']);
       $('input[name=deal_price]').attr('value', deal_price);

       $("#deal_price_span").html(deal_price);

       var total_tax_per = 0;
       $('.charge_tax').each(function() {
         total_tax_per += +$(this).val();
       });

       var total_tax = (total_tax_per/100)*deal_price;
       var deal_total = deal_price+total_tax;
       $("input[name=tax_price]").attr('value', total_tax);   
       $("input[name=tax_percentage]").val(total_tax_per);   
       $("input[name=deal_total_price]").val(deal_total);   
       $("#deal_total_span").html(deal_total);

       $("#promo_code_button").attr('disabled',false);
       $("input[name=promo_code]").attr('readonly',false);
       $("input[name='pay_amt']:not(:checked)").attr('disabled', false);  


       var pay_amt = $("input[name='pay_amt']:checked").val();
       if (pay_amt=='full') {
        $('#promo_code').show();

        $("input[name=amount_paying]").attr('value', deal_total);
        $("input[name=amount_remaining]").attr('value', '0');
        $("#amount_paying_span").html(deal_total);
        $("#amount_remaining_span").html(0);
        $("#pay_to_venue").hide();
      } 
      if (pay_amt=='part') {
        $('#promo_code').hide();

          var part_pay = (deal_total*0.15).toFixed(2); //Part Pay (15%) Percentage for TYP
          var remaining_pay = (deal_total*0.85).toFixed(2); // Remaining (85%) for venue 
          $("input[name=amount_paying]").attr('value', part_pay);
          $("input[name=amount_remaining]").attr('value', remaining_pay);
          $("#amount_paying_span").html(part_pay);
          $("#amount_remaining_span").html(remaining_pay);
          $("#pay_to_venue").show();

        }
      }
    },
    error : function(data) 
    {
      console.log('No data found');
    }
  });
}else{
  console.log('error');
}
}
// Deal change ajax close

// on change Part & Full Payment open
$('#party_size').on('change',function(){

  $("#promo_code_button").val('Apply'); 
  $('#promo_code_button').removeClass('promo_code_applying');
  $('#promo_code_button').addClass('select_deal_button');
  $("input[name=promo_code]").val('');
  $("input[name=promo_code]").attr('placeholder', 'Enter Promo Code');
  $('#promo_code_span').html('');

  $("#promo_code_button").attr('disabled',false);
  $("input[name=promo_code]").attr('readonly',false);
  $("input[name='pay_amt']:not(:checked)").attr('disabled', false);  

  var party_size = $(this).val();
  var deal_price_base = $("input[name=deal_price_base]").val();
  var total_tax_per = $("input[name=tax_percentage]").val();

  var deal_price = party_size*deal_price_base;
  $('input[name=deal_price]').attr('value', deal_price);
  $("#deal_price_span").html(deal_price);

  var total_tax = deal_price*(total_tax_per/100);
  $("input[name=tax_price]").attr('value', total_tax.toFixed(2));  

  var deal_total = deal_price+total_tax;
  $("input[name=deal_total_price]").val(deal_total);
  $("#deal_total_span").html(deal_total);

  var pay_amt = $("input[name='pay_amt']:checked").val();
  if (pay_amt=='full') {
    $('#promo_code').show();

    $("input[name=amount_paying]").attr('value', deal_total);
    $("input[name=amount_remaining]").attr('value', '0');
    $("#amount_paying_span").html(deal_total);
    $("#amount_remaining_span").html(0);
    $("#pay_to_venue").hide();
  } 
  if (pay_amt=='part') {
    $('#promo_code').hide();

    var part_pay = (deal_total*0.15).toFixed(2); //Part Pay (15%) Percentage for TYP
    var remaining_pay = (deal_total*0.85).toFixed(2); // Remaining (85%) for venue 
    $("input[name=amount_paying]").attr('value', part_pay);
    $("input[name=amount_remaining]").attr('value', remaining_pay);
    $("#amount_paying_span").html(part_pay);
    $("#amount_remaining_span").html(remaining_pay);
    $("#pay_to_venue").show();
  }

});
// on change Part & Full Payment close

// on change Party Size Payment open
$('.radio').on('change',function(){
  var pay_amt = $("input[name='pay_amt']:checked").val();
  var deal_total = $("input[name=deal_total_price]").val();
  if (pay_amt=='full') {
    $('#promo_code').show();

    $("input[name=amount_paying]").attr('value', deal_total);
    $("input[name=amount_remaining]").attr('value', '0');
    $("#amount_paying_span").html(deal_total);
    $("#amount_remaining_span").html(0);
    $("#pay_to_venue").hide();
  } 

  if (pay_amt=='part') {
    $('#promo_code').hide();

    var part_pay = (deal_total*0.15).toFixed(2); //Part Pay (15%) Percentage for TYP
    var remaining_pay = (deal_total*0.85).toFixed(2); // Remaining (85%) for venue 
    $("input[name=amount_paying]").attr('value', part_pay);
    $("input[name=amount_remaining]").attr('value', remaining_pay);
    $("#amount_paying_span").html(part_pay);
    $("#amount_remaining_span").html(remaining_pay);
    $("#pay_to_venue").show();
  }

});
// on change Part & Full Payment close

// Party size show open
$(document).on('input', '#party_size', function() {
  $('#show_size').html( $(this).val() );
});
// Party size show close

// Applting & checking promo code open
$('#promo_code_button').on('click',function(){
  var promo_code = $("input[name=promo_code]").val();
  var pay_amt = $("input[name='pay_amt']:checked").val();
  var deal_price = $('input[name=deal_price]').val();
  var deal_book_date = $('input[name=deal_book_date]').val();
  var deal_book_time = $('input[name=deal_book_time]').val();

  // button change open
  $('#promo_code_button').removeClass('select_deal_button');
  $('#promo_code_button').addClass('promo_code_applying');
  $("#promo_code_button").val('Applying'); 
  //button change close

  if(promo_code && deal_price && deal_book_date && deal_book_time && pay_amt=='full')
  {
    $.ajax({
      url : "<?php echo base_url(); ?>pages/get_promo_code",
      type : "POST",
      data : {'promocode':promo_code,'pay_amt':pay_amt,'deal_price':deal_price,'deal_book_date':deal_book_date,'deal_book_time':deal_book_time},
      success : function(data) 
      {
        if(data!="No Data Available")
        {
          data = jQuery.parseJSON(data);

          // console.log(data['applied']);
          $('#promo_code_span').html(data['applied']);
          $("input[name=offer_amount]").attr('value', data['offer_per']);
          $("input[name=after_offer]").attr('value', data['after_offer']);

          var total_tax_per = $("input[name=tax_percentage]").val();
          var tax_price = (total_tax_per/100)*data['after_offer'];
          var deal_total = (tax_price+data['after_offer']);
          var deal_total = deal_total.toFixed(2);
          $("input[name=deal_total_price]").val(deal_total);   
          $("input[name=tax_price]").val(tax_price);   
          $("input[name=amount_paying]").val(deal_total);
          $("input[name=amount_remaining]").val('0');
          $("#deal_total_span").html(deal_total);

          $("#amount_paying_span").html(deal_total);
          $("#amount_remaining_span").html('0');
          $("#pay_to_venue").hide();


          $("#promo_code_button").val('Applied'); 
          $('#promo_code_button').removeClass('promo_code_applying');
          $('#promo_code_button').addClass('select_deal_button');
          $("#promo_code_button").attr('disabled',true);
          $("input[name=promo_code]").attr('readonly',true);
          $("input[name='pay_amt']:not(:checked)").attr('disabled', true);  
        }
        else {
          $("#promo_code_button").val('Apply'); 
          $('#promo_code_span').html('Invalid promocode');
          $('#promo_code_button').removeClass('promo_code_applying');
          $('#promo_code_button').addClass('select_deal_button');
        }
      },
      error : function(data) 
      {
        $("#promo_code_button").val('Apply'); 
        $('#promo_code_span').html('Invalid promocode');
        $('#promo_code_button').removeClass('promo_code_applying');
        $('#promo_code_button').addClass('select_deal_button');
      }
    });

  }else{
    $('#promo_code_span').html('Please enter fields first.');
    $("#promo_code_button").val('Apply'); 
    $('#promo_code_button').removeClass('promo_code_applying');
    $('#promo_code_button').addClass('select_deal_button');
  }
});
// Applting & checking promo code close

</script>
