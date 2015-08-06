<?php

/*
Plugin Name: iCKPlayer
Plugin URI: http://chaoyuyan.com/ick
Description: 调用CKplayer解析优酷、土豆等视频网站。使用方法：编辑文章添加[ick]视频地址[/ick]，如[ick]http://v.youku.com/v_show/id_XNzIxODU2NTQw.html[/ick]。如果解析失败请联系作者更新。
Version: 1.0
Author: Jack
Author URI: http://chaoyuyan.com/
*/



add_action( 'admin_menu', 'ickplayer_menu' );
function ickplayer_menu(){
 add_submenu_page( 'plugins.php', 'iCKPlayer Options', 'iCKPlayer设置', 'manage_options', 'ickplayer_menu', 'ickplayer_options' );
}

function ickplayer_options() {

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( '您没有操作权限！' ) );
	}
    $opt_name1 = 'ck_width';
    $opt_name2 = 'ck_height';	
    $hidden_field_name = 'mt_submit_hidden';
    $data_field_name1 = 'ck_width';
    $data_field_name2 = 'ck_height';
    $opt_val1 = get_option( $opt_name1 );
    $opt_val2 = get_option( $opt_name2 );
	
 
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        $opt_val1 = $_POST[ $data_field_name1 ];
        $opt_val2 = $_POST[ $data_field_name2 ];
	

        update_option( $opt_name1, $opt_val1 );
        update_option( $opt_name2, $opt_val2 );
		
?>


<div class="updated"><p><strong>
<?php _e('Settings Saved.', 'menu-test' ); ?>
</strong></p></div>

<?php } 

?>



<div class="wrap">
<h2>iCKPlayer设置</h2>
<!--宽高设置-->
<form name="form1" method="post" action="">

<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p>播放器宽度：
<input type="text" name="ck_width" value="<?php echo get_option('ck_width');?>" size="20">
</p><hr />

<p>播放器高度：
<input type="text" name="ck_height" value="<?php echo get_option('ck_height');?>" size="20">
</p><hr />


<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="OK" />
</p>

</form>





</div>


<?php } 



//短代码




add_shortcode('ick','ckplayer');
add_action('admin_print_footer_scripts', 'ckwoa_add_quicktags' );

function ckplayer($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'0'),$atts));	
	return '<embed name="Player" id="Player" src="http://chaoyuyan.com/v/ckplayer.swf" flashvars="a='.$content.'&p=0" quality="high" width="'.get_option('ck_width').'" height="'.get_option('ck_height').'" align="middle" allowScriptAccess="always" allowFullscreen="true" type="application/x-shockwave-flash"></embed>';
	
}


//添加文本模式下快捷按钮
function ckwoa_add_quicktags() {
?>	

<script type="text/javascript">
QTags.addButton( 'ick', 'iCKPlayer', '[ick][/ick]','' ); 
</script>

<?php } 

?>
