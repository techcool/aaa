<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://authoritypartners.com/
 * @since      1.0.0
 *
 * @package    Rate_Calculator
 * @subpackage Rate_Calculator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rate_Calculator
 * @subpackage Rate_Calculator/admin
 * @author     Authority Partners <hello@authoritypartners.com>
 */
class Rate_Calculator_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}    
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rate_Calculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rate_Calculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rate-calculator-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'rc-style', plugin_dir_url( __FILE__ ) . 'css/rcstyle.css', array(), $this->version, 'all'  );
	    wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), $this->version, 'all' );
	    wp_enqueue_style( 'data-table', plugin_dir_url( __FILE__ ) . 'css/dataTables.bootstrap4.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rate_Calculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rate_Calculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rate-calculator-admin.js', array( 'jquery' ), $this->version, false );		
	    wp_enqueue_script( 'ajax-script', plugin_dir_url( __FILE__ ) . 'js/rcscript.js', array('jquery') );
	    wp_enqueue_script( 'data-table', plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array('jquery') );
	    wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/dataTables.bootstrap4.min.js', array('jquery') );
	    wp_localize_script( 'ajax-script', 'rc_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}
	/* excle upload by admin */
    function rc_do_read () {
        global $wpdb;
        if(empty($_FILES)){
            echo '<div class="upload-erre"><p style="color: #red;">Please upload valid file.</p></div>';
        }else{
        foreach ($_FILES as $file) :
            if($file['error'] == UPLOAD_ERR_NO_FILE) :
                continue;
            endif;

        $valid_ext = array( 'xls' , 'xlsx');
        $extension_upload = strtolower(  substr(  strrchr($file['name'], '.')  ,1)  );
        if ( in_array($extension_upload,$valid_ext) ) :
            $name_upload = uniqid() . $file['name'];
            $url_insert = trailingslashit( plugin_dir_path( dirname( __FILE__ ) ) ) . 'uploads';
            wp_mkdir_p($url_insert);
            $name_insert = trailingslashit($url_insert) . $name_upload;
            $action = move_uploaded_file($file['tmp_name'],$name_insert);
            echo $msg = '<div class="upload-msg"><p>Uploaded Successfully.</p></div>';
            /************************* xls read ************************/
            require_once(plugin_dir_path( dirname( __FILE__ ) )  ."/vendor/autoload.php"); 
            $inputFileType = 'Xls';
            $inputFileName = plugin_dir_path( dirname( __FILE__ ) ) .'/uploads/'.$name_upload;
            //$sheetname = '30 pages';
            /**  Create a new Reader of the type defined in $inputFileType  **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            /**  Load only the rows and columns that match our filter to Spreadsheet  **/
            $spreadsheet = $reader->load($inputFileName);
            $worksheet = $spreadsheet->getActiveSheet(1);
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $key=>$cell) {
                    if($key == 'B'){
                        $cells[] = $cell->getCalculatedValue(); # this is dynamically got, but no value in showing how
                    }
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }
            
            $allData = array();
            ?>
            <div class="be-confirm"><b>Please check your uploaed excl file. If is it okay then save.</b><button value="<?=$name_upload?>" id="be-confirm-save">Save</button><button value="delete" id="be-confirm-delete">Cancel</button></div>
            <table id="allRcData" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>State</th>
                    <th>County</th>
                    <th>Fee</th>
                </tr>
                </thead>
                <tbody>
            <?php 
            $nulClass = '';
            foreach ($rows as $key => $each) {
                if($key == 0) continue;
                $stateCounty = explode("-",$each[0]);
                $state = $stateCounty[0];
                $county = $stateCounty[1];
                $fee = $each[1];
                $allData[$key]['state'] = $state;
                $allData[$key]['county'] = $county;
                $allData[$key]['fee'] = $fee;
                if(is_numeric($fee) == ''){
                    $nulClass = 'not-number';
                    $state = "#ERROR $state";
                }else{
                    $nulClass = '';
                }
                ?>
                <tr id="<?=$nulClass?>">
                    <td><?=$state?></td>
                    <td><?=$county?></td>
                    <td><?=$fee?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>State</th>
                    <th>County</th>
                    <th>Fee</th>
                </tr>
            </tfoot>
            </table>
            <?php
        else :
            echo $msg = '<div class="upload-erre"><p >Please upload valid file.</p></div></p>';
        endif;
    endforeach;
        }
    //echo $msg;
    die();
    }
    /* excle data save */
    function rc_do_save () {
            global $wpdb;       
            /************************* xls read ************************/
            require_once(plugin_dir_path( dirname( __FILE__ ) ) ."vendor/autoload.php"); 
            $inputFileType = 'Xls';
            $inputFileName = plugin_dir_path( dirname( __FILE__ ) ) .'uploads/'.$_POST['fileName'];
            //$sheetname = '30 pages';
            /**  Create a new Reader of the type defined in $inputFileType  **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            /**  Load only the rows and columns that match our filter to Spreadsheet  **/
            $spreadsheet = $reader->load($inputFileName);
            $worksheet = $spreadsheet->getActiveSheet(1);
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $key=>$cell) {
                    if($key == 'B'){
                        $cells[] = $cell->getCalculatedValue(); # this is dynamically got, but no value in showing how
                    }
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }
            
            $allData = array();
            
            foreach ($rows as $key => $each) {
                if($key == 0) continue;
                $stateCounty = explode("-",$each[0]);
                $state = $stateCounty[0];
                $county = $stateCounty[1];
                $fee = $each[1];
                $allData[$key]['state'] = $state;
                $allData[$key]['county'] = $county;
                $allData[$key]['fee'] = $fee;
                
                /*For state table*/
                $stateTable = $wpdb->prefix.'rate_calculator_state';
                $results = $wpdb->get_results( "SELECT * FROM ".$stateTable." where name = '".$state."'");
                if(empty($results)){
                    $data = array('id' => '', 'name' => $state);
                    $format = array('%d','%s');
                    $wpdb->insert($stateTable,$data,$format);
                    $stateID = $wpdb->insert_id;
                }else{
                    $results = $wpdb->get_results( "SELECT * FROM ".$stateTable." where name = '".$state."'");
                    $stateID =  $results[0]->id;
                }
                
                /*For county table*/
                if(is_numeric($fee) == 1){
	                $countyTable = $wpdb->prefix.'rate_calculator_county';
                    $feeTable = $wpdb->prefix.'rate_calculator_recording_fee';
                    $checkIfExists = $wpdb->get_var("SELECT ID FROM $countyTable WHERE name = '$county' AND stateid = '$stateID'");
                    if ($checkIfExists == NULL) {
                        $data = array('id' => '', 'stateid' => $stateID,'name' => $county);
                        $format = array('%d','%d','%s');
                        $wpdb->insert($countyTable,$data,$format);
                        $countyID = $wpdb->insert_id;
                        /*For fee table*/
                        $data = array('id' => '','countyid' => $countyID, 'value' => $fee);
                        $format = array('%d','%d','%d');
                        $wpdb->insert($feeTable,$data,$format);
                    } else {
                        $countyID = $checkIfExists;
                        $data = array('value' => $fee);
                        $where = array('countyid' => $countyID);
                        $format = array('%d');
                        $wpdb->update($feeTable,$data,$where,$format);
                    }
	            }
            }            
                /*status*/
                $statusTable = $wpdb->prefix.'rate_calculator_status';
                $data = array('id' => '','status' => 1);
                $format = array('%d','%d');
                $wpdb->insert($statusTable,$data,$format);
            $msg = '<div class="upload-msg"><p style="color: #4aa13a;">Successfully Saved. Please stay. This page will be reloaded after a few moments</p></div>';            
        echo $msg;
        die();
        }
    
    public function add_plugin_admin_menu() {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        /*add_options_page( 'Rate Calculator', 'Rate Calculator', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );*/
        add_menu_page(
                    __( 'Rate Calculator', 'textdomain' ),
                    __( 'Rate Calculator','textdomain' ),
                    'administrator',
                    $this->plugin_name,
                    array($this, 'display_plugin_setup_page'),
                    ''
        );
                
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        // $settings_link = array(
        //     '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        // );
        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page12=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );

        return array_merge(  $settings_link, $links );

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {
        include_once( 'partials/rate-calculator-admin-display.php' );
    }

    public function validate($input) {
        // All checkboxes inputs
        $valid = array();

        //RateCalculator
        $valid['disablewidget'] = (isset($input['disablewidget']) && !empty($input['disablewidget'])) ? 1 : 0;
        $valid['notaryfee'] = (isset($input['notaryfee']) && !empty($input['notaryfee']) && is_numeric($input['notaryfee'])) ? $input['notaryfee'] : 150;
        $valid['affordable_housing_act'] = (isset($input['affordable_housing_act']) && !empty($input['affordable_housing_act']) && is_numeric($input['affordable_housing_act'])) ? $input['affordable_housing_act'] : 225;
        $valid['place_order_link'] = $input['place_order_link'];
        return $valid;
    }

    public function options_update() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
        $role = get_role( 'editor' );
        $role->add_cap('manage_options');  
    }


}
