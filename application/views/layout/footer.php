 



<script src="<?php echo base_url(); ?>backend/dist/js/moment.min.js"></script>
<footer class="main-footer">
    &copy;  <?php echo date('Y'); ?> 
    <?php echo $this->customlib->getAppName(); ?> <?php echo $this->customlib->getAppVersion(); ?>
</footer>
<div class="control-sidebar-bg"></div>
</div>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<link href="<?php echo base_url(); ?>backend/toast-alert/toastr.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>backend/toast-alert/toastr.js"></script>
<script src="<?php echo base_url(); ?>backend/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/input-mask/jquery.inputmask.extensions.js"></script>


<script src="<?php echo base_url(); ?>backend/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>backend/dist/js/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".studentsidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('.studentsideclose, .overlay').on('click', function () {
            $('.studentsidebar').removeClass('active');
            $('.overlay').fadeOut();
        });

        $('#sidebarCollapse').on('click', function () {
            $('.studentsidebar').addClass('active');
            $('.overlay').fadeIn();
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>


<script src="<?php echo base_url(); ?>backend/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>backend/dist/js/moment.min.js"></script>

<?php
$language = $this->customlib->getLanguage();
$language_name = $language["short_code"];

if ($language_name != 'en') {
    ?>
    <script src="<?php echo base_url(); ?>backend/plugins/datepicker/locales/bootstrap-datepicker.<?php echo $language_name ?>.js"></script>
    <script src="<?php echo base_url(); ?>backend/dist/js/locale/<?php echo $language_name ?>.js"></script>

<?php } ?>
<script src="<?php echo base_url(); ?>backend/datepicker/js/bootstrap-datetimepicker.js"></script>

<!-- <script src="<?php echo base_url(); ?>backend/plugins/chartjs/Chart.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>backend/js/canvasjs.min.js"></script> -->
<script src="<?php echo base_url(); ?>backend/plugins/fastclick/fastclick.min.js"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url();       ?>backend/dist/js/bootstrap-filestyle.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>backend/js/dist/bootstrap-FileUpload.js"></script>
-->
<script src="<?php echo base_url(); ?>backend/dist/js/app.min.js"></script>

<!--nprogress-->
<script src="<?php echo base_url(); ?>backend/dist/js/nprogress.js"></script>
<!--file dropify-->
<script src="<?php echo base_url(); ?>backend/dist/js/dropify.min.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/buttons.colVis.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/dataTables.responsive.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>backend/dist/datatables/js/ss.custom.js" ></script>
<!-- <script src="<?php echo base_url(); ?>backend/dist/datatables/js/moment.min.js"></script> -->

<script src="<?php echo base_url(); ?>backend/dist/datatables/js/datetime-moment.js"></script>
<script src="<?php echo base_url() ?>backend/plugins/select2/select2.full.min.js"></script>
</body>
</html>
<!-- jQuery 3 -->
<!--script src="<?php echo base_url(); ?>backend/dist/js/pages/dashboard2.js"></script-->
<script src="<?php echo base_url() ?>backend/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="<?php echo base_url() ?>backend/fullcalendar/dist/locale-all.js"></script>
<?php if ($language_name != 'en') { ?>
    <script src="<?php echo base_url() ?>backend/fullcalendar/dist/locale/<?php echo $language_name ?>.js"></script>
<?php } ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {

<?php
if ($this->session->flashdata('success_msg')) {
    ?>
            successMsg("<?php echo $this->session->flashdata('success_msg'); ?>");
    <?php
} else if ($this->session->flashdata('error_msg')) {
    ?>
            errorMsg("<?php echo $this->session->flashdata('error_msg'); ?>");
    <?php
} else if ($this->session->flashdata('warning_msg')) {
    ?>
            infoMsg("<?php echo $this->session->flashdata('warning_msg'); ?>");
    <?php
} else if ($this->session->flashdata('info_msg')) {
    ?>
            warningMsg("<?php echo $this->session->flashdata('info_msg'); ?>");
    <?php
}
?>
    });


    function complete_event(id, status) {

        $.ajax({
            url: "<?php echo site_url("admin/calendar/markcomplete/") ?>" + id,
            type: "POST",
            data: {id: id, active: status},
            dataType: 'json',

            success: function (res)
            {

                if (res.status == "fail") {

                    var message = "";
                    $.each(res.error, function (index, value) {

                        message += value;
                    });
                    errorMsg(message);

                } else {

                    successMsg(res.message);

                    window.location.reload(true);
                }

            }

        });
    }

    function markc(id) {

        $('#newcheck' + id).change(function () {

            if (this.checked) {

                complete_event(id, 'yes');
            } else {

                complete_event(id, 'no');
            }

        });
    }

    // $(function() {
    //            var offset = $(".uploadbarfixes").offset();
    //            var topPadding = 50;
    //            $(window).scroll(function() {
    //                if ($(window).scrollTop() > offset.top) {
    //                    $(".uploadbarfixes").stop().animate({
    //                        marginTop: $(window).scrollTop() - offset.top + topPadding
    //                    });
    //                } else {
    //                    $(".uploadbarfixes").stop().animate({
    //                        marginTop: 0
    //                    });
    //                };
    //            });
    //        });

</script>
<?php $this->load->view('layout/routine_update'); ?>


<!-- Button trigger modal -->
<!-- Modal -->
<div class="row">
    <div class="modal fade" id="sessionModal" tabindex="-1" role="dialog" aria-labelledby="sessionModalLabel">
        <form action="<?php echo site_url('admin/admin/activeSession') ?>" id="form_modal_session" class="form-horizontal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="sessionModalLabel"><?php echo $this->lang->line('session'); ?></h4>
                    </div>
                    <div class="modal-body sessionmodal_body pb0">

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-primary submit_session" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait.."><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
$floor_list = $this->floor_model->floor_list();
$bedlist = $this->bed_model->bed_list();
$bedgroup_list = $this->bedgroup_model->bedGroupFloor();
?>
<div id="bed" class="modal fade bedmodal" role="dialog">
    <div class="modal-dialog modal100per">
        <!-- Modal content-->
        <div class="modal-content fullshadow">
            <button type="button" class="ukclose" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                <div id="ajaxbedstatus"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function savedata(eventData) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/calendar/saveevent',
            type: 'POST',
            data: eventData,
            dataType: "json",
            success: function (msg) {
                alert(msg);

            }
        });
    }

    $calendar = $('#calendar');
    var base_url = '<?php echo base_url() ?>';
    today = new Date();
    y = today.getFullYear();
    m = today.getMonth();
    d = today.getDate();
    var viewtitle = 'month';
    var pagetitle = "<?php
if (isset($title)) {
    echo $title;
}
?>";

    if (pagetitle == "Dashboard") {

        viewtitle = 'agendaWeek';
    }

    $calendar.fullCalendar({
        viewRender: function (view, element) {
            // We make sure that we activate the perfect scrollbar when the view isn't on Month
            //if (view.name != 'month'){
            //  $(element).find('.fc-scroller').perfectScrollbar();
            //}
        },

        header: {
            center: 'title',
            right: 'month,agendaWeek,agendaDay',
            left: 'prev,next,today'
        },
        defaultDate: today,
        defaultView: viewtitle,
        selectable: true,
        selectHelper: true,
        views: {
            month: {// name of view
                titleFormat: 'MMMM YYYY'
                        // other view-specific options here
            },
            week: {
                titleFormat: " MMMM D YYYY"
            },
            day: {
                titleFormat: 'D MMM, YYYY'
            }
        },
        timezone: "Asia/Kolkata",
        draggable: false,
        lang: '<?php echo $language_name ?>',
        editable: false,
        eventLimit: false, // allow "more" link when too many events


        // color classes: [ event-blue | event-azure | event-green | event-orange | event-red ]
        events: {
            url: base_url + 'admin/calendar/getevents'

        },

        eventRender: function (event, element) {
            element.attr('title', event.title);
            element.attr('onclick', event.onclick);
            element.attr('data-toggle', 'tooltip');
            if ((!event.url) && (event.event_type != 'task')) {
                element.attr('title', event.title + '-' + event.description);
                element.click(function () {
                    view_event(event.id);
                });
            }
        },
        dayClick: function (date, jsEvent, view) {
            var d = date.format();
            if (!$.fullCalendar.moment(d).hasTime()) {
                d += ' 05:30';
            }
            //var vformat = (app_time_format == 24 ? app_date_format + ' H:i' : app_date_format + ' g:i A');
<?php if ($this->rbac->hasPrivilege('calendar_to_do_list', 'can_add')) { ?>


                $("#input-field").val('');
                $("#desc-field").text('');
                $("#date-field").daterangepicker({
                    startDate: date,
                    endDate: date,
                    timePicker: true, timePickerIncrement: 5, locale: {
                        format: 'MM/DD/YYYY hh:mm a'
                    }
                });
                $('#newEventModal').modal('show');

<?php } ?>
            return false;
        }

    });

    $(document).ready(function () {
        $("#date-field").daterangepicker({timePicker: true, timePickerIncrement: 5, locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }});


    });

    function datepic() {
        $("#date-field").daterangepicker();
    }
    function view_event(id) {
        //$("#28B8DA").removeClass('cpicker-small').addClass('cpicker-big');
        $('.selectevent').find('.cpicker-big').removeClass('cpicker-big').addClass('cpicker-small');
        var base_url = '<?php echo base_url() ?>';
        if (typeof (id) == 'undefined') {
            return;
        }
        $.ajax({
            url: base_url + 'admin/calendar/view_event/' + id,
            type: 'POST',
            //data: '',
            dataType: "json",
            success: function (msg) {


                $("#event_title").val(msg.event_title);
                $("#event_desc").text(msg.event_description);
                $('#eventdates').val(msg.start_date + '-' + msg.end_date);
                $('#eventid').val(id);
                if (msg.event_type == 'public') {

                    $('input:radio[name=eventtype]')[0].checked = true;

                } else if (msg.event_type == 'private') {
                    $('input:radio[name=eventtype]')[1].checked = true;

                } else if (msg.event_type == 'sameforall') {
                    $('input:radio[name=eventtype]')[2].checked = true;

                } else if (msg.event_type == 'protected') {
                    $('input:radio[name=eventtype]')[3].checked = true;

                }
                // $("#red#28B8DA").removeClass('cpicker-big').addClass('cpicker-small');

                //$(this).removeClass('cpicker-small', 'fast').addClass('cpicker-big', 'fast');
                $("#eventdates").daterangepicker({
                    startDate: msg.startdate,
                    endDate: msg.enddate,
                    timePicker: true, timePickerIncrement: 5, locale: {
                        format: 'MM/DD/YYYY hh:mm A'
                    }
                });
                $("#event_color").val(msg.event_color);
                $("#delete_event").attr("onclick", "deleteevent(" + id + ",'Event')")

                // $("#28B8DA").removeClass('cpicker-big').addClass('cpicker-small');
                $("#" + msg.colorid).removeClass('cpicker-small').addClass('cpicker-big');
                $('#viewEventModal').modal('show');
            }
        });


    }

    $(document).ready(function (e) {
// var datetime_format = '<?php //echo $result = strtr($this->customlib->getSchoolDateFormat(true,true), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY','H' => 'hh','i' => 'mm',])     ?>';
//       $('.datetime').datetimepicker({
//         format :datetime_format,
//       });

    });
    $(document).ready(function (e) {
        var datetime_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY', 'H' => 'hh', 'i' => 'mm',]) ?>';
        $("body").delegate(".datetime", "focusin", function () {
            $(this).datetimepicker({
                format: datetime_format,
                locale:
                        '<?php echo $language_name ?>',

            });
        });




        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        var capital_date_format = date_format.toUpperCase();
        $.fn.dataTable.moment(capital_date_format);

        $("body").delegate(".date", "focusin", function () {

            $(this).datepicker({
                todayHighlight: false,
                format: date_format,
                autoclose: true,
                language: '<?php echo $language_name ?>'
            });
        });
        var daterange_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY']) ?>';
        $("body").delegate(".daterange", "focusin", function () {
            $(this).daterangepicker({
                locale: {
                    format: daterange_format,
                },

            });
        });

    });
    $(document).ready(function (e) {
        $("#addevent_form").on('submit', (function (e) {
            $("#addevent_formbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url("admin/calendar/saveevent") ?>",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (res)
                {

                    if (res.status == "fail") {

                        var message = "";
                        $.each(res.error, function (index, value) {

                            message += value;
                        });
                        errorMsg(message);

                    } else {

                        successMsg(res.message);
                        window.location.reload(true);
                    }
                    $("#addevent_formbtn").button('reset');
                }
            });
        }));


    });


    $(document).ready(function (e) {
        $("#updateevent_form").on('submit', (function (e) {
            $("#updateevent_formbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url("admin/calendar/updateevent") ?>",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (res)
                {

                    if (res.status == "fail") {

                        var message = "";
                        $.each(res.error, function (index, value) {

                            message += value;
                        });
                        errorMsg(message);

                    } else {

                        successMsg(res.message);

                        window.location.reload(true);
                    }
                    $("#updateevent_formbtn").button('reset');
                }
            });
        }));


    });

    function deleteevent(id, msg) {
        if (typeof (id) == 'undefined') {
            return;
        }
        if (confirm("<?php echo $this->lang->line('are_you_sure_to_delete_this') ?>" + msg + " !")) {
            $.ajax({
                url: base_url + 'admin/calendar/delete_event/' + id,
                type: 'POST',
                //data: '',
                dataType: "json",
                success: function (res) {
                    if (res.status == "fail") {



                        errorMsg(res.message);

                    } else {

                        successMsg(msg + "<?php echo $this->lang->line('delete_message') ?>");

                        window.location.reload(true);
                    }
                }

            })
        }

    }


    $("body").on('click', '.cpicker', function () {
        var color = $(this).data('color');
        // Clicked on the same selected color
        if ($(this).hasClass('cpicker-big')) {
            return false;
        }

        $(this).parents('.cpicker-wrapper').find('.cpicker-big').removeClass('cpicker-big').addClass('cpicker-small');
        $(this).removeClass('cpicker-small', 'fast').addClass('cpicker-big', 'fast');
        if ($(this).hasClass('kanban-cpicker')) {
            $(this).parents('.panel-heading-bg').css('background', color);
            $(this).parents('.panel-heading-bg').css('border', '1px solid ' + color);
        } else if ($(this).hasClass('calendar-cpicker')) {
            $("body").find('input[name="eventcolor"]').val(color);
        }
    });

<?php if (isset($bedid)) { ?>

        add_inpatient('<?php echo $bedid ?>', '<?php echo $bedgroupid ?>');
<?php } ?>

    /*  $('.modal').on('hidden.bs.modal', function () {
     $(this).find('form').trigger('reset');
     $(".select2").select2('destroy');
     })*/

    function getbedstatus() {


        $("#beddata").button('loading');

        $.ajax({
            url: base_url + 'admin/patient/getBedStatus/',
            type: 'POST',
            data: '',
            //dataType: "json",
            success: function (res) {
                $("#ajaxbedstatus").html(res);
                $("#bed").modal('show');
                $("#beddata").button('reset');
            }
        })
    }
</script>
<!-------------------Appointment To Move OPD------------------------->
<?php
if (isset($opd_data) && (!empty($opd_data))) {
    if (isset($opd_data['opd_data']['patient_id'])) {
        ?>
        <script type="text/javascript">
            var datetime_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy', 'H' => 'hh', 'i' => 'mm',]) ?>';

            var opd_data = '<?php echo json_encode($opd_data['opd_data']) ?>';
            var data = JSON.parse(opd_data);
            $("#admission_date").val(new Date(data.appointment_date).toString(datetime_format));
            $("#consultant_doctor").val(data.cons_doctor);
            $("#addpatient_id").val(data.patient_id);
            get_PatientDetails(data.patient_id);
            holdModal('myModal');
        </script>
    <?php } else {
        ?> 
        <script type="text/javascript">
            var datetime_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy', 'H' => 'hh', 'i' => 'mm',]) ?>';

            var opd_data = '<?php echo json_encode($opd_data['opd_data']) ?>';
            var data = JSON.parse(opd_data);
            // console.log(data);
            $("#name").val(data.patient_name);
            $("#addformemail").val(data.email);
            $("#number").val(data.phone);
            $("#addformgender").val(data.gender);
            $("#admission_date").val(new Date(data.appointment_date).toString(datetime_format));
            $("#consultant_doctor").val(data.cons_doctor);
            holdModal('myModalpa');
        </script>
    <?php }
}
?>

<!-------------------Appontment To Move IPD ------------------------->
<?php
if (isset($ipd_data) && (!empty($ipd_data))) {
    if (isset($ipd_data['ipd_data']['patient_id'])) {
        ?>
        <script type="text/javascript">
            var datetime_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy', 'H' => 'hh', 'i' => 'mm',]) ?>';

            var ipd_data = '<?php echo json_encode($ipd_data['ipd_data']) ?>';
            var data = JSON.parse(ipd_data);
            $("#admission_date").val(new Date(data.appointment_date).toString(datetime_format));
            $("#consultant_doctor").val(data.cons_doctor);
            $("#addpatient_id").val(data.patient_id);
            get_PatientDetails(data.patient_id);
            holdModal('myModal');
        </script>
    <?php } else {
        ?> 
        <script type="text/javascript">
            var datetime_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy', 'H' => 'hh', 'i' => 'mm',]) ?>';

            var ipd_data = '<?php echo json_encode($ipd_data['ipd_data']) ?>';
            var data = JSON.parse(ipd_data);
            console.log(data);
            $("#name").val(data.patient_name);
            $("#addformemail").val(data.email);
            $("#number").val(data.phone);
            $("#addformgender").val(data.gender);
            $("#admission_date").val(new Date(data.appointment_date).toString(datetime_format));
            $("#consultant_doctor").val(data.cons_doctor);

            holdModal('myModalpa');
        </script>
    <?php }
}
?>

<!-------------------OPD Notification------------------------->
<?php
if (isset($opdn_data) && (!empty($opdn_data))) {
    if (isset($opdn_data['opdn_data']['patient_id'])) {
        ?>
        <script type="text/javascript">
            var datetime_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy', 'H' => 'hh', 'i' => 'mm',]) ?>';

            var opdn_data = '<?php echo json_encode($opdn_data['opdn_data']) ?>';
            var data = JSON.parse(opdn_data);
            var patientid = data.patient_id;
            var opdid = data.id;
            // console.log(opdid);
            // $("#admission_date").val(new Date(data.appointment_date).toString(datetime_format));
            // $("#consultant_doctor").val(data.cons_doctor);
            // $("#addpatient_id").val(data.patient_id);
            // get_PatientDetails(data.patient_id);
            // holdModal('myModal');
            getRecord(patientid, opdid);
        </script>
    <?php } else {
        ?> 
        <script type="text/javascript">
            var datetime_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy', 'H' => 'hh', 'i' => 'mm',]) ?>';

            var opdn_data = '<?php echo json_encode($opdn_data['opdn_data']) ?>';
            var data = JSON.parse(opdn_data);
            var patientid = data.patient_id;
            var opdid = data.id;
            //console.log(data);
            // $("#name").val(data.patient_name);
            // $("#addformemail").val(data.email);
            // $("#number").val(data.phone);
            // $("#addformgender").val(data.gender);
            //$("#admission_date").val(new Date(data.appointment_date).toString(datetime_format));
            // $("#consultant_doctor").val(data.cons_doctor);

            // holdModal('myModalpa');
            getRecord(patientid, opdid)
        </script>
    <?php }
}
?>



<!-------------------Ot Notification------------------------->
<?php
if (isset($ot_data) && (!empty($ot_data))) {
    if (isset($ot_data['ot_data']['patient_id'])) {
        ?>
        <script type="text/javascript">
            // $('#reportdata').html(data);
            var ot_data = '<?php echo json_encode($ot_data['ot_data']) ?>';
            var data = JSON.parse(ot_data);
            var patientid = data.patient_id;
            $("#patients_name").html(data.patient_name);
            $("#operations_name").html(data.operation_name);
            $("#patientsids").html(data.patient_unique_id);
            $("#genderes").html(data.gender);
            $("#mobileno").html(data.mobileno);
            $("#age_age").html(data.age + " Year " + data.month + " Month");
            $("#date_s").html(data.date);
            $("#ass_consultants_1").html(data.ass_consultant_1);
            $("#ass_consultants_2").html(data.ass_consultant_2);

            viewDetail(patientid);

        </script>
    <?php } else {
        ?> 
        <script type="text/javascript">
            var ot_data = '<?php echo json_encode($ot_data['ot_data']) ?>';
            var data = JSON.parse(ot_data);
            var patientid = data.patient_id;
            viewDetail(patientid);
        </script>
    <?php }
}
?>

<!-------------------Appointment Notification------------------------->
<?php
if (isset($app_data) && (!empty($app_data))) {
    if (isset($app_data['app_data']['patient_id'])) {
        ?>
        <script type="text/javascript">

            var app_data = '<?php echo json_encode($app_data['app_data']) ?>';
            var data = JSON.parse(app_data);
            var appointmentid = data.id
            //console.log(data);
            $("#dating").html(data.date);
            $("#patient_ids").html(data.patient_id);
            $("#patient_names").html(data.patient_name);
            $("#appointmentno").html(data.appointment_no);
            $("#genders").html(data.gender);
            $("#emails").html(data.email);
            $("#phones").html(data.mobileno);
            $("#doctors").html(data.name + " " + data.surname);
            $("#messages").html(data.message);
            var label = "";
            if (data.appointment_status == "approve") {
                var label = "class='label label-success'";
            } else if (data.appointment_status == "pending") {
                var label = "class='label label-warning'";
            } else if (data.appointment_status == "cancel") {
                var label = "class='label label-danger'";
            }

            $("#status").html("<small " + label + " >" + data.appointment_status + "</small>");
            viewDetail(appointmentid);
            // holdModal('viewModal');

        </script>
    <?php } else {
        ?> 
        <script type="text/javascript">
            var app_data = '<?php echo json_encode($app_data['app_data']) ?>';
            var data = JSON.parse(app_data);
            var appointmentid = data.id
            $("#dating").html(data.date);
            $("#patient_ids").html(data.patient_id);
            $("#patient_names").html(data.patient_name);
            $("#appointmentno").html(data.appointment_no);
            $("#genders").html(data.gender);
            $("#emails").html(data.email);
            $("#phones").html(data.mobileno);
            $("#doctors").html(data.name + " " + data.surname);
            $("#messages").html(data.message);
            var label = "";
            if (data.appointment_status == "approve") {
                var label = "class='label label-success'";
            } else if (data.appointment_status == "pending") {
                var label = "class='label label-warning'";
            } else if (data.appointment_status == "cancel") {
                var label = "class='label label-danger'";
            }

            $("#status").html("<small " + label + " >" + data.appointment_status + "</small>");
            // holdModal('viewModal');
            viewDetail(appointmentid);

        </script>
    <?php }
}
?>

<!-------------------payslip Notification ------------------------->
<?php
if (isset($staff_data) && (!empty($staff_data))) {
    if (isset($staff_data['staff_data']['id'])) {
        ?>
        <script type="text/javascript">
            // $('#reportdata').html(data);
            var staff_data = '<?php echo json_encode($staff_data['staff_data']) ?>';
            var data = JSON.parse(staff_data);
            var payid = data.id;
            //$('#test2').val(data.name);
            //$('#test3').val(data.surname);
            //alert(payid);
            getPayslip(payid)
        </script>
    <?php } else {
        ?> 
        <script type="text/javascript">
            alert('hello else');
            //holdModal('viewModal');
        </script>
    <?php }
}
?>
<!-- 
<?php if (isset($ipd_data) && (!empty($ipd_data))) {
    ?>
        <script type="text/javascript">
            var datetime_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy', 'H' => 'hh', 'i' => 'mm',]) ?>';
               
            var opd_data = '<?php echo json_encode($ipd_data['opd_data']) ?>';
            var data = JSON.parse(opd_data);
           $("#admission_date").val(new Date(data.appointment_date).toString(datetime_format));
            $("#consultant_doctor").val(data.cons_doctor);
            $("#addpatient_id").val(data.id);
            get_PatientDetails(data.id);
            holdModal('myModal');
        </script>
<?php }
?>  -->