<?php

$config['staffattendance'] = array(
    'present' => 1,
    'half_day' => 4,
    'late' => 2,
    'absent' => 3,
    'holiday' => 5
);

$config['contracttype'] = array(
    'permanent' => lang('permanent'),
    'probation' => lang('probation'),
);

$config['status'] = array(
    'pending' => lang('pending'),
    'approve' => lang('approved'),
    'disapprove' => lang('disapprove'),
);

$config['marital_status'] = array(
    'Single' => lang('Single'),
    'Married' => lang('Married'),
    'Widowed' => lang('Widowed'),
    'Seperated' => lang('Seperated'),
    'Not_specified' => lang('Not_specified'),
);

$config['staff_marital_status'] = array(
    'Single' => lang('Single'),
    'Married' => lang('Married'),
    'Widowed' => lang('Widowed'),
    'Seperated' => lang('Seperated'),
    'Not_specified' => lang('Not_specified'),
);

$config['staff_bloodgroup'] = array('1' => 'O+', '2' => 'A+', '3' => 'B+', '4' => 'AB+', '5' => 'O-', '6' => 'A-', '7' => 'B-', '8' => 'AB-');

$config['payroll_status'] = array(
    'generated' => lang('generated'),
    'paid' => lang('paid'),
    'unpaid' => lang('unpaid'),
    'not_generate' => lang('not_generated'),
);
$config['payment_mode'] = array(
    'Cash' => lang('cash'),
    'Cheque' => lang('cheque'),
    'Online' => lang('online'),
    'Other' => lang('other')
);
$config['enquiry_status'] = array(
    'active' => lang('active'),
    'passive' => lang('passive'),
    'dead' => lang('dead'),
    'won' => lang('won'),
    'lost' => lang('lost'),
);
$config['charge_type'] = array(
    'Procedures' => lang('procedures'),
    'Investigations' => lang('investigations'),
    'Supplier' => lang('supplier'),
    'Operation Theatre' => lang('operation_theatre'),
    'Others' => lang('others'),
);
$config['appointment_status'] = array(
    'pending' => lang('pending'),
    'approved' => lang('approved'),
    'cancel' => lang('cancel'),
);
$config['search_type'] = array(
    'today' => lang('today'),
    'this_week' => lang('this_week'),
    'last_week' => lang('last_week'),
    'this_month' => lang('this_month'),
    'last_month' => lang('last_month'),
    'last_3_month' => lang('last_3_month'),
    'last_6_month' => lang('last_6_month'),
    'last_12_month' => lang('last_12_month'),
    'this_year' => lang('this_year'),
    'last_year' => lang('last_year'),
    'period' => lang('period'),
);

$config['search_type_expiry'] = array(
    // 'today' => lang('today'),
    // 'this_week' => lang('this_week'),
    // 'last_week' => lang('last_week'),
    'this_month' => lang('this_month'),
    'last_month' => lang('last_month'),
    'last_3_month' => lang('last_3_month'),
    'last_6_month' => lang('last_6_month'),
    // 'last_12_month' => lang('last_12_month'),
    'this_year' => lang('this_year'),
    'last_year' => lang('last_year'),
    // 'period' => lang('period'),
);
?>