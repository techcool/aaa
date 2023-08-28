<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://authoritypartners.com/
 * @since      1.0.0
 *
 * @package    Rate_Calculator
 * @subpackage Rate_Calculator/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

    function delete_county($id) {
        global $wpdb;
        
        $table_county = $wpdb->prefix.'rate_calculator_county';
        $table_recording_fee = $wpdb->prefix.'rate_calculator_recording_fee';

        $wpdb->delete( $table_recording_fee, array( 'countyid' => $id ) );
        $wpdb->delete( $table_county, array( 'id' => $id ) );
    }

    if(isset($_REQUEST['method1']))
    {
        $method = $_REQUEST['method1'];
        $record = $_REQUEST['deleteId'];

        delete_county($record);
    }

?>


<div class="wrap">

    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <h2 class="nav-tab-wrapper"></h2>

<div class="display-code">
    <b>Short Code: [rate-calculator]</b>
</div>
</div>

<!-- Loader-->
<!-- <div class="loader" style="display: none;"></div> -->
<!--Upload Form-->


<p></p>
<div class="fee-wrap">
    <div class="msg-save" style="display: none;"></div>
    <form id="rcfeeform" method="post" name="cleanup_options" action="options.php">
    <?php
        //Grab all options

        $options = get_option($this->plugin_name);

        // Rate Calculator
        $disablewidget = $options['disablewidget'];
        $notaryfee = $options['notaryfee'];
        $affordable_housing_act = $options['affordable_housing_act'];
        $place_order_link = $options['place_order_link'];
    ?>

    <?php
        settings_fields( $this->plugin_name );
        do_settings_sections( $this->plugin_name );
    ?>
        <div class="rcfeeform-wrap">
            <label>Popup Widget</label>
            <fieldset>                
                <label for="<?php echo $this->plugin_name;?>-widget">
                    <input type="checkbox" id="<?php echo $this->plugin_name;?>-disablewidget" name="<?php echo $this->plugin_name;?>[disablewidget]" value="1" <?php checked( $disablewidget, 1 ); ?> />
                    <span><?php esc_attr_e( 'Disable widget calculator', $this->plugin_name ); ?></span>
                </label>
            </fieldset>
        </div>
        <div class="rcfeeform-wrap">
            <label>Notary Fee </label>
            <input type="number" id="<?php echo $this->plugin_name;?>-notaryfee" name="<?php echo $this->plugin_name;?>[notaryfee]" value="<?=$notaryfee?>" > 
        </div>
        <div class="rcfeeform-wrap">
           <label>Affordable Housing Act </label>
           <input type="number" id="<?php echo $this->plugin_name;?>-affordable_housing_act" name="<?php echo $this->plugin_name;?>[affordable_housing_act]" value="<?=$affordable_housing_act?>" >
        </div>
        <div class="rcfeeform-wrap">
           <label>place order link </label>
           <input type="text" id="<?php echo $this->plugin_name;?>-place_order_link" name="<?php echo $this->plugin_name;?>[place_order_link]" value="<?=$place_order_link?>" >
        </div>
        <div class="rcfeeform-wrap">
            <?php submit_button(__('Save Changes', $this->plugin_name), 'primary','submit', TRUE); ?>
        </div>
    </form>

</div>
<form action="#" method="post" enctype="multipart/form-data" id="rcform">
    <div class="rc_wrap">
         <h2>Excel Upload Form</h2>
         <div class="rc_inner">
             <p>Choose an Excel file to upload.</p>
             <input type="file" name="rcfile" class="rcfile">
         </div>
         <div class="upload-erre" style="display: none"><p style="color: #red;">Please upload valid file.</p></div>   
         <input type="submit" name="submit" value="Upload" id="rcupload">   
        
    </div>
    
        
        

</form>
<!--Save Data -->
<div class="table-wrap">
<?php 
    global $wpdb;
    $stateTable = $wpdb->prefix.'rate_calculator_state';
    $resultsState = $wpdb->get_results( "SELECT * FROM ".$stateTable);
    $i = 1;
    foreach($resultsState as $eachState){
        $countyTable = $wpdb->prefix.'rate_calculator_county';
        $resultsCounty = $wpdb->get_results( "SELECT *, id as countyId FROM ".$countyTable." where stateid = ".$eachState->id);
        if(!empty($resultsCounty)){  
            foreach($resultsCounty as $eachCounty){
                $resultArr[$i]['state'] =  $eachState->name;
                $resultArr[$i]['county'] =  $eachCounty->name;
                $resultArr[$i]['countyId'] =  $eachCounty->countyId;
                $feeTable = $wpdb->prefix.'rate_calculator_recording_fee';
                $resultsFee = $wpdb->get_results( "SELECT * FROM ".$feeTable." where countyid = ".$eachCounty->id);
                $resultArr[$i]['fee'] = $resultsFee[0]->value;
                $resultArr[$i]['feeId'] = $resultsFee[0]->id;
                $i++;
            }
        }
    }
?>
<?php if(!empty($resultArr)){ ?>
<button class="accordion"><b>Saved Data</b></button>
<div class="panel">
<table id="allRcSaveData" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>State</th>
            <th>County</th>
            <th>Fee</th>
            <th>Action</th>
        </tr>   
    </thead>
    <tbody>
        <?php 
        $nulClass = '';
                foreach ($resultArr as $key => $each) {
                    $state = $each['state'];
                    $county = $each['county'];
                    $fee = $each['fee'];

                    if($each['countyId'] != "")
                    {
                    ?>
                    <tr id="<?=$nulClass?>">
                        <td><?=$state?></td>
                        <td><?=$county?></td>
                        <td><?=$fee?></td> 
                        <td>
                            <form id="deleteOptionForm" action="#" method="post" enctype="multipart/form-data" >
                                <input type="hidden" name="method1" value="delete" />
                                <input type="hidden" name="deleteId" value="<?= $each['countyId'] ?>" />
                                <button class="btn btn-sm btn-primary" onclick="deleteOption()">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    } 
                }
        ?>
    </tbody>    
</table>
</div>
<?php } ?>
</div>
<!-- Fetch Data From EXCEL-->
<div class="put-data-wrap" >
    <div class="loader-wrap" style="display: none;">
       <div class="loader" ></div>
    </div>
    <div class="put-data"></div>

</div>

<script type="text/javascript">
    function deleteOption(){
        jQuery('#deleteOptionForm').submit();
        
    }

</script>