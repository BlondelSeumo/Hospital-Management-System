<style>

    .ui-accordion{border: 1px solid #f4f4f4;}    
    .panel-heading {
        padding: 0;
        border: 0;
    }
    .panel-title > a,
    .panel-title > a:active {
        display: block;
        padding: 15px;
        color: #555;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        word-spacing: 3px;
        text-decoration: none;
    }
    .panel-heading a:before {
        font-family: 'FontAwesome';
        content: "\f106";
        float: right;
        transition: all 0.5s;
    }
    .panel-heading.active a:before {
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .accordianheader {
        color: #000;
        background: #fff;
        padding: 10px 10px;
        margin-bottom: 0px;
        border-top: 1px solid #ddd;
        position: relative;
        overflow: hidden;
        outline: 0;
        cursor: pointer;
    }
    .accordianbody {
        background: #f4f4f4;
    }
    /*.accordianbody ul {
      margin: 0;
      list-style: none;
      padding: 0;
    }
    .accordianbody ul li {
      padding: 10px;
      border-bottom: 1px solid lightgrey;
    }*/

    .accordianbody i {
        color: #fff !important;
        position: absolute;
        right: 20px;
        top: 14px;

        -webkit-transition: all 300ms ease-in 0s;
        -moz-transition: all 300ms ease-in 0s;
        -o-transition: all 300ms ease-in 0s;
        transition: all 300ms ease-in 0s;
    }
    .ui-state-active i {
        color: #000;
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
        -webkit-transition: all 300ms ease-in 0s;
        -moz-transition: all 300ms ease-in 0s;
        -o-transition: all 300ms ease-in 0s;
        transition: all 300ms ease-in 0s;
    }


    /*.more-less{color: #000;font-size: 20px;position: absolute; right: 30px;}
    .rotate {
      -moz-transform: rotate(-180deg);
      -ms-transform: rotate(-180deg);
      -webkit-transform: rotate(-180deg);
      transform: rotate(-180deg);
    }
    
    .icon-rotate {
      -moz-transition-duration: 0.4s;
      -o-transition-duration: 0.4s;
      -webkit-transition-duration: 0.4s;
      transition-duration: 0.4s;
      display: inline-block;
    }
    
    .collapsed{background: #eff4f9;}
    .noselected{background:#fff;}*/
    /* Style the element that is used to open and close the accordion class */
    /*.accordion-toggle{position: relative;}
    .accordion-toggle:after {
        font-family: 'FontAwesome';
        content: "\f106";    
        font-size: 18px;
        position: absolute; right:20px; top:20px;
    }
    .accordion-opened .accordion-toggle:after {    
        content: "\f107";    
    }
    */

    /*.accordion {
        color: #444;
        cursor: pointer;
        width: 100%;
        text-align: left;
        border: none;
        outline: none;
        transition: 0.4s;
    }*/

    /* Add a background color to the accordion if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
    /*p.accordion.active, p.accordion:hover {
        background-color: #ddd;
    }*/

    /* Unicode character for "plus" sign (+) */
    /*.table.notetable tr:hover .accordion:after{opacity: 100;}
    .accordion:after {
        content: "\f106"; 
        font-size: 20px;
        color: #777;
        float: right;
        opacity: 0;
        margin-left: 5px;
        transition: all 0.3s;
        position: absolute;right: 30px;
        font-family:"FontAwesome";
    }*/

    /* Unicode character for "minus" sign (-) */
    /*.accordion.active:after {opacity: 100;}
    .accordion.active:after {
        content: "\f106";
        transform: rotate(180deg);
    }*/

    /* Style the element that is used for the panel class */
    /*.selected{background: #eff4f9;}
    div.panel {
        max-height: 0;
        overflow: hidden;
        transition: 0.4s ease-in-out;
        opacity: 0;
        background: transparent;
        box-shadow: none;
        transition: all 0.3s;
    }
    
    div.panel.show {
        opacity: 1;
        max-height: 500px;
    }*/
    .notigybg{background: #fafafa; padding: 10px; overflow: hidden;font-weight: bold;}
    .notifyleft{width: 8%; float: left;}
    .notifymiddle{width: 70%; float: left;}
    .notifyright{width: 18%; float: left;}
    .noteangle{position: absolute; right:20px; font-size: 18px; top:20px;}
    .note-content{padding-left: 8.5%;padding-bottom: 15px;}

    .noteDM10{padding-top: 10px;}
    .unreadbg{background:#e1eeff;}
    .readbg{background:#fff;}
    .accordianheader{-webkit-transition: all 0.5s ease 0s;
                     -moz-transition: all 0.5s ease 0s;
                     -ms-transition: all 0.5s ease 0s;
                     -o-transition: all 0.5s ease 0s;
                     transition: all 0.5s ease 0s;}
    .accordianheader:focus,
    .accordianheader:visited,
    .accordianheader:hover{background:#f5f5f5;}
    @media(max-width:767px){
        .notifyleft{width: 60px;}
        .notifymiddle{width: 40%;}
        .notifyright{width: 20%;}
        .noteDM10{padding-top: 0px;}
        .note-content{padding-left: 70px;}
    }
</style>

<script>
    /*document.addEventListener("DOMContentLoaded", function(event) { 
     
     
     var acc = document.getElementsByClassName("accordion");
     var panel = document.getElementsByClassName('panel');
     
     for (var i = 0; i < acc.length; i++) {
     acc[i].onclick = function() {
     // alert("hi");
     //  id = $(this).attr("id");
     //updateStatus(id);
     var setClasses = !this.classList.contains('active');
     setClass(acc, 'active', 'remove');
     setClass(panel, 'show', 'remove');
     
     if (setClasses) {
     this.classList.toggle("active");
     this.nextElementSibling.classList.toggle("show");
     }
     }
     }
     
     function setClass(els, className, fnName) {
     for (var i = 0; i < els.length; i++) {
     els[i].classList[fnName](className);
     }
     }
     
     });*/

    function updateStatus(id) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/systemnotification/updateStatus/',
            type: 'POST',
            data: {id: id},
            dataType: "json",
            success: function (res) {
                // $("#ajaxbedstatus").html(res);
                // $("#bed").modal('show');
                // $("#beddata").button('reset');
            }
        })
    }

    $(function () {
        $(".accordianheader").click(function () {
            var id = $(this).attr("data-noticeid");
            $(this).addClass('readbg');
            updateStatus(id);
            //alert(id);
        });
    });

</script>

<script>
    /* Toggle between adding and removing the "active" and "show" classes when the user clicks on one of the "Section" buttons. The "active" class is used to add a background color to the current button when its belonging panel is open. The "show" class is used to open the specific accordion panel */
// var acc = document.getElementsByClassName("accordion");
// var i;

// for (i = 0; i < acc.length; i++) {
//     acc[i].onclick = function(){
//         this.classList.toggle("active");
//         this.nextElementSibling.classList.toggle("show");
// };
// }
</script>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><i class="fa fa-bell-o"></i> <?php echo $this->lang->line('notifications'); ?></h3>
                    </div>
                    <div class="box-body">



                        <div id="accordion" class="accordionclick">
                            <div class="notigybg">   
                                <div class="notifyleft" style=""><?php echo $this->lang->line('type'); ?></div>
                                <div class="notifymiddle" style=""><?php echo $this->lang->line('subject'); ?></div>

                                <div class="notifyright" style=""><?php echo $this->lang->line('date'); ?></div>
                            </div>   
                            <!-- yeah, yeah, I spelled Accordion wrong,  do something about it.  - G  -->
                            <?php if (empty($notifications)) { ?>
                                <?php
                            } else {
                                $count = 1;
                                $color = "";
                                foreach ($notifications as $result) {
                                    // print_r($result);
                                    if ((!empty($result['read'])) && ($result['read'] == 'no')) {
                                        $class = "readbg";
                                    } else {
                                        $class = "unreadbg";
                                    }
                                    ?>
                                    <div class="accordianheader  <?php echo $class ?>" data-noticeid="<?php echo $result['id'] ?>">
                                        <div class="notifyleft">
                                            <div class="bellcircle">
                                                <?php
                                                if ($result['notification_type'] == 'opd') {
                                                    $class = $notificationicon['opd'];
                                                    //$url_link = $notificationurl['opd'];
                                                } if ($result['notification_type'] == 'ipd') {
                                                    $class = $notificationicon['ipd'];
                                                    //$url_link = $notificationurl['ipd'];
                                                } if ($result['notification_type'] == 'appointment') {
                                                    $class = $notificationicon['appointment'];
                                                    // $url_link = $notificationurl['appointment'];
                                                } if ($result['notification_type'] == 'ot') {
                                                    $class = $notificationicon['ot'];
                                                    //$url_link = $notificationurl['ot'];
                                                } if ($result['notification_type'] == 'salary') {
                                                    $class = $notificationicon['salary'];
                                                    // $url_link = $notificationurl['salary']."/".$result['id'];
                                                }
                                                ?>     
                                                <i class="<?php echo $class; ?>" style="transform: rotate(0deg); color: #fff;"></i>               
                                            </div>
                                        </div><!--./notifyleft-->

                                        <div class="notifymiddle noteDM10"><?php echo $result['notification_title']; ?></div>
                                        <div class="notifyright noteDM10"><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['date'])); ?></div>
                                        <div class="noteangle" style=""><i class="fa fa-angle-down" ></i>
                                        </div>
                                    </div>
                                    <div class="accordianbody" style="position: relative;">
                                        <div class="note-content"> 
                                            <?php echo $result['notification_desc']; ?>

                                        </div>
                                    </div>
                                    <?php
                                    $count++;
                                }
                            }
                            ?>
                            <!--./accordianbody-->

                            <!-- <div class="accordianheader">
                                 <div style="width: 8%; float: left">
                                     <div class="bellcircle"><i class="fa fa-bell-o" style="transform: rotate(0deg); color: #fff;"></i></div>
                                 </div>
                                 <div style="width: 70%; float: left;padding-top: 10px;">OPD Visit Created-1</div>
                                 <div style="width: 22%; float: left;padding-top: 10px;">09/13/2019 10:05 AM</div>
                                 <div style="position: absolute; right:20px; font-size: 18px;"><i class="fa fa-angle-down" ></i></div>
                             </div>
                             <div class="accordianbody" style="position: relative;">
                                <div style="padding-left: 9%;"> 
                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.</div>
                             </div>--><!--./accordianbody-->


                        </div><!--.#accordion-->




                        <br /> <br />     

               <!-- <table class="notetable table table-border table-hover" width="100%">
           
                    <tr>
                        <th width="8%">Type</th>
                        <th width="70%">Subject</th>
                        <th  width="22%">Date</th>
                    </tr>
                        <?php if (empty($notifications)) { ?>
                            <?php
                        } else {
                            $count = 1;
                            $color = "";
                            foreach ($notifications as $result) {
                                ?>
                                                       
                                      <tr class="<?php echo $color ?>">
                                          <div>
                                           <td>
                                          <div class="bellcircle"><i class="fa fa-bell-o"></i></div>
                                        </td>
                                      
                                      <td>
                                        <p class="accordion" id="<?php echo $result["id"] ?>"><b><?php echo $result['notification_title']; ?></b></p>
                    
                                          <div class="panel">
                                            <p><?php echo $result['notification_desc']; ?></p>
                                        </div>
                                      </td>
                                      <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['date'])); ?></td> 
                                        </div>    </tr>
                                <?php
                                $count++;
                            }
                        }
                        ?>
                </table>  -->

                        <ul class="pagination">
<?php echo $this->pagination->create_links(); ?>

                        </ul>
                    </div>        
                </div>


            </div><!--./row-->

    </section>
</div>


<script src="<?php echo base_url() ?>backend/js/Chart.bundle.js"></script>
<script src="<?php echo base_url() ?>backend/js/utils.js"></script>

<script type="text/javascript">


    $("#accordion").accordion({
        heightStyle: "content",
        active: true,
        collapsible: true,
        header: ".accordianheader"
    });

    $(document).ready(function () {
        $(".accordianheader").click(function () {
            // $(this).removeClass('bgwhite').addClass('bggray');
            //  $(".note-content").css("border-bottom", "1px solid #e6e5e5");
            //  $(".accordianheader").css("border-top", "1px solid #e6e5e5");
        });

        // $(".accordianheader").click(function(){
        //   $(this).removeClass('bgwhite').addClass('bggray');
        // });

    });

    // $('.panel-collapse').on('show.bs.collapse', function () {
    //    $(this).siblings('.panel-heading').addClass('active');
    //  });

    //  $('.panel-collapse').on('hide.bs.collapse', function () {
    //    $(this).siblings('.panel-heading').removeClass('active');
    //  });


// $(function() {
//     $(".accordion-toggle").on('click', function() { 
//      $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
//      $(this).addClass('collapsed').addClass('collapsed');   

//        //$(".fa-angle-up").toggleClass("rotate");
//        //$('.accordion-toggle').removeClass('selected');
//     });
// });

// function toggleIcon(e) {
//     $(e.target)
//         .prev('.panel-heading')
//         .find(".more-less")
//         .toggleClass('fa-angle-up fa-angle-down');
// }

    // $(document).on('show','.accordion', function (e) {
    //      //$('.accordion-heading i').toggleClass(' ');
    //      //$(e.target).prev('.accordion-heading').addClass('accordion-opened');
    // });

    // $(document).on('hide','.accordion', function (e) {
    //     $(this).find('.accordion-heading').not($(e.target)).removeClass('accordion-opened');
    //     //$('.accordion-heading i').toggleClass('fa-chevron-right fa-chevron-down');
    // });
    //    $('.panel-collapse').on('show.bs.collapse', function () {
    //   $(this).siblings('.panel-heading').addClass('active');
    // });

    // $('.panel-collapse').on('hide.bs.collapse', function () {
    //   $(this).siblings('.panel-heading').removeClass('active');
    // });
</script>
<script type="text/javascript">
// $(document).ready(function () {
//     $('table.notetable tr').removeClass('selected');
//     $(this).addClass('selected');
// });

// $(document).ready(function () {
//     $('table.notetable tr').addClass('selected');
//     $(this).removeClass('selected');
// });

    $(document).ready(function () {

        $(document).on('click', '.close_notice', function () {
            var data = $(this).data();
            $.ajax({
                type: "POST",
                url: base_url + "admin/notification/read",
                data: {'notice': data.noticeid},
                dataType: "json",
                success: function (data) {
                    if (data.status == "fail") {

                        errorMsg(data.msg);
                    } else {
                        successMsg(data.msg);
                    }

                }
            });
        });
    });
</script>
<!-- https://bootsnipp.com/snippets/Q6zjv -->