<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woo_user_suggest_image
 * @subpackage Woo_user_suggest_image/public/partials
 */

 
if(isset($_POST['submit_suggest_image'])) {
    if ( isset( $_FILES['upload_suggest_image'] ) ) {
        $errors    = array();
        $file_name = isset( $_FILES['upload_suggest_image']['name'] ) ? sanitize_text_field( $_FILES['upload_suggest_image']['name'] ) : '';
        $file_size = isset( $_FILES['upload_suggest_image']['size'] ) ? sanitize_text_field( $_FILES['upload_suggest_image']['size'] ) : '';
        $file_tmp  = isset( $_FILES['upload_suggest_image']['tmp_name'] ) ? sanitize_text_field( $_FILES['upload_suggest_image']['tmp_name'] ) : '';
        $file_type = isset( $_FILES['upload_suggest_image']['type'] ) ? sanitize_text_field( $_FILES['upload_suggest_image']['type'] ) : '';
        $file_ext  = strtolower( end( explode( '.', $_FILES['upload_suggest_image']['name'] ) ) );
        // echo $file_name;
        // global $post;
        // echo '-----------------<br>';
        // echo get_the_ID();
    
        // echo 'saghdfjasbkd';
    
        $extensions = array( 'JPEG', 'PNG' , 'PDF', 'png', 'jpeg', 'pdf');
    
        if ( in_array( $file_ext, $extensions ) === false ) {
        	$errors[] = sanitize_text_field( 'extension not allowed, please choose a image or a PDF file.' );
        }
    
        if ( empty( $errors ) == true ) {
        	$upload      = wp_upload_dir();
        	$upload_dir  = $upload['basedir'];
        	$data_exists = $upload_dir . '/user_suggestion_images/user_suggestion_images' . $file_name;
        	if ( file_exists( $data_exists ) ) {
        		$errors[] = 'File Already Exists';
        	} else {
        		move_uploaded_file( $file_tmp, $upload_dir . '/user_suggestion_images/user_suggestion_images' . $file_name );
    //     		$data = array();
    //     		$data = get_option( 'user_suggestion_images' );
    //     		if ( ! empty( $data ) ) {
    //     			$data[] = array( 'file_name' => $file_name );
    //     		} else {
    //     			$data[0] = array( 'file_name' => $file_name );
    //     		}
              
        		update_post_meta( get_the_ID(),'user_suggestion_images', $file_name );
        		echo '<div style="background-color:green; color:white;padding:10px;">Successfully Inserted</div>';
    
        	}
        }
    }
}


?>




<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id='upload_file_content' style = "border:1px solid black;">
    <div id= 'title_content' >
         Hey if you want to suggest some image 
        plese upload here 
    </div> 
    <div id = 'form'>
        <form method="post" action="" enctype="multipart/form-data" id="myform">
            <input type="file" id = 'upload_suggest_image' name ='upload_suggest_image' accept="image/*"> 
            <input type="submit" name = 'submit_suggest_image' id = 'submit_suggest_image'>
        </form>
    </div>
   
    <?php 
     if(!empty($errors)) {
        print_r($errors);
     }
    ?>
</div>