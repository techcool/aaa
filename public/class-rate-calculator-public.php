<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://authoritypartners.com/
 * @since      1.0.0
 *
 * @package    Rate_Calculator
 * @subpackage Rate_Calculator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rate_Calculator
 * @subpackage Rate_Calculator/public
 * @author     Authority Partners <hello@authoritypartners.com>
 */
class Rate_Calculator_Public {

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
        $this->wp_rc_options = get_option($this->plugin_name);

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
         * defined in Rate_Calculator_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Rate_Calculator_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rate-calculator-public.css', array(), $this->version, 'all' );

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
         * defined in Rate_Calculator_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Rate_Calculator_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rate-calculator-public.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'jspdf', plugin_dir_url( __FILE__ ) . 'js/pdf/dist/jspdf.debug.js', array( ), $this->version, false );
        wp_enqueue_script( 'basicpdf', plugin_dir_url( __FILE__ ) . 'js/pdf/basic.js', array( ), $this->version, false );
        wp_localize_script('basicpdf', 'basicpdf', array(
                     'pluginsUrl' => plugins_url(),
                                            ));                           
    }

    function calculate_rates($amount, $type, $state){

        $amount = (int) $amount;
        $result = new stdClass();
        if ($type == "Refinance"){

            $result->lender = 315;
            $result->escrow = 350;

            if($state == 'CA')
            {
                if($amount > 300000){
                    $result->lender = 395;
                }


                if($amount > 600000){
                    $result->lender = 495;
                }


                if($amount > 800000){
                    $result->lender = 595;
                }


                if($amount > 1000000){
                    $result->lender = 700;
                    $result->escrow = 450;
                }


                if($amount > 1300000){
                    $result->lender = 850;
                }


                if($amount > 1600000){
                    $result->lender = 1000;
                }


                if($amount > 1800000){
                    $result->lender = 1150;
                }


                if($amount > 2000000){
                    $result->lender = 1750;
                    $result->escrow = 550;
                }


                if($amount > 3000000){
                    $result->lender = 2350;
                }

                if($amount > 4000000){
                    $result->lender = 2950;
                }

                if($amount > 5000000){
                    $result->lender = 2950;
                    $amount = $amount  - 5000000;
                    $result->lender += (intdiv($amount, 1000000) + 1)*300;
                }
            }else if($state == 'AZ')
            {
                $result->lender = 350;
                if($amount > 250000){
                    $result->lender = 450;
                }

                if($amount > 500000){
                    $result->lender = 550;
                }

                if($amount > 750000){
                    $result->lender = 650;
                }

                if($amount > 1000000){
                    $result->lender = 750;
                }

                if($amount > 1500000){
                    $result->lender = 880;
                }

                if($amount > 2000000){
                    $result->lender = 880;
                    $amount = $amount  - 2000000;
                    $result->lender += (intdiv($amount, 10000) + 1)*4;
                }
            }
            else
            {
                $result->lender = 420;
                if($amount > 250000){
                    $result->lender = 540;
                }

                if($amount > 500000){
                    $result->lender = 660;
                }

                if($amount > 750000){
                    $result->lender = 780;
                }

                if($amount > 1000000){
                    $result->lender = 900;
                }

                if($amount > 1500000){
                    $result->lender = 960;
                }

                if($amount > 2000000){
                    $result->lender = 960;
                    $amount = $amount  - 2000000;
                    $result->lender += (intdiv($amount, 10000) + 1)*4;
                }


            }

        } else{
            $result->buyer = new stdClass();
            $result->seller = new stdClass();

            $result->buyer->title = 275;
            $result->seller->title = 600;
            $result->seller->escrow = 700;

            if($amount > 100000){
                $result->buyer->title = 350;
                $result->seller->title = 850;
                $result->seller->escrow = 875;
            }

            if($amount > 200000){
                $result->buyer->title = 425;
                $result->seller->title = 1100;
                $result->seller->escrow = 1025;
            }

            if($amount > 300000){
                $result->buyer->title = 500;
                $result->seller->title = 1275;
                $result->seller->escrow = 1155;
            }

            if($amount > 400000){
                $result->buyer->title = 575;
                $result->seller->title = 1475;
                $result->seller->escrow = 1250;
            }

            if($amount > 500000){
                $result->buyer->title = 650;
                $result->seller->title = 1675;
                $result->seller->escrow = 1365;
            }

            if($amount > 600000){
                $result->buyer->title = 725;
                $result->seller->title = 1875;
                $result->seller->escrow = 1465;
            }

            if($amount > 700000){
                $result->buyer->title = 800;
                $result->seller->title = 2075;
                $result->seller->escrow = 1565;
            }

            if($amount > 800000){
                $result->buyer->title = 875;
                $result->seller->title = 2275;
                $result->seller->escrow = 1665;
            }

            if($amount > 900000){
                $result->buyer->title = 950;
                $result->seller->title = 2385;
                $result->seller->escrow = 1665;
            }

            if($amount > 1000000){
                $result->buyer->title = 1350;
                $result->seller->title = 2600;
                $result->seller->escrow = 1900;
            }

            if($amount > 1250000){
                $result->buyer->title = 1550;
                $result->seller->title = 2900;
                $result->seller->escrow = 2130;
            }

            if($amount > 1500000){
                $result->buyer->title = 1650;
                $result->seller->title = 3250;
                $result->seller->escrow = 2130;
            }

            if($amount > 1750000){
                $result->buyer->title = 1750;
                $result->seller->title = 3575;
                $result->seller->escrow = 2130;
            }

            if($amount > 2000000){
                $result->buyer->title = 1850;
                $result->seller->title = 3800;
                $result->seller->escrow = 2130 + (intdiv(($amount - 2000000), 50000) + 1)*50;
            }

            if($amount > 2250000){
                $result->buyer->title = 1950;
                $result->seller->title = 4000;
            }

            if($amount > 2500000){
                $result->buyer->title = 2050;
                $result->seller->title = 4150;
            }

            if($amount > 2750000){
                $result->buyer->title = 2150;
                $result->seller->title = 4300;
            }

            if($amount > 3000000){
                $result->buyer->title = 2250;
                $result->seller->title = 4450;
            }

            if($amount > 3250000){
                $result->buyer->title = 2350;
                $result->seller->title = 4600;
            }

            if($amount > 3500000){
                $result->buyer->title = 2450;
                $result->seller->title = 4750;
            }

            if($amount > 3750000){
                $result->buyer->title = 2550;
                $result->seller->title = 4900;
            }

            if($amount > 4000000){
                $result->buyer->title = 2625;
                $result->seller->title = 5350;
            }

            if($amount > 4500000){
                $result->buyer->title = 2925;
                $result->seller->title = 5850;
            }

            if($amount > 5000000){
                $result->buyer->title = 3175;
                $result->seller->title = 6350;
            }

            if($amount > 5500000){
                $result->buyer->title = 3425;
                $result->seller->title = 6850;
            }

            if($amount > 6000000){
                $result->buyer->title = 3675;
                $result->seller->title = 7350;
            }

            if($amount > 6500000){
                $result->buyer->title = 3925;
                $result->seller->title = 7850;
            }

            if($amount > 7000000){
                $result->buyer->title = 4175;
                $result->seller->title = 8350;
            }

            if($amount > 7500000){
                $result->buyer->title = 4425;
                $result->seller->title = 8850;
            }

            if($amount > 8000000){
                $result->buyer->title = 4675;
                $result->seller->title = 9350;
            }

            if($amount > 8500000){
                $result->buyer->title = 4925;
                $result->seller->title = 9850;
            }

            if($amount > 9000000){
                $result->buyer->title = 5175;
                $result->seller->title = 10350;
            }

            if($amount > 9500000){
                $result->buyer->title = 5425;
                $result->seller->title = 10850;
            }
        }

        return $result;
    }

    function get_widgetsubmitquotes_ajax(){
        check_ajax_referer( "rc-widget-quotes" );
        $options = get_option($this->plugin_name);
        $quotes = $_POST[ 'quotes' ];
        if( $quotes ):
            global $wpdb;
            $fileName = uniqid(rand(), true) ;
            $loanwithcomma = number_format($quotes['loan']);
            $saleswithcomma = number_format($quotes['sales']);
            $quotes['loan'] = str_replace(',', '', $quotes['loan']);
            $quotes['sales'] = str_replace(',', '', $quotes['sales']);
            $amount = $quotes['sales'];
            if($quotes['transaction'] == "Refinance"){
                $quotes['sales'] = "";
                $amount =  $quotes['loan'];
            }
            $table_name = $wpdb->prefix . "rate_calculator";
            $wpdb->insert($table_name, array('loan_amount' => $quotes['loan'], 'sales_amount' => $quotes['sales'], 'transaction' => $quotes['transaction'], 'p_address' => $quotes['state'], 'services' => $quotes['services']));
            
            $total = 0;

            $stateTable = $wpdb->prefix.'rate_calculator_state';
            $stateResults = $wpdb->get_results( "SELECT * FROM ".$stateTable." where id = '".$quotes['state']."'");
            $countyTable = $wpdb->prefix.'rate_calculator_county';

            $countyResults = $wpdb->get_results( "SELECT * FROM ".$countyTable." where id = ".$quotes['county']);
            //print_r($CountyResults);
            $feeTable = $wpdb->prefix.'rate_calculator_recording_fee';
            $feeResults = $wpdb->get_results( "SELECT * FROM ".$feeTable." where countyid = ".$quotes['county']);

            $result = $this->calculate_rates($amount, $quotes['transaction'], $stateResults[0]->name);
            ?>
            <div class="rc-widget-popup-result-inner">
                <div class="row rc-quoteparam">
                    <div class="rc-col-12">
                        <label>State:</label><?php echo $stateResults[0]->name ?>
                        <label>County:</label><?php echo $countyResults[0]->name ?>
                        <label>Transaction type:</label><?php echo $quotes['transaction'] ?>
                        <label>Loan amount:</label>$<?php echo $loanwithcomma; ?>
                        <?php if(($quotes['transaction'] == "Purchase")){
                            echo "<label>Sales price:</label>$$saleswithcomma";
                        } ?>
                        <label>Services:</label><?php echo $quotes['services'] ?>
                    </div>
                </div>
                <?php if($quotes['transaction'] == "Refinance"):
                    if($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Title'): ?>
                        <div class="row">
                            <div class="rc-col-12">
                                <table class="rc-table">
                                    <tbody>
                                    <tr class="rc-table-head">
                                        <td><b>Title Charges</b></td>
                                        <td><b></b></td>
                                        <td><b>Borrower</b></td>
                                    </tr>
                                    <tr>
                                        <td>Lender's Title Insurance*</td>
                                        <td></td>
                                        <td><span class="lenderP">$<?php echo number_format($result->lender); $total +=$result->lender;  ?></td></span>
                                    </tr>
                                    <tr>
                            <td colspan="3" class="other-services">
                                <?php if($quotes['services'] == 'Title'){ ?>
                                            *Any applicable endorsement charges are not included in this quote.<br>
                                <?php } ?>
                            </td>
                        </tr>                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif;
                    if($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Escrow'): ?>

                        <div class="row">
                            <div class="rc-col-12">
                                <table class="rc-table">
                                    <tbody>
                                    <tr class="rc-table-head">
                                        <td><b>Settlement/Escrow</b></td>
                                        <td><b></b></td>
                                        <td><b>Borrower</b></td>
                                    </tr>
                                    <tr>
                                        <td>Closing Fee</td>
                                        <td></td>
                                        <td><span class="closeP">$<?php echo number_format($result->escrow); $total +=$result->escrow;?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Notary Fee</td>
                                        <td></td>
                                        <td><span class="notaryP">$<?=number_format($options['notaryfee'])?></span></td>
                                        <?php $total +=$options['notaryfee'];?>
                                    </tr>
                                    <tr>
                                        <td>Recording Fee**</td>
                                        <td></td>
                                        <td><span class="recordingP">$<?php echo $feeResults[0]->value ?></span></td>
                                        <?php $total +=$feeResults[0]->value;?>
                                    </tr>
                                    <?php if($stateResults[0]->name == 'CA' || $stateResults[0]->name == 'ca'){
                                            $total +=$options['affordable_housing_act'];
                                            ?>
                                            <tr>
                                                <td>Affordable Housing Act</td>
                                                <td></td>
                                                <td><span class="housingP">$<?=number_format($options['affordable_housing_act'])?></span></td>
                                            </tr>
                                    <?php } ?>

                                    <?php if(strtoupper($stateResults[0]->name) == 'CA' || $stateResults[0]->name == 'ca'){
                                            $total +=$options['affordable_housing_act'];
                                            ?>
                                            <tr>
                                                <td>Affordable Housing Act</td>
                                                <td></td>
                                                <td><span class="housingP">$<?=number_format($options['affordable_housing_act'])?></span></td>
                                            </tr>
                                    <?php } ?>

                                    <tr>
                                        <td colspan="3" class="other-services">
                                            <?php if($quotes['services'] == 'Title and Escrow'){ ?>
                                            *Any applicable endorsement charges are not included in this quote.<br>
                                            **Charges can vary based on # of pages and document types.
                                            <?php } if($quotes['services'] == 'Escrow'){ ?>
                                            **Charges can vary based on # of pages and document types.
                                        <?php } ?>
                                    </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="rc-col-12">
                            <table class="rc-table">
                                <tbody>
                                <tr class="rc-table-footer">
                                    <td><b>Total</b></td>
                                    <td><b></b></td>
                                    <?php $rTotal = number_format($total);?>
                                    <td><b><span class="totalP">$<?php echo number_format($total) ?></b></span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php endif;
                if(($quotes['transaction'] == "Purchase")):
                    if($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Title'): ?>
                        <div class="row">
                            <div class="rc-col-12">
                                <table class="rc-table">
                                    <tbody>
                                    <tr class="rc-table-head">
                                        <td><b>Title Charges</b></td>
                                        <td><b>Buyer</b></td>
                                        <td><b>Seller</b></td>
                                    </tr>
                                    <tr>
                                        <td>Owner's Title Insurance</td>
                                        <td></td>
                                        <td><span class="ownerP">$<?php echo number_format($result->seller->title); $total +=$result->seller->title;  ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Lender's Title Insurance*</td>
                                        <td><span class="lenderP">$<?php echo number_format($result->buyer->title) ?></span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="other-services">
                                            <?php if($quotes['services'] == 'Title'){ ?>
                                            *Any applicable endorsement charges are not included in this quote.<br>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif;
                    if($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Escrow'): ?>

                        <div class="row">
                            <div class="rc-col-12">
                                <table class="rc-table">
                                    <tbody>
                                    <tr class="rc-table-head">
                                        <td><b>Settlement/Escrow</b></td>
                                        <td><b>Buyer</b></td>
                                        <td><b>Seller</b></td>
                                    </tr>
                                    <tr>
                                        <td>Closing Fee</td>
                                        <td></td>
                                        <td><span class="closeP">$<?php echo number_format($result->seller->escrow); $total +=$result->seller->escrow; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Notary Fee</td>
                                        <td></td>
                                        <td><span class="notaryP">$<?=number_format($options['notaryfee'])?></span></td>
                                        <?php $total +=$options['notaryfee'];?>
                                    </tr>
                                    <tr>
                                        <td>Recording Fee**</td>
                                        <td></td>
                                        <td><span class="recordingP">$<?php echo $feeResults[0]->value ?></span></td>
                                        <?php $total +=$feeResults[0]->value;?>
                                    </tr>
                                    <?php if($stateResults[0]->name == 'CA' || $stateResults[0]->name == 'ca'){
                                            $total +=$options['affordable_housing_act'];
                                    ?>
                                            <tr>
                                                <td>Affordable Housing Act</td>
                                                <td></td>
                                                <td><span class="housingP">$<?=number_format($options['affordable_housing_act'])?></span></td>
                                            </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3" class="other-services">
                                            <?php if($quotes['services'] == 'Title and Escrow'){ ?>
                                            *Any applicable endorsement charges are not included in this quote.<br>
                                            **Charges can vary based on # of pages and document types.
                                            <?php } if($quotes['services'] == 'Escrow'){ ?>
                                                **Charges can vary based on # of pages and document types.
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="rc-col-12">
                            <table class="rc-table">
                                <tbody>
                                <tr class="rc-table-footer">
                                    <td><b>Total</b></td>
                                    <td><b>$<?php echo ($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Title') ? number_format($result->buyer->title): 0 ?></b></td>
                                    <td><b><span class="totalP">$<?php echo number_format($total) ?></b></span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row rc-widget-popup-result-footer">
                <div class="rc-col-12">
                    <button type="button">
                        <a class="rate-calculator-submit-text" href="javascript:demoTwoPageDocument()">Download</a>
                    </button>
                    <button id="rc-widget-submit" type="button" class="btn btn-primary btn-custom" style="width: auto">
                        <span class="rc-widget-submit-text"><a href="<?=$options['place_order_link']?>" target="_blank">Place Order</a></span>
                    </button>
                </div>
            </div>
        <?php //endif;
        
        endif;
        die();
    }

    function get_submitquotes_ajax() {
        check_ajax_referer( "rc-quotes" );
        $options = get_option($this->plugin_name);
        $quotes = $_POST[ 'quotes' ];
        if( $quotes ):
            global $wpdb;
            $fileName = uniqid(rand(), true) ;
            $loanwithcomma = number_format($quotes['loan']);
            $saleswithcomma = number_format($quotes['sales']);
            $quotes['loan'] = str_replace(',', '', $quotes['loan']);
            $quotes['sales'] = str_replace(',', '', $quotes['sales']);
            $amount = $quotes['sales'];
            if($quotes['transaction'] == "Refinance"){
                $quotes['sales'] = "";
                $amount =  $quotes['loan'];
            }
            $table_name = $wpdb->prefix . "rate_calculator";
            $wpdb->insert($table_name, array('loan_amount' => $quotes['loan'], 'sales_amount' => $quotes['sales'], 'transaction' => $quotes['transaction'], 'p_address' => $quotes['state'], 'services' => $quotes['services']));
            
            $total = 0;

            $stateTable = $wpdb->prefix.'rate_calculator_state';
            $stateResults = $wpdb->get_results( "SELECT * FROM ".$stateTable." where id = '".$quotes['state']."'");
            $countyTable = $wpdb->prefix.'rate_calculator_county';
            $countyResults = $wpdb->get_results( "SELECT * FROM ".$countyTable." where id = ".$quotes['county']);
            //print_r($CountyResults);
            $feeTable = $wpdb->prefix.'rate_calculator_recording_fee';
            $feeResults = $wpdb->get_results( "SELECT * FROM ".$feeTable." where countyid = ".$quotes['county']);

            $result = $this->calculate_rates($amount, $quotes['transaction'], $stateResults[0]->name);
             ?>
            <div class="row">
                <div class="rc-col-12" style="text-align: center; position:relative">
                    <div class="rc-button-back">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31.494 31.494" xml:space="preserve" width="16px"><path d="M10.273,5.009c0.444-0.444,1.143-0.444,1.587,0c0.429,0.429,0.429,1.143,0,1.571l-8.047,8.047h26.554c0.619,0,1.127,0.492,1.127,1.111c0,0.619-0.508,1.127-1.127,1.127H3.813l8.047,8.032c0.429,0.444,0.429,1.159,0,1.587c-0.444,0.444-1.143,0.444-1.587,0l-9.952-9.952c-0.429-0.429-0.429-1.143,0-1.571L10.273,5.009z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                        <span>Back</span>
                    </div>
                    <p class="quotes__heading" style="display: inline-block">Quotes Result</p>
                </div>
            </div>

            <div class="row rc-quoteparam">
                <div class="rc-col-12" style="position: relative">
                    <b>Summary</b>
                    <div class="rc-button-edit">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>
                        <span id="rc-button-edit">Edit</span>
                    </div>
                    <div class="rc-separator"></div>
                    <label>State:</label><span class="stateP"><?php echo $stateResults[0]->name ?></span>
                    <label>County:</label><span class="countyP"><?php echo $countyResults[0]->name ?></span>
                    <label>Transaction type:</label><span class="ttypeP"><?php echo $quotes['transaction'] ?></span>
                    <label>Loan amount:</label><span class="loanP">$<?php echo $loanwithcomma; ?></span>
                    <?php if(($quotes['transaction'] == "Purchase")){
                        echo "<label>Sales price:</label><span class='salesP'>$$saleswithcomma</span>";
                    } ?>
                    <label>Services:</label><span class="servicesP"><?php echo $quotes['services'] ?></span>
                </div>
            </div>
            <?php if($quotes['transaction'] == "Refinance"):
            if($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Title'): ?>
            <div class="row">
                <div class="rc-col-12">
                    <table class="rc-table">
                        <tbody>
                        <tr class="rc-table-head">
                            <td><b>Title Charges</b></td>
                            <td><b></b></td>
                            <td><b>Borrower</b></td>
                        </tr>
                        <tr>
                            <td>Lender's Title Insurance*</td>
                            <td></td>
                            <td><span class="lenderP">$<?php echo number_format($result->lender); $total +=$result->lender;  ?></span></td>
                        </tr>

                        <?php if(strtoupper($stateResults[0]->name) == 'NV' || strtoupper($stateResults[0]->name) == 'AZ'){
                                $total +=number_format('25');
                                ?>
                                <tr>
                                    <td>CPL</td>
                                    <td></td>
                                    <td>$<?=number_format('25')?></td>
                                </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="3" class="other-services">
                                <?php if($quotes['services'] == 'Title'){ ?>
                                            *Any applicable endorsement charges are not included in this quote.<br>
                                <?php } ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif;
            

            if($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Escrow'): ?>
            
            <div class="row">
                <div class="rc-col-12">
                    <table class="rc-table">
                        <tbody>
                        <tr class="rc-table-head">
                            <td><b>Settlement/Escrow</b></td>
                            <td><b></b></td>
                            <td><b>Borrower</b></td>
                        </tr>
                        <tr>
                            <td>Closing Fee</td>
                            <td></td>
                            <td><span class="closeP">$<?php echo number_format($result->escrow); $total +=$result->escrow;?></span></td>
                        </tr>
                        <tr>
                            <td>Notary Fee</td>
                            <td></td>
                            <td><span class="notaryP">$<?=number_format($options['notaryfee'])?></span></td>
                            <?php $total +=$options['notaryfee'];?>
                        </tr>
                        <tr>
                            <td>Recording Fee**</td>
                            <td></td>
                            <td><span class="recordingP">$<?php echo $feeResults[0]->value ?></span></td>
                            <?php $total +=$feeResults[0]->value;?>
                        </tr>
                        <?php if($stateResults[0]->name == 'CA' || $stateResults[0]->name == 'ca'){
                                $total +=$options['affordable_housing_act'];
                                ?>
                                <tr>
                                    <td>Affordable Housing Act</td>
                                    <td></td>
                                    <td><span class="housingP">$<?=number_format($options['affordable_housing_act'])?></span></td>
                                </tr>
                        <?php } ?>

                        <?php /*if(strtoupper($stateResults[0]->name) == 'NV' || strtoupper($stateResults[0]->name) == 'AZ'){
                                $total +=number_format('25');
                                ?>
                                <tr>
                                    <td>CPL</td>
                                    <td></td>
                                    <td>$<?=number_format('25')?></td>
                                </tr>
                        <?php } */?>

                        <tr>
                            <td colspan="3" class="other-services">
                                <?php if($quotes['services'] == 'Title and Escrow'){ ?>
                                            *Any applicable endorsement charges are not included in this quote.<br>
                                            **Charges can vary based on # of pages and document types.
                                <?php } if($quotes['services'] == 'Escrow'){ ?>
                                            **Charges can vary based on # of pages and document types.
                                <?php } ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="rc-col-12">
                    <table class="rc-table">
                        <tbody>
                        <tr class="rc-table-footer">
                            <td><b>Total</b></td>
                            <td><b></b></td>
                            <td><b><span class="totalP">$<?php echo number_format($total) ?></b></span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php endif;
            if(($quotes['transaction'] == "Purchase")):
                if($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Title'): ?>
                <div class="row">
                    <div class="rc-col-12">
                        <table class="rc-table">
                            <tbody>
                            <tr class="rc-table-head">
                                <td><b>Title Charges</b></td>
                                <td><b>Buyer</b></td>
                                <td><b>Seller</b></td>
                            </tr>
                            <tr>
                                <td>Owner's Title Insurance</td>
                                <td></td>
                                <td><span class="ownerP">$<?php echo number_format($result->seller->title); $total +=$result->seller->title;  ?></span></td>
                            </tr>
                            <tr>
                                <td>Lender's Title Insurance*</td>
                                <td><span class="lenderP">$<?php echo number_format($result->buyer->title) ?></td></span>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="other-services">
                                    <?php if($quotes['services'] == 'Title'){ ?>
                                        *Any applicable endorsement charges are not included in this quote.<br>
                                    <?php } ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif;
                if($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Escrow'): ?>

                <div class="row">
                    <div class="rc-col-12">
                        <table class="rc-table">
                            <tbody>
                            <tr class="rc-table-head">
                                <td><b>Settlement/Escrow</b></td>
                                <td><b>Buyer</b></td>
                                <td><b>Seller</b></td>
                            </tr>
                            <tr>
                                <td>Closing Fee</td>
                                <td></td>
                                <td><span class="closeP">$<?php echo number_format($result->seller->escrow); $total +=$result->seller->escrow; ?></span></td>
                            </tr>
                            <tr>
                                <td>Notary Fee</td>
                                <td></td>
                                <td><span class="notaryP">$<?=number_format($options['notaryfee'])?></span></td>
                                <?php $total +=$options['notaryfee'];?>
                            </tr>
                            <tr>
                                <td>Recording Fee**</td>
                                <td></td>
                                <td><span class="recordingP">$<?php echo $feeResults[0]->value ?></span></td>
                                <?php $total +=$feeResults[0]->value;?>
                            </tr>
                            <?php if($stateResults[0]->name == 'CA' || $stateResults[0]->name == 'ca'){
                            $total +=$options['affordable_housing_act'];
                            ?>
                            <tr>
                                <td>Affordable Housing Act</td>
                                <td></td>
                                <td><span class="housingP">$<?=number_format($options['affordable_housing_act'])?></span></td>
                            </tr>
                        <?php } ?>
                            <tr>
                                <td colspan="3" class="other-services">
                                    <?php if($quotes['services'] == 'Title and Escrow'){ ?>
                                    *Any applicable endorsement charges are not included in this quote.<br>
                                    **Charges can vary based on # of pages and document types. 
                                    <?php } if($quotes['services'] == 'Escrow'){ ?>
                                        **Charges can vary based on # of pages and document types.
                                    <?php } ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="rc-col-12">
                        <table class="rc-table">
                            <tbody>
                            <tr class="rc-table-footer">
                                <td><b>Total</b></td>
                                <td><b>$<?php echo ($quotes['services'] == 'Title and Escrow' || $quotes['services'] == 'Title') ? number_format($result->buyer->title): 0 ?></b></td>
                                <td><b><span class="totalP">$<?php echo number_format($total) ?></b></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row" style="margin-top:30px">
                <div class="rc-col-12">
                    <button type="button">
                        <a class="rate-calculator-submit-text" href="javascript:demoTwoPageDocument()">Download</a>
                    </button>
                    <button type="button" class="btn btn-primary btn-custom">
                        <a class="rate-calculator-submit-text" href="<?=$options['place_order_link']?>">Place Order</a>
                    </button>
                </div>
            </div>
        <?php //endif;
        
        endif;
        die();
    }
    //load county
    function rc_load_county(){
        global $wpdb;
        $countyTable = $wpdb->prefix.'rate_calculator_county';
        $results = $wpdb->get_results( "SELECT * FROM ".$countyTable." where stateid = ".$_POST['stateID']);
        ?>        
        <select name="county" id="rc-county">
            <option value="" selected="selected">Select a County</option>
            <?php
            foreach ($results as $eachCounty) {
            ?>
                <option value="<?=$eachCounty->id?>"><?=$eachCounty->name?></option>                       
            <?php
            }
            ?>
        </select>
        <?php
        die();
    }
    
    public function rate_calculator_shortcode($atts){
        $nonce = wp_create_nonce( 'rc-quotes' );
        ?>
        <script  type='text/javascript'>            
            function handle_edit(){
                jQuery('.rc-button-edit').click(function() { //start function when any update link is clicked
                    jQuery(".rc-body-result").toggle();
                    jQuery(".rc-body-inner").fadeIn("slow");
                });
            }

            function handle_back(){
                jQuery('.rc-button-back').click(function() { //start function when any update link is clicked
                    jQuery("#rc-sales").parent().parent().hide();
                    jQuery("#rc-loan").val('');
                    jQuery("#rc-sales").val('');
                    jQuery("#rc-transaction").val('Refinance');
                    jQuery("#rc-state").val('');
                    jQuery("#rc-county").val('');
                    jQuery("#rc-services").val('Title and Escrow');
                    jQuery(".rc-body-result").toggle();
                    jQuery(".rc-body-inner").fadeIn("slow");
                });
            }

            function submit_quotes( quotes ) {
                jQuery.ajax({
                    type: "post",
                    url: "<?php echo get_site_url().'/wp-admin/admin-ajax.php'?>",
                    data: { action: 'submitquotes', 
                            quotes: quotes, 
                            _ajax_nonce: '<?php echo $nonce; ?>' },
                    beforeSend: function() {
                        jQuery("#rate-calculator-submit").addClass('rc-inactive');
                        jQuery(".rate-calculator-submit-text").toggle();
                        jQuery(".rc-loader").fadeIn('fast');}, //fadeIn loading just when link is clicked
                    success: function(html){ //so, if data is retrieved, store it in html
                        jQuery(".rc-body-inner").hide();
                        jQuery(".rc-body-result").html(html).fadeIn("slow");
                        jQuery(".rc-loader").hide();
                        handle_edit();
                        handle_back();

                        //jQuery(".rc-loader").toggle();
                        jQuery(".rate-calculator-submit-text").fadeIn("slow"); //animation
                        jQuery("#rate-calculator-submit").removeClass('rc-inactive').prop('disabled', false);;
                    }
                }); //close jQuery.ajax(
            }

            function numberWithOutCommas(x) {
                return parseInt(x.toString().replace(',', ''));
            }

            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function rc_validation(){
                var error = false;
                if(!jQuery("#rc-state").val()){
                    error = true;
                    jQuery("#rc-state").next().slideDown();
                } else {
                    jQuery("#rc-state").next().slideUp();
                }
                if(!jQuery("#rc-county").val()){
                    error = true;
                    jQuery("#rc-county").parent().next().slideDown();
                } else {
                    jQuery("#rc-county").parent().next().slideUp();
                }
                if(jQuery("#rc-loan").val() == ""){
                    error = true;
                    jQuery("#rc-loan").next().slideDown();
                } else{
                    jQuery("#rc-loan").next().slideUp();
                }

                /*if(jQuery("#rc-sales").val() == "" && jQuery("#rc-transaction").val() == "Purchase"){
                    error = true;
                    jQuery("#rc-sales").next().slideDown();
                } else if (!jQuery("#rc-sales").val() == "" && jQuery("#rc-transaction").val() == "Purchase"){
                    jQuery("#rc-sales").next().slideUp();
                }*/

                return error;
            }

            // When the document loads do everything inside here ...
            jQuery(document).ready(function(){
                jQuery(document).on('change','#rc-state', function(e){
                e.preventDefault();
                var ajax_url = "<?php echo get_site_url() . '/wp-admin/admin-ajax.php'?>";
                var fd = new FormData();
                var stateID = jQuery(this).val();
                //alert(stateID);
                fd.append('action', 'load_county');
                fd.append('stateID', stateID);
                

                var stateName = jQuery( "#rc-state option:selected" ).text();
                jQuery.ajax({
                    type: 'POST',
                    url: ajax_url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        jQuery('#for-county').html(response);
                        if(stateName == "CA")
                        {
                            jQuery("#rc-transaction option[value='Purchase']").attr("selected", true);
                            jQuery("#rc-transaction option[value='Purchase']").attr("disabled", false);
                            jQuery("#rc-transaction option[value='Refinance']").attr("disabled", 'disabled');
                        }
                        else
                        {
                            jQuery("#rc-transaction option[value='Refinance']").attr("selected", true);
                            jQuery("#rc-transaction option[value='Refinance']").attr("disabled", false);
                            jQuery("#rc-transaction option[value='Purchase']").attr("disabled", 'disabled');
                        }
                    }
                });
            });
                jQuery('#rate-calculator-submit').click(function() { //start function when any update link is clicked
                   
                    if(rc_validation()){
                        return;
                    }
                    jQuery(this).prop('disabled', true);
                    var rcLoan = jQuery("#rc-loan").val();
                    var rcSales = jQuery("#rc-sales").val();
                    var rcTransaction = jQuery("#rc-transaction").val();
                    var rcState = jQuery("#rc-state").val();
                    var rcServices = jQuery("#rc-services").val();
                    var rcCounty = jQuery("#rc-county").val();
                    var quotes = {
                        loan: rcLoan,
                        transaction: rcTransaction,
                        state: rcState,
                        county: rcCounty,
                        sales: rcSales,
                        services: rcServices,
                    };
                    submit_quotes( quotes );
                });

                /*! jQuery number 2.1.3 (c) github.com/teamdf/jquery-number | opensource.teamdf.com/license */
                (function(h){function r(f,a){if(this.createTextRange){var c=this.createTextRange();c.collapse(true);c.moveStart("character",f);c.moveEnd("character",a-f);c.select()}else if(this.setSelectionRange){this.focus();this.setSelectionRange(f,a)}}function s(f){var a=this.value.length;f=f.toLowerCase()=="start"?"Start":"End";if(document.selection){a=document.selection.createRange();var c;c=a.duplicate();c.expand("textedit");c.setEndPoint("EndToEnd",a);c=c.text.length-a.text.length;a=c+a.text.length;return f==
                "Start"?c:a}else if(typeof this["selection"+f]!="undefined")a=this["selection"+f];return a}var q={codes:{188:44,109:45,190:46,191:47,192:96,220:92,222:39,221:93,219:91,173:45,187:61,186:59,189:45,110:46},shifts:{96:"~",49:"!",50:"@",51:"#",52:"$",53:"%",54:"^",55:"&",56:"*",57:"(",48:")",45:"_",61:"+",91:"{",93:"}",92:"|",59:":",39:'"',44:"<",46:">",47:"?"}};h.fn.number=function(f,a,c,k){k=typeof k==="undefined"?",":k;c=typeof c==="undefined"?".":c;a=typeof a==="undefined"?0:a;var j="\\u"+("0000"+
                    c.charCodeAt(0).toString(16)).slice(-4),o=RegExp("[^"+j+"0-9]","g"),p=RegExp(j,"g");if(f===true)return this.is("input:text")?this.on({"keydown.format":function(b){var d=h(this),e=d.data("numFormat"),g=b.keyCode?b.keyCode:b.which,m="",i=s.apply(this,["start"]),n=s.apply(this,["end"]),l="";l=false;if(q.codes.hasOwnProperty(g))g=q.codes[g];if(!b.shiftKey&&g>=65&&g<=90)g+=32;else if(!b.shiftKey&&g>=69&&g<=105)g-=48;else if(b.shiftKey&&q.shifts.hasOwnProperty(g))m=q.shifts[g];if(m=="")m=String.fromCharCode(g);
                        if(g!==8&&m!=c&&!m.match(/[0-9]/)){d=b.keyCode?b.keyCode:b.which;if(d==46||d==8||d==9||d==27||d==13||(d==65||d==82)&&(b.ctrlKey||b.metaKey)===true||(d==86||d==67)&&(b.ctrlKey||b.metaKey)===true||d>=35&&d<=39)return;b.preventDefault();return false}if(i==0&&n==this.value.length||d.val()==0)if(g===8){i=n=1;this.value="";e.init=a>0?-1:0;e.c=a>0?-(a+1):0;r.apply(this,[0,0])}else if(m===c){i=n=1;this.value="0"+c+Array(a+1).join("0");e.init=a>0?1:0;e.c=a>0?-(a+1):0}else{if(this.value.length===0){e.init=
                            a>0?-1:0;e.c=a>0?-a:0}}else e.c=n-this.value.length;if(a>0&&m==c&&i==this.value.length-a-1){e.c++;e.init=Math.max(0,e.init);b.preventDefault();l=this.value.length+e.c}else if(m==c){e.init=Math.max(0,e.init);b.preventDefault()}else if(a>0&&g==8&&i==this.value.length-a){b.preventDefault();e.c--;l=this.value.length+e.c}else if(a>0&&g==8&&i>this.value.length-a){if(this.value==="")return;if(this.value.slice(i-1,i)!="0"){l=this.value.slice(0,i-1)+"0"+this.value.slice(i);d.val(l.replace(o,"").replace(p,
                            c))}b.preventDefault();e.c--;l=this.value.length+e.c}else if(g==8&&this.value.slice(i-1,i)==k){b.preventDefault();e.c--;l=this.value.length+e.c}else if(a>0&&i==n&&this.value.length>a+1&&i>this.value.length-a-1&&isFinite(+m)&&!b.metaKey&&!b.ctrlKey&&!b.altKey&&m.length===1){this.value=l=n===this.value.length?this.value.slice(0,i-1):this.value.slice(0,i)+this.value.slice(i+1);l=i}l!==false&&r.apply(this,[l,l]);d.data("numFormat",e)},"keyup.format":function(b){var d=h(this),e=d.data("numFormat");b=b.keyCode?
                        b.keyCode:b.which;var g=s.apply(this,["start"]);if(!(this.value===""||(b<48||b>57)&&(b<96||b>105)&&b!==8)){d.val(d.val());if(a>0)if(e.init<1){g=this.value.length-a-(e.init<0?1:0);e.c=g-this.value.length;e.init=1;d.data("numFormat",e)}else if(g>this.value.length-a&&b!=8){e.c++;d.data("numFormat",e)}d=this.value.length+e.c;r.apply(this,[d,d])}},"paste.format":function(b){var d=h(this),e=b.originalEvent,g=null;if(window.clipboardData&&window.clipboardData.getData)g=window.clipboardData.getData("Text");
                    else if(e.clipboardData&&e.clipboardData.getData)g=e.clipboardData.getData("text/plain");d.val(g);b.preventDefault();return false}}).each(function(){var b=h(this).data("numFormat",{c:-(a+1),decimals:a,thousands_sep:k,dec_point:c,regex_dec_num:o,regex_dec:p,init:false});this.value!==""&&b.val(b.val())}):this.each(function(){var b=h(this),d=+b.text().replace(o,"").replace(p,".");b.number(!isFinite(d)?0:+d,a,c,k)});return this.text(h.number.apply(window,arguments))};var t=null,u=null;if(h.isPlainObject(h.valHooks.text)){if(h.isFunction(h.valHooks.text.get))t=
                    h.valHooks.text.get;if(h.isFunction(h.valHooks.text.set))u=h.valHooks.text.set}else h.valHooks.text={};h.valHooks.text.get=function(f){var a=h(f).data("numFormat");if(a){if(f.value==="")return"";f=+f.value.replace(a.regex_dec_num,"").replace(a.regex_dec,".");return""+(isFinite(f)?f:0)}else if(h.isFunction(t))return t(f)};h.valHooks.text.set=function(f,a){var c=h(f).data("numFormat");if(c)return f.value=h.number(a,c.decimals,c.dec_point,c.thousands_sep);else if(h.isFunction(u))return u(f,a)};h.number=
                    function(f,a,c,k){k=typeof k==="undefined"?",":k;c=typeof c==="undefined"?".":c;a=!isFinite(+a)?0:Math.abs(a);var j="\\u"+("0000"+c.charCodeAt(0).toString(16)).slice(-4),o="\\u"+("0000"+k.charCodeAt(0).toString(16)).slice(-4);f=(f+"").replace(".",c).replace(RegExp(o,"g"),"").replace(RegExp(j,"g"),".").replace(RegExp("[^0-9+-Ee.]","g"),"");f=!isFinite(+f)?0:+f;j="";j=function(p,b){var d=Math.pow(10,b);return""+Math.round(p*d)/d};j=(a?j(f,a):""+Math.round(f)).split(".");if(j[0].length>3)j[0]=j[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,
                        k);if((j[1]||"").length<a){j[1]=j[1]||"";j[1]+=Array(a-j[1].length+1).join("0")}return j.join(c)}})(jQuery);
                jQuery("#rc-loan").number( true, 0 );

                jQuery("#rc-sales").number( true, 0 );

                jQuery("#rc-transaction").on("change", function() {
                    if(this.value == "Purchase"){
                        jQuery("#rc-sales").parent().parent().fadeIn();
                    } else{
                        jQuery("#rc-sales").parent().parent().fadeOut('fast');
                    }
                });
            })
        </script>
        <div class="rc-body">
            <div class="rc-body-inner">
                <div class="row">
                    <div class="rc-col-12">
                        <p class="quotes__heading">Get instant quotes</p>
                        <p class="quotes__subheading"></p>
                    </div>
                </div>

                <div class="row">
                    <div class="rc-col-12">
                        <label for="">State</label>
                        <?php 
                            global $wpdb;
                            $stateTable = $wpdb->prefix.'rate_calculator_state';
                            $results = $wpdb->get_results( "SELECT * FROM ".$stateTable);
                        ?>
                        <select name="state" id="rc-state">
                            <option value="" selected="selected">Select a State</option>
                            <?php foreach($results as $eachState){ 
                                    $countyTable = $wpdb->prefix.'rate_calculator_county';
                                    $resultsCounty = $wpdb->get_results( "SELECT * FROM ".$countyTable." where stateid = ".$eachState->id);
                                    if(!empty($resultsCounty)){
                                ?>
                                <option value="<?=$eachState->id?>"><?=$eachState->name?></option>
                            <?php } }?>
                        </select>
                        <label class="error-validation"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'pix/exclamation-mark.png'; ?>"> Please select a valid State</label>
                    </div>
                </div>

                <div class="row">
                    <div class="rc-col-12">
                        <label for="">County</label>
                        <div id="for-county">
                            <select name="county" class="disable-state" id="" disabled="disabled">
                                <option value="" selected="selected">Select a County</option>
                            </select>                            
                        </div>
                        <label class="error-validation"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'pix/exclamation-mark.png'; ?>"> Please select a valid County</label>
                    </div>
                </div>

                <div class="row">
                    <div class="rc-col-12">
                        <label for="">Transaction type</label>
                        <select id="rc-transaction">
                            <option value="Refinance">Refinance</option>
                            <option value="Purchase">Purchase</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="rc-col-12">
                        <label for="">Loan Amount</label>
                        <div class="input-group-addon">$</div>
                        <input id="rc-loan" class="input-group" type="text" placeholder="Enter amount of new loan(s)">
                        <label class="error-validation"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'pix/exclamation-mark.png'; ?>"> Please fill in the loan amount</label>
                    </div>
                </div>

                <div class="row" style="display: none">
                    <div class="rc-col-12">
                        <label for="">Sales Price</label>
                        <div class="input-group-addon">$</div>
                        <input id="rc-sales" class="input-group" type="text" placeholder="Enter property sales price">
                        <label class="error-validation"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'pix/exclamation-mark.png'; ?>"> Please fill in the sales price</label>
                    </div>
                </div>

                <div class="row">
                    <div class="rc-col-12">
                        <label for="">Services types</label>
                        <select id="rc-services">
                            <option value="Title and Escrow">Title & Escrow</option>
                            <option value="Title">Title</option>
                            <option value="Escrow">Escrow</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="rc-col-12">
                        <button id="rate-calculator-submit" type="button" class="btn btn-primary btn-custom">
                            <span class="rate-calculator-submit-text">Calculate</span>
                            <div class="rc-loader" style="display: none;">
                                <img src="<?php echo plugin_dir_url( __FILE__ ) . "pix/loader.svg"; ?>"
                            </div>
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="rc-body-result" style="display: none"></div>
        </div>
        <?php
    }

    function rate_calculator_widget(){
        $nonce = wp_create_nonce( 'rc-widget-quotes' );
        global $post;
        if(has_shortcode( $post->post_content, 'rate-calculator')) return;
        ?>
        <script  type='text/javascript'>

            function widget_submit_quotes( widgetQuotes ) {
                jQuery.ajax({
                    type: "post",
                    url: "<?php echo get_site_url() . '/wp-admin/admin-ajax.php'?>",
                    data: {action: 'widgetsubmitquotes', quotes: widgetQuotes, _ajax_nonce: '<?php echo $nonce; ?>'},
                    beforeSend: function () {
                        jQuery("#rc-widget-submit").addClass('rc-inactive');
                        jQuery(".rc-widget-submit-text").toggle();
                        jQuery(".rc-widget-loader").fadeIn('fast');
                    }, //fadeIn loading just when link is clicked
                    success: function (html) { //so, if data is retrieved, store it in html
                        jQuery(".rc-widget-poput-body").toggle();
                        jQuery("#rc-widget-back-button").toggle();
                        jQuery(".rc-widget-poput-result").html(html).fadeIn("slow");

                        jQuery(".rc-widget-loader").toggle();
                        jQuery(".rc-widget-submit-text").fadeIn("slow"); //animation
                        jQuery("#rc-widget-submit").removeClass('rc-inactive').prop('disabled', false);
                        ;
                    }
                }); //close jQuery.ajax(
            }
            
            function rc_widget_validation(){
                var error = false;
                if(!jQuery("#rc-widget-state").val()){
                    error = true;
                    jQuery("#rc-widget-state").next().slideDown();
                } else {
                    jQuery("#rc-widget-state").next().slideUp();
                }
                if(!jQuery("#rc-county").val()){
                    error = true;
                    jQuery("#rc-county").parent().next().slideDown();
                } else {
                    jQuery("#rc-county").parent().next().slideUp();
                }
                if(jQuery("#rc-widget-loan").val() == ""){
                    error = true;
                    jQuery("#rc-widget-loan").next().slideDown();
                } else{
                    jQuery("#rc-widget-loan").next().slideUp();
                }

                if(jQuery("#rc-widget-sales").val() == "" && jQuery("#rc-widget-transaction").val() == "Purchase"){
                    error = true;
                    jQuery("#rc-widget-sales").next().slideDown();
                } else if (!jQuery("#rc-widget-sales").val() == "" && jQuery("#rc-widget-transaction").val() == "Purchase"){
                    jQuery("#rc-widget-sales").next().slideUp();
                }

                return error;
            }

            // When the document loads do everything inside here ...
            jQuery(document).ready(function(){
                jQuery(document).on('change','#rc-widget-state', function(e){
                    e.preventDefault();
                    var ajax_url = "<?php echo get_site_url() . '/wp-admin/admin-ajax.php'?>";
                    var fd = new FormData();
                    var stateID = jQuery(this).val();
                    fd.append('action', 'load_county');
                    fd.append('stateID', stateID);
                
                    jQuery.ajax({
                        type: 'POST',
                        url: ajax_url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response){
                            jQuery('#for-county').html(response);
                        }
                    });
                });
                jQuery('#rc-widget-submit').click(function() { //start function when any update link is clicked
                    if(rc_widget_validation()){
                        return;
                    }
                    jQuery(this).prop('disabled', true);
                    var rcWidgetLoan = jQuery("#rc-widget-loan").val();
                    var rcWidgetSales = jQuery("#rc-widget-sales").val();
                    var rcWidgetTransaction = jQuery("#rc-widget-transaction").val();
                    //var rcWidgetState = jQuery("#rc-widget-state").val();
                    var rcWidgetServices = jQuery("#rc-widget-services").val();
                    var rcWidgetState = jQuery("#rc-widget-state").val();
                    var rcWidgetCounty = jQuery("#rc-county").val();
                    var widgetQuotes = {
                        loan: rcWidgetLoan,
                        sales: rcWidgetSales,
                        transaction: rcWidgetTransaction,
                        state: rcWidgetState,
                        county: rcWidgetCounty,
                        services: rcWidgetServices,
                    };
                    widget_submit_quotes( widgetQuotes );
                });

                jQuery('#rc-widget-back-button').click(function() { //start function when any update link is clicked
                    jQuery("#rc-widget-sales").parent().hide();
                    jQuery("#rc-widget-loan").parent().attr("class", "rc-col-12");
                    jQuery("#rc-widget-loan").val('');
                    jQuery("#rc-widget-sales").val('');
                    jQuery("#rc-widget-transaction").val('Refinance');
                    jQuery("#rc-widget-state").val('');
                    jQuery("#rc-widget-services").val('Title and Escrow');
                    jQuery(".rc-widget-poput-result").toggle();
                    jQuery(this).toggle();
                    jQuery(".rc-widget-poput-body").fadeIn("slow");
                });

                jQuery('.rc-widget-openform').click(function() {
                    jQuery('.rc-widget-popup').fadeToggle();
                });

                /*! jQuery number 2.1.3 (c) github.com/teamdf/jquery-number | opensource.teamdf.com/license */
                (function(h){function r(f,a){if(this.createTextRange){var c=this.createTextRange();c.collapse(true);c.moveStart("character",f);c.moveEnd("character",a-f);c.select()}else if(this.setSelectionRange){this.focus();this.setSelectionRange(f,a)}}function s(f){var a=this.value.length;f=f.toLowerCase()=="start"?"Start":"End";if(document.selection){a=document.selection.createRange();var c;c=a.duplicate();c.expand("textedit");c.setEndPoint("EndToEnd",a);c=c.text.length-a.text.length;a=c+a.text.length;return f==
                "Start"?c:a}else if(typeof this["selection"+f]!="undefined")a=this["selection"+f];return a}var q={codes:{188:44,109:45,190:46,191:47,192:96,220:92,222:39,221:93,219:91,173:45,187:61,186:59,189:45,110:46},shifts:{96:"~",49:"!",50:"@",51:"#",52:"$",53:"%",54:"^",55:"&",56:"*",57:"(",48:")",45:"_",61:"+",91:"{",93:"}",92:"|",59:":",39:'"',44:"<",46:">",47:"?"}};h.fn.number=function(f,a,c,k){k=typeof k==="undefined"?",":k;c=typeof c==="undefined"?".":c;a=typeof a==="undefined"?0:a;var j="\\u"+("0000"+
                    c.charCodeAt(0).toString(16)).slice(-4),o=RegExp("[^"+j+"0-9]","g"),p=RegExp(j,"g");if(f===true)return this.is("input:text")?this.on({"keydown.format":function(b){var d=h(this),e=d.data("numFormat"),g=b.keyCode?b.keyCode:b.which,m="",i=s.apply(this,["start"]),n=s.apply(this,["end"]),l="";l=false;if(q.codes.hasOwnProperty(g))g=q.codes[g];if(!b.shiftKey&&g>=65&&g<=90)g+=32;else if(!b.shiftKey&&g>=69&&g<=105)g-=48;else if(b.shiftKey&&q.shifts.hasOwnProperty(g))m=q.shifts[g];if(m=="")m=String.fromCharCode(g);
                        if(g!==8&&m!=c&&!m.match(/[0-9]/)){d=b.keyCode?b.keyCode:b.which;if(d==46||d==8||d==9||d==27||d==13||(d==65||d==82)&&(b.ctrlKey||b.metaKey)===true||(d==86||d==67)&&(b.ctrlKey||b.metaKey)===true||d>=35&&d<=39)return;b.preventDefault();return false}if(i==0&&n==this.value.length||d.val()==0)if(g===8){i=n=1;this.value="";e.init=a>0?-1:0;e.c=a>0?-(a+1):0;r.apply(this,[0,0])}else if(m===c){i=n=1;this.value="0"+c+Array(a+1).join("0");e.init=a>0?1:0;e.c=a>0?-(a+1):0}else{if(this.value.length===0){e.init=
                            a>0?-1:0;e.c=a>0?-a:0}}else e.c=n-this.value.length;if(a>0&&m==c&&i==this.value.length-a-1){e.c++;e.init=Math.max(0,e.init);b.preventDefault();l=this.value.length+e.c}else if(m==c){e.init=Math.max(0,e.init);b.preventDefault()}else if(a>0&&g==8&&i==this.value.length-a){b.preventDefault();e.c--;l=this.value.length+e.c}else if(a>0&&g==8&&i>this.value.length-a){if(this.value==="")return;if(this.value.slice(i-1,i)!="0"){l=this.value.slice(0,i-1)+"0"+this.value.slice(i);d.val(l.replace(o,"").replace(p,
                            c))}b.preventDefault();e.c--;l=this.value.length+e.c}else if(g==8&&this.value.slice(i-1,i)==k){b.preventDefault();e.c--;l=this.value.length+e.c}else if(a>0&&i==n&&this.value.length>a+1&&i>this.value.length-a-1&&isFinite(+m)&&!b.metaKey&&!b.ctrlKey&&!b.altKey&&m.length===1){this.value=l=n===this.value.length?this.value.slice(0,i-1):this.value.slice(0,i)+this.value.slice(i+1);l=i}l!==false&&r.apply(this,[l,l]);d.data("numFormat",e)},"keyup.format":function(b){var d=h(this),e=d.data("numFormat");b=b.keyCode?
                        b.keyCode:b.which;var g=s.apply(this,["start"]);if(!(this.value===""||(b<48||b>57)&&(b<96||b>105)&&b!==8)){d.val(d.val());if(a>0)if(e.init<1){g=this.value.length-a-(e.init<0?1:0);e.c=g-this.value.length;e.init=1;d.data("numFormat",e)}else if(g>this.value.length-a&&b!=8){e.c++;d.data("numFormat",e)}d=this.value.length+e.c;r.apply(this,[d,d])}},"paste.format":function(b){var d=h(this),e=b.originalEvent,g=null;if(window.clipboardData&&window.clipboardData.getData)g=window.clipboardData.getData("Text");
                    else if(e.clipboardData&&e.clipboardData.getData)g=e.clipboardData.getData("text/plain");d.val(g);b.preventDefault();return false}}).each(function(){var b=h(this).data("numFormat",{c:-(a+1),decimals:a,thousands_sep:k,dec_point:c,regex_dec_num:o,regex_dec:p,init:false});this.value!==""&&b.val(b.val())}):this.each(function(){var b=h(this),d=+b.text().replace(o,"").replace(p,".");b.number(!isFinite(d)?0:+d,a,c,k)});return this.text(h.number.apply(window,arguments))};var t=null,u=null;if(h.isPlainObject(h.valHooks.text)){if(h.isFunction(h.valHooks.text.get))t=
                    h.valHooks.text.get;if(h.isFunction(h.valHooks.text.set))u=h.valHooks.text.set}else h.valHooks.text={};h.valHooks.text.get=function(f){var a=h(f).data("numFormat");if(a){if(f.value==="")return"";f=+f.value.replace(a.regex_dec_num,"").replace(a.regex_dec,".");return""+(isFinite(f)?f:0)}else if(h.isFunction(t))return t(f)};h.valHooks.text.set=function(f,a){var c=h(f).data("numFormat");if(c)return f.value=h.number(a,c.decimals,c.dec_point,c.thousands_sep);else if(h.isFunction(u))return u(f,a)};h.number=
                    function(f,a,c,k){k=typeof k==="undefined"?",":k;c=typeof c==="undefined"?".":c;a=!isFinite(+a)?0:Math.abs(a);var j="\\u"+("0000"+c.charCodeAt(0).toString(16)).slice(-4),o="\\u"+("0000"+k.charCodeAt(0).toString(16)).slice(-4);f=(f+"").replace(".",c).replace(RegExp(o,"g"),"").replace(RegExp(j,"g"),".").replace(RegExp("[^0-9+-Ee.]","g"),"");f=!isFinite(+f)?0:+f;j="";j=function(p,b){var d=Math.pow(10,b);return""+Math.round(p*d)/d};j=(a?j(f,a):""+Math.round(f)).split(".");if(j[0].length>3)j[0]=j[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,
                        k);if((j[1]||"").length<a){j[1]=j[1]||"";j[1]+=Array(a-j[1].length+1).join("0")}return j.join(c)}})(jQuery);

                jQuery("#rc-widget-loan").number( true, 0 );

                jQuery("#rc-widget-sales").number( true, 0 );

                jQuery("#rc-widget-transaction").on("change", function() {
                    if(this.value == "Purchase"){
                        jQuery("#rc-widget-loan").parent().attr("class", "rc-col-6");
                        jQuery("#rc-widget-sales").parent().fadeIn();
                    } else{
                        jQuery("#rc-widget-sales").parent().fadeOut('fast');
                        setTimeout(function(){
                            jQuery("#rc-widget-loan").parent().attr("class", "rc-col-12");
                        },300);

                    }
                });
            });
        </script>

        <div class="rc-widget rc-body">
            <div class="rc-widget-popup" style="display: none;">
                <div class="row rc-widget-popup-header">
                    <div class="rc-col-12">
                        <svg id="rc-widget-back-button" style="display: none" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 31.494 31.494" xml:space="preserve" width="18px"><path style="fill:#ffffff;" d="M10.273,5.009c0.444-0.444,1.143-0.444,1.587,0c0.429,0.429,0.429,1.143,0,1.571l-8.047,8.047h26.554c0.619,0,1.127,0.492,1.127,1.111c0,0.619-0.508,1.127-1.127,1.127H3.813l8.047,8.032c0.429,0.444,0.429,1.159,0,1.587c-0.444,0.444-1.143,0.444-1.587,0l-9.952-9.952c-0.429-0.429-0.429-1.143,0-1.571L10.273,5.009z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                        <span>Rate Calculator</span>
                        <div class="rc-widget-close" onclick="jQuery('.rc-widget-popup').fadeToggle()">X</div>
                    </div>
                </div>
                <div class="rc-widget-poput-body">
                    <div class="rc-widget-popup-body-inner">
                        <div class="row">
                            <div class="rc-col-12">
                                <label for="">State</label>
                                <?php 
                                    global $wpdb;
                                    $stateTable = $wpdb->prefix.'rate_calculator_state';
                                    $results = $wpdb->get_results( "SELECT * FROM ".$stateTable);
                                ?>
                        <select name="state" id="rc-widget-state">
                            <option value="" selected="selected">Select a State</option>
                            <?php foreach($results as $eachState){ 
                                    $countyTable = $wpdb->prefix.'rate_calculator_county';
                                    $resultsCounty = $wpdb->get_results( "SELECT * FROM ".$countyTable." where stateid = ".$eachState->id);
                                    if(!empty($resultsCounty)){
                                ?>
                                <option value="<?=$eachState->id?>"><?=$eachState->name?></option>
                            <?php } }?>
                        </select>
                                <label class="error-validation"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'pix/exclamation-mark.png'; ?>"> Please select a valid State</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="rc-col-12">
                                <label for="">County</label>
                                <div id="for-county">
                                    <select name="state" class="disable-state" id="rc-widget-county" disabled="disabled">
                                        <option value="" selected="selected">Select a County</option>
                                    </select>
                                </div>
                                <label class="error-validation"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'pix/exclamation-mark.png'; ?>"> Please select a valid county</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="rc-col-12">
                                <label for="">Transaction type</label>
                                <select id="rc-widget-transaction">
                                    <option value="Refinance">Refinance</option>
                                    <option value="Purchase">Purchase</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="rc-col-12">
                                <label for="">Loan Amount</label>
                                <div class="input-group-addon">$</div>
                                <input id="rc-widget-loan" class="input-group" type="text" placeholder="Enter amount of new loan(s)">
                                <label class="error-validation"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'pix/exclamation-mark.png'; ?>"> Enter loan amount</label>
                            </div>

                            <div class="rc-col-6" style="display: none">
                                <label for="">Sales Price</label>
                                <div class="input-group-addon">$</div>
                                <input id="rc-widget-sales" class="input-group" type="text" placeholder="Enter amount">
                                <label class="error-validation"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'pix/exclamation-mark.png'; ?>"> Enter sales price</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="rc-col-12">
                                <label for="">Services types</label>
                                <select id="rc-widget-services">
                                    <option value="Title and Escrow">Title & Escrow</option>
                                    <option value="Title">Title</option>
                                    <option value="Escrow">Escrow</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row rc-widget-popup-body-footer">
                        <div class="rc-col-12">
                            <button id="rc-widget-submit" type="button" class="btn btn-primary btn-custom">
                                <span class="rc-widget-submit-text">Calculate</span>
                                <div class="rc-widget-loader" style="display: none;">
                                    <img src="<?php echo plugin_dir_url( __FILE__ ) . "pix/loader.svg"; ?>"
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="rc-widget-poput-result" style="display: none">

                </div>
            </div>

            <div class="rc-widget-openform">
            <span tooltip="GET A QUOTE" flow="left">
                <img src="<?php echo plugin_dir_url( __FILE__ ) . "pix/calculator-icon.svg"; ?>">
            </span>
            </div>
        </div>

        <?php
    }

}
