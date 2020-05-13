<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['adm_digit_length'] = 6;
/* $config['exam_type'] = array(
  'basic_system' => 'Fail or Pass',
  'school_grade_system' => 'School Based Grading System',
  'coll_grade_system' => 'College Based Grading System',
  'gpa' => 'GPA Grading System'
  ); */


$config['image_validate'] = array(
    'allowed_mime_type' => array('image/jpeg', 'image/jpg', 'image/png'), //mime_type
    'allowed_extension' => array('jpg', 'jpeg', 'png'), // image extensions
    'upload_size' => 1048576, // bytes
);

$config['file_validate'] = array(
    'allowed_mime_type' => array('image/jpeg', 'image/jpg', 'image/png','application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'), //mime_type
    'allowed_extension' => array('jpg', 'jpeg', 'png','pdf', 'doc', 'docx', 'xls', 'xlsx'), // image extensions
    'upload_size' => 1048576, // bytes
);

$config['filecsv_validate'] = array(
    'allowed_mime_type' => array('text/csv', 'application/vnd.ms-excel'), //mime_type
    'allowed_extension' => array('csv', 'xls'), // image extensions
    'upload_size' => 1048576, // bytes
);




