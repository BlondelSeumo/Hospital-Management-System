<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('display_custom_fields')) {

    function display_custom_fields($belongs_to, $rel_id = false, $where = array()) {
        $CI = &get_instance();
        $CI->db->from('custom_fields');
        $CI->db->where('belong_to', $belongs_to);
        $CI->db->order_by('custom_fields.belong_to', 'asc');
        $CI->db->order_by('custom_fields.weight', 'asc');
        $query = $CI->db->get();
        $result = $query->result_array();
        $fields_html = '';

        foreach ($result as $result_key => $field) {
            $type = $field['type'];

            $label = ucfirst($field['name']);
            $field_name = 'custom_fields[' . $field['belong_to'] . '][' . $field['id'] . ']';
            if ($field['bs_column'] == '' || $field['bs_column'] == 0) {
                $field['bs_column'] = 12;
            }
            $input_class = "";
            $value = "";
            if ($rel_id !== false) {

                $return_value = get_custom_field_value($rel_id, $field['id'], $belongs_to);
                if (!empty($return_value)) {
                    $value = $return_value->field_value;
                }
            }


            $fields_html .= '<div class="col-md-' . $field['bs_column'] . '">';
            if ($field['type'] == 'input' || $field['type'] == 'number') {
                $type = $field['type'] == 'input' ? 'text' : 'number';
                $fields_html .= render_input_field($field_name, $label, $value, $type, $input_class, $field['belong_to'], $field['id']);
            } elseif ($field['type'] == 'textarea') {
                $fields_html .= render_textarea_field($field_name, $label, $value, $type, $input_class, $field['belong_to'], $field['id']);
            } elseif ($field['type'] == 'select') {

                $options = optionSplit($field['field_values']);


                $fields_html .= render_select_field($field_name, $options, $label, $value, $type, $input_class, $field['belong_to'], $field['id']);
            } elseif ($field['type'] == 'multiselect') {
                $options = optionSplit($field['field_values']);
                $fields_html .= render_multiselect_field($field_name, $options, $label, $value, $type, $input_class, $field['belong_to'], $field['id']);
            } elseif ($field['type'] == 'checkbox') {

                $options = optionSplit($field['field_values']);
                $fields_html .= render_checkbox_field($field_name, $options, $label, $value, $type, $input_class, $field['belong_to'], $field['id']);
            } elseif ($field['type'] == 'date_picker') {

                $type = $field['type'];
                $fields_html .= render_date_picker_field($field_name, $label, $value, $type, $input_class, $field['belong_to'], $field['id']);
            } elseif ($field['type'] == 'date_picker_time') {

                $type = $field['type'];
                $fields_html .= render_date_picker_time_field($field_name, $label, $value, $type, $input_class, $field['belong_to'], $field['id']);
            } elseif ($field['type'] == 'colorpicker') {

                $type = $field['type'];
                $fields_html .= render_colorpicker_field($field_name, $label, $value, $type, $input_class, $field['belong_to'], $field['id']);
            } elseif ($field['type'] == 'link') {

                $type = $field['type'];
                $fields_html .= render_link_field($field_name, $label, $value, $type, $input_class, $field['belong_to'], $field['id']);
            }
            $fields_html .= '</div>';
        }
        return $fields_html;
    }

    function render_input_field($name, $label = '', $value = '', $type = 'text', $input_class = '', $belong_to, $field_id) {
        $input = '';
        $_form_group_attr = '';
        $_input_attrs = '';

        if (isset($_POST['custom_fields'][$belong_to][$field_id])) {
            $value = $_POST['custom_fields'][$belong_to][$field_id];
        }
        if (!empty($input_class)) {
            $input_class = ' ' . $input_class;
        }

        $input .= '<div class="form-group">';

        if ($label != '') {
            $input .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
        }
        $input .= '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" class="form-control' . $input_class . '" ' . $_input_attrs . ' value="' . $value . '">';

        $input .= '<span class="text-danger">' . form_error($name) . '</span>';
        $input .= '</div>';


        return $input;
    }

    function render_textarea_field($name, $label = '', $value = '', $type = 'text', $input_class = '', $belong_to, $field_id) {
        $input = '';
        $_form_group_attr = '';
        $_input_attrs = '';
        if (isset($_POST['custom_fields'][$belong_to][$field_id])) {
            $value = $_POST['custom_fields'][$belong_to][$field_id];
        }
        if (!empty($input_class)) {
            $input_class = ' ' . $input_class;
        }

        $input .= '<div class="form-group">';

        if ($label != '') {
            $input .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
        }
        $input .= '<textarea id="' . $name . '" name="' . $name . '" class="form-control' . $input_class . '" ' . $_input_attrs . ' >' . $value . '</textarea>';

        $input .= '<span class="text-danger">' . form_error($name) . '</span>';
        $input .= '</div>';


        return $input;
    }

    function render_select_field($name, $options, $label = '', $value = '', $type = 'text', $input_class = '', $belong_to, $field_id) {

        $input = '';
        $_form_group_attr = '';
        $_input_attrs = '';

        if (!empty($input_class)) {
            $input_class = ' ' . $input_class;
        }

        $input .= '<div class="form-group">';

        if ($label != '') {
            $input .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
        }
        $input .= '<select id="' . $name . '" name="' . $name . '" class="form-control' . $input_class . '" ' . $_input_attrs . '>';
        $input .= '<option value="">Select</option>';
        foreach ($options as $option_key => $option_value) {
            $input .= '<option value="' . $option_value . '" ' . set_select($name, $option_value, (set_value($name, $value) == $option_value ) ? TRUE : FALSE) . '>' . $option_value . '</option>';
        }
        $input .= '</select>';
        $input .= '<span class="text-danger">' . form_error($name) . '</span>';
        $input .= '</div>';
        return $input;
    }

    function render_multiselect_field($name, $options, $label = '', $value = '', $type = 'text', $input_class = '', $belong_to, $field_id) {
        $input = '';
        $_form_group_attr = '';
        $_input_attrs = '';

        if (!empty($input_class)) {
            $input_class = ' ' . $input_class;
        }

        $input .= '<div class="form-group">';

        if ($label != '') {
            $input .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
        }
        $input .= '<select id="' . $name . '" name="' . $name . '[]" class="form-control' . $input_class . '" ' . $_input_attrs . ' multiple  >' . $value . '>';
        $input .= '<option value="">Select</option>';
        foreach ($options as $option_key => $option_value) {

            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                if (isset($_POST[$name]) && in_array($option_value, $name)) {
                    $chk_status = TRUE;
                } else {
                    $chk_status = FALSE;
                }
            } elseif ($value != "" && in_array($option_value, explode(",", $value))) {
                $chk_status = TRUE;
            } else {
                $chk_status = FALSE;
            }


            $input .= '<option value="' . $option_value . '" ' . set_select($name, $option_value, $chk_status) . '>' . $option_value . '</option>';
        }

        $input .= '</select>';

        $input .= '<span class="text-danger">' . form_error($name) . '</span>';
        $input .= '</div>';


        return $input;
    }

    function render_checkbox_field($name, $options, $label = '', $value = '', $type = 'text', $input_class = '', $belong_to, $field_id) {


        $input = '';
        $_form_group_attr = '';
        $_input_attrs = '';

        if (!empty($input_class)) {
            $input_class = ' ' . $input_class;
        }
        $input .= '<div class="form-group">';

        if ($label != '') {
            $input .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
        }
        $input .= '<div class="checkbox">';
        foreach ($options as $option_key => $option_value) {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                if (isset($_POST[$name]) && in_array($option_value, $name)) {
                    $chk_status = TRUE;
                } else {
                    $chk_status = FALSE;
                }
            } elseif ($value != "" && in_array($option_value, explode(",", $value))) {
                $chk_status = TRUE;
            } else {
                $chk_status = FALSE;
            }
            $input .= '<label class="checkbox-inline">';

            $input .= '<input type="' . $type . '" id="' . $name . '" name="' . $name . '[]"  value="' . $option_value . '" ' . set_checkbox($name, $option_value, $chk_status) . '>' . $option_value . '</label>';
            $input .= '</label>';
        }

        $input .= '<span class="text-danger">' . form_error($name) . '</span>';
        $input .= '</div>';
        $input .= '</div>';
        return $input;
    }

    function render_date_picker_field($name, $label = '', $value = '', $type = 'text', $input_class = '', $belong_to, $field_id) {
        $input = '';
        $_form_group_attr = '';
        $_input_attrs = '';
        if (isset($_POST['custom_fields'][$belong_to][$field_id])) {
            $value = $_POST['custom_fields'][$belong_to][$field_id];
        }
        if (!empty($input_class)) {
            $input_class = ' ' . $input_class;
        }

        $input .= '<div class="form-group">';

        if ($label != '') {
            $input .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
        }
        $input .= '<input  id="' . $name . '" name="' . $name . '" class="form-control date' . $input_class . '" ' . $_input_attrs . ' value="' . $value . '">';

        $input .= '<span class="text-danger">' . form_error($name) . '</span>';
        $input .= '</div>';


        return $input;
    }

    function render_date_picker_time_field($name, $label = '', $value = '', $type = 'text', $input_class = '', $belong_to, $field_id) {
        $input = '';
        $_form_group_attr = '';
        $_input_attrs = '';
        if (isset($_POST['custom_fields'][$belong_to][$field_id])) {
            $value = $_POST['custom_fields'][$belong_to][$field_id];
        }
        if (!empty($input_class)) {
            $input_class = ' ' . $input_class;
        }

        $input .= '<div class="form-group">';

        if ($label != '') {
            $input .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
        }
        $input .= '<input  id="' . $name . '" name="' . $name . '" class="form-control datetime' . $input_class . '" ' . $_input_attrs . ' value="' . $value . '">';

        $input .= '<span class="text-danger">' . form_error($name) . '</span>';
        $input .= '</div>';


        return $input;
    }

    function render_colorpicker_field($name, $label = '', $value = '', $type = 'text', $input_class = '', $belong_to, $field_id) {
        $input = '';
        $_form_group_attr = '';
        $_input_attrs = '';
        if (isset($_POST['custom_fields'][$belong_to][$field_id])) {
            $value = $_POST['custom_fields'][$belong_to][$field_id];
        }
        if (!empty($input_class)) {
            $input_class = ' ' . $input_class;
        }

        $input .= '<div class="form-group">';

        if ($label != '') {
            $input .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
        }
        $input .= '<input  id="' . $name . '" name="' . $name . '" class="form-control color' . $input_class . '" ' . $_input_attrs . ' value="' . $value . '">';

        $input .= '<span class="text-danger">' . form_error($name) . '</span>';
        $input .= '</div>';


        return $input;
    }

    function render_link_field($name, $label = '', $value = '', $type = 'text', $input_class = '', $belong_to, $field_id) {
        $input = '';
        $_form_group_attr = '';
        $_input_attrs = '';

        if (isset($_POST['custom_fields'][$belong_to][$field_id])) {
            $value = $_POST['custom_fields'][$belong_to][$field_id];
        }
        if (!empty($input_class)) {
            $input_class = ' ' . $input_class;
        }

        $input .= '<div class="form-group">';
        if ($label != '') {
            $input .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
        }
        $input .= '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" class="form-control' . $input_class . '" ' . $_input_attrs . ' value="' . $value . '">';
        $input .= '<span class="text-danger">' . form_error($name) . '</span>';
        $input .= '</div>';
        return $input;
    }

    function get_custom_field_value($rel_id, $field_id, $belongs_to) {
        $CI = &get_instance();
        $sql = 'SELECT * FROM `custom_fields` INNER JOIN custom_field_values on custom_field_values.belong_table_id=' . $CI->db->escape($rel_id) . ' and custom_field_values.custom_field_id=custom_fields.id WHERE belong_to =' . $CI->db->escape($belongs_to) . ' and custom_field_values.custom_field_id=' . $CI->db->escape($field_id);

        $query = $CI->db->query($sql);
        return $query->row();
    }

    function optionSplit($values) {
        return explode(',', $values);
    }

    function removeBreak($option_value) {
        return preg_replace('/<br\\s*?\\/?>\\s*$/', '', $option_value);
    }

    function get_custom_table_values($table_id, $belongs_to) {
        $CI = &get_instance();
        $sql = 'SELECT custom_field_values.*,custom_fields.name, custom_fields.id as cid,custom_fields.type,custom_fields.belong_to  FROM `custom_field_values` RIGHT JOIN custom_fields on custom_fields.id=custom_field_values.custom_field_id  and belong_table_id=' . $CI->db->escape($table_id) . ' WHERE custom_fields.belong_to=' . $CI->db->escape($belongs_to) . ' ORDER by custom_fields.id asc';

        $query = $CI->db->query($sql);
        return $query->result();
    }

    function get_custom_fields($belongs_to) {
        $CI = &get_instance();
        $sql = 'SELECT custom_fields.*  FROM `custom_fields` WHERE custom_fields.belong_to=' . $CI->db->escape($belongs_to) . ' ORDER by custom_fields.id asc';

        $query = $CI->db->query($sql);
        return $query->result();
    }

}