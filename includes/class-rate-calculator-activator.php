<?php

/**
 * Fired during plugin activation
 *
 * @link       https://authoritypartners.com/
 * @since      1.0.0
 *
 * @package    Rate_Calculator
 * @subpackage Rate_Calculator/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Rate_Calculator
 * @subpackage Rate_Calculator/includes
 * @author     Authority Partners <hello@authoritypartners.com>
 */
class Rate_Calculator_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        (new self)->rate_calculator_create_db();
	}

    public function rate_calculator_create_db() {

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
    	$table_rc_state = $wpdb->prefix . 'rate_calculator_state';
    	$table_rc_county = $wpdb->prefix . 'rate_calculator_county';
    	$table_rc_recording_fee = $wpdb->prefix . 'rate_calculator_recording_fee';
    	$table_rc_status = $wpdb->prefix . 'rate_calculator_status';
    	$table_rc_calculator = $wpdb->prefix . 'rate_calculator';
    	$table_rc_address = $wpdb->prefix . 'rate_calculator_address';

	    $queries  = [   "CREATE TABLE IF NOT EXISTS $table_rc_state (
	                                                id INT NOT NULL AUTO_INCREMENT,
	                                                name TEXT NOT NULL,
	                                                PRIMARY KEY (id)
	                                                )$charset_collate;",
	                    "CREATE TABLE IF NOT EXISTS $table_rc_county (
	                                                id INT NOT NULL AUTO_INCREMENT,
	                                                stateid INT NOT NULL,
	                                                name TEXT NOT NULL,
	                                                PRIMARY KEY (id),
	                                                FOREIGN KEY  (stateid) REFERENCES $table_rc_state(id)
	                                                )$charset_collate;",
	                    "CREATE TABLE IF NOT EXISTS $table_rc_recording_fee (
	                                                id INT NOT NULL AUTO_INCREMENT,
	                                                countyid INT NOT NULL,
	                                                value DECIMAL NOT NULL,
	                                                PRIMARY KEY (id),
	                                                FOREIGN KEY  (countyid) REFERENCES $table_rc_county(id)
	                                                )$charset_collate;",
	                    "CREATE TABLE IF NOT EXISTS $table_rc_status (
	                                                id INT NOT NULL AUTO_INCREMENT,
	                                                status boolean not null default 0,
	                                                PRIMARY KEY (id)
	                                                )$charset_collate;",
	                    "CREATE TABLE IF NOT EXISTS $table_rc_calculator (
													id mediumint(9) NOT NULL AUTO_INCREMENT,
													loan_amount VARCHAR(255) NOT NULL DEFAULT '0',
													sales_amount VARCHAR(255),
											        transaction VARCHAR(255) NOT NULL,
											        p_address VARCHAR(255),
											        services VARCHAR(255) NOT NULL,
											        timecreated timestamp NOT NULL DEFAULT current_timestamp(),
											        PRIMARY KEY(id),
													UNIQUE KEY id (id)
												) $charset_collate;" ,  
						"CREATE TABLE IF NOT EXISTS $table_rc_address (
													id mediumint(9) NOT NULL AUTO_INCREMENT,
													state VARCHAR(255) NOT NULL,
													name VARCHAR(255) NOT NULL,
											        PRIMARY KEY(id),
													UNIQUE KEY id (id)
												) $charset_collate;"                                              
	                ];

    	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
	    foreach($queries as $sql ){     
	        dbDelta($sql);
	    }      
    }
    
}
