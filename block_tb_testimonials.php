<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Testimonials View Block
 *
 * @package    block_tb_testimonials
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @author     Leeloo LXP <info@leeloolxp.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

/**
 * Testimonials View Block
 *
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @author     Leeloo LXP <info@leeloolxp.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_tb_testimonials extends block_base {

    /**
     * Block initialization
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_tb_testimonials');
    }

    /**
     * Block Config Allow
     */
    public function instance_allow_config() {
        return true;
    }

    /**
     * Block allow multiple instance
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Return contents of tb_testimonials block
     *
     * @return stdClass contents of block
     */
    public function get_content() {

        if ($this->content !== null) {
            return $this->content;
        }

        $leeloolxplicense = get_config('block_tb_testimonials')->license;

        $url = 'https://leeloolxp.com/api_moodle.php/?action=page_info';
        $postdata = '&license_key=' . $leeloolxplicense;

        $curl = new curl;

        $options = array(
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HEADER' => false,
            'CURLOPT_POST' => count($postdata),
        );

        if (!$output = $curl->post($url, $postdata, $options)) {
            $this->content->text = get_string('nolicense', 'block_tb_testimonials');
            return $this->content;
        }

        $infoleeloolxp = json_decode($output);

        if ($infoleeloolxp->status != 'false') {
            $leeloolxpurl = $infoleeloolxp->data->install_url;
        } else {
            $this->content->text = get_string('nolicense', 'block_tb_testimonials');
            return $this->content;
        }

        $url = $leeloolxpurl . '/admin/Theme_setup/get_testimonials';

        $postdata = '&license_key=' . $leeloolxplicense;

        $curl = new curl;

        $options = array(
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_HEADER' => false,
            'CURLOPT_POST' => count($postdata),
        );

        if (!$output = $curl->post($url, $postdata, $options)) {
            $this->content->text = get_string('nolicense', 'block_tb_testimonials');
            return $this->content;
        }

        $resposedata = json_decode($output);
        $settingleeloolxp = $resposedata->data->testimonials_data;

        if (empty($settingleeloolxp->tst_block_title)) {
            $title = get_string('displayname', 'block_tb_testimonials');
        } else {
            $title = $settingleeloolxp->tst_block_title;
        }

        $this->title = $title;
        $this->content = new stdClass();

        $this->content->text = $this->get_testimonialcontent($settingleeloolxp);

        $this->content->footer = '';

        return $this->content;
    }

    /**
     * Generate HTML for Testimonial
     *
     * @param string $settingleeloolxp Settings from LeelooLXP
     * @return string
     */
    public function get_testimonialcontent($settingleeloolxp) {
        $htmltestimonial = '<div class="tb_testimonials">';

        $htmltestimonial .= '<div id="testimonial_box1" class="testimonial_box">';

        $htmltestimonial .= '<div class="testimonial_img">';
        $htmltestimonial .= '<img src="' . $settingleeloolxp->testimonials_1_img . '"/>';
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div class="testimonial_title">';
        $htmltestimonial .= $settingleeloolxp->testimonials_1_txt;
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div class="testimonial_des">';
        $htmltestimonial .= $settingleeloolxp->testimonials_1_cn;
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div class="testimonial_pos">';
        $htmltestimonial .= $settingleeloolxp->testimonials_1_cp;
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div id="testimonial_box2" class="testimonial_box">';

        $htmltestimonial .= '<div class="testimonial_img">';
        $htmltestimonial .= '<img src="' . $settingleeloolxp->testimonials_2_img . '"/>';
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div class="testimonial_title">';
        $htmltestimonial .= $settingleeloolxp->testimonials_2_txt;
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div class="testimonial_des">';
        $htmltestimonial .= $settingleeloolxp->testimonials_2_cn;
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div class="testimonial_pos">';
        $htmltestimonial .= $settingleeloolxp->testimonials_2_cp;
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div id="testimonial_box3" class="testimonial_box">';

        $htmltestimonial .= '<div class="testimonial_img">';
        $htmltestimonial .= '<img src="' . $settingleeloolxp->testimonials_3_img . '"/>';
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div class="testimonial_title">';
        $htmltestimonial .= $settingleeloolxp->testimonials_3_txt;
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div class="testimonial_des">';
        $htmltestimonial .= $settingleeloolxp->testimonials_3_cn;
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '<div class="testimonial_pos">';
        $htmltestimonial .= $settingleeloolxp->testimonials_3_cp;
        $htmltestimonial .= '</div>';

        $htmltestimonial .= '</div>';

        if ($settingleeloolxp->show_get_started) {
            $startedlink = $settingleeloolxp->get_started_link;
            $startedtxt = $settingleeloolxp->get_started_txt;

            $htmltestimonial .= '<div class="test_get_started"><a href="' . $startedlink . '">' . $startedtxt . '</a></div>';
        }

        $htmltestimonial .= '</div>';

        return $htmltestimonial;
    }

    /**
     * Allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }

    /**
     * Locations where block can be displayed
     *
     * @return array
     */
    public function applicable_formats() {
        return array('all' => true);
    }

    /**
     * Sets block header to be hidden or visible
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {
        // Hide header if welcome area is show.
        $config = get_config('block_tb_testimonials');
        return !empty($config->showwelcomearea);
    }
}
