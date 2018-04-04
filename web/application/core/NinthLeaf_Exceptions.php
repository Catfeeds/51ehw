<?php

/**
 * NinthLeaf_Exceptions 扩展CI_Exceptions
 *
 * 用于跳转安装页面
 *
 * @package DiliCMS
 * @subpackage core
 * @category core
 * @author Clark So
 *
 * @link
 *
 */
class NinthLeaf_Exceptions extends CI_Exceptions{

    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * install Error Handler
     *
     * @param	string	$page		Page URI
     * @param 	bool	$log_error	Whether to log the error
     * @return	void
     */
    public function show_install($page = '', $log_error = TRUE)
    {
        // By default we log this, but allow a dev to skip it
        if ($log_error)
        {
            log_message('error', 'Go to install page: '.$page);
        }

        redirect("_install/install");
        exit(); // EXIT_UNKNOWN_FILE
    }

    // --------------------------------------------------------------------

}