<?php
// --------------------------------------------------
// 全局控制器
// --------------------------------------------------
class Ctcms_Controller extends CI_Controller {
	function __construct() {
		parent::__construct();
		header(base64decode('WC1HZW5lcmF0b3I6IEN0Y21zIChodHRwOi8vd3d3LmN0Y21zLmNuKQ'));
	}
}
