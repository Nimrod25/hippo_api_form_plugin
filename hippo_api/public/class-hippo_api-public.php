<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/nimesh-sangada-125420160/
 * @since      1.0.0
 *
 * @package    Hippo_api
 * @subpackage Hippo_api/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Hippo_api
 * @subpackage Hippo_api/public
 * @author     Nimesh <nimeshsangada007@gmail.com>
 */
class Hippo_api_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hippo_api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hippo_api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style("bootstrap_css",'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', array(), $this->version, 'all' );

		wp_enqueue_style("fontawesome",'https://pro.fontawesome.com/releases/v5.10.0/css/all.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hippo_api-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hippo_api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hippo_api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script("jquery_js", 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), $this->version, true );
		wp_enqueue_script("bootstrap_js", 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js', array( 'jquery' ), $this->version, true);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hippo_api-public.js', array( 'jquery' ), $this->version, true );

		wp_localize_script( $this->plugin_name, 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}

	public  function hipp_api_call()
	{ 
	     foreach($_POST as $key => $value){
	        $$key = $value;      
	    }
	    
	    $address = urlencode($address);
	    $city = urlencode($city);
	    $email = urlencode($email);
	    
	    $date=date_create($dob);
	    $dob = date_format($date,"mdY");
	    
	 	$param = "&street=$address&city=$city&state=$state&zip=$zip&first_name=$fname&last_name=$lname&email=$email&phone=$phone&date_of_birth=$dob";
	    
        $hurl = "";
        $htoken ="";
        if (get_option('hippo_api_url',false) ){
            $hurl = get_option('hippo_api_url');
        }
        if (get_option('hippo_api_token',false) ){
            $htoken = get_option('hippo_api_token');
        }
        
        
        
        $token = $htoken;
        $url = $hurl;
        $api_url = $url.'?auth_token='.$token.$param;

	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	      CURLOPT_URL => $api_url,
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 30,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => "GET",
	      CURLOPT_HTTPHEADER => array(
	        "cache-control: no-cache",
	      ),
	    ));
	    
	    $response = curl_exec($curl);
	    $err = curl_error($curl);
	    
	    curl_close($curl);
	    
	    if ($err) {
	      echo "cURL Error #:" . $err;
	    } else {
	      echo $response;
	    }
	     
	    die(0);
	 }
	 
	 public function register_hippo_form_shortcodes() {
      add_shortcode( 'hippo_form', array( $this, 'hippo_form_callback') );
    }
    
    public function hippo_form_callback(){
        ob_start();
	?> 
	<div class="container">
<form name="hippo_form" id="hippo_form" method="post">
  <!-- 2 column grid layout with text inputs for the first and last names -->
  <div class="row mb-4">
    <div class="col">
      <div class="form-outline">
       <label class="form-label" for="fname">First name<span class="astrik">*</span></label>
        <input type="text" id="fname" required name="fname" class="form-control" />
       
      </div>
    </div>
    <div class="col">
      <div class="form-outline">
        <label class="form-label" for="mname">Middle name</label>
        <input type="text" id="mname" name="mname" class="form-control" />
      
      </div>
    </div>
        <div class="col">
      <div class="form-outline">
        <label class="form-label" for="lname">Last name <span class="astrik">*</span></label>
        <input type="text" id="lname" required name="lname" class="form-control" />
      
      </div>
    </div>
  </div>
   <div class="row mb-4">
    <div class="col col-lg-8">
      <div class="form-outline">
       <label class="form-label" for="address">Street Address <span class="astrik">*</span></label>
        <input type="text" id="address" required name="address" class="form-control" />
      </div>
    </div>
    <div class="col col-lg-4">
      <div class="form-outline">
       <label class="form-label" for="unit">UNIT#</label>
        <input type="text" id="unit" name="unit" class="form-control" />
      </div>
    </div>
   </div>
    <div class="row mb-4">
        <div class="col col-lg-4">
          <div class="form-outline">
           <label class="form-label" for="city">CITY <span class="astrik">*</span></label>
            <input type="text" id="city" required name="city" class="form-control" />
          </div>
        </div>
        <div class="col col-lg-4">
          <div class="form-outline">
           <label class="form-label" for="state">State <span class="astrik">*</span></label>
            <input type="text" id="state" required name="state" class="form-control" />
          </div>
        </div>
        <div class="col col-lg-4">
          <div class="form-outline">
           <label class="form-label" for="zip">Zip code <span class="astrik">*</span></label>
            <input type="text" id="zip" required name="zip" class="form-control" />
         </div>
        </div>
   </div>
    <div class="row mb-4">
        <div class="col col-lg-12">
          <div class="form-outline">
           <label class="form-label" for="dob">Date Of Birth <span class="astrik">*</span></label>
            <input type="date" id="dob" required name="dob" class="form-control" />
          </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col col-lg-6">
          <div class="form-outline">
           <label class="form-label" for="phone">Phone Number <span class="astrik">*</span></label>
            <input type="text" id="phone" required name="phone" class="form-control" />
          </div>
        </div>
        <div class="col col-lg-6">
          <div class="form-outline">
            <label class="form-label" for="email">Email address <span class="astrik">*</span></label>
            <input type="email" id="email" required name="email" class="form-control" />
          </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <label class="form-label" for="house">IS THIS A HOUSE,CONDO OR HO5?</label>
        <div class="col col-lg-4">
          <div class="form-outline radio_wrapper">
            <div class="row mb-4">
                <div class="col col-lg-3">
                    <i class="fas fa-home"></i>
                </div>
                <div class="col col-lg-9">
                    <label class="form-label" for="house">House</label>
                    <p>This may be a single-family home,townhose or duplex you own and live in</p>
                </div>
            </div>
            <input type="radio" id="house" name="htype" value="house" class="form-control" />
          </div>
        </div>
        <div class="col col-lg-4">
          <div class="form-outline  radio_wrapper">
          <div class="row mb-4">
                <div class="col col-lg-3">
                  <i class="fas fa-building"></i>
                </div>
                <div class="col col-lg-9">
                    <label class="form-label" for="condo">Condo</label>
                    <p>This is likely a multi-family building or complex in which you own a unit</p>
                </div>
            </div>
            <input type="radio" id="condo"  name="htype" value="condo" class="form-control" />
          </div>
        </div>
        <div class="col col-lg-4">
          <div class="form-outline radio_wrapper">
          <div class="row mb-4">
                <div class="col col-lg-3">
                    <i class="fas fa-building"></i>
                </div>
                <div class="col col-lg-9">
            <label class="form-label" for="ho5">HO5</label>
              <p>The HO5 is an open perils insurance policy for a single family home or duplex</p>
            </div>
            </div>
            <input type="radio" id="ho5"  name="htype" value="ho5" class="form-control" />
          </div>
        </div>
    </div>
 
    <input type="hidden" name="action" value="hippo_api">
   <!-- Submit button -->
  <input type="submit" class="btn btn-primary btn-block mb-4" value="SUBMIT">

</form>
</div>
	<?php
	return ob_get_clean();
    
    }
	 
	 
}
