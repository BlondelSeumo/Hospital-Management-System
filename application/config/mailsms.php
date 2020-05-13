<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


// Config variables

$config['mailsms'] = array(
    'opd_patient_registration' => lang('opd_patient_registration'),
    'ipd_patient_registration' => lang('ipd_patient_registration'),
    'patient_discharged' => lang('patient_discharged'),
    'patient_revisit' => lang('patient_revisit'),
    'login_credential' => lang('login_credential'),
    'appointment' => lang('appointment')
);

$config['notification'] = array(
    'appointment_created' => "Appointment has been created for <a href='<url>'><patient></a>",
    'appointment_approved' => "Appointment has been approved for <a href='<url>'><patient></a>",
    'opd_created' => "OPD has been created with <a href='<url>'><opdno></a>",
    'ipd_created' => "IPD has been created with <a href='<url>'><ipdno></a>",
    'ot_created' => "OT Visit has been created for <a href='<url>' onclick='<onchngfun>'><patient></a>",
    'salary_paid' => "Salary Amount <amount> has been paid for Month <month> to <a href='<url>'><staffname></a>"
);

$config['notification_icon'] = array(
    'opd' => 'fas fa-stethoscope',
    'ipd' => 'fas fa-procedures',
    'appointment' => 'fas fa-dungeon',
    'ot' => 'fas fa-cut',
    'salary' => 'fas fa-sitemap'
);


$config['patient_notification_url'] = array(
    'opd' => "patient/dashboard/profile",
    'ipd' => "patient/dashboard/ipdprofile",
    'appointment' => "patient/dashboard/appointment",
    'ot' => "patient/dashboard/otsearch",
);

/* $config['notification_url'] = array(
  'opd' =>"admin/patient/search",
  'opd_revisit' =>"admin/patient/profile",
  'ipd' =>"admin/patient/ipdsearch" ,
  'appointment' => "admin/appointment/search",
  'ot' => "admin/operationtheatre/otsearch",
  'salary' => "admin/staff/profile"
  ); */

$config['notification_url'] = array(
    'opd' => "admin/systemnotification/moveopdnotification",
    //'opd_revisit' =>"admin/patient/profile",
    'ipd' => "admin/systemnotification/moveipdnotification",
    'appointment' => "admin/systemnotification/moveappointment",
    'ot' => "admin/systemnotification/moveotpatient",
    'salary' => "admin/systemnotification/movesalarypay"
);

$config['attendence'] = array(
    'present' => 1,
    'late_with_excuse' => 2,
    'late' => 3,
    'absent' => 4,
    'holiday' => 5,
    'half_day' => 6
);

$config['perm_category'] = array('can_view', 'can_add', 'can_edit', 'can_delete');

$config['bloodgroup'] = array('1' => 'O+', '2' => 'A+', '3' => 'B+', '4' => 'AB+', '5' => 'O-', '6' => 'A-', '7' => 'B-', '8' => 'AB-');
