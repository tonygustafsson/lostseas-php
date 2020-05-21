<?php

/* ---------------------------
Automatically loads the top and bottom of the HTML code
if the request is not of AJAX type
-- --------------------------*/

class MY_Loader extends CI_Loader
{
    public function view_ajax($view, $vars = array(), $return = false)
    {
        //Get instance
        $CI =& get_instance();

        if ($CI->input->is_ajax_request() !== true) {
            //If its not an AJAX request, load the HTML top
            $town = (isset($vars['game']['town'])) ? $vars['game']['town'] : false;
            $place = ($CI->uri->segment(1) != "") ? $CI->uri->segment(1) : 'Presentation';
            $vars['page_title'] = $this->url_to_title($town, $place, $CI->uri->segment(2)) . ' - ' . $CI->config->item('site_name');
            $this->_ci_load(array('_ci_view' => 'html_top', '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
        }

        //Load the normal page requested
        $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));

        if ($CI->input->is_ajax_request() !== true) {
            //If its not an AJAX request, load the HTML bottom
            $this->_ci_load(array('_ci_view' => 'html_bottom', '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
        }
    }

    public function url_to_title($town, $place, $subplace = false)
    {
        $town_places = array('shop', 'tavern', 'cityhall', 'bank', 'shipyard', 'market', 'harbor');
        
        if (in_array($place, $town_places)) {
            $title = ucwords($town) . 's ' . $place;
        } else {
            $title = ($subplace === false) ? ucwords($place) : ucwords(str_replace("_", " ", $subplace));
        }

        return $title;
    }
}

/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */
