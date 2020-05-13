-- Smart Hospital DB
-- Version 2.1
-- https://smart-hospital.in
-- https://qdocs.in



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `ambulance_call`
--

CREATE TABLE `ambulance_call` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(200) NOT NULL,
  `patient_name` varchar(50) DEFAULT NULL,
  `contact_no` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `vehicle_no` varchar(20) DEFAULT NULL,
  `vehicle_model` varchar(20) DEFAULT NULL,
  `driver` varchar(100) NOT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_no` varchar(100) NOT NULL,
  `date` datetime DEFAULT NULL,
  `patient_name` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobileno` varchar(50) DEFAULT NULL,
  `doctor` varchar(50) DEFAULT NULL,
  `amount` varchar(200) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `appointment_status` varchar(11) DEFAULT NULL,
  `source` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_opd` varchar(200) NOT NULL,
  `is_ipd` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bed`
--

CREATE TABLE `bed` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bed_type_id` int(11) NOT NULL,
  `bed_group_id` int(100) NOT NULL,
  `is_active` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bed_group`
--

CREATE TABLE `bed_group` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `floor` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bed_type`
--

CREATE TABLE `bed_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `birth_report`
--

CREATE TABLE `birth_report` (
  `id` int(11) NOT NULL,
  `ref_no` varchar(200) NOT NULL,
  `opd_ipd_no` varchar(200) NOT NULL,
  `child_name` varchar(200) NOT NULL,
  `child_pic` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `birth_date` datetime NOT NULL,
  `weight` varchar(200) NOT NULL,
  `mother_name` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `mother_pic` varchar(200) NOT NULL,
  `father_name` varchar(200) NOT NULL,
  `father_pic` varchar(200) NOT NULL,
  `birth_report` mediumtext NOT NULL,
  `document` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `is_active` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank_status`
--

CREATE TABLE `blood_bank_status` (
  `id` int(11) NOT NULL,
  `blood_group` varchar(3) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `ceated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blood_bank_status`
--

INSERT INTO `blood_bank_status` (`id`, `blood_group`, `status`, `ceated_at`) VALUES
(1, 'A+', '0', '2018-08-18 11:40:07'),
(2, 'B+', '0', '2018-08-18 12:10:55'),
(3, 'A-', '0', '2018-08-18 12:11:24'),
(4, 'B-', '0', '2018-08-18 12:11:44'),
(5, 'O+', '0', '2018-08-18 12:12:06'),
(6, 'O-', '0', '2018-08-18 12:12:20'),
(7, 'AB+', '0', '2018-08-18 12:12:36'),
(8, 'AB-', '0', '2018-08-18 12:13:18');

-- --------------------------------------------------------

--
-- Table structure for table `blood_donor`
--

CREATE TABLE `blood_donor` (
  `id` int(11) NOT NULL,
  `donor_name` varchar(100) DEFAULT NULL,
  `age` varchar(11) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `blood_group` varchar(11) DEFAULT NULL,
  `gender` varchar(11) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blood_donor_cycle`
--

CREATE TABLE `blood_donor_cycle` (
  `id` int(11) NOT NULL,
  `blood_donor_id` int(11) NOT NULL,
  `institution` varchar(100) DEFAULT NULL,
  `lot` varchar(11) DEFAULT NULL,
  `bag_no` varchar(11) DEFAULT NULL,
  `quantity` varchar(11) DEFAULT NULL,
  `donate_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blood_issue`
--

CREATE TABLE `blood_issue` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(200) NOT NULL,
  `date_of_issue` datetime DEFAULT NULL,
  `recieve_to` varchar(50) DEFAULT NULL,
  `blood_group` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `doctor` varchar(200) DEFAULT NULL,
  `institution` varchar(100) DEFAULT NULL,
  `technician` varchar(50) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `donor_name` varchar(50) DEFAULT NULL,
  `lot` varchar(20) DEFAULT NULL,
  `bag_no` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` int(11) NOT NULL,
  `charge_type` varchar(200) NOT NULL,
  `charge_category` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `code` varchar(100) NOT NULL,
  `standard_charge` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `charge_categories`
--

CREATE TABLE `charge_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `charge_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `id` int(11) NOT NULL,
  `complaint_type` varchar(100) NOT NULL,
  `source` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `action_taken` varchar(200) NOT NULL,
  `assigned` varchar(50) NOT NULL,
  `note` text NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `complaint_type`
--

CREATE TABLE `complaint_type` (
  `id` int(11) NOT NULL,
  `complaint_type` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `consultant_register`
--

CREATE TABLE `consultant_register` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `ipd_id` int(11) NOT NULL,
  `date` varchar(100) DEFAULT NULL,
  `ins_date` varchar(50) DEFAULT NULL,
  `instruction` varchar(200) NOT NULL,
  `cons_doctor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `consult_charges`
--

CREATE TABLE `consult_charges` (
  `id` int(11) NOT NULL,
  `doctor` int(11) NOT NULL,
  `standard_charge` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `is_public` varchar(10) DEFAULT 'No',
  `class_id` int(11) DEFAULT NULL,
  `cls_sec_id` int(10) NOT NULL,
  `file` varchar(250) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `content_for`
--

CREATE TABLE `content_for` (
  `id` int(11) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `belong_to` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `bs_column` int(10) DEFAULT NULL,
  `validation` int(11) DEFAULT 0,
  `field_values` mediumtext DEFAULT NULL,
  `show_table` varchar(100) DEFAULT NULL,
  `visible_on_table` int(11) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_values`
--

CREATE TABLE `custom_field_values` (
  `id` int(11) NOT NULL,
  `belong_table_id` int(11) DEFAULT NULL,
  `custom_field_id` int(11) DEFAULT NULL,
  `field_value` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `death_report`
--

CREATE TABLE `death_report` (
  `id` int(11) NOT NULL,
  `opdipd_no` varchar(200) NOT NULL,
  `patient` varchar(200) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `image` varchar(200) NOT NULL,
  `death_date` datetime NOT NULL,
  `guardian_name` varchar(200) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `address` varchar(200) NOT NULL,
  `death_report` text NOT NULL,
  `is_active` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department_name` varchar(200) NOT NULL,
  `is_active` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `report_type` varchar(200) NOT NULL,
  `document` varchar(200) NOT NULL,
  `description` varchar(400) NOT NULL,
  `report_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_receive`
--

CREATE TABLE `dispatch_receive` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(50) NOT NULL,
  `to_title` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `note` varchar(500) NOT NULL,
  `from_title` varchar(200) NOT NULL,
  `date` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `id` int(11) UNSIGNED NOT NULL,
  `email_type` varchar(100) DEFAULT NULL,
  `smtp_server` varchar(100) DEFAULT NULL,
  `smtp_port` varchar(100) DEFAULT NULL,
  `smtp_username` varchar(100) DEFAULT NULL,
  `smtp_password` varchar(100) DEFAULT NULL,
  `ssl_tls` varchar(100) DEFAULT NULL,
  `is_active` varchar(10) NOT NULL DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`id`, `email_type`, `smtp_server`, `smtp_port`, `smtp_username`, `smtp_password`, `ssl_tls`, `is_active`, `created_at`) VALUES
(2, 'sendmail', '', '', '', '', '', 'yes', '2019-11-01 12:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

CREATE TABLE `enquiry` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` mediumtext NOT NULL,
  `reference` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(500) NOT NULL,
  `follow_up_date` date NOT NULL,
  `note` mediumtext NOT NULL,
  `source` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `assigned` varchar(100) NOT NULL,
  `class` int(11) NOT NULL,
  `no_of_child` varchar(11) DEFAULT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_type`
--

CREATE TABLE `enquiry_type` (
  `id` int(11) NOT NULL,
  `enquiry_type` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_title` varchar(200) NOT NULL,
  `event_description` varchar(300) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `event_type` varchar(100) NOT NULL,
  `event_color` varchar(200) NOT NULL,
  `event_for` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `exp_head_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(200) NOT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'yes',
  `is_deleted` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expense_head`
--

CREATE TABLE `expense_head` (
  `id` int(11) NOT NULL,
  `exp_category` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'yes',
  `is_deleted` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

CREATE TABLE `floor` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `follow_up`
--

CREATE TABLE `follow_up` (
  `id` int(11) NOT NULL,
  `enquiry_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `next_date` date NOT NULL,
  `response` text NOT NULL,
  `note` text NOT NULL,
  `followup_by` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_media_gallery`
--

CREATE TABLE `front_cms_media_gallery` (
  `id` int(11) NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  `thumb_path` varchar(300) DEFAULT NULL,
  `dir_path` varchar(300) DEFAULT NULL,
  `img_name` varchar(300) DEFAULT NULL,
  `thumb_name` varchar(300) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file_type` varchar(100) NOT NULL,
  `file_size` varchar(100) NOT NULL,
  `vid_url` mediumtext NOT NULL,
  `vid_title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_menus`
--

CREATE TABLE `front_cms_menus` (
  `id` int(11) NOT NULL,
  `menu` varchar(100) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `open_new_tab` int(10) NOT NULL DEFAULT 0,
  `ext_url` mediumtext NOT NULL,
  `ext_url_link` mediumtext NOT NULL,
  `publish` int(11) NOT NULL DEFAULT 0,
  `content_type` varchar(10) NOT NULL DEFAULT 'manual',
  `is_active` varchar(10) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `front_cms_menus`
--

INSERT INTO `front_cms_menus` (`id`, `menu`, `slug`, `description`, `open_new_tab`, `ext_url`, `ext_url_link`, `publish`, `content_type`, `is_active`, `created_at`) VALUES
(1, 'Main Menu', 'main-menu', 'Main menu', 0, '', '', 0, 'default', 'no', '2018-04-20 09:24:49'),
(2, 'Bottom Menu', 'bottom-menu', 'Bottom Menu', 0, '', '', 0, 'default', 'no', '2018-04-20 09:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_menu_items`
--

CREATE TABLE `front_cms_menu_items` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu` varchar(100) DEFAULT NULL,
  `page_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `ext_url` mediumtext DEFAULT NULL,
  `open_new_tab` int(11) DEFAULT 0,
  `ext_url_link` mediumtext DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `publish` int(11) NOT NULL DEFAULT 0,
  `description` mediumtext DEFAULT NULL,
  `is_active` varchar(10) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `front_cms_menu_items`
--

INSERT INTO `front_cms_menu_items` (`id`, `menu_id`, `menu`, `page_id`, `parent_id`, `ext_url`, `open_new_tab`, `ext_url_link`, `slug`, `weight`, `publish`, `description`, `is_active`, `created_at`) VALUES
(16, 2, 'Home', 1, 0, NULL, NULL, NULL, 'home-1', NULL, 0, NULL, 'no', '2018-07-14 08:44:12'),
(23, 1, 'Appointment', 77, 0, '1', NULL, 'http://yourdomainname.com/form/appointment', 'appointment', 2, 0, NULL, 'no', '2019-11-01 07:36:32'),
(26, 1, 'Home', 1, 0, NULL, NULL, NULL, 'home', NULL, 0, NULL, 'no', '2019-01-24 08:48:17'),
(27, 2, 'Appointment', 0, 0, '1', NULL, 'http://yourdomainname.com/form/appointment', 'appointment-1', NULL, 0, NULL, 'no', '2019-11-02 16:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_pages`
--

CREATE TABLE `front_cms_pages` (
  `id` int(11) NOT NULL,
  `page_type` varchar(10) NOT NULL DEFAULT 'manual',
  `is_homepage` int(1) DEFAULT 0,
  `title` varchar(250) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `meta_title` mediumtext DEFAULT NULL,
  `meta_description` mediumtext DEFAULT NULL,
  `meta_keyword` mediumtext DEFAULT NULL,
  `feature_image` varchar(200) NOT NULL,
  `description` longtext DEFAULT NULL,
  `publish_date` date NOT NULL,
  `publish` int(10) DEFAULT 0,
  `sidebar` int(10) DEFAULT 0,
  `is_active` varchar(10) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `front_cms_pages`
--

INSERT INTO `front_cms_pages` (`id`, `page_type`, `is_homepage`, `title`, `url`, `type`, `slug`, `meta_title`, `meta_description`, `meta_keyword`, `feature_image`, `description`, `publish_date`, `publish`, `sidebar`, `is_active`, `created_at`) VALUES
(1, 'default', 1, 'Home', 'page/home', 'page', 'home', '', '', '', '', '<p>Home page</p>', '0000-00-00', 1, 1, 'no', '2019-01-24 08:33:59'),
(2, 'default', 0, 'Complain', 'page/complain', 'page', 'complain', 'Complain form', '                                                                                                                                                                                    complain form                                                                                                                                                                                                                                ', 'complain form', '', '<div class=\"col-md-12 col-sm-12\">\r\n<h2 class=\"text-center\">&nbsp;</h2>\r\n\r\n<p class=\"text-center\">[form-builder:complain]</p>\r\n</div>', '0000-00-00', 1, 1, 'no', '2019-01-24 08:30:12'),
(54, 'default', 0, '404 page', 'page/404-page', 'page', '404-page', '', '                                ', '', '', '<html>\r\n<head>\r\n <title></title>\r\n</head>\r\n<body>\r\n<p>404 page found</p>\r\n</body>\r\n</html>', '0000-00-00', 0, NULL, 'no', '2018-05-18 09:16:04'),
(76, 'default', 0, 'Contact us', 'page/contact-us', 'page', 'contact-us', '', '', '', '', '<p>[form-builder:contact_us]</p>', '0000-00-00', 0, NULL, 'no', '2019-01-24 08:31:58'),
(77, 'manual', 0, 'our-appointment', 'page/our-appointment', 'page', 'our-appointment', '', '', '', '', '<form action=\"welcome/appointment\" method=\"get\">\r\n  First name: <input type=\"text\" name=\"fname\"><br>\r\n  Last name: <input type=\"text\" name=\"lname\"><br>\r\n  <input type=\"submit\" value=\"Submit\">\r\n</form>', '0000-00-00', 0, 1, 'no', '2019-11-01 07:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_page_contents`
--

CREATE TABLE `front_cms_page_contents` (
  `id` int(11) NOT NULL,
  `page_id` int(11) DEFAULT NULL,
  `content_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_programs`
--

CREATE TABLE `front_cms_programs` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `url` mediumtext DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `event_start` date DEFAULT NULL,
  `event_end` date DEFAULT NULL,
  `event_venue` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `is_active` varchar(10) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `meta_title` mediumtext NOT NULL,
  `meta_description` mediumtext NOT NULL,
  `meta_keyword` mediumtext NOT NULL,
  `feature_image` mediumtext NOT NULL,
  `publish_date` date NOT NULL,
  `publish` varchar(10) DEFAULT '0',
  `sidebar` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_program_photos`
--

CREATE TABLE `front_cms_program_photos` (
  `id` int(11) NOT NULL,
  `program_id` int(11) DEFAULT NULL,
  `media_gallery_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_settings`
--

CREATE TABLE `front_cms_settings` (
  `id` int(11) NOT NULL,
  `theme` varchar(50) DEFAULT NULL,
  `is_active_rtl` int(10) DEFAULT 0,
  `is_active_front_cms` int(11) DEFAULT 0,
  `is_active_sidebar` int(1) DEFAULT 0,
  `logo` varchar(200) DEFAULT NULL,
  `contact_us_email` varchar(100) DEFAULT NULL,
  `complain_form_email` varchar(100) DEFAULT NULL,
  `sidebar_options` mediumtext NOT NULL,
  `fb_url` varchar(200) NOT NULL,
  `twitter_url` varchar(200) NOT NULL,
  `youtube_url` varchar(200) NOT NULL,
  `google_plus` varchar(200) NOT NULL,
  `instagram_url` varchar(200) NOT NULL,
  `pinterest_url` varchar(200) NOT NULL,
  `linkedin_url` varchar(200) NOT NULL,
  `google_analytics` mediumtext DEFAULT NULL,
  `footer_text` varchar(500) DEFAULT NULL,
  `fav_icon` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `front_cms_settings`
--

INSERT INTO `front_cms_settings` (`id`, `theme`, `is_active_rtl`, `is_active_front_cms`, `is_active_sidebar`, `logo`, `contact_us_email`, `complain_form_email`, `sidebar_options`, `fb_url`, `twitter_url`, `youtube_url`, `google_plus`, `instagram_url`, `pinterest_url`, `linkedin_url`, `google_analytics`, `footer_text`, `fav_icon`, `created_at`) VALUES
(1, 'default', NULL, 0, 0, '', '', '', '[\"news\",\"complain\"]', '', '', '', '', '', '', '', '', '', '', '2019-11-02 16:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `general_calls`
--

CREATE TABLE `general_calls` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(12) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(500) NOT NULL,
  `follow_up_date` date NOT NULL,
  `call_dureation` varchar(50) NOT NULL,
  `note` mediumtext NOT NULL,
  `call_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `inc_head_id` varchar(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(200) NOT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'yes',
  `is_deleted` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `documents` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `income_head`
--

CREATE TABLE `income_head` (
  `id` int(255) NOT NULL,
  `income_category` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` varchar(255) NOT NULL DEFAULT 'yes',
  `is_deleted` varchar(255) NOT NULL DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ipd_billing`
--

CREATE TABLE `ipd_billing` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `ipd_id` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `other_charge` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `tax` decimal(15,2) NOT NULL,
  `gross_total` decimal(15,2) NOT NULL,
  `net_amount` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `generated_by` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ipd_details`
--

CREATE TABLE `ipd_details` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `height` varchar(5) DEFAULT NULL,
  `weight` varchar(5) DEFAULT NULL,
  `bp` varchar(20) DEFAULT NULL,
  `ipd_no` varchar(200) NOT NULL,
  `room` varchar(100) NOT NULL,
  `bed` varchar(100) NOT NULL,
  `bed_group_id` varchar(10) DEFAULT NULL,
  `case_type` varchar(100) NOT NULL,
  `casualty` varchar(100) NOT NULL,
  `symptoms` varchar(200) NOT NULL,
  `known_allergies` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `refference` varchar(200) NOT NULL,
  `cons_doctor` int(11) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `credit_limit` varchar(100) NOT NULL,
  `tax` varchar(100) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `discharged` varchar(200) NOT NULL,
  `discharged_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ipd_prescription_basic`
--

CREATE TABLE `ipd_prescription_basic` (
  `id` int(11) NOT NULL,
  `ipd_id` int(11) NOT NULL,
  `header_note` varchar(100) NOT NULL,
  `footer_note` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ipd_prescription_details`
--

CREATE TABLE `ipd_prescription_details` (
  `id` int(11) NOT NULL,
  `basic_id` int(11) NOT NULL,
  `ipd_id` int(11) NOT NULL,
  `medicine_category_id` int(11) NOT NULL,
  `medicine` varchar(200) NOT NULL,
  `dosage` varchar(200) NOT NULL,
  `instruction` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `item_category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(200) NOT NULL,
  `item_photo` varchar(225) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `item_store_id` int(11) DEFAULT NULL,
  `item_supplier_id` int(11) DEFAULT NULL,
  `quantity` int(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `id` int(255) NOT NULL,
  `item_category` varchar(255) NOT NULL,
  `is_active` varchar(255) NOT NULL DEFAULT 'yes',
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_issue`
--

CREATE TABLE `item_issue` (
  `id` int(11) NOT NULL,
  `issue_type` varchar(15) DEFAULT NULL,
  `issue_to` varchar(100) DEFAULT NULL,
  `issue_by` varchar(100) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `item_category_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(10) NOT NULL,
  `note` text NOT NULL,
  `is_returned` int(2) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` varchar(10) DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_stock`
--

CREATE TABLE `item_stock` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `symbol` varchar(10) NOT NULL DEFAULT '+',
  `store_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `purchase_price` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `attachment` varchar(250) DEFAULT NULL,
  `description` text NOT NULL,
  `is_active` varchar(10) DEFAULT 'yes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_store`
--

CREATE TABLE `item_store` (
  `id` int(255) NOT NULL,
  `item_store` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_supplier`
--

CREATE TABLE `item_supplier` (
  `id` int(255) NOT NULL,
  `item_supplier` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_person_name` varchar(255) NOT NULL,
  `contact_person_phone` varchar(255) NOT NULL,
  `contact_person_email` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lab`
--

CREATE TABLE `lab` (
  `id` int(11) NOT NULL,
  `lab_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` varchar(50) DEFAULT NULL,
  `short_code` varchar(100) NOT NULL,
  `is_deleted` varchar(10) NOT NULL DEFAULT 'yes',
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `short_code`, `is_deleted`, `is_active`, `created_at`) VALUES
(1, 'Azerbaijan', '', 'no', 'no', '2017-04-06 05:08:33'),
(2, 'Albanian', '', 'no', 'no', '2017-04-06 05:08:33'),
(4, 'English', 'en', 'no', 'no', '2018-12-01 10:08:15'),
(5, 'Arabic', '', 'no', 'no', '2017-04-06 05:08:33'),
(7, 'Afrikaans', '', 'no', 'no', '2017-04-06 05:08:33'),
(8, 'Basque', '', 'no', 'no', '2017-04-06 05:08:33'),
(11, 'Bengali', '', 'no', 'no', '2017-04-06 05:08:33'),
(13, 'Bosnian', '', 'no', 'no', '2017-04-06 05:08:33'),
(14, 'Welsh', '', 'no', 'no', '2017-04-06 05:08:33'),
(15, 'Hungarian', '', 'no', 'no', '2017-04-06 05:08:33'),
(16, 'Vietnamese', '', 'no', 'no', '2017-04-06 05:08:33'),
(17, 'Haitian (Creole)', '', 'no', 'no', '2017-04-06 05:08:33'),
(18, 'Galician', '', 'no', 'no', '2017-04-06 05:08:33'),
(19, 'Dutch', '', 'no', 'no', '2017-04-06 05:08:33'),
(21, 'Greek', '', 'no', 'no', '2017-04-06 05:08:33'),
(22, 'Georgian', '', 'no', 'no', '2017-04-06 05:08:33'),
(23, 'Gujarati', '', 'no', 'no', '2017-04-06 05:08:33'),
(24, 'Danish', '', 'no', 'no', '2017-04-06 05:08:33'),
(25, 'Hebrew', '', 'no', 'no', '2017-04-06 05:08:33'),
(26, 'Yiddish', '', 'no', 'no', '2017-04-06 05:08:33'),
(27, 'Indonesian', '', 'no', 'no', '2017-04-06 05:08:33'),
(28, 'Irish', '', 'no', 'no', '2017-04-06 05:08:33'),
(29, 'Italian', 'it', 'no', 'no', '2018-12-01 10:07:03'),
(30, 'Icelandic', '', 'no', 'no', '2017-04-06 05:08:33'),
(31, 'Spanish', 'es', 'no', 'no', '2018-12-01 10:09:37'),
(33, 'Kannada', '', 'no', 'no', '2017-04-06 05:08:33'),
(34, 'Catalan', '', 'no', 'no', '2017-04-06 05:08:33'),
(36, 'Chinese', '', 'no', 'no', '2017-04-06 05:08:33'),
(37, 'Korean', '', 'no', 'no', '2017-04-06 05:08:33'),
(38, 'Xhosa', '', 'no', 'no', '2017-04-06 05:08:33'),
(39, 'Latin', '', 'no', 'no', '2017-04-06 05:08:33'),
(40, 'Latvian', '', 'no', 'no', '2017-04-06 05:08:33'),
(41, 'Lithuanian', '', 'no', 'no', '2017-04-06 05:08:33'),
(43, 'Malagasy', '', 'no', 'no', '2017-04-06 05:08:33'),
(44, 'Malay', '', 'no', 'no', '2017-04-06 05:08:33'),
(45, 'Malayalam', '', 'no', 'no', '2017-04-06 05:08:33'),
(46, 'Maltese', '', 'no', 'no', '2017-04-06 05:08:33'),
(47, 'Macedonian', '', 'no', 'no', '2017-04-06 05:08:33'),
(48, 'Maori', '', 'no', 'no', '2017-04-06 05:08:33'),
(49, 'Marathi', '', 'no', 'no', '2017-04-06 05:08:33'),
(51, 'Mongolian', '', 'no', 'no', '2017-04-06 05:08:33'),
(52, 'German', '', 'no', 'no', '2017-04-06 05:08:33'),
(53, 'Nepali', '', 'no', 'no', '2017-04-06 05:08:33'),
(54, 'Norwegian', '', 'no', 'no', '2017-04-06 05:08:33'),
(55, 'Punjabi', '', 'no', 'no', '2017-04-06 05:08:33'),
(57, 'Persian', '', 'no', 'no', '2017-04-06 05:08:33'),
(59, 'Portuguese', '', 'no', 'no', '2017-04-06 05:08:33'),
(60, 'Romanian', '', 'no', 'no', '2017-04-06 05:08:33'),
(61, 'Russian', '', 'no', 'no', '2017-04-06 05:08:33'),
(62, 'Cebuano', '', 'no', 'no', '2017-04-06 05:08:33'),
(64, 'Sinhala', '', 'no', 'no', '2017-04-06 05:08:33'),
(65, 'Slovakian', '', 'no', 'no', '2017-04-06 05:08:33'),
(66, 'Slovenian', '', 'no', 'no', '2017-04-06 05:08:33'),
(67, 'Swahili', '', 'no', 'no', '2017-04-06 05:08:33'),
(68, 'Sundanese', '', 'no', 'no', '2017-04-06 05:08:33'),
(70, 'Thai', '', 'no', 'no', '2017-04-06 05:08:33'),
(71, 'Tagalog', '', 'no', 'no', '2017-04-06 05:08:33'),
(72, 'Tamil', '', 'no', 'no', '2017-04-06 05:08:33'),
(74, 'Telugu', '', 'no', 'no', '2017-04-06 05:08:33'),
(75, 'Turkish', '', 'no', 'no', '2017-04-06 05:08:33'),
(77, 'Uzbek', '', 'no', 'no', '2017-04-06 05:08:33'),
(79, 'Urdu', '', 'no', 'no', '2017-04-06 05:08:33'),
(80, 'Finnish', '', 'no', 'no', '2017-04-06 05:08:33'),
(81, 'French', 'fr', 'no', 'no', '2018-12-01 10:08:47'),
(82, 'Hindi', '', 'no', 'no', '2017-04-06 05:08:33'),
(84, 'Czech', '', 'no', 'no', '2017-04-06 05:08:33'),
(85, 'Swedish', '', 'no', 'no', '2017-04-06 05:08:33'),
(86, 'Scottish', '', 'no', 'no', '2017-04-06 05:08:33'),
(87, 'Estonian', '', 'no', 'no', '2017-04-06 05:08:33'),
(88, 'Esperanto', '', 'no', 'no', '2017-04-06 05:08:33'),
(89, 'Javanese', '', 'no', 'no', '2017-04-06 05:08:33'),
(90, 'Japanese', '', 'no', 'no', '2017-04-06 05:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `is_active` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_bad_stock`
--

CREATE TABLE `medicine_bad_stock` (
  `id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `outward_date` date NOT NULL,
  `expiry_date` varchar(200) NOT NULL,
  `batch_no` varchar(200) NOT NULL,
  `quantity` varchar(200) NOT NULL,
  `note` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_batch_details`
--

CREATE TABLE `medicine_batch_details` (
  `id` int(11) NOT NULL,
  `supplier_bill_basic_id` varchar(100) NOT NULL,
  `medicine_category_id` varchar(200) NOT NULL,
  `pharmacy_id` int(100) NOT NULL,
  `inward_date` datetime NOT NULL,
  `expiry_date` varchar(100) DEFAULT NULL,
  `expiry_date_format` date NOT NULL,
  `batch_no` varchar(100) NOT NULL,
  `packing_qty` varchar(100) NOT NULL,
  `purchase_rate_packing` varchar(100) NOT NULL,
  `quantity` varchar(200) NOT NULL,
  `mrp` varchar(11) DEFAULT NULL,
  `purchase_price` varchar(200) NOT NULL,
  `sale_rate` varchar(11) DEFAULT NULL,
  `batch_amount` decimal(10,2) NOT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `available_quantity` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_category`
--

CREATE TABLE `medicine_category` (
  `id` int(11) NOT NULL,
  `medicine_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_dosage`
--

CREATE TABLE `medicine_dosage` (
  `id` int(11) NOT NULL,
  `medicine_category_id` int(11) NOT NULL,
  `dosage_form` varchar(100) NOT NULL,
  `dosage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `send_mail` varchar(10) DEFAULT '0',
  `send_sms` varchar(10) DEFAULT '0',
  `is_group` varchar(10) DEFAULT '0',
  `is_individual` varchar(10) DEFAULT '0',
  `is_class` int(10) NOT NULL DEFAULT 0,
  `group_list` text DEFAULT NULL,
  `user_list` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification_roles`
--

CREATE TABLE `notification_roles` (
  `id` int(11) NOT NULL,
  `send_notification_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification_setting`
--

CREATE TABLE `notification_setting` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `is_mail` varchar(10) DEFAULT '0',
  `is_sms` varchar(10) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification_setting`
--

INSERT INTO `notification_setting` (`id`, `type`, `is_mail`, `is_sms`, `created_at`) VALUES
(5, 'login_credential', '1', '0', '2019-03-09 16:35:53'),
(6, 'patient_registration', '0', '0', '2018-12-26 07:38:55'),
(7, 'patient_discharged', '1', '0', '2019-03-09 16:35:53'),
(8, 'patient_revisit', '1', '0', '2019-03-09 16:35:53'),
(9, 'patient_discharge', '0', '0', '2018-12-23 12:54:57'),
(10, 'appointment', '1', '0', '2019-03-09 16:35:53'),
(11, 'opd_patient_registration', '1', '0', '2019-03-09 16:35:53'),
(12, 'ipd_patient_registration', '1', '0', '2019-03-09 16:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `opd_billing`
--

CREATE TABLE `opd_billing` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `opd_id` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `other_charge` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `tax` decimal(15,2) NOT NULL,
  `gross_total` decimal(15,2) NOT NULL,
  `net_amount` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `generated_by` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `opd_details`
--

CREATE TABLE `opd_details` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `opd_no` varchar(100) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `case_type` varchar(200) NOT NULL,
  `casualty` varchar(200) NOT NULL,
  `symptoms` varchar(200) NOT NULL,
  `bp` varchar(200) NOT NULL,
  `height` varchar(100) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `known_allergies` varchar(200) NOT NULL,
  `note_remark` varchar(225) DEFAULT NULL,
  `refference` varchar(100) NOT NULL,
  `cons_doctor` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `tax` decimal(15,2) NOT NULL,
  `payment_mode` varchar(200) NOT NULL,
  `header_note` varchar(200) NOT NULL,
  `footer_note` varchar(200) NOT NULL,
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `opd_patient_charges`
--

CREATE TABLE `opd_patient_charges` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `patient_id` int(11) NOT NULL,
  `opd_id` int(11) NOT NULL,
  `charge_id` int(11) NOT NULL,
  `org_charge_id` int(11) NOT NULL,
  `apply_charge` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `opd_payment`
--

CREATE TABLE `opd_payment` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `opd_id` int(11) NOT NULL,
  `paid_amount` decimal(15,2) NOT NULL,
  `balance_amount` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `note` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `document` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operation_theatre`
--

CREATE TABLE `operation_theatre` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(200) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `charge_id` varchar(11) DEFAULT NULL,
  `operation_name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `operation_type` varchar(100) DEFAULT NULL,
  `consultant_doctor` varchar(100) DEFAULT NULL,
  `ass_consultant_1` varchar(50) DEFAULT NULL,
  `ass_consultant_2` varchar(50) DEFAULT NULL,
  `anesthetist` varchar(50) DEFAULT NULL,
  `anaethesia_type` varchar(50) DEFAULT NULL,
  `ot_technician` varchar(100) DEFAULT NULL,
  `ot_assistant` varchar(100) DEFAULT NULL,
  `result` varchar(50) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `height` varchar(200) NOT NULL,
  `weight` varchar(200) NOT NULL,
  `bp` varchar(200) NOT NULL,
  `symptoms` varchar(200) NOT NULL,
  `apply_charge` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `id` int(11) NOT NULL,
  `organisation_name` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
  `address` varchar(300) NOT NULL,
  `contact_person_name` varchar(200) NOT NULL,
  `contact_person_phone` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `organisations_charges`
--

CREATE TABLE `organisations_charges` (
  `id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `charge_type` varchar(50) NOT NULL,
  `charge_id` int(11) NOT NULL,
  `org_charge` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ot_consultant_register`
--

CREATE TABLE `ot_consultant_register` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `ins_date` date NOT NULL,
  `ins_time` time NOT NULL,
  `instruction` varchar(200) NOT NULL,
  `cons_doctor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pathology`
--

CREATE TABLE `pathology` (
  `id` int(11) NOT NULL,
  `test_name` varchar(100) DEFAULT NULL,
  `short_name` varchar(100) DEFAULT NULL,
  `test_type` varchar(100) DEFAULT NULL,
  `pathology_category_id` varchar(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `sub_category` varchar(50) NOT NULL,
  `report_days` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `charge_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pathology_category`
--

CREATE TABLE `pathology_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pathology_report`
--

CREATE TABLE `pathology_report` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(200) NOT NULL,
  `pathology_id` int(11) NOT NULL,
  `patient_id` varchar(30) DEFAULT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `consultant_doctor` varchar(10) NOT NULL,
  `reporting_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `pathology_report` varchar(255) DEFAULT NULL,
  `apply_charge` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `patient_unique_id` int(11) NOT NULL,
  `admission_date` varchar(100) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `age` varchar(10) NOT NULL,
  `month` varchar(200) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `mobileno` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `marital_status` varchar(100) NOT NULL,
  `blood_group` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `guardian_phone` varchar(100) DEFAULT NULL,
  `guardian_address` text DEFAULT NULL,
  `guardian_email` varchar(100) NOT NULL,
  `is_active` varchar(255) DEFAULT 'no',
  `discharged` varchar(100) NOT NULL,
  `patient_type` varchar(200) NOT NULL,
  `credit_limit` varchar(50) DEFAULT NULL,
  `organisation` varchar(100) NOT NULL,
  `known_allergies` varchar(200) NOT NULL,
  `old_patient` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `disable_at` date NOT NULL,
  `note` varchar(200) NOT NULL,
  `is_ipd` varchar(200) NOT NULL,
  `app_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patient_charges`
--

CREATE TABLE `patient_charges` (
  `id` int(11) NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `ipd_id` int(11) NOT NULL,
  `charge_id` int(11) DEFAULT NULL,
  `org_charge_id` int(11) DEFAULT NULL,
  `apply_charge` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patient_timeline`
--

CREATE TABLE `patient_timeline` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `timeline_date` date NOT NULL,
  `description` varchar(200) NOT NULL,
  `document` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `ipd_id` int(11) NOT NULL,
  `paid_amount` decimal(15,2) NOT NULL,
  `balance_amount` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `note` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `document` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` int(11) NOT NULL,
  `payment_type` varchar(200) NOT NULL,
  `api_username` varchar(200) DEFAULT NULL,
  `api_secret_key` varchar(200) NOT NULL,
  `salt` varchar(200) NOT NULL,
  `api_publishable_key` varchar(200) NOT NULL,
  `api_password` varchar(200) DEFAULT NULL,
  `api_signature` varchar(200) DEFAULT NULL,
  `api_email` varchar(200) DEFAULT NULL,
  `paypal_demo` varchar(100) NOT NULL,
  `account_no` varchar(200) NOT NULL,
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payslip_allowance`
--

CREATE TABLE `payslip_allowance` (
  `id` int(11) NOT NULL,
  `payslip_id` int(11) NOT NULL,
  `allowance_type` varchar(200) NOT NULL,
  `amount` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `cal_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permission_category`
--

CREATE TABLE `permission_category` (
  `id` int(11) NOT NULL,
  `perm_group_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `short_code` varchar(100) DEFAULT NULL,
  `enable_view` int(11) DEFAULT 0,
  `enable_add` int(11) DEFAULT 0,
  `enable_edit` int(11) DEFAULT 0,
  `enable_delete` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_category`
--

INSERT INTO `permission_category` (`id`, `perm_group_id`, `name`, `short_code`, `enable_view`, `enable_add`, `enable_edit`, `enable_delete`, `created_at`) VALUES
(9, 3, 'Income', 'income', 1, 1, 1, 1, '2018-06-22 15:53:21'),
(10, 3, 'Income Head', 'income_head', 1, 1, 1, 1, '2018-06-22 15:52:44'),
(12, 4, 'Expense', 'expense', 1, 1, 1, 1, '2018-06-22 15:54:06'),
(13, 4, 'Expense Head', 'expense_head', 1, 1, 1, 1, '2018-06-22 15:53:47'),
(14, 4, 'Search Expense', 'search_expense', 1, 0, 0, 0, '2018-06-22 15:54:13'),
(27, 8, 'Upload Content', 'upload_content', 1, 1, 0, 1, '2018-06-22 16:03:19'),
(31, 10, 'Issue Item', 'issue_item', 1, 1, 0, 1, '2018-12-17 15:25:14'),
(32, 10, 'Item Stock', 'item_stock', 1, 1, 1, 1, '2018-06-22 16:05:17'),
(33, 10, 'Item', 'item', 1, 1, 1, 1, '2018-06-22 16:05:40'),
(34, 10, 'Store', 'store', 1, 1, 1, 1, '2018-06-22 16:06:02'),
(35, 10, 'Supplier', 'supplier', 1, 1, 1, 1, '2018-06-22 16:06:25'),
(43, 13, 'Notice Board', 'notice_board', 1, 1, 1, 1, '2018-06-22 16:11:17'),
(44, 13, 'Email / SMS', 'email_sms', 1, 0, 0, 0, '2018-06-22 16:10:54'),
(46, 13, 'Email / SMS Log', 'email_sms_log', 1, 0, 0, 0, '2018-06-22 16:11:23'),
(48, 14, 'OPD Report', 'opd_report', 1, 0, 0, 0, '2018-12-18 14:29:18'),
(53, 15, 'Languages', 'languages', 0, 1, 0, 0, '2018-06-22 16:13:18'),
(54, 15, 'General Setting', 'general_setting', 1, 0, 1, 0, '2018-07-05 14:38:35'),
(56, 15, 'Notification Setting', 'notification_setting', 1, 0, 1, 0, '2018-07-05 14:38:41'),
(57, 15, 'SMS Setting', 'sms_setting', 1, 0, 1, 0, '2018-07-05 14:38:47'),
(58, 15, 'Email Setting', 'email_setting', 1, 0, 1, 0, '2018-07-05 14:38:51'),
(59, 15, 'Front CMS Setting', 'front_cms_setting', 1, 0, 1, 0, '2018-07-05 14:38:55'),
(60, 15, 'Payment Methods', 'payment_methods', 1, 0, 1, 0, '2018-07-05 14:38:59'),
(61, 16, 'Menus', 'menus', 1, 1, 0, 1, '2018-07-09 09:20:06'),
(62, 16, 'Media Manager', 'media_manager', 1, 1, 0, 1, '2018-07-09 09:20:26'),
(63, 16, 'Banner Images', 'banner_images', 1, 1, 0, 1, '2018-06-22 16:16:02'),
(64, 16, 'Pages', 'pages', 1, 1, 1, 1, '2018-06-22 16:16:21'),
(65, 16, 'Gallery', 'gallery', 1, 1, 1, 1, '2018-06-22 16:17:02'),
(66, 16, 'Event', 'event', 1, 1, 1, 1, '2018-06-22 16:17:20'),
(67, 16, 'News', 'notice', 1, 1, 1, 1, '2018-07-03 14:09:34'),
(80, 17, 'Visitor Book', 'visitor_book', 1, 1, 1, 1, '2018-06-22 16:18:58'),
(81, 17, 'Phone Call Log', 'phone_call_log', 1, 1, 1, 1, '2018-06-22 16:20:57'),
(82, 17, 'Postal Dispatch', 'postal_dispatch', 1, 1, 1, 1, '2018-06-22 16:20:21'),
(83, 17, 'Postal Receive', 'postal_receive', 1, 1, 1, 1, '2018-06-22 16:20:04'),
(84, 17, 'Complain', 'complain', 1, 1, 1, 1, '2018-12-19 14:41:37'),
(85, 17, 'Setup Front Office', 'setup_front_office', 1, 1, 1, 1, '2018-11-15 06:19:58'),
(86, 18, 'Staff', 'staff', 1, 1, 1, 1, '2018-06-22 16:23:31'),
(87, 18, 'Disable Staff', 'disable_staff', 1, 0, 0, 0, '2018-06-22 16:23:12'),
(88, 18, 'Staff Attendance', 'staff_attendance', 1, 1, 1, 0, '2018-06-22 16:23:10'),
(89, 18, 'Staff Attendance Report', 'staff_attendance_report', 1, 0, 0, 0, '2018-06-22 16:22:54'),
(90, 18, 'Staff Payroll', 'staff_payroll', 1, 1, 0, 1, '2018-06-22 16:22:51'),
(91, 18, 'Payroll Report', 'payroll_report', 1, 0, 0, 0, '2018-06-22 16:22:34'),
(102, 21, 'Calendar To Do List', 'calendar_to_do_list', 1, 1, 1, 1, '2018-06-22 16:24:41'),
(104, 10, 'Item Category', 'item_category', 1, 1, 1, 1, '2018-06-22 16:04:33'),
(108, 18, ' Approve Leave Request', 'approve_leave_request', 1, 1, 1, 1, '2018-07-02 15:47:41'),
(109, 18, 'Apply Leave', 'apply_leave', 1, 1, 1, 1, '2018-06-26 09:23:32'),
(110, 18, 'Leave Types ', 'leave_types', 1, 1, 1, 1, '2018-07-02 15:47:56'),
(111, 18, 'Department', 'department', 1, 1, 1, 1, '2018-06-26 09:27:07'),
(112, 18, 'Designation', 'designation', 1, 1, 1, 1, '2018-06-26 09:27:07'),
(118, 22, 'Staff Role Count Widget', 'staff_role_count_widget', 1, 0, 0, 0, '2018-07-03 12:43:35'),
(126, 15, 'User Status', 'user_status', 1, 0, 0, 0, '2018-07-03 14:12:29'),
(127, 18, 'Can See Other Users Profile', 'can_see_other_users_profile', 1, 0, 0, 0, '2018-07-03 14:12:29'),
(129, 18, 'Staff Timeline', 'staff_timeline', 0, 1, 0, 1, '2018-07-05 13:38:52'),
(130, 15, 'Backup', 'backup', 1, 1, 0, 1, '2018-07-09 09:47:17'),
(131, 15, 'Restore', 'restore', 1, 0, 0, 0, '2018-07-09 09:47:17'),
(132, 23, 'OPD Patient', 'opd_patient', 1, 1, 1, 1, '2018-12-20 15:07:26'),
(134, 23, 'Prescription', 'prescription', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(135, 23, 'Revisit', 'revisit', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(136, 23, 'OPD Diagnosis', 'opd diagnosis', 1, 1, 1, 1, '2018-10-11 12:16:59'),
(137, 23, 'OPD Timeline', 'opd timeline', 1, 1, 1, 1, '2018-10-11 12:17:22'),
(138, 24, 'IPD Patients', 'ipd_patient', 1, 1, 1, 1, '2018-10-11 12:44:55'),
(139, 24, 'Discharged Patients', 'discharged patients', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(140, 24, 'Consultant Register', 'consultant register', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(141, 24, 'IPD Diagnosis', 'ipd diagnosis', 1, 1, 1, 1, '2018-10-11 12:19:18'),
(142, 24, 'IPD Timeline', 'ipd timeline', 1, 1, 1, 1, '2018-10-11 12:19:42'),
(143, 24, 'Charges', 'charges', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(144, 24, 'Payment', 'payment', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(145, 24, 'Bill', 'bill', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(146, 25, 'Medicine', 'medicine', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(147, 25, 'Add Medicine Stock', 'add_medicine_stock', 1, 1, 1, 1, '2018-12-21 16:19:20'),
(148, 25, 'Pharmacy Bill', 'pharmacy bill', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(149, 26, 'Pathology Test', 'pathology test', 1, 1, 1, 1, '2018-12-22 14:16:42'),
(150, 26, 'Add Patient & Test Report', 'add_patho_patient_test_report', 1, 1, 1, 1, '2019-10-18 12:35:57'),
(152, 27, 'Radiology Test', 'radiology test', 1, 1, 1, 1, '2018-10-11 06:58:26'),
(153, 27, 'Add Patient & Test Report', 'add_radio_patient_test_reprt', 1, 1, 1, 1, '2019-10-18 12:35:49'),
(155, 22, 'IPD Income Widget', 'ipd_income_widget', 1, 0, 0, 0, '2018-12-20 14:38:05'),
(156, 22, 'OPD Income Widget', 'opd_income_widget', 1, 0, 0, 0, '2018-12-20 14:38:15'),
(157, 22, 'Pharmacy Income Widget', 'pharmacy_income_widget', 1, 0, 0, 0, '2018-12-20 14:38:25'),
(158, 22, 'Pathology Income Widget', 'pathology_income_widget', 1, 0, 0, 0, '2018-12-20 14:38:37'),
(159, 22, 'Radiology Income Widget', 'radiology_income_widget', 1, 0, 0, 0, '2018-12-20 14:38:49'),
(160, 22, 'OT Income Widget', 'ot_income_widget', 1, 0, 0, 0, '2018-12-20 14:39:02'),
(161, 22, 'Blood Bank Income Widget', 'blood_bank_income_widget', 1, 0, 0, 0, '2018-12-20 14:39:13'),
(162, 22, 'Ambulance Income Widget', 'ambulance_income_widget', 1, 0, 0, 0, '2018-12-20 14:39:25'),
(163, 28, 'OT Patient', 'ot_patient', 1, 1, 1, 1, '2018-10-27 09:05:57'),
(164, 28, 'OT Consultant Instruction', 'ot_consultant_instruction', 1, 1, 1, 1, '2018-10-27 09:06:19'),
(165, 29, 'Ambulance Call', 'ambulance_call', 1, 1, 1, 1, '2018-10-27 09:07:51'),
(166, 29, 'Ambulance', 'ambulance', 1, 1, 1, 1, '2018-10-27 09:07:59'),
(167, 30, 'Blood Bank Status', 'blood_bank_status', 1, 1, 1, 1, '2018-10-27 09:50:09'),
(168, 30, 'Blood Issue', 'blood_issue', 1, 1, 1, 1, '2018-10-27 09:50:15'),
(169, 30, 'Blood Donor', 'blood_donor', 1, 1, 1, 1, '2018-10-27 09:50:19'),
(170, 25, 'Medicine Category', 'medicine_category', 1, 1, 1, 1, '2018-10-25 11:40:24'),
(171, 27, 'Radiology Category', 'radiology category', 1, 1, 1, 1, '2018-12-22 14:33:20'),
(173, 31, 'Organisation', 'organisation', 1, 1, 1, 1, '2018-10-25 11:40:24'),
(174, 31, 'Charges', 'tpa_charges', 1, 1, 1, 1, '2018-12-22 15:36:57'),
(175, 26, 'Pathology Category', 'pathology_category', 1, 1, 1, 1, '2018-10-25 11:40:24'),
(176, 32, 'Charges', 'hospital_charges', 1, 1, 1, 1, '2018-12-22 15:38:26'),
(178, 14, 'IPD Report', 'ipd_report', 1, 0, 0, 0, '2018-12-12 15:39:24'),
(179, 14, 'Pharmacy Bill Report', 'pharmacy_bill_report', 1, 0, 0, 0, '2018-12-12 15:39:24'),
(180, 14, 'Pathology Patient Report', 'pathology_patient_report', 1, 0, 0, 0, '2018-12-12 15:39:24'),
(181, 14, 'Radiology Patient Report', 'radiology_patient_report', 1, 0, 0, 0, '2018-12-12 15:39:24'),
(182, 14, 'OT Report', 'ot_report', 1, 0, 0, 0, '2019-03-08 12:26:54'),
(183, 14, 'Blood Donor Report', 'blood_donor_report', 1, 0, 0, 0, '2018-12-12 15:39:24'),
(184, 14, 'Payroll Month Report', 'payroll_month_report', 1, 0, 0, 0, '2019-03-08 12:27:25'),
(185, 14, 'Payroll Report', 'payroll_report', 1, 0, 0, 0, '2019-03-08 12:27:35'),
(186, 14, 'Staff Attendance Report', 'staff_attendance_report', 1, 0, 0, 0, '2019-03-08 12:33:28'),
(187, 14, 'User Log', 'user_log', 1, 0, 0, 0, '2018-12-12 15:39:24'),
(188, 14, 'Patient Login Credential', 'patient_login_credential', 1, 0, 0, 0, '2018-12-12 15:39:24'),
(189, 14, 'Email / SMS Log', 'email_sms_log', 1, 0, 0, 0, '2018-12-12 15:39:24'),
(190, 22, 'Yearly Income & Expense Chart', 'yearly_income_expense_chart', 1, 0, 0, 0, '2018-12-12 15:52:05'),
(191, 22, 'Monthly Income & Expense Chart', 'monthly_income_expense_chart', 1, 0, 0, 0, '2018-12-12 15:55:14'),
(192, 23, 'OPD Prescription Print Header Footer ', 'opd_prescription_print_header_footer', 1, 1, 1, 1, '2018-12-12 16:01:07'),
(193, 24, 'Revert Generated Bill', 'revert_generated_bill', 1, 0, 0, 0, '2018-12-12 16:04:02'),
(194, 24, 'Calculate Bill', 'calculate_bill', 1, 0, 0, 0, '2018-12-12 16:05:30'),
(195, 24, 'Generate Bill & Discharge Patient', 'generate_bill_discharge_patient', 1, 0, 0, 0, '2018-12-21 14:56:00'),
(196, 24, 'Bed', 'bed', 1, 1, 1, 1, '2018-12-12 16:16:01'),
(197, 24, 'IPD Prescription Print Header Footer', 'ipd_prescription_print_header_footer', 1, 1, 1, 1, '2018-12-12 16:09:42'),
(198, 24, 'Bed Status', 'bed_status', 1, 0, 0, 0, '2018-12-12 16:09:42'),
(200, 25, 'Medicine Bad Stock', 'medicine_bad_stock', 1, 1, 0, 1, '2018-12-18 06:42:46'),
(201, 25, 'Pharmacy Bill print Header Footer', 'pharmacy_bill_print_header_footer', 1, 1, 1, 1, '2018-12-12 16:36:47'),
(202, 30, 'Donate Blood', 'donate_blood', 1, 1, 0, 1, '2018-12-12 16:47:10'),
(203, 32, 'Charge Category', 'charge_category', 1, 1, 1, 1, '2018-12-12 16:49:38'),
(204, 17, 'Appointment', 'appointment', 1, 1, 1, 1, '2018-12-18 17:22:53'),
(205, 17, 'Appointment Approve', 'appointment_approve', 1, 0, 0, 0, '2018-12-18 17:25:58'),
(206, 14, 'TPA Report', 'tpa_report', 1, 0, 0, 0, '2019-03-08 12:19:25'),
(207, 14, 'Ambulance Report', 'ambulance_report', 1, 0, 0, 0, '2019-03-08 12:19:41'),
(208, 14, 'Discharge Patient Report', 'discharge_patient_report', 1, 0, 0, 0, '2019-03-08 12:19:55'),
(209, 14, 'Appointment Report', 'appointment_report', 1, 0, 0, 0, '2019-03-08 12:20:10'),
(210, 14, 'Transaction Report', 'transaction_report', 1, 0, 0, 0, '2019-03-08 12:27:35'),
(211, 14, 'Blood Issue Report', 'blood_issue_report', 1, 0, 0, 0, '2019-03-08 12:27:35'),
(212, 14, 'Income Report', 'income_report', 1, 0, 0, 0, '2019-03-08 12:27:35'),
(213, 14, 'Expense Report', 'expense_report', 1, 0, 0, 0, '2019-03-08 12:27:35'),
(214, 34, 'Birth Record', 'birth_record', 1, 1, 1, 1, '2018-06-22 16:06:02'),
(215, 34, 'Death Record', 'death_record', 1, 1, 1, 1, '2018-06-22 16:06:02'),
(216, 17, 'Move Patient in OPD', 'move_patient_in_opd', 1, 0, 0, 0, '2019-09-23 10:14:41'),
(217, 17, 'Move Patient in IPD', 'move_patient_in_ipd', 1, 0, 0, 0, '2018-12-18 17:25:58'),
(218, 23, 'Move Patient in IPD', 'opd_move _patient_in_ipd', 1, 0, 0, 0, '2019-09-23 10:19:42'),
(219, 23, 'Manual Prescription', 'manual_prescription', 1, 0, 0, 0, '2019-09-23 10:22:06'),
(220, 24, 'Prescription ', 'ipd_prescription', 1, 1, 1, 1, '2019-09-24 06:29:27'),
(221, 23, 'Charges', 'opd_charges', 1, 1, 1, 1, '2019-09-23 10:28:03'),
(222, 23, 'Payment', 'opd_payment', 1, 1, 1, 1, '2019-09-24 06:14:29'),
(223, 23, 'Bill', 'opd_bill', 1, 1, 1, 1, '2019-09-23 10:29:37'),
(224, 25, 'Import Medicine', 'import_medicine', 1, 0, 0, 0, '2019-09-23 10:33:31'),
(225, 25, 'Medicine Purchase', 'medicine_purchase', 1, 1, 1, 1, '2019-09-23 10:35:53'),
(226, 25, 'Medicine Supplier', 'medicine_supplier', 1, 1, 1, 1, '2019-09-23 10:39:36'),
(227, 25, 'Medicine Dosage', 'medicine_dosage', 1, 1, 1, 1, '2019-09-23 10:47:16'),
(228, 32, 'Doctor OPD Charges', 'doctor_opd_charges', 1, 1, 1, 1, '2019-09-23 10:50:26'),
(229, 18, 'Staff Import', 'staff_import', 1, 0, 0, 0, '2019-09-23 10:51:39'),
(236, 36, 'Patient', 'patient', 1, 1, 1, 1, '2019-09-23 11:55:35'),
(237, 36, 'Enabled/Disabled', 'enabled_disabled', 1, 0, 0, 0, '2019-09-23 11:55:35'),
(238, 22, 'Notification Center', 'notification_center', 1, 0, 0, 0, '2019-09-24 09:18:33'),
(239, 36, 'Import', 'patient_import', 1, 0, 0, 0, '2019-10-04 06:50:26'),
(240, 34, 'Birth Print Header Footer', 'birth_print_header_footer', 1, 1, 1, 1, '2019-10-04 08:14:01'),
(241, 34, 'Custom Fields', 'birth_death_customfields', 1, 1, 1, 1, '2019-10-04 06:53:55'),
(242, 34, 'Death Print Header Footer', 'death_print_header_footer', 1, 1, 1, 1, '2019-10-04 08:13:56'),
(243, 26, 'Print Header Footer', 'pathology_print_header_footer', 1, 1, 1, 1, '2019-10-04 07:06:15'),
(244, 27, 'Print Header Footer', 'radiology_print_header_footer', 1, 1, 1, 1, '2019-10-04 07:10:01'),
(245, 28, 'Print Header Footer', 'ot_print_header_footer', 1, 1, 1, 1, '2019-10-04 07:11:15'),
(246, 30, 'Print Header Footer', 'bloodbank_print_header_footer', 1, 1, 1, 1, '2019-10-04 08:17:17'),
(247, 29, 'Print Header Footer', 'ambulance_print_header_footer', 1, 1, 1, 1, '2019-10-04 07:15:03'),
(248, 24, 'IPD Bill Print Header Footer', 'ipd_bill_print_header_footer', 1, 1, 1, 1, '2019-10-04 07:43:28'),
(249, 18, 'Print Payslip Header Footer', 'print_payslip_header_footer', 1, 1, 1, 1, '2019-10-04 08:01:33'),
(250, 14, 'Income Group Report', 'income_group_report\r\n', 1, 0, 0, 0, '2019-10-04 09:35:55'),
(251, 14, 'Expense Group Report', 'expense_group_report', 1, 0, 0, 0, '2019-10-04 09:45:56'),
(252, 3, 'Search Income', 'search_income', 1, 0, 0, 0, '2019-10-04 09:47:12'),
(253, 14, 'Inventory Stock Report', 'inventory_stock_report', 1, 0, 0, 0, '2019-10-04 10:50:31'),
(254, 14, 'Inventory Item Report', 'add_item_report', 1, 0, 0, 0, '2019-10-04 10:53:22'),
(255, 14, 'Inventory Issue Report', 'issue_inventory_report', 1, 0, 0, 0, '2019-10-04 10:54:40'),
(256, 14, 'Expiry Medicine Report', 'expiry_medicine_report', 1, 0, 0, 0, '2019-10-04 11:30:11'),
(257, 26, 'Pathology Bill', 'pathology bill', 1, 1, 1, 1, '2018-12-22 14:16:42'),
(258, 14, 'Birth Report', 'birth_report', 1, 0, 0, 0, '2019-10-14 08:42:35'),
(259, 14, 'Death Report', 'death_report', 1, 0, 0, 0, '2019-10-14 08:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `permission_group`
--

CREATE TABLE `permission_group` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `short_code` varchar(100) NOT NULL,
  `is_active` int(11) DEFAULT 0,
  `system` int(11) NOT NULL,
  `sort_order` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_group`
--

INSERT INTO `permission_group` (`id`, `name`, `short_code`, `is_active`, `system`, `sort_order`, `created_at`) VALUES
(3, 'Income', 'income', 1, 0, '9.00', '2018-12-23 16:26:51'),
(4, 'Expense', 'expense', 1, 0, '10.00', '2018-12-18 10:20:47'),
(8, 'Download Center', 'download_center', 1, 0, '15.00', '2018-12-18 10:23:12'),
(10, 'Inventory', 'inventory', 1, 0, '16.00', '2018-12-18 10:23:27'),
(13, 'Messaging', 'communicate', 1, 0, '14.00', '2018-12-18 10:22:54'),
(14, 'Reports', 'reports', 1, 1, '19.00', '2018-12-18 10:24:41'),
(15, 'System Settings', 'system_settings', 1, 1, '18.00', '2018-12-18 10:24:23'),
(16, 'Front CMS', 'front_cms', 1, 0, '17.00', '2018-12-18 10:23:47'),
(17, 'Front Office', 'front_office', 1, 0, '12.00', '2018-12-18 10:21:58'),
(18, 'Human Resource', 'human_resource', 1, 1, '13.00', '2018-12-18 10:22:37'),
(21, 'Calendar To Do List', 'calendar_to_do_list', 1, 0, '22.00', '2019-10-04 07:26:23'),
(22, 'Dashboard and Widgets', 'dashboard_and_widgets', 1, 1, '20.00', '2018-12-18 10:24:51'),
(23, 'OPD', 'OPD', 1, 0, '1.00', '2019-11-01 12:36:37'),
(24, 'IPD', 'IPD', 1, 0, '2.00', '2019-10-30 13:05:10'),
(25, 'Pharmacy', 'pharmacy', 1, 0, '3.00', '2018-12-18 10:02:51'),
(26, 'Pathology', 'pathology', 1, 0, '4.00', '2018-12-18 10:02:56'),
(27, 'Radiology', 'radiology', 1, 0, '5.00', '2018-12-18 10:03:00'),
(28, 'Operation Theatre', 'operation_theatre', 1, 0, '6.00', '2018-12-18 10:03:05'),
(29, 'Ambulance', 'ambulance', 1, 0, '11.00', '2018-12-18 10:20:57'),
(30, 'Blood Bank', 'blood_bank', 1, 0, '7.00', '2018-12-18 10:19:14'),
(31, 'TPA Management', 'tpa_management', 1, 0, '8.00', '2018-12-18 10:19:39'),
(32, 'Hospital Charges', 'hospital_charges', 1, 1, '10.10', '2019-03-10 07:08:22'),
(34, 'Birth Death Record', 'birth_death_report', 1, 0, '12.00', '2019-10-04 07:18:39'),
(36, 'Patient', 'patient', 1, 0, '21.00', '2019-10-04 07:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(200) DEFAULT NULL,
  `medicine_category_id` varchar(50) NOT NULL,
  `medicine_image` varchar(200) NOT NULL,
  `medicine_company` varchar(100) DEFAULT NULL,
  `medicine_composition` varchar(100) DEFAULT NULL,
  `medicine_group` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `min_level` varchar(50) DEFAULT NULL,
  `reorder_level` varchar(50) DEFAULT NULL,
  `vat` varchar(50) DEFAULT NULL,
  `unit_packing` varchar(50) DEFAULT NULL,
  `supplier` varchar(50) DEFAULT NULL,
  `vat_ac` varchar(50) DEFAULT NULL,
  `note` varchar(200) NOT NULL,
  `is_active` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_bill_basic`
--

CREATE TABLE `pharmacy_bill_basic` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `patient_id` varchar(200) NOT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `doctor_name` varchar(50) DEFAULT NULL,
  `file` varchar(200) NOT NULL,
  `opd_ipd_no` varchar(50) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `discount` decimal(15,2) NOT NULL,
  `tax` decimal(15,2) NOT NULL,
  `net_amount` decimal(15,2) NOT NULL,
  `note` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_bill_detail`
--

CREATE TABLE `pharmacy_bill_detail` (
  `id` int(11) NOT NULL,
  `pharmacy_bill_basic_id` varchar(50) NOT NULL,
  `medicine_category_id` int(11) NOT NULL,
  `medicine_name` varchar(200) NOT NULL,
  `expire_date` varchar(100) NOT NULL,
  `batch_no` varchar(200) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `sale_price` decimal(15,2) NOT NULL,
  `amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(11) NOT NULL,
  `opd_id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `medicine_category_id` int(11) NOT NULL,
  `medicine` varchar(200) NOT NULL,
  `dosage` varchar(200) NOT NULL,
  `instruction` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `print_setting`
--

CREATE TABLE `print_setting` (
  `id` int(11) NOT NULL,
  `print_header` varchar(300) NOT NULL,
  `print_footer` varchar(200) NOT NULL,
  `setting_for` varchar(200) NOT NULL,
  `is_active` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `radio`
--

CREATE TABLE `radio` (
  `id` int(11) NOT NULL,
  `test_name` varchar(100) DEFAULT NULL,
  `short_name` varchar(100) DEFAULT NULL,
  `test_type` varchar(100) DEFAULT NULL,
  `radiology_category_id` varchar(11) NOT NULL,
  `sub_category` varchar(50) NOT NULL,
  `report_days` varchar(50) NOT NULL,
  `charge_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `radiology_report`
--

CREATE TABLE `radiology_report` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(200) NOT NULL,
  `radiology_id` int(11) NOT NULL,
  `patient_id` varchar(11) DEFAULT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `consultant_doctor` varchar(10) NOT NULL,
  `reporting_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `radiology_report` varchar(255) DEFAULT NULL,
  `apply_charge` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `read_notification`
--

CREATE TABLE `read_notification` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `read_systemnotification`
--

CREATE TABLE `read_systemnotification` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `is_active` varchar(200) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `is_active` int(11) DEFAULT 0,
  `is_system` int(1) NOT NULL DEFAULT 0,
  `is_superadmin` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `is_active`, `is_system`, `is_superadmin`, `created_at`) VALUES
(1, 'Admin', NULL, 0, 1, 0, '2018-12-25 11:49:43'),
(2, 'Accountant', NULL, 0, 1, 0, '2018-12-25 11:49:38'),
(3, 'Doctor', NULL, 0, 1, 0, '2018-07-21 10:37:36'),
(4, 'Pharmacist', NULL, 0, 1, 0, '2018-07-21 10:38:26'),
(5, 'Pathologist', NULL, 0, 1, 0, '2018-12-25 11:49:59'),
(6, 'Radiologist', NULL, 0, 1, 0, '2018-12-25 11:50:27'),
(7, 'Super Admin', NULL, 0, 1, 1, '2018-12-25 11:52:24'),
(8, 'Receptionist', NULL, 0, 1, 0, '2018-12-25 11:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `perm_cat_id` int(11) DEFAULT NULL,
  `can_view` int(11) DEFAULT NULL,
  `can_add` int(11) DEFAULT NULL,
  `can_edit` int(11) DEFAULT NULL,
  `can_delete` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role_id`, `perm_cat_id`, `can_view`, `can_add`, `can_edit`, `can_delete`, `created_at`) VALUES
(1, 1, 132, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(3, 1, 134, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(4, 1, 135, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(5, 1, 136, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(6, 1, 137, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(7, 1, 192, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(8, 1, 138, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(9, 1, 139, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(10, 1, 140, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(11, 1, 141, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(12, 1, 142, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(13, 1, 143, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(14, 1, 144, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(15, 1, 145, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(16, 1, 193, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(17, 1, 194, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(18, 1, 195, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(19, 1, 196, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(20, 1, 197, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(21, 1, 198, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(22, 1, 146, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(23, 1, 147, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(24, 1, 148, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(25, 1, 170, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(26, 1, 200, 1, 1, 0, 1, '2019-03-09 17:26:01'),
(27, 1, 201, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(28, 1, 149, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(29, 1, 150, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(30, 1, 175, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(31, 1, 152, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(32, 1, 153, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(33, 1, 171, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(34, 1, 163, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(35, 1, 164, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(36, 1, 167, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(37, 1, 168, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(38, 1, 169, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(39, 1, 202, 1, 1, 0, 1, '2019-03-09 17:26:01'),
(40, 1, 173, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(41, 1, 174, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(42, 1, 9, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(43, 1, 10, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(45, 1, 176, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(46, 1, 203, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(47, 1, 12, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(48, 1, 13, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(49, 1, 14, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(50, 1, 165, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(51, 1, 166, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(52, 1, 80, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(53, 1, 81, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(54, 1, 82, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(55, 1, 83, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(56, 1, 84, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(57, 1, 85, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(58, 1, 204, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(59, 1, 205, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(60, 1, 86, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(61, 1, 87, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(62, 1, 88, 1, 1, 1, 0, '2019-03-09 17:26:01'),
(63, 1, 89, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(64, 1, 90, 1, 1, 0, 1, '2019-03-09 17:26:01'),
(65, 1, 91, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(66, 1, 108, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(67, 1, 109, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(68, 1, 110, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(69, 1, 111, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(70, 1, 112, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(71, 1, 127, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(72, 1, 129, 0, 1, 0, 1, '2019-03-09 17:26:01'),
(73, 1, 43, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(74, 1, 44, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(75, 1, 46, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(76, 1, 27, 1, 1, 0, 1, '2019-03-09 17:26:01'),
(77, 1, 31, 1, 1, 0, 1, '2019-03-09 17:26:01'),
(78, 1, 32, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(79, 1, 33, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(80, 1, 34, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(81, 1, 35, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(82, 1, 104, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(83, 1, 61, 1, 1, 0, 1, '2019-03-09 17:26:01'),
(84, 1, 62, 1, 1, 0, 1, '2019-03-09 17:26:01'),
(85, 1, 63, 1, 1, 0, 1, '2019-03-09 17:26:01'),
(86, 1, 64, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(87, 1, 65, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(88, 1, 66, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(89, 1, 67, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(90, 1, 53, 0, 1, 0, 0, '2019-03-09 17:26:01'),
(91, 1, 54, 1, 0, 1, 0, '2019-03-09 17:26:01'),
(92, 1, 56, 1, 0, 1, 0, '2019-03-09 17:26:01'),
(93, 1, 57, 1, 0, 1, 0, '2019-03-09 17:26:01'),
(94, 1, 58, 1, 0, 1, 0, '2019-03-09 17:26:01'),
(95, 1, 59, 1, 0, 1, 0, '2019-03-09 17:26:01'),
(96, 1, 60, 1, 0, 1, 0, '2019-03-09 17:26:01'),
(97, 1, 126, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(98, 1, 130, 1, 1, 0, 1, '2019-03-09 17:26:01'),
(99, 1, 131, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(100, 1, 48, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(101, 1, 178, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(102, 1, 179, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(103, 1, 180, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(104, 1, 181, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(105, 1, 182, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(106, 1, 183, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(107, 1, 184, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(108, 1, 185, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(109, 1, 186, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(110, 1, 187, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(111, 1, 188, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(112, 1, 189, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(113, 1, 206, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(114, 1, 207, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(115, 1, 208, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(116, 1, 209, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(117, 1, 210, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(118, 1, 211, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(119, 1, 212, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(120, 1, 213, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(121, 1, 118, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(122, 1, 155, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(123, 1, 156, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(124, 1, 157, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(125, 1, 158, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(126, 1, 159, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(127, 1, 160, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(128, 1, 161, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(129, 1, 162, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(130, 1, 190, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(131, 1, 191, 1, 0, 0, 0, '2019-03-09 17:26:01'),
(132, 1, 102, 1, 1, 1, 1, '2019-03-09 17:26:01'),
(133, 2, 132, 1, 1, 1, 0, '2019-03-09 17:43:21'),
(134, 2, 135, 1, 1, 1, 0, '2019-03-09 17:43:21'),
(135, 2, 138, 1, 1, 1, 0, '2019-03-09 17:43:21'),
(136, 2, 139, 1, 1, 1, 0, '2019-03-09 17:43:21'),
(137, 2, 143, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(138, 2, 144, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(139, 2, 145, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(140, 2, 193, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(141, 2, 194, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(142, 2, 195, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(143, 2, 196, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(144, 2, 198, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(145, 2, 148, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(146, 2, 149, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(147, 2, 150, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(148, 2, 152, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(149, 2, 153, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(150, 2, 163, 1, 1, 1, 0, '2019-03-09 17:43:21'),
(151, 2, 167, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(152, 2, 168, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(153, 2, 173, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(154, 2, 174, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(155, 2, 9, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(156, 2, 10, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(158, 2, 176, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(159, 2, 203, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(160, 2, 12, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(161, 2, 13, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(162, 2, 14, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(163, 2, 165, 1, 1, 1, 0, '2019-03-09 17:43:21'),
(164, 2, 166, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(165, 2, 204, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(166, 2, 205, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(167, 2, 86, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(168, 2, 87, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(169, 2, 88, 1, 1, 1, 0, '2019-03-09 17:43:21'),
(170, 2, 89, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(171, 2, 90, 1, 1, 0, 1, '2019-03-09 17:43:21'),
(172, 2, 91, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(173, 2, 108, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(174, 2, 109, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(175, 2, 110, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(176, 2, 111, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(177, 2, 112, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(178, 2, 127, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(179, 2, 129, 0, 1, 0, 1, '2019-03-09 17:43:21'),
(180, 2, 43, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(181, 2, 44, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(182, 2, 46, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(183, 2, 27, 1, 1, 0, 1, '2019-03-09 17:43:21'),
(184, 2, 31, 1, 1, 0, 1, '2019-03-09 17:43:21'),
(185, 2, 32, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(186, 2, 33, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(187, 2, 34, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(188, 2, 35, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(189, 2, 104, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(190, 2, 48, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(191, 2, 178, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(192, 2, 179, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(193, 2, 180, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(194, 2, 181, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(195, 2, 182, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(196, 2, 184, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(197, 2, 185, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(198, 2, 186, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(199, 2, 188, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(200, 2, 189, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(201, 2, 206, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(202, 2, 207, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(203, 2, 208, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(204, 2, 209, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(205, 2, 210, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(206, 2, 211, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(207, 2, 212, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(208, 2, 213, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(209, 2, 118, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(210, 2, 155, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(211, 2, 156, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(212, 2, 157, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(213, 2, 158, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(214, 2, 159, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(215, 2, 160, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(216, 2, 161, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(217, 2, 162, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(218, 2, 190, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(219, 2, 191, 1, 0, 0, 0, '2019-03-09 17:43:21'),
(220, 2, 102, 1, 1, 1, 1, '2019-03-09 17:43:21'),
(221, 3, 132, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(222, 3, 134, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(223, 3, 135, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(224, 3, 136, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(225, 3, 137, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(226, 3, 138, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(227, 3, 139, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(228, 3, 140, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(229, 3, 141, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(230, 3, 142, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(231, 3, 143, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(232, 3, 144, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(233, 3, 145, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(234, 3, 194, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(235, 3, 198, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(236, 3, 163, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(237, 3, 164, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(238, 3, 167, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(239, 3, 166, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(240, 3, 204, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(241, 3, 205, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(242, 3, 86, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(243, 3, 109, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(244, 3, 127, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(245, 3, 43, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(246, 3, 44, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(248, 3, 27, 1, 1, 0, 1, '2019-03-10 07:17:01'),
(249, 3, 48, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(250, 3, 178, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(251, 3, 182, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(253, 3, 208, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(254, 3, 209, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(255, 3, 118, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(256, 3, 155, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(257, 3, 156, 1, 0, 0, 0, '2019-03-10 07:17:01'),
(262, 3, 102, 1, 1, 1, 1, '2019-03-10 07:17:01'),
(263, 4, 146, 1, 1, 1, 1, '2019-03-10 07:21:00'),
(264, 4, 147, 1, 1, 1, 1, '2019-03-10 07:21:00'),
(265, 4, 148, 1, 1, 1, 1, '2019-10-12 11:04:19'),
(266, 4, 170, 1, 1, 1, 1, '2019-03-10 07:21:00'),
(267, 4, 200, 1, 1, 0, 1, '2019-03-10 07:21:00'),
(268, 4, 86, 1, 0, 0, 0, '2019-03-10 07:21:00'),
(269, 4, 43, 1, 1, 1, 1, '2019-03-10 07:21:00'),
(270, 4, 44, 1, 0, 0, 0, '2019-03-10 07:21:00'),
(272, 4, 27, 1, 1, 0, 1, '2019-03-10 07:21:00'),
(273, 4, 179, 1, 0, 0, 0, '2019-03-10 07:21:00'),
(274, 4, 118, 1, 0, 0, 0, '2019-03-10 07:21:00'),
(275, 4, 157, 1, 0, 0, 0, '2019-03-10 07:21:00'),
(276, 4, 102, 1, 1, 1, 1, '2019-03-10 07:21:00'),
(277, 5, 149, 1, 1, 1, 1, '2019-03-10 07:23:30'),
(278, 5, 150, 1, 1, 1, 1, '2019-03-10 07:23:30'),
(279, 5, 175, 1, 1, 1, 1, '2019-03-10 07:23:30'),
(280, 5, 86, 1, 0, 0, 0, '2019-03-10 07:23:30'),
(281, 5, 109, 1, 1, 1, 1, '2019-03-10 07:23:30'),
(282, 5, 43, 1, 1, 1, 1, '2019-03-10 07:23:30'),
(283, 5, 44, 1, 0, 0, 0, '2019-03-10 07:23:30'),
(285, 5, 27, 1, 1, 0, 1, '2019-03-10 07:23:30'),
(286, 5, 180, 1, 0, 0, 0, '2019-03-10 07:23:30'),
(288, 5, 158, 1, 0, 0, 0, '2019-03-10 07:23:30'),
(289, 5, 102, 1, 1, 1, 1, '2019-03-10 07:23:30'),
(290, 6, 152, 1, 1, 1, 1, '2019-03-10 07:31:58'),
(291, 6, 153, 1, 1, 1, 1, '2019-03-10 07:31:58'),
(292, 6, 171, 1, 1, 1, 1, '2019-03-10 07:31:58'),
(293, 6, 86, 1, 0, 0, 0, '2019-03-10 07:31:58'),
(294, 6, 109, 1, 1, 1, 1, '2019-03-10 07:31:58'),
(295, 6, 181, 1, 0, 0, 0, '2019-03-10 07:31:58'),
(297, 6, 118, 1, 0, 0, 0, '2019-03-10 07:31:58'),
(298, 6, 159, 1, 0, 0, 0, '2019-03-10 07:31:58'),
(299, 6, 102, 1, 1, 1, 1, '2019-03-10 07:31:58'),
(300, 8, 132, 1, 1, 1, 1, '2019-03-10 07:38:46'),
(306, 8, 81, 1, 1, 1, 1, '2019-03-10 07:38:46'),
(324, 9, 214, 1, 1, 1, 1, '2019-09-24 05:57:58'),
(325, 9, 215, 1, 1, 1, 1, '2019-09-24 05:57:58'),
(326, 9, 132, 1, 1, 1, 1, '2019-09-24 08:09:37'),
(327, 9, 218, 1, 0, 0, 0, '2019-09-24 05:59:54'),
(338, 9, 135, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(339, 9, 219, 1, 0, 0, 0, '2019-09-24 06:10:21'),
(340, 9, 221, 1, 1, 1, 1, '2019-09-24 06:12:42'),
(341, 9, 222, 1, 1, 1, 1, '2019-09-24 06:15:14'),
(342, 9, 223, 1, 1, 1, 1, '2019-09-24 06:20:24'),
(343, 9, 220, 1, 1, 1, 1, '2019-09-24 06:36:30'),
(344, 9, 138, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(345, 9, 146, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(346, 9, 147, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(347, 9, 148, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(348, 9, 170, 1, 1, 1, 1, '2019-09-24 07:33:23'),
(349, 9, 200, 1, 1, 0, 1, '2019-09-24 09:26:31'),
(350, 9, 201, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(351, 9, 224, 1, 0, 0, 0, '2019-09-24 06:37:17'),
(352, 9, 225, 1, 1, 1, 1, '2019-09-24 06:52:41'),
(353, 9, 226, 1, 1, 1, 1, '2019-09-24 07:32:07'),
(354, 9, 227, 1, 1, 1, 1, '2019-09-24 07:32:07'),
(355, 9, 54, 1, 0, 1, 0, '2019-09-24 09:26:31'),
(356, 9, 56, 1, 0, 1, 0, '2019-09-24 09:26:31'),
(357, 9, 57, 1, 0, 1, 0, '2019-09-24 09:26:31'),
(358, 9, 58, 1, 0, 1, 0, '2019-09-24 09:26:31'),
(359, 9, 59, 1, 0, 1, 0, '2019-09-24 09:26:31'),
(360, 9, 60, 1, 0, 1, 0, '2019-09-24 09:26:31'),
(361, 9, 126, 1, 0, 0, 0, '2019-09-24 07:10:42'),
(362, 9, 130, 1, 1, 0, 1, '2019-09-24 09:26:31'),
(363, 9, 131, 1, 0, 0, 0, '2019-09-24 07:10:42'),
(364, 9, 174, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(367, 9, 14, 1, 0, 0, 0, '2019-09-24 07:56:25'),
(375, 9, 236, 1, 1, 1, 1, '2019-09-24 08:42:37'),
(376, 9, 237, 1, 0, 0, 0, '2019-09-24 08:42:37'),
(377, 9, 134, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(378, 9, 136, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(379, 9, 137, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(380, 9, 192, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(381, 9, 139, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(382, 9, 140, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(383, 9, 141, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(384, 9, 142, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(385, 9, 143, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(386, 9, 144, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(387, 9, 145, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(388, 9, 193, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(389, 9, 194, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(390, 9, 195, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(391, 9, 196, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(392, 9, 197, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(393, 9, 198, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(394, 9, 149, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(395, 9, 150, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(396, 9, 175, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(397, 9, 152, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(398, 9, 153, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(399, 9, 171, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(400, 9, 163, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(401, 9, 164, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(402, 9, 167, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(403, 9, 168, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(404, 9, 169, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(405, 9, 202, 1, 1, 0, 1, '2019-09-24 09:26:31'),
(406, 9, 173, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(407, 9, 9, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(408, 9, 10, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(409, 9, 12, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(410, 9, 13, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(411, 9, 176, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(412, 9, 203, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(413, 9, 228, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(414, 9, 165, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(415, 9, 166, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(416, 9, 80, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(417, 9, 81, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(418, 9, 82, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(419, 9, 83, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(420, 9, 84, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(421, 9, 85, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(422, 9, 204, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(423, 9, 205, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(424, 9, 216, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(425, 9, 217, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(426, 9, 86, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(427, 9, 87, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(428, 9, 88, 1, 1, 1, 0, '2019-09-24 09:26:31'),
(429, 9, 89, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(430, 9, 90, 1, 1, 0, 1, '2019-09-24 09:26:31'),
(431, 9, 91, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(432, 9, 108, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(433, 9, 109, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(434, 9, 110, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(435, 9, 111, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(436, 9, 112, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(437, 9, 127, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(438, 9, 129, 0, 1, 0, 1, '2019-09-24 09:26:31'),
(439, 9, 229, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(440, 9, 43, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(441, 9, 44, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(442, 9, 46, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(443, 9, 27, 1, 1, 0, 1, '2019-09-24 09:26:31'),
(444, 9, 31, 1, 1, 0, 1, '2019-09-24 09:26:31'),
(445, 9, 32, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(446, 9, 33, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(447, 9, 34, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(448, 9, 35, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(449, 9, 104, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(450, 9, 61, 1, 1, 0, 1, '2019-09-24 09:26:31'),
(451, 9, 62, 1, 1, 0, 1, '2019-09-24 09:26:31'),
(452, 9, 63, 1, 1, 0, 1, '2019-09-24 09:26:31'),
(453, 9, 64, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(454, 9, 65, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(455, 9, 66, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(456, 9, 67, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(457, 9, 53, 0, 1, 0, 0, '2019-09-24 09:26:31'),
(458, 9, 48, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(459, 9, 178, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(460, 9, 179, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(461, 9, 180, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(462, 9, 181, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(463, 9, 182, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(464, 9, 183, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(465, 9, 184, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(466, 9, 185, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(467, 9, 186, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(468, 9, 187, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(469, 9, 188, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(470, 9, 189, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(471, 9, 206, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(472, 9, 207, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(473, 9, 208, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(474, 9, 209, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(475, 9, 210, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(476, 9, 211, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(477, 9, 212, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(478, 9, 213, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(479, 9, 118, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(480, 9, 155, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(481, 9, 156, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(482, 9, 157, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(483, 9, 158, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(484, 9, 159, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(485, 9, 160, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(486, 9, 161, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(487, 9, 162, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(488, 9, 190, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(489, 9, 191, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(490, 9, 238, 1, 0, 0, 0, '2019-09-24 09:26:31'),
(491, 9, 102, 1, 1, 1, 1, '2019-09-24 09:26:31'),
(492, 8, 236, 1, 1, 1, 0, '2019-10-12 12:40:43'),
(493, 8, 146, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(495, 8, 138, 1, 1, 1, 1, '2019-10-04 06:35:20'),
(496, 8, 139, 1, 1, 1, 1, '2019-10-04 06:35:49'),
(500, 8, 143, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(501, 8, 144, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(502, 8, 145, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(504, 8, 194, 1, 0, 0, 0, '2019-10-04 06:36:51'),
(506, 8, 196, 1, 0, 1, 1, '2019-10-12 13:16:52'),
(508, 8, 198, 1, 0, 0, 0, '2019-10-04 06:36:51'),
(511, 8, 148, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(516, 8, 225, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(524, 4, 201, 1, 1, 1, 1, '2019-10-04 07:51:19'),
(525, 4, 197, 1, 1, 1, 1, '2019-10-04 07:52:12'),
(526, 4, 243, 1, 0, 0, 0, '2019-10-04 09:11:46'),
(527, 4, 244, 1, 0, 0, 0, '2019-10-04 09:12:02'),
(528, 4, 245, 1, 0, 0, 0, '2019-10-04 07:57:23'),
(530, 4, 249, 1, 1, 1, 1, '2019-10-04 08:02:34'),
(531, 9, 246, 0, 1, 1, 1, '2019-10-04 08:07:16'),
(533, 4, 247, 1, 0, 0, 0, '2019-10-04 08:08:38'),
(536, 4, 240, 1, 0, 0, 0, '2019-10-04 08:10:41'),
(537, 4, 242, 1, 1, 1, 1, '2019-10-04 10:10:41'),
(540, 3, 245, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(541, 9, 243, 1, 0, 0, 0, '2019-10-04 09:17:02'),
(542, 9, 243, 1, 0, 0, 0, '2019-10-04 09:17:02'),
(543, 9, 239, 1, 0, 0, 0, '2019-10-04 09:18:14'),
(544, 9, 239, 1, 0, 0, 0, '2019-10-04 09:18:14'),
(545, 9, 242, 0, 1, 0, 0, '2019-10-04 09:41:27'),
(546, 4, 214, 1, 0, 0, 0, '2019-10-04 09:50:36'),
(547, 4, 241, 1, 1, 1, 1, '2019-10-04 10:01:24'),
(548, 4, 215, 1, 0, 0, 0, '2019-10-04 09:51:09'),
(550, 4, 236, 1, 0, 0, 0, '2019-10-04 10:15:36'),
(571, 4, 256, 1, 0, 0, 0, '2019-10-04 11:36:02'),
(572, 4, 224, 1, 0, 0, 0, '2019-10-12 11:12:53'),
(573, 4, 225, 1, 1, 1, 1, '2019-10-12 12:09:04'),
(574, 4, 226, 1, 1, 1, 1, '2019-10-12 12:09:04'),
(575, 4, 227, 1, 1, 1, 1, '2019-10-12 12:09:04'),
(577, 4, 203, 1, 0, 0, 0, '2019-10-12 11:22:51'),
(578, 4, 176, 1, 0, 0, 0, '2019-10-12 11:25:06'),
(579, 4, 228, 1, 0, 0, 0, '2019-10-12 11:34:35'),
(580, 2, 221, 1, 1, 1, 1, '2019-10-12 11:56:04'),
(581, 2, 222, 1, 1, 1, 1, '2019-10-12 11:56:04'),
(582, 2, 223, 1, 1, 1, 1, '2019-10-12 11:56:04'),
(583, 2, 225, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(584, 2, 216, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(585, 2, 217, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(586, 2, 229, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(587, 2, 249, 1, 1, 1, 1, '2019-10-12 11:56:04'),
(588, 2, 250, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(589, 2, 251, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(590, 2, 253, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(591, 2, 254, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(592, 2, 255, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(593, 2, 256, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(594, 2, 238, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(595, 2, 236, 1, 1, 1, 0, '2019-10-12 11:56:04'),
(596, 2, 237, 1, 0, 0, 0, '2019-10-12 11:56:04'),
(597, 3, 192, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(598, 3, 218, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(599, 3, 219, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(600, 3, 221, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(601, 3, 222, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(602, 3, 223, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(603, 3, 193, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(604, 3, 195, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(605, 3, 196, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(606, 3, 197, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(607, 3, 220, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(608, 3, 248, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(609, 3, 146, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(610, 3, 149, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(611, 3, 152, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(612, 3, 173, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(613, 3, 174, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(614, 3, 176, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(615, 3, 228, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(616, 3, 165, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(617, 3, 214, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(618, 3, 215, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(619, 3, 216, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(620, 3, 217, 1, 0, 0, 0, '2019-10-12 12:02:53'),
(621, 3, 236, 1, 1, 1, 1, '2019-10-12 12:02:53'),
(622, 4, 109, 1, 1, 1, 1, '2019-10-12 12:09:04'),
(623, 5, 243, 1, 1, 1, 1, '2019-10-12 12:24:41'),
(624, 5, 236, 1, 0, 0, 0, '2019-10-12 12:24:41'),
(625, 6, 43, 1, 1, 1, 1, '2019-10-12 12:30:16'),
(626, 6, 44, 1, 0, 0, 0, '2019-10-12 12:30:16'),
(627, 6, 27, 1, 1, 0, 1, '2019-10-12 12:30:16'),
(628, 6, 236, 1, 0, 0, 0, '2019-10-12 12:30:16'),
(629, 8, 135, 1, 1, 1, 1, '2019-10-12 12:40:43'),
(630, 8, 218, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(631, 8, 219, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(632, 8, 221, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(633, 8, 222, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(634, 8, 223, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(635, 8, 149, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(636, 8, 152, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(637, 8, 163, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(638, 8, 167, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(639, 8, 173, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(640, 8, 174, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(641, 8, 176, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(642, 8, 228, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(643, 8, 165, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(644, 8, 166, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(645, 8, 214, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(646, 8, 215, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(647, 8, 82, 1, 1, 1, 1, '2019-10-12 12:40:43'),
(648, 8, 83, 1, 1, 1, 1, '2019-10-12 12:40:43'),
(649, 8, 84, 1, 1, 1, 1, '2019-10-12 12:40:43'),
(650, 8, 85, 1, 1, 1, 1, '2019-10-12 12:40:43'),
(651, 8, 204, 1, 1, 1, 1, '2019-10-12 12:40:43'),
(652, 8, 205, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(653, 8, 216, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(654, 8, 217, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(655, 8, 109, 1, 1, 1, 1, '2019-10-12 12:40:43'),
(656, 8, 43, 1, 1, 1, 1, '2019-10-12 12:40:43'),
(657, 8, 44, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(658, 8, 27, 1, 1, 0, 1, '2019-10-12 12:40:43'),
(659, 8, 31, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(660, 8, 32, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(661, 8, 33, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(662, 8, 48, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(663, 8, 178, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(664, 8, 180, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(665, 8, 181, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(666, 8, 186, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(667, 8, 207, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(668, 8, 208, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(669, 8, 209, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(670, 8, 253, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(671, 8, 254, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(672, 8, 255, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(673, 8, 118, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(674, 8, 238, 1, 0, 0, 0, '2019-10-12 12:40:43'),
(675, 8, 102, 1, 1, 1, 1, '2019-10-12 12:40:43'),
(676, 5, 176, 1, 0, 0, 0, '2019-10-12 13:10:30'),
(677, 6, 176, 1, 0, 0, 0, '2019-10-12 13:12:51'),
(678, 8, 86, 1, 0, 0, 0, '2019-10-12 13:16:52'),
(679, 8, 182, 1, 0, 0, 0, '2019-10-12 13:16:52'),
(680, 2, 147, 1, 0, 0, 0, '2019-10-14 09:34:51'),
(681, 2, 200, 1, 0, 0, 0, '2019-10-14 09:34:51'),
(682, 2, 164, 1, 0, 0, 0, '2019-10-14 09:36:36'),
(683, 2, 146, 1, 0, 0, 0, '2019-10-14 09:39:47'),
(684, 1, 218, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(685, 1, 219, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(686, 1, 221, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(687, 1, 222, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(688, 1, 223, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(689, 1, 220, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(690, 1, 248, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(691, 1, 224, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(692, 1, 225, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(693, 1, 226, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(694, 1, 227, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(695, 1, 243, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(696, 1, 257, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(697, 1, 244, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(698, 1, 245, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(699, 1, 246, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(700, 1, 252, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(701, 1, 228, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(702, 1, 247, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(703, 1, 214, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(704, 1, 215, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(705, 1, 240, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(706, 1, 241, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(707, 1, 242, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(708, 1, 216, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(709, 1, 217, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(710, 1, 229, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(711, 1, 249, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(712, 1, 250, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(713, 1, 251, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(714, 1, 253, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(715, 1, 254, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(716, 1, 255, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(717, 1, 256, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(718, 1, 258, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(719, 1, 259, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(720, 1, 238, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(721, 1, 236, 1, 1, 1, 1, '2019-10-15 06:18:33'),
(722, 1, 237, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(723, 1, 239, 1, 0, 0, 0, '2019-10-15 06:18:33'),
(724, 3, 226, 1, 0, 0, 0, '2019-10-18 10:33:53'),
(725, 3, 150, 1, 0, 0, 0, '2019-10-19 04:38:20'),
(726, 3, 153, 1, 0, 0, 0, '2019-10-19 04:38:20'),
(727, 3, 238, 1, 0, 0, 0, '2019-11-01 05:40:24');

-- --------------------------------------------------------

--
-- Table structure for table `sch_settings`
--

CREATE TABLE `sch_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `dise_code` varchar(50) DEFAULT NULL,
  `date_format` varchar(50) NOT NULL,
  `time_format` varchar(20) DEFAULT '24-hour',
  `currency` varchar(50) NOT NULL,
  `currency_symbol` varchar(50) NOT NULL,
  `is_rtl` varchar(10) DEFAULT 'disabled',
  `timezone` varchar(30) DEFAULT 'UTC',
  `session_id` int(11) DEFAULT NULL,
  `start_month` varchar(40) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `mini_logo` varchar(200) NOT NULL,
  `theme` varchar(200) NOT NULL DEFAULT 'default.jpg',
  `credit_limit` varchar(255) DEFAULT NULL,
  `opd_record_month` varchar(50) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cron_secret_key` varchar(100) NOT NULL,
  `fee_due_days` int(3) DEFAULT 0,
  `doctor_restriction` varchar(100) NOT NULL,
  `superadmin_restriction` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sch_settings`
--

INSERT INTO `sch_settings` (`id`, `name`, `email`, `phone`, `address`, `lang_id`, `dise_code`, `date_format`, `time_format`, `currency`, `currency_symbol`, `is_rtl`, `timezone`, `session_id`, `start_month`, `image`, `mini_logo`, `theme`, `credit_limit`, `opd_record_month`, `is_active`, `created_at`, `cron_secret_key`, `fee_due_days`, `doctor_restriction`, `superadmin_restriction`) VALUES
(0, 'Your Hospital Name', 'Your Hospital Email', 'Your Hospital Phone', 'Your Hospital Address', 4, 'Your Hospital Code', 'd-m-Y', '12-hour', 'USD', '$', 'disabled', 'UTC', NULL, '', '0.png', '0mini_logo.png', 'default.jpg', '20000', '1', 'no', '2019-11-01 12:29:48', '', 60, 'disabled', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `send_notification`
--

CREATE TABLE `send_notification` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  `message` text DEFAULT NULL,
  `visible_student` varchar(10) NOT NULL DEFAULT 'no',
  `visible_staff` varchar(10) NOT NULL DEFAULT 'no',
  `visible_parent` varchar(10) NOT NULL DEFAULT 'no',
  `created_by` varchar(60) DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_config`
--

CREATE TABLE `sms_config` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `api_id` varchar(100) NOT NULL,
  `authkey` varchar(100) NOT NULL,
  `senderid` varchar(100) NOT NULL,
  `contact` text DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT 'disabled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

CREATE TABLE `source` (
  `id` int(11) NOT NULL,
  `source` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(200) NOT NULL,
  `department` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `qualification` varchar(200) NOT NULL,
  `work_exp` varchar(200) NOT NULL,
  `specialization` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `surname` varchar(200) NOT NULL,
  `father_name` varchar(200) NOT NULL,
  `mother_name` varchar(200) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
  `emergency_contact_no` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `dob` date NOT NULL,
  `marital_status` varchar(100) NOT NULL,
  `date_of_joining` date NOT NULL,
  `date_of_leaving` date NOT NULL,
  `local_address` varchar(300) NOT NULL,
  `permanent_address` varchar(200) NOT NULL,
  `note` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `password` varchar(250) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `blood_group` varchar(100) NOT NULL,
  `account_title` varchar(200) NOT NULL,
  `bank_account_no` varchar(200) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `ifsc_code` varchar(200) NOT NULL,
  `bank_branch` varchar(100) NOT NULL,
  `payscale` varchar(200) NOT NULL,
  `basic_salary` varchar(200) NOT NULL,
  `epf_no` varchar(200) NOT NULL,
  `contract_type` varchar(100) NOT NULL,
  `shift` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `twitter` varchar(200) NOT NULL,
  `linkedin` varchar(200) NOT NULL,
  `instagram` varchar(200) NOT NULL,
  `resume` varchar(200) NOT NULL,
  `joining_letter` varchar(200) NOT NULL,
  `resignation_letter` varchar(200) NOT NULL,
  `other_document_name` varchar(200) NOT NULL,
  `other_document_file` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `verification_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_attendance`
--

CREATE TABLE `staff_attendance` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `staff_id` int(11) NOT NULL,
  `staff_attendance_type_id` int(11) NOT NULL,
  `remark` varchar(200) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_attendance_type`
--

CREATE TABLE `staff_attendance_type` (
  `id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `key_value` varchar(200) NOT NULL,
  `is_active` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff_attendance_type`
--

INSERT INTO `staff_attendance_type` (`id`, `type`, `key_value`, `is_active`, `created_at`) VALUES
(1, 'Present', '<b class=\"text text-success\">P</b>', 'yes', '0000-00-00 00:00:00'),
(2, 'Late', '<b class=\"text text-warning\">L</b>', 'yes', '0000-00-00 00:00:00'),
(3, 'Absent', '<b class=\"text text-danger\">A</b>', 'yes', '0000-00-00 00:00:00'),
(4, 'Half Day', '<b class=\"text text-warning\">F</b>', 'yes', '2018-05-07 01:56:16'),
(5, 'Holiday', 'H', 'yes', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff_designation`
--

CREATE TABLE `staff_designation` (
  `id` int(11) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `is_active` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_leave_details`
--

CREATE TABLE `staff_leave_details` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `alloted_leave` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_leave_request`
--

CREATE TABLE `staff_leave_request` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `leave_from` date NOT NULL,
  `leave_to` date NOT NULL,
  `leave_days` int(11) NOT NULL,
  `employee_remark` varchar(200) NOT NULL,
  `admin_remark` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL,
  `applied_by` varchar(200) NOT NULL,
  `document_file` varchar(200) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_payroll`
--

CREATE TABLE `staff_payroll` (
  `id` int(11) NOT NULL,
  `basic_salary` int(11) NOT NULL,
  `pay_scale` varchar(200) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `is_active` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_payslip`
--

CREATE TABLE `staff_payslip` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `basic` int(11) NOT NULL,
  `total_allowance` int(11) NOT NULL,
  `total_deduction` int(11) NOT NULL,
  `leave_deduction` int(11) NOT NULL,
  `tax` decimal(15,2) NOT NULL,
  `net_salary` decimal(15,2) NOT NULL,
  `status` varchar(100) NOT NULL,
  `month` varchar(200) NOT NULL,
  `year` varchar(200) NOT NULL,
  `payment_mode` varchar(200) NOT NULL,
  `payment_date` date NOT NULL,
  `remark` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_roles`
--

CREATE TABLE `staff_roles` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_timeline`
--

CREATE TABLE `staff_timeline` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `timeline_date` date NOT NULL,
  `description` varchar(300) NOT NULL,
  `document` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_bill_basic`
--

CREATE TABLE `supplier_bill_basic` (
  `id` int(11) NOT NULL,
  `purchase_no` varchar(200) NOT NULL,
  `date` varchar(200) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(200) NOT NULL,
  `file` varchar(200) NOT NULL,
  `total` varchar(200) NOT NULL,
  `tax` varchar(200) NOT NULL,
  `discount` varchar(200) NOT NULL,
  `net_amount` varchar(200) NOT NULL,
  `note` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_bill_detail`
--

CREATE TABLE `supplier_bill_detail` (
  `id` int(11) NOT NULL,
  `supplier_bill_basic_id` varchar(200) NOT NULL,
  `medicine_category_id` varchar(200) NOT NULL,
  `medicine_name` varchar(200) NOT NULL,
  `expire_date` varchar(100) NOT NULL,
  `batch_no` varchar(200) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `purchase_price` varchar(200) NOT NULL,
  `mrp` varchar(200) NOT NULL,
  `sale_price` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_category`
--

CREATE TABLE `supplier_category` (
  `id` int(11) NOT NULL,
  `supplier_category` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `supplier_person` varchar(200) NOT NULL,
  `supplier_person_contact` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `system_notification`
--

CREATE TABLE `system_notification` (
  `id` int(11) NOT NULL,
  `notification_title` varchar(200) NOT NULL,
  `notification_type` varchar(200) NOT NULL,
  `notification_desc` varchar(200) NOT NULL,
  `notification_for` varchar(200) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `is_active` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `test_type_report`
--

CREATE TABLE `test_type_report` (
  `id` int(11) NOT NULL,
  `radiology_id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `test_name` varchar(100) DEFAULT NULL,
  `reporting_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `test_report` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tpa_doctorcharges`
--

CREATE TABLE `tpa_doctorcharges` (
  `id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `charge_id` int(11) NOT NULL,
  `org_charge` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tpa_master`
--

CREATE TABLE `tpa_master` (
  `id` int(11) NOT NULL,
  `organisation` varchar(200) NOT NULL,
  `charge_id` int(11) NOT NULL,
  `organisation_charge` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `user` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `ipaddress` varchar(100) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `login_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `childs` text NOT NULL,
  `role` varchar(30) NOT NULL,
  `verification_code` varchar(200) NOT NULL,
  `is_active` varchar(255) DEFAULT 'yes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(10) UNSIGNED NOT NULL,
  `vehicle_no` varchar(20) DEFAULT NULL,
  `vehicle_model` varchar(100) NOT NULL DEFAULT 'None',
  `manufacture_year` varchar(4) DEFAULT NULL,
  `vehicle_type` varchar(100) NOT NULL,
  `driver_name` varchar(50) DEFAULT NULL,
  `driver_licence` varchar(50) NOT NULL DEFAULT 'None',
  `driver_contact` varchar(20) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visitors_book`
--

CREATE TABLE `visitors_book` (
  `id` int(11) NOT NULL,
  `source` varchar(100) DEFAULT NULL,
  `purpose` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(12) NOT NULL,
  `id_proof` varchar(50) NOT NULL,
  `no_of_pepple` int(11) NOT NULL,
  `date` date NOT NULL,
  `in_time` varchar(20) NOT NULL,
  `out_time` varchar(20) NOT NULL,
  `note` mediumtext NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visitors_purpose`
--

CREATE TABLE `visitors_purpose` (
  `id` int(11) NOT NULL,
  `visitors_purpose` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visit_details`
--

CREATE TABLE `visit_details` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `opd_id` int(11) NOT NULL,
  `opd_no` varchar(100) NOT NULL,
  `cons_doctor` int(11) NOT NULL,
  `case_type` varchar(200) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `symptoms` varchar(200) NOT NULL,
  `bp` varchar(100) NOT NULL,
  `height` varchar(100) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `known_allergies` varchar(100) NOT NULL,
  `casualty` varchar(200) NOT NULL,
  `refference` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(100) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `tax` decimal(15,2) NOT NULL,
  `note_remark` mediumtext NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `generated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ambulance_call`
--
ALTER TABLE `ambulance_call`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bed`
--
ALTER TABLE `bed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bed_group`
--
ALTER TABLE `bed_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bed_type`
--
ALTER TABLE `bed_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `birth_report`
--
ALTER TABLE `birth_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_bank_status`
--
ALTER TABLE `blood_bank_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_donor`
--
ALTER TABLE `blood_donor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_donor_cycle`
--
ALTER TABLE `blood_donor_cycle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_issue`
--
ALTER TABLE `blood_issue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charge_categories`
--
ALTER TABLE `charge_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaint_type`
--
ALTER TABLE `complaint_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultant_register`
--
ALTER TABLE `consultant_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consult_charges`
--
ALTER TABLE `consult_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_for`
--
ALTER TABLE `content_for`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`content_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_field_values`
--
ALTER TABLE `custom_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_field_id` (`custom_field_id`);

--
-- Indexes for table `death_report`
--
ALTER TABLE `death_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dispatch_receive`
--
ALTER TABLE `dispatch_receive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_config`
--
ALTER TABLE `email_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiry_type`
--
ALTER TABLE `enquiry_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_head`
--
ALTER TABLE `expense_head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `floor`
--
ALTER TABLE `floor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follow_up`
--
ALTER TABLE `follow_up`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_media_gallery`
--
ALTER TABLE `front_cms_media_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_menus`
--
ALTER TABLE `front_cms_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_menu_items`
--
ALTER TABLE `front_cms_menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_pages`
--
ALTER TABLE `front_cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_page_contents`
--
ALTER TABLE `front_cms_page_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `front_cms_programs`
--
ALTER TABLE `front_cms_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_program_photos`
--
ALTER TABLE `front_cms_program_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `front_cms_settings`
--
ALTER TABLE `front_cms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_calls`
--
ALTER TABLE `general_calls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_head`
--
ALTER TABLE `income_head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_billing`
--
ALTER TABLE `ipd_billing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_details`
--
ALTER TABLE `ipd_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_prescription_basic`
--
ALTER TABLE `ipd_prescription_basic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_prescription_details`
--
ALTER TABLE `ipd_prescription_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_issue`
--
ALTER TABLE `item_issue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `item_category_id` (`item_category_id`);

--
-- Indexes for table `item_stock`
--
ALTER TABLE `item_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `item_store`
--
ALTER TABLE `item_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_supplier`
--
ALTER TABLE `item_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `medicine_bad_stock`
--
ALTER TABLE `medicine_bad_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_batch_details`
--
ALTER TABLE `medicine_batch_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_category`
--
ALTER TABLE `medicine_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_dosage`
--
ALTER TABLE `medicine_dosage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_roles`
--
ALTER TABLE `notification_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `send_notification_id` (`send_notification_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `notification_setting`
--
ALTER TABLE `notification_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opd_billing`
--
ALTER TABLE `opd_billing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opd_details`
--
ALTER TABLE `opd_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opd_patient_charges`
--
ALTER TABLE `opd_patient_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opd_payment`
--
ALTER TABLE `opd_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operation_theatre`
--
ALTER TABLE `operation_theatre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organisations_charges`
--
ALTER TABLE `organisations_charges`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `org_id` (`org_id`) USING BTREE,
  ADD KEY `charge_id` (`charge_id`) USING BTREE;

--
-- Indexes for table `ot_consultant_register`
--
ALTER TABLE `ot_consultant_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pathology`
--
ALTER TABLE `pathology`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pathology_category`
--
ALTER TABLE `pathology_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pathology_report`
--
ALTER TABLE `pathology_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_charges`
--
ALTER TABLE `patient_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_timeline`
--
ALTER TABLE `patient_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payslip_allowance`
--
ALTER TABLE `payslip_allowance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_category`
--
ALTER TABLE `permission_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_group`
--
ALTER TABLE `permission_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_bill_basic`
--
ALTER TABLE `pharmacy_bill_basic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_bill_detail`
--
ALTER TABLE `pharmacy_bill_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `print_setting`
--
ALTER TABLE `print_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `radio`
--
ALTER TABLE `radio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `radiology_report`
--
ALTER TABLE `radiology_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `read_notification`
--
ALTER TABLE `read_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `read_systemnotification`
--
ALTER TABLE `read_systemnotification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sch_settings`
--
ALTER TABLE `sch_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lang_id` (`lang_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `send_notification`
--
ALTER TABLE `send_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_config`
--
ALTER TABLE `sms_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source`
--
ALTER TABLE `source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_attendance_type`
--
ALTER TABLE `staff_attendance_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_designation`
--
ALTER TABLE `staff_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_leave_details`
--
ALTER TABLE `staff_leave_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_leave_request`
--
ALTER TABLE `staff_leave_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_payroll`
--
ALTER TABLE `staff_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_payslip`
--
ALTER TABLE `staff_payslip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_roles`
--
ALTER TABLE `staff_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff_timeline`
--
ALTER TABLE `staff_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_bill_basic`
--
ALTER TABLE `supplier_bill_basic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_bill_detail`
--
ALTER TABLE `supplier_bill_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_category`
--
ALTER TABLE `supplier_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_notification`
--
ALTER TABLE `system_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_type_report`
--
ALTER TABLE `test_type_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tpa_doctorcharges`
--
ALTER TABLE `tpa_doctorcharges`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `org_id` (`org_id`) USING BTREE,
  ADD KEY `charge_id` (`charge_id`) USING BTREE;

--
-- Indexes for table `tpa_master`
--
ALTER TABLE `tpa_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors_book`
--
ALTER TABLE `visitors_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors_purpose`
--
ALTER TABLE `visitors_purpose`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visit_details`
--
ALTER TABLE `visit_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ambulance_call`
--
ALTER TABLE `ambulance_call`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bed`
--
ALTER TABLE `bed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bed_group`
--
ALTER TABLE `bed_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bed_type`
--
ALTER TABLE `bed_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `birth_report`
--
ALTER TABLE `birth_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_bank_status`
--
ALTER TABLE `blood_bank_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blood_donor`
--
ALTER TABLE `blood_donor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_donor_cycle`
--
ALTER TABLE `blood_donor_cycle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_issue`
--
ALTER TABLE `blood_issue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `charge_categories`
--
ALTER TABLE `charge_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaint_type`
--
ALTER TABLE `complaint_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultant_register`
--
ALTER TABLE `consultant_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consult_charges`
--
ALTER TABLE `consult_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content_for`
--
ALTER TABLE `content_for`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_field_values`
--
ALTER TABLE `custom_field_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `death_report`
--
ALTER TABLE `death_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diagnosis`
--
ALTER TABLE `diagnosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dispatch_receive`
--
ALTER TABLE `dispatch_receive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_config`
--
ALTER TABLE `email_config`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiry_type`
--
ALTER TABLE `enquiry_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_head`
--
ALTER TABLE `expense_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follow_up`
--
ALTER TABLE `follow_up`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_media_gallery`
--
ALTER TABLE `front_cms_media_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_menus`
--
ALTER TABLE `front_cms_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `front_cms_menu_items`
--
ALTER TABLE `front_cms_menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `front_cms_pages`
--
ALTER TABLE `front_cms_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `front_cms_page_contents`
--
ALTER TABLE `front_cms_page_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_programs`
--
ALTER TABLE `front_cms_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_program_photos`
--
ALTER TABLE `front_cms_program_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `front_cms_settings`
--
ALTER TABLE `front_cms_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `general_calls`
--
ALTER TABLE `general_calls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income_head`
--
ALTER TABLE `income_head`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ipd_billing`
--
ALTER TABLE `ipd_billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ipd_details`
--
ALTER TABLE `ipd_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ipd_prescription_basic`
--
ALTER TABLE `ipd_prescription_basic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ipd_prescription_details`
--
ALTER TABLE `ipd_prescription_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_issue`
--
ALTER TABLE `item_issue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_stock`
--
ALTER TABLE `item_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_store`
--
ALTER TABLE `item_store`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_supplier`
--
ALTER TABLE `item_supplier`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab`
--
ALTER TABLE `lab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_bad_stock`
--
ALTER TABLE `medicine_bad_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_batch_details`
--
ALTER TABLE `medicine_batch_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_category`
--
ALTER TABLE `medicine_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_dosage`
--
ALTER TABLE `medicine_dosage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_roles`
--
ALTER TABLE `notification_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_setting`
--
ALTER TABLE `notification_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `opd_billing`
--
ALTER TABLE `opd_billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opd_details`
--
ALTER TABLE `opd_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opd_patient_charges`
--
ALTER TABLE `opd_patient_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opd_payment`
--
ALTER TABLE `opd_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operation_theatre`
--
ALTER TABLE `operation_theatre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organisations_charges`
--
ALTER TABLE `organisations_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ot_consultant_register`
--
ALTER TABLE `ot_consultant_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathology`
--
ALTER TABLE `pathology`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathology_category`
--
ALTER TABLE `pathology_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathology_report`
--
ALTER TABLE `pathology_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_charges`
--
ALTER TABLE `patient_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_timeline`
--
ALTER TABLE `patient_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payslip_allowance`
--
ALTER TABLE `payslip_allowance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_category`
--
ALTER TABLE `permission_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `permission_group`
--
ALTER TABLE `permission_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharmacy_bill_basic`
--
ALTER TABLE `pharmacy_bill_basic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharmacy_bill_detail`
--
ALTER TABLE `pharmacy_bill_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `print_setting`
--
ALTER TABLE `print_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radio`
--
ALTER TABLE `radio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radiology_report`
--
ALTER TABLE `radiology_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `read_notification`
--
ALTER TABLE `read_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `read_systemnotification`
--
ALTER TABLE `read_systemnotification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=728;

--
-- AUTO_INCREMENT for table `send_notification`
--
ALTER TABLE `send_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_config`
--
ALTER TABLE `sms_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `source`
--
ALTER TABLE `source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_attendance_type`
--
ALTER TABLE `staff_attendance_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff_designation`
--
ALTER TABLE `staff_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_leave_details`
--
ALTER TABLE `staff_leave_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_leave_request`
--
ALTER TABLE `staff_leave_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_payroll`
--
ALTER TABLE `staff_payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_payslip`
--
ALTER TABLE `staff_payslip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_roles`
--
ALTER TABLE `staff_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_timeline`
--
ALTER TABLE `staff_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_bill_basic`
--
ALTER TABLE `supplier_bill_basic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_bill_detail`
--
ALTER TABLE `supplier_bill_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_category`
--
ALTER TABLE `supplier_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_notification`
--
ALTER TABLE `system_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_type_report`
--
ALTER TABLE `test_type_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tpa_doctorcharges`
--
ALTER TABLE `tpa_doctorcharges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tpa_master`
--
ALTER TABLE `tpa_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitors_book`
--
ALTER TABLE `visitors_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitors_purpose`
--
ALTER TABLE `visitors_purpose`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visit_details`
--
ALTER TABLE `visit_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `content_for`
--
ALTER TABLE `content_for`
  ADD CONSTRAINT `content_for_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `content_for_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `front_cms_page_contents`
--
ALTER TABLE `front_cms_page_contents`
  ADD CONSTRAINT `front_cms_page_contents_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `front_cms_pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `front_cms_program_photos`
--
ALTER TABLE `front_cms_program_photos`
  ADD CONSTRAINT `front_cms_program_photos_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `front_cms_programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_issue`
--
ALTER TABLE `item_issue`
  ADD CONSTRAINT `item_issue_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_issue_ibfk_2` FOREIGN KEY (`item_category_id`) REFERENCES `item_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_stock`
--
ALTER TABLE `item_stock`
  ADD CONSTRAINT `item_stock_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_stock_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `item_supplier` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_stock_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `item_store` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification_roles`
--
ALTER TABLE `notification_roles`
  ADD CONSTRAINT `notification_roles_ibfk_1` FOREIGN KEY (`send_notification_id`) REFERENCES `send_notification` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
