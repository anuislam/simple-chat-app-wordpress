<?php


/**
* my custom function
*/
class assetfunc
{
	protected $wp_prifix;
	function __construct()
	{
		$this->db         = new as_database();
		$this->wp_prifix = 'wp_';
	}

	public function get_image_by_size($post_id, $size_key = false){
		$post = $this->get_post($post_id);
		$ret_data = false;
		if ($post) {
			$img_url = explode('-', $post['post_date']);
			$img_url = array(
				$img_url[0],
				$img_url[1]
				);
			$img_url = implode('/', $img_url).'/';
			if ($post['post_type'] == 'attachment') {
				$attachment_meta = $this->get_post_meta($post_id, '_wp_attachment_metadata', true);
				$attachment_meta = unserialize($attachment_meta);
				if (is_array($attachment_meta) === true) {
					foreach ($attachment_meta['sizes'] as $key => $value) {
						if ($size_key){
							if ($key == $size_key) {
								$ret_data = $img_url.$value['file'];
							}else {
								if ($key == 'thumbnail') {
									$ret_data = $img_url.$value['file'];
								}
							}
						}else {
							if ($key == 'thumbnail') {
								$ret_data = $img_url.$value['file'];
							}
						}
					}
				}				
			}
		}
		return $ret_data;
	}

	public function get_post_meta($post_id, $key = null, $single = false){
		$ret_data = false;
		$data = $this->db->query("SELECT * FROM `".$this->wp_prifix."postmeta` WHERE `post_id` = '".$post_id."'");
		$num = count($data);
		if ($num > 0) {
			if (is_array($data)) {
				foreach ($data as $value) {
					if ($value['meta_key'] == $key) {
						if ($single === true) {
							$ret_data = $value['meta_value'];
							break;
						}else{
							$ret_data[$value['meta_key']] = $value['meta_value'];
						}
					}else{
						$ret_data[$value['meta_key']] = $value['meta_value'];
					}
				}
			}
		}
		return $ret_data;
	}

	public function get_post($post_id){
		$data = $this->db->query("SELECT * FROM `".$this->wp_prifix."posts` WHERE `ID` = '".(int)$post_id."'");
		return isset($data[0]) === true ? $data[0] : false ;
	}

	public function get_user_meta($user_id, $key = '', $single = false){
		$ret_data = false;
		$data = $this->db->query("SELECT * FROM `".$this->wp_prifix."usermeta` WHERE `user_id` = '".(int)$user_id."'");
		$num = count($data);
		if ($num > 0) {
			if (empty($key) === false) {
				foreach ($data as $user_key => $value) {
					if ($value['meta_key'] == $key) {
						if ($single === true) {
							$ret_data = $value['meta_value'];
							break;
						}else{
							$ret_data[$value['meta_key']] = $value['meta_value'];
						}
					}else{
						$ret_data[$value['meta_key']] = $value['meta_value'];
					}
				}
			}
		}
		return $ret_data;
	}

	public function get_user($user_id){
		$data = $this->db->query("SELECT * FROM `".$this->wp_prifix."users` WHERE `ID` = '".(int)$user_id."'");
		return isset($data[0]) === true ? $data[0] : false ;
	}

}