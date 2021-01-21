<?php
add_action('add_meta_boxes', function(){  add_meta_box('my-metaboxx1', 'Page Banner','func99999', 'page','side','high'); }, 9);
function func99999($post){ 
    $url =get_post_meta($post->ID,'my-image-for-post', true);   ?>
    <input id="my_image_URL" name="my_image_URL" type="hidden" value="<?php echo $url;?>"  style="width:400px;" />
    <img src="<?php echo $url;?>" style="width:100%;" id="picsrc" />
    <script>
    jQuery(document).ready( function( $ ) {
        $(document).ready( function() {
	var file_frame; // variable for the wp.media file_frame
	
	// attach a click event (or whatever you want) to some element on your page
	$( '#picsrc' ).on( 'click', function( event ) {
		event.preventDefault();

        // if the file_frame has already been created, just reuse it
		if ( file_frame ) {
			file_frame.open();
			return;
		} 

		file_frame = wp.media.frames.file_frame = wp.media({
			title: $( this ).data( 'uploader_title' ),
			button: {
				text: $( this ).data( 'uploader_button_text' ),
			},
			multiple: false // set this to true for multiple file selection
		});

		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();

			// do something with the file here
			//$( '#frontend-button' ).hide();
            $('#my_image_URL').val(attachment.url);
			$( '#picsrc' ).attr('src', attachment.url);
		});

		file_frame.open();
	});
});

    });
    </script>
<?php
}


add_action( 'save_post', function ($post_id) {
    if (isset($_POST['my_image_URL'])){
        update_post_meta($post_id, 'my-image-for-post',$_POST['my_image_URL']);
    }
});

?>
