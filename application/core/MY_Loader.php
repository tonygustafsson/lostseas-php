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

        $page_title = $this->url_to_title($vars);

        if ($CI->input->is_ajax_request()) {
            if (isset($vars['json'])) {
                $data['manipulateDom'] = $vars['json'];
            }
            $data['title'] = $page_title;
            $data['content'] = $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => true));
            echo json_encode($data);
        } else {
            $vars['page_title'] = $page_title;
            $this->_ci_load(array('_ci_view' => 'html_top', '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
            $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
            $this->_ci_load(array('_ci_view' => 'html_bottom', '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
        }
    }

    public function url_to_title($vars)
    {
        $CI =& get_instance();

        $town = (isset($vars['game']['town'])) ? $vars['game']['town'] : false;
        $place = $CI->uri->segment(1);
        $sub_place = $CI->uri->segment(2);
        $place2 = (isset($vars['game']['place'])) ? $vars['game']['place'] : false;

        $town_places = array('shop', 'tavern', 'cityhall', 'bank', 'shipyard', 'market', 'dock', 'harbor');
        
        if (in_array($place, $town_places)) {
            return ucwords($town) . 's ' . $place  . ' - ' . $CI->config->item('site_name');
        }

        if ($place && $sub_place) {
            return ucwords($sub_place) . ' - ' . ucwords($place) . ' - ' . $CI->config->item('site_name');
        }

        return ucwords($place) . ' - ' . $CI->config->item('site_name');
    }
}

/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */
