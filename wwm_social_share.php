<?php
/*
Plugin Name: WWM Social Share
Plugin URI: http://www.walkswithme.net
Description: Social Share on Image Hover.
Version: 2.2
Author: Jobin Jose
Author URI: http://www.walkswithme.net/contact-me
*/

add_action('admin_init', 'wwmsocialshare_init' );
add_action('admin_menu', 'wwmsocialshare_add_page');
add_action('wp_enqueue_scripts', 'wwmsocialshare_add_head_content');

if (!defined('MYPLUGIN_THEME_DIR'))
	define('MYPLUGIN_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('MYPLUGIN_PLUGIN_NAME'))
	define('MYPLUGIN_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('MYPLUGIN_PLUGIN_DIR'))
	define('MYPLUGIN_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . MYPLUGIN_PLUGIN_NAME);

if (!defined('MYPLUGIN_PLUGIN_URL'))
	define('MYPLUGIN_PLUGIN_URL', WP_PLUGIN_URL . '/' . MYPLUGIN_PLUGIN_NAME);

// Intializing the plugin options when the plugin data loads on admin
function wwmsocialshare_init(){

	register_setting( 'wwmsocialshare_options', 'wwm_params');

}
//Add the menu Item
function wwmsocialshare_add_page(){
	add_options_page('WWM Social Share', 'WWM Social Share', 'manage_options', 'wwmsocialshare_options', 'wwmsocialshare_do_page');
}
//Add the head content
function wwmsocialshare_add_head_content(){
	$options = get_option('wwm_params');

	if($options['facebook'] && $options['facebook_app_id']){
	/*	$scripts .= '<script type="application/javascript">
			  window.fbAsyncInit = function() {
				// init the FB JS SDK
				FB.init({
				  appId      : "'.$options['facebook_app_id'].'",
          autoLogAppEvents : true,
				  xfbml      : true,
          version          : "v9.0"
				});

			  };';

		if($options['facebook_sdk']){
				$scripts .= ' // Load the SDK asynchronously
				(function(d, s, id){
				 var js, fjs = d.getElementsByTagName(s)[0];
				 if (d.getElementById(id)) {return;}
				 js = d.createElement(s); js.id = id;
				 js.src = "//connect.facebook.net/en_US/all.js";
				 fjs.parentNode.insertBefore(js, fjs);
			   }(document, "script", "facebook-jssdk"));';
		}
      echo $scripts .= '</script>';
    */

  		echo $scripts = '<meta property="fb:app_id" content="'.$options['facebook_app_id'].'" />';
	}

	wp_enqueue_style('wwm_social_share_style',plugins_url().'/'.MYPLUGIN_PLUGIN_NAME.'/css/wwm_custom.css');
	wp_enqueue_script('wwm_social_share_scripts',plugins_url().'/'.MYPLUGIN_PLUGIN_NAME.'/js/wwm_custom.js',array('jquery'));
}
//Show the page
function wwmsocialshare_do_page(){
?>
<style type="text/css">
.javascript-sdk{
	display:none;
	position:absolute;
}
.display_none{
	display:none;
}
.tab_items{
	background: none repeat scroll 0 0 rgb(238, 238, 238);
    border-radius: 5px 5px 0px 0px;
    display: table-cell;
    height: 30px;
    padding: 5px;
    text-align: center;
    vertical-align: middle;
    width: 150px;
	border: 1px solid rgb(204, 204, 204);
	font-weight:bold;
	cursor:pointer;}
.tab_content{
	border:1px solid #EEE;
	padding-bottom: 20px;
}
.tab_items.active{
	background:#CCC;
}
</style>
<script type="application/javascript">
jQuery(document).ready(function(e) {
    jQuery('.wht_this').hover(function(){
		jQuery('.javascript-sdk').show();
	},
	function(){
		jQuery('.javascript-sdk').hide();
	});

jQuery('.tab_items').click(function(){
	jQuery('.tab_items').removeClass('active')
	jQuery(this).addClass('active');
	var ele_id = jQuery(this).attr('id');
	var id_ = new Array();
	id_ = ele_id.split('_');
	jQuery('.tab_content').addClass('display_none');
	jQuery('#tabcontent_'+id_[1]).removeClass('display_none');
})

jQuery('.ex_in_option').click(function(){
	var op_val = jQuery('input:radio[name="wwm_params[exclude_include_class]"]:checked').val();
	if(op_val == 1){
		jQuery('.ex_class').removeClass('display_none');
		jQuery('.in_class').addClass('display_none');
	}else{
		jQuery('.in_class').removeClass('display_none');
		jQuery('.ex_class').addClass('display_none');
	}
});
});

</script>
	<div class="wrap">
		<h2>WWM Social Share</h2>
	 <form method="post" action="options.php">
			<?php settings_fields('wwmsocialshare_options'); ?>
			<?php $options = get_option('wwm_params');

			    if ($options['mode'] == "") $options['mode'] = 1;
          if ($options['facebook'] == "") $options['facebook'] = 1;
			    if ($options['facebook_sdk'] == "") $options['facebook_sdk'] = 1;
			    if ($options['twitter'] == "") $options['twitter'] = 1;
			    if ($options['gplus'] == "") $options['gplus'] = 1;
			    if ($options['pinit'] == "") $options['pinit'] = 1;
				  if ($options['tumblr'] == "") $options['tumblr'] = 1;
			    if ($options['linked'] == "") $options['linked'] = 1;
          if ($options['download'] == "") $options['download'] = 1;
				if ($options['alignment'] == "") $options['alignment'] = 1;
				if ($options['share_width'] == "") $options['share_width'] = 150;
				if ($options['force_fix'] == "") $options['force_fix'] = 0;
				if ($options['short_url'] == "") $options['short_url'] = 1;
				if ($options['exclude_include_class'] == "") $options['exclude_include_class'] = 1;
			 ?>
       <div class="tabs">
       <div id="tab_1" class="tab_items active">
        Basic
       </div>
       <div id="tab_2" class="tab_items">
        Advanced
       </div>
       </div>
       <div id="tabcontent_1" class="tab_content">
       <table class="form-table" width="80%">
       <tr>
        <td> Rendering Method
        </td>
        <td> <input name="wwm_params[mode]" type="radio" value="1" <?php checked(1, $options['mode']); ?> /> PHP  &nbsp;
     <input name="wwm_params[mode]" type="radio" value="0" <?php checked(0, $options['mode']); ?> /> Java Script
        </td>
       </tr>
       <tr>
       <td  width="25%">
       Enable FaceBook
       </td>
       <td width="40%">
       <input name="wwm_params[facebook]" type="radio" value="1" <?php checked(1, $options['facebook']); ?> /> Yes &nbsp;
	   <input name="wwm_params[facebook]" type="radio" value="0" <?php checked(0, $options['facebook']); ?> /> No
      </td>
        <td width="30%" style="position:absolute;"><strong>Documentaion & Support</strong>
      <br/><a href="http://www.walkswithme.net/social-share-icons-on-image-hover" target="_blank">
      <img src="<?php echo MYPLUGIN_PLUGIN_URL;?>/images/walkswithme.png" alt="walkswithme" /></a>
      <br/>
      <a href="http://www.walkswithme.net/social-share-icons-on-image-hover" target="_blank"><strong>Integration</strong></a> &nbsp; <a href="http://www.walkswithme.net/social-share-icons-on-image-hover" target="_blank"><strong>Demo</strong></a> &nbsp; <a href="http://www.walkswithme.net/social-share-icons-on-image-hover" target="_blank"><strong>Support</strong></a>
      <br/>
      How this plugin works ?
      Social share buttons tooks the share details from meta tags (<strong>og:title,og:description,og:image</strong>), If your meta tags are empty it will tooks the Page Title as share title.
      Also the current image(hover one) is not able to share due to any reason it tooks the image from <strong>og:image</strong> tag.
      <br/><br/>
      The <strong>Version 2.0</strong> introduced a new feature called Rendering method with this options. You will be able to choose plugin rendering via JavaScript or PHP. When you choose JS this will enable lot of more features with the plugin , you can integrate with Gallery plugins, featured images faster page loading etc.
      <br/>

      </td>
      </tr>
      <tr>
       <td>
       Load FaceBook SDK (JS)
       </td>
       <td>
       <input name="wwm_params[facebook_sdk]" type="radio" value="1" <?php checked(1, $options['facebook_sdk']); ?> /> Yes &nbsp;
	   <input name="wwm_params[facebook_sdk]" type="radio" value="0" <?php checked(0, $options['facebook_sdk']); ?> /> No
       <a href="#" class="wht_this" title="FaceBook JavaScript SDK may already be loaded in your template, so you can avoid it loading again by using this options. If you are not aware of this Just make Yes.">What is this ?</a>
       <span class="javascript-sdk"><img src="<?php echo MYPLUGIN_PLUGIN_URL;?>/images/javascript-sdk.png"/></span>
      </td>
      <td></td>
      </tr>
      <tr>
       <td>
       FaceBook APP ID
       </td>
       <td>
      <input name="wwm_params[facebook_app_id]" type="text" value="<?php echo $options['facebook_app_id'];?>" />
       <a href="https://developers.facebook.com/apps" target="_blank">Create Facebook APP</a> and get the ID
      </td> <td></td>
      </tr>
       <tr>
       <td>
       Enable Twitter
       </td>
       <td>
       <input name="wwm_params[twitter]" type="radio" value="1" <?php checked(1, $options['twitter']); ?> /> Yes &nbsp;
	   <input name="wwm_params[twitter]" type="radio" value="0" <?php checked(0, $options['twitter']); ?> /> No
      </td> <td></td>
      </tr>
       <tr>
       <td>
       Enable Gplus
       </td>
       <td>
       <input name="wwm_params[gplus]" type="radio" value="1" <?php checked(1, $options['gplus']); ?> /> Yes &nbsp;
	   <input name="wwm_params[gplus]" type="radio" value="0" <?php checked(0, $options['gplus']); ?> /> No
      </td> <td></td>
      </tr>
       <tr>
       <td>
       Enable Pinterest
       </td>
       <td>
       <input name="wwm_params[pinit]" type="radio" value="1" <?php checked(1, $options['pinit']); ?> /> Yes &nbsp;
	   <input name="wwm_params[pinit]" type="radio" value="0" <?php checked(0, $options['pinit']); ?> /> No
      </td> <td></td>
      </tr>
       <tr>
       <td>
       Enable Tumblr
       </td>
       <td>
       <input name="wwm_params[tumblr]" type="radio" value="1" <?php checked(1, $options['tumblr']); ?> /> Yes &nbsp;
	   <input name="wwm_params[tumblr]" type="radio" value="0" <?php checked(0, $options['tumblr']); ?> /> No
      </td> <td></td>
      </tr>
       <tr>
       <td>
       Enable LinkedIn
       </td>
       <td>
       <input name="wwm_params[linked]" type="radio" value="1" <?php checked(1, $options['linked']); ?> /> Yes &nbsp;
	   <input name="wwm_params[linked]" type="radio" value="0" <?php checked(0, $options['linked']); ?> /> No
      </td> <td></td>
      </tr>
       <tr>
       <td>
       Enable Download
       </td>
       <td>
       <input name="wwm_params[download]" type="radio" value="1" <?php checked(1, $options['download']); ?> /> Yes &nbsp;
     <input name="wwm_params[download]" type="radio" value="0" <?php checked(0, $options['download']); ?> /> No
      </td> <td></td>
      </tr>
       <tr>
       <td>
       Share Button Alignment
       </td>
       <td>
       <input name="wwm_params[alignment]" type="radio" value="1" <?php checked(1, $options['alignment']); ?> /> Top Left &nbsp;
	   <input name="wwm_params[alignment]" type="radio" value="2" <?php checked(2, $options['alignment']); ?> /> Top Right &nbsp;
       <input name="wwm_params[alignment]" type="radio" value="3" <?php checked(3, $options['alignment']); ?> /> Bottom Left &nbsp;
       <input name="wwm_params[alignment]" type="radio" value="4" <?php checked(4, $options['alignment']); ?> /> Bottom Right &nbsp;
      </td> <td></td>
      </tr>
        <tr>
       <td>
      Share Options Disable Under X Width(In Pixel if JS mode)
       </td>
       <td>
       <input name="wwm_params[share_width]" type="text" value="<?php echo $options['share_width'];?>" />

      </td> <td></td>
      </tr>
       <tr>
       <td>
      Force Alignment Fix<a href="javascript:;" title="Some template may break the aligment of the share button when you align the image to centre or right side .Only this case you can use this option to Yes. If its not break the alignment leave this option as NO." > (?)</a>
       </td>
       <td>
       <input name="wwm_params[force_fix]" type="radio" value="1" <?php checked(1, $options['force_fix']); ?> /> Yes &nbsp;
	   <input name="wwm_params[force_fix]" type="radio" value="0" <?php checked(0, $options['force_fix']); ?> /> No
      </td> <td></td>
      </tr>
     	<tr>
    	 <td colspan="2" align="left">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	   </td>
       </tr>
      </table>
       </div>
       <div id="tabcontent_2" class="display_none tab_content">
       <table class="form-table" width="80%">
        <tr>
         <td>
          Enable Short URL
         </td>
         <td>
         <input name="wwm_params[short_url]" type="radio" value="1" <?php checked(1, $options['short_url']); ?> /> Yes &nbsp;
	     <input name="wwm_params[short_url]" type="radio" value="0" <?php checked(0, $options['short_url']); ?> /> No
         </td>
         </tr>
          <tr>
         <td>
         Google API Key
         </td>
         <td>
          <input name="wwm_params[google_key]" type="text" value="<?php echo $options['google_key']; ?>" />
          <a href="https://console.developers.google.com/project/" target="_blank">Create Google App</a> and get the Key
         </td>
         </tr>
          <tr>
         <td>
          Exlcude/Include
         </td>
         <td>
         <input name="wwm_params[exclude_include_class]" class="ex_in_option" type="radio" value="1" <?php checked(1, $options['exclude_include_class']); ?> /> Exlcude Class &nbsp;
	     <input name="wwm_params[exclude_include_class]" class="ex_in_option" type="radio" value="0" <?php checked(0, $options['exclude_include_class']); ?> /> Include class
         <br/>[How this works: <br />
         		1)When you choose exclude option the share icons do not appear on those classes or images.
         <br/>  2)When you choose include options the share icons only appear on those classes.]
         </td>
         <?php if($options['exclude_include_class'] == 1){
		 			$ex_class = "";
					$in_class = "display_none";
				 }else{
					$ex_class = "display_none";
					$in_class = "";
				 }
		 ?>
         </tr>
         <tr class="in_class <?php echo $in_class;?>">
         <td>
          Include Class
         </td>
         <td>
          <textarea name="wwm_params[include_class]" rows="5" cols="60"><?php echo $options['include_class']; ?></textarea>
          <br/>comma separated values(eg:demo,smily,item-image )
         </td>
         </tr>
          <tr class="ex_class <?php echo $ex_class;?>">
         <td>
          Exlcude Class
         </td>
         <td>
          <textarea name="wwm_params[exclude_class]" rows="5" cols="60"><?php echo $options['exclude_class']; ?></textarea>
          <br/>comma separated values(eg:demo,smily,item-image )
         </td>
         </tr>
          <tr class="ex_class <?php echo $ex_class;?>">
         <td>
          Exclude Image
         </td>
         <td>
          <textarea name="wwm_params[exclude_image]"  rows="5" cols="60"><?php echo $options['exclude_image']; ?></textarea>
           <br/>comma separated values(eg:demo.png,smily.jpg,item-image.gif)
         </td>
         </tr>
         </tr>
     	<tr>
    	 <td colspan="2" align="left">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	   </td>
       </tr>
       </table>
       </div>
    </form>

    </div>
<?php }
function wwmsocialshare_contentrender($content){

	$content = do_shortcode($content);

	$options = get_option('wwm_params');

	if($options['short_url']){
		$dir = plugin_dir_path( __FILE__ );
		require_once($dir.'lib/GoogleApi.php');
		$GoogleApi = new GoogleUrlApi($options['google_key']);
		$pageUrl   = site_url().$_SERVER['REQUEST_URI'];
		$short_url = $GoogleApi->shorten($pageUrl);
	}else{
		$short_url = '';
	}

	if($options['force_fix'] == 1){
		$alignment_fix = '<input type="hidden" id="force_fix" value="1" />';
	}else{
		$alignment_fix = '<input type="hidden" id="force_fix" value="0" />';
	}

	switch($options['alignment']){
		case 1 :
				 $align_class = 'wwm_top_left';
				 break;
		case 2 :
				 $align_class = 'wwm_top_right';
				 break;
		case 3 :
				 $align_class = 'wwm_bottom_left';
				 break;
		case 4 :
				 $align_class = 'wwm_bottom_right';
				 break;
		default :
				 $align_class = 'wwm_top_left';
				 break;
	}

   $ul = '<ul class="wwm_social_share '.$align_class.'">';
   if($options['facebook'])
   		$ul .= '<li class="wwm_facebook"></li>';
   if($options['twitter'])
   		$ul .= '<li class="wwm_twitter"></li>';
   if($options['gplus'])
   		$ul .= '<li class="wwm_gplus"></li>';
   if($options['pinit'])
   		$ul .= '<li class="wwm_pinit"></li>';
	if($options['tumblr'])
   		$ul .= '<li class="wwm_tumblr"></li>';
	if($options['linked'])
   		$ul .= '<li class="wwm_linked"></li>';
  if($options['download'])
      $ul .= '<li class="wwm_download"></li>';
	$ul .= '</ul><input type="hidden" id="wwm_short_url" value="'.$short_url.'"/>'.$alignment_fix;
   if($options['linked'] || $options['pinit'] || $options['gplus'] || $options['tumblr'] || $options['twitter'] || $options['facebook'])
   		$hidden_ul = $ul;
	else
		$hidden_ul = '';



	if(trim($content)!='' && $options['mode'] == 1){
		libxml_use_internal_errors(true);
		$dom = new DOMDocument();

		$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
		$new_div = $dom->createElement('div');
		$new_div->setAttribute('class','wwm_socialshare_imagewrapper');
		$ImageList = $dom->getElementsByTagName('img');

		if(trim($options['exclude_class']) && $options['exclude_include_class'] == 1){
			$exclude_class = explode(',',$options['exclude_class']);
		}else{
			$exclude_class = array();
		}
		if(trim($options['include_class']) && $options['exclude_include_class'] == 0){
			$include_class = explode(',',$options['include_class']);
		}else{
			$include_class = array();
		}
		if(trim($options['exclude_image']) && $options['exclude_include_class'] == 1){
			$exclude_image = explode(',',$options['exclude_image']);

		}else{
			$exclude_image = array();
		}

		foreach($ImageList as $key => $Image)
		{
			$ImgClass = explode(' ',$Image->getAttribute('class'));
			$fileDetails =  pathinfo($Image->getAttribute('src'));
			$matchme = $fileDetails['basename'];

			//echo "Ex-->".count(array_intersect($exclude_class, $ImgClass))."In-->".count(array_intersect($include_class, $ImgClass));
			if(((int)$Image->getAttribute('width') > 0 && (int)$Image->getAttribute('width') < $options['share_width']) ||
			    (count(array_intersect($exclude_class, $ImgClass)) !== 0 || in_array($matchme,$exclude_image) && $options['exclude_include_class'] == 1) ||
				(count(array_intersect($include_class, $ImgClass)) === 0 && $options['exclude_include_class'] == 0)
				){
				//First check the width condition
				//checked the exclude image and class options
				//checked the include image option
				//echo "Skip";
				//skip adding class
			}else{

				//echo "Show me";
				if($Image->parentNode->nodeName === 'a')
				{
					$class_names = $Image->parentNode->getAttribute('class');
					$Image->parentNode->setAttribute('class',$class_names.' wwm_socialshare_imagewrapper ');

				}else{

					$new_div_clone = $new_div->cloneNode();
					$Image->parentNode->replaceChild($new_div_clone,$Image);
					$new_div_clone->appendChild($Image);

				}
			}
		}


	//Fixed the issue with additional html tags loading

	$content = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
	}else if($options['mode'] == 0){


    $hidden_ul .= '<input type="hidden" id="exclude_include_class" value="'.$options['exclude_include_class'].'"/>';
    $hidden_ul .= '<input type="hidden" id="exclude_class" value="'.$options['exclude_class'].'"/>';
    $hidden_ul .= '<input type="hidden" id="exclude_image" value="'.$options['exclude_image'].'"/>';
    $hidden_ul .= '<input type="hidden" id="include_class" value="'.$options['include_class'].'"/>';
    $hidden_ul .= '<input type="hidden" id="share_width" value="'.$options['share_width'].'"/>';

  }
   $hidden_ul .= '<input type="hidden" id="wwm_mode" value="'.$options['mode'].'"/>';
   // return the processed content
   return $content.$hidden_ul;

}

add_filter('the_content', 'wwmsocialshare_contentrender');

/* Adding action links on plugin list*/
function wwmsocialshare_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=wwmsocialshare_options">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}

add_filter('plugin_action_links', 'wwmsocialshare_action_links', 10, 2);
?>
