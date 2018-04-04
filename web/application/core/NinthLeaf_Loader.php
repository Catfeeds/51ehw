<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

    // ------------------------------------------------------------------------

/**
 * Loader 扩展CI_Loader
 *
 * 用于支持多皮肤
 *
 * @package 9thleaf
 * @subpackage core
 * @category core
 * @author Clark So
 *
 * @link
 *
 */

class NinthLeaf_Loader extends CI_Loader
{

    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->add_package_path(SUITEPATH . SUITE);
    }

    // ------------------------------------------------------------------------

    /**
     * 切换视图路径
     *
     * @access public
     * @return void
     */
    public function switch_theme($theme = 'default')
    {

        $this->_ci_view_paths = array(
            SUITEPATH . SUITE. '/views/' . $theme . '/' => TRUE
        );
    }

    // ------------------------------------------------------------------------
}

/* End of file My_Loader.php */
/* Location: ./application/core/My_Loader.php */