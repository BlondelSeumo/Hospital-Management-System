<!-- <style type="text/css">
    body:not(.form-membership) {
    overflow: hidden;
}
</style> -->
<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/chat/main.css"> 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-map-o"></i> Chat --r
        </h1>
    </section>

    <!-- Main content -->
    <section class="content" style="position: relative;">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div id="frame">
                    <div class="chatloader"></div>  

                    <div id="sidepanel">
                        <input type="hidden" name="chat_connection_id" value="0">
                        <input type="hidden" name="chat_to_user" value="0">
                        <input type="hidden" name="last_chat_id" value="0">

                        <div id="search">
                            <label for="">Chat System</label>
                            <!-- <input type="text" placeholder="Search contacts..." /> -->
                            <div id="bottom-bar">
                                <button id="addcontact" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>

                            </div>
                        </div>
                        <div id="contacts">

                            <ul>
                            </ul>
                        </div>

                    </div>
                    <div class="chatcontent">
                        <div class="contact-profile">
                            <img src="<?php echo base_url('uploads/student_images/no_image.png'); ?>" alt="" />
                            <p>Select any user to start your chat --r</p>

                        </div>
                        <div class="messages">
                            <ul>

                            </ul>
                        </div>
                        <div class="message-input ">
                            <div class="wrap relative">
                                <input type="text" placeholder="Write your message..." class="chat_input" />
                                <!-- <i class="fa fa-paperclip attachment" aria-hidden="true"></i> -->
                                <button class="submit input_submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.box-header -->
        </div><!-- /.box-header -->

    </section>

</div><!-- /.box-body -->
</div>
</div><!--/.col (left) -->
<!-- right column -->

</div>

</section><!-- /.content -->
</div><!-- /.content-wrapper -->



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form id="addUser" action="<?php echo site_url('admin/chat/adduser') ?>" method="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Contact --r</h4>
                </div>
                <div class="modal-body">
                    <div id="custom-search-input">
                        <div class="input-group col-md-12">
                            <input type="text" class="search-query form-control" placeholder="Search" />
                        </div>
                    </div>
                    <div class="usersearchlist">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait"><i class="fa fa-plus"></i> Add --r</button>
                </div>
            </div>
        </form>

    </div>
</div>




<script>
    var timestamp = '<?php echo time(); ?>';
    var date_time_temp = "";
    function updateTime() {
        date_time_temp = js_yyyy_mm_dd_hh_mm_ss(Date(timestamp));
        timestamp++;
    }

    $(document).on('click', '.input_submit', function (e) {


        message = $(".message-input input").val();
        if ($.trim(message) == '') {
            return false;
        }
        newChatMessage();
        e.preventDefault(); // To prevent the default
    });

    $(function () {
        setInterval(updateTime, 1000);
    });
    $(".messages").animate(
            {
                scrollTop: $(document).height()
            },
            "fast"
            );

    $("#profile-img").click(function () {
        $("#status-options").toggleClass("active");
    });

    $(".expand-button").click(function () {
        $("#profile").toggleClass("expanded");
        $("#contacts").toggleClass("expanded");
    });

    $("#status-options ul li").click(function () {
        $("#profile-img").removeClass();
        $("#status-online").removeClass("active");
        $("#status-away").removeClass("active");
        $("#status-busy").removeClass("active");
        $("#status-offline").removeClass("active");
        $(this).addClass("active");

        if ($("#status-online").hasClass("active")) {
            $("#profile-img").addClass("online");
        } else if ($("#status-away").hasClass("active")) {
            $("#profile-img").addClass("away");
        } else if ($("#status-busy").hasClass("active")) {
            $("#profile-img").addClass("busy");
        } else if ($("#status-offline").hasClass("active")) {
            $("#profile-img").addClass("offline");
        } else {
            $("#profile-img").removeClass();
        }
        ;

        $("#status-options").removeClass("active");
    });


    var interval;
    var intervalchat;
    var intervalchatnew;
    $(document).on('keyup', '.search-query', function () {
        $this = $(this);
        var keyword = $(this).val();

        if (keyword.length >= 2) {

            $.ajax({
                type: "POST",
                url: base_url + 'admin/chat/searchuser',
                data: {'keyword': keyword},
                dataType: "JSON",
                beforeSend: function () {
                    $this.addClass('dropdownloading');

                },
                success: function (data) {
                    $('.usersearchlist').html("").html(data.page);
                    $this.removeClass('dropdownloading');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $this.removeClass('dropdownloading');
                },
                complete: function (data) {
                    $this.removeClass('dropdownloading');
                }
            })
        } else if (keyword.length >= 0) {
            $('.usersearchlist').html("")
        }

    });


    $(document).ready(function () {

        $.ajax({
            type: "POST",
            url: base_url + 'admin/chat/myuser',
            data: {},
            dataType: "JSON",
            beforeSend: function () {
                $('.chatloader').css({display: 'block'});
            },
            success: function (data) {
                $("#contacts ul").html(data.page);

                if (data.status === "1") {

                    clearInterval(intervalchat);
                    intervalchat = setInterval(getChatNotification, 15000);

                    clearInterval(intervalchatnew);
                    intervalchat = setInterval(mynewUser, 25000);

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.chatloader').css({display: 'none'});
            },
            complete: function (data) {
                $('.chatloader').css({display: 'none'});
            }
        });
    });
    $(document).on('click', '.contact', function () {
        var chat_connection_id = $(this).data('chatConnectionId');
        var $this = $(this);
        $.ajax({
            type: "POST",
            url: base_url + 'admin/chat/getChatRecord',
            data: {'chat_connection_id': chat_connection_id},
            dataType: "JSON",
            beforeSend: function () {
                $('.chatloader').css({display: 'block'});
                $(".chat_input").val("");
                $('.contact-profile').find('p').html($this.find('.name').text());
                $('.contact-profile').find('img').attr("src", $this.find('img').attr('src'));
                $this.addClass('active').siblings().removeClass('active');
            },
            success: function (data) {

                $this.find('span.notification_count').css("display", "none");


                $(".messages ul").html(data.page);

                $("input[name='chat_connection_id']").val(data.chat_connection_id);
                $("input[name='chat_to_user']").val(data.chat_to_user);
                $("input[name='last_chat_id']").val(data.user_last_chat.id);
                $('.messages').animate({
                    scrollTop: $('.messages')[0].scrollHeight}, "slow"
                        );
                clearInterval(interval);
                interval = setInterval(getChatsUpdates, 2000);


            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.chatloader').css({display: 'none'});
            },
            complete: function (data) {
                $('.chatloader').css({display: 'none'});
            }
        })

    });



    $(document).on('keydown', '.chat_input', function (e) {

        switch (e.which) {
            case 13:
                newChatMessage();
                break;
        }


    });


    function newChatMessage() {
        message = $(".message-input input").val();
        if ($.trim(message) == '') {
            return false;
        }

        var chat_connection_id = $("input[name='chat_connection_id']").val();
        var chat_to_user = $("input[name='chat_to_user']").val();
        if (chat_connection_id > 0 && chat_to_user > 0) {

            $.ajax({
                type: "POST",
                url: base_url + 'admin/chat/newMessage',
                data: {'chat_connection_id': chat_connection_id, 'message': message, 'chat_to_user': chat_to_user, 'time': date_time_temp},
                dataType: "JSON",
                beforeSend: function () {

                },
                success: function (data) {
                    var last_chat_id = $("input[name='last_chat_id']").val(data.last_insert_id);
                    $('<li class="replies"><p>' + message + '</p> <span class="time_date_send"> ' + date_time_temp + '</span></li>').appendTo($('.messages ul'));
                    $('.chat_input').val(null);
                    $('.contact.active .preview').html('<span>You: </span>' + message);
                    // $(".messages").animate({scrollTop: $(document).height()}, "fast");

                    $('.messages').animate({
                        scrollTop: $('.messages')[0].scrollHeight}, "slow");

                },
                error: function (jqXHR, textStatus, errorThrown) {

                },
                complete: function (data) {

                }
            })
        }

    }
    ;


    function getChatsUpdates() {
        var end_reach = false;
        var chat_connection_id = $("input[name='chat_connection_id']").val();
        var chat_to_user = $("input[name='chat_to_user']").val();
        var last_chat_id = $("input[name='last_chat_id']").val();
        $.ajax({
            type: "POST",
            url: base_url + 'admin/chat/chatUpdate',
            data: {'chat_connection_id': chat_connection_id, 'chat_to_user': chat_to_user, 'last_chat_id': last_chat_id},
            dataType: "JSON",
            beforeSend: function () {

            },
            success: function (data) {
                var scrollTop = $('.messages').scrollTop();
                if (scrollTop + $('.messages').innerHeight() >= $('.messages')[0].scrollHeight) {
                    end_reach = true;
                }
                $("input[name='last_chat_id']").val(data.user_last_chat.id);
                $('.messages ul').append(data.page);
                if (end_reach) {
                    $('.messages').animate({
                        scrollTop: $('.messages')[0].scrollHeight}, "slow");

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            },
            complete: function (data) {

            }
        })


    }

    $(document).on('click', '.usersearchlist ul li', function () {
        $this = $(this);
        $this.addClass('active').siblings().removeClass('active');

    });

    $("#addUser").submit(function (event) {
        event.preventDefault();
        var img = "";
        var userrecord = $('.usersearchlist').find("ul li.active");
        var userId = userrecord.data('userId');
        var userType = userrecord.data('userType');
        var $form = $(this),
                url = $form.attr('action');
        // var $this = $('.submit_class');
        // $this.button('loading');
        var $button = $form.find("button[type=submit]:focus");
        $.ajax({
            type: "POST",
            url: url,
            data: {'user_type': userType, 'user_id': userId},
            dataType: "JSON",

            beforeSend: function () {
                $button.button('loading');

            },
            success: function (data) {
                if (data.status == 0) {
                    var message = "";
                    $.each(data.error, function (index, value) {

                        message += value;
                    });
                    errorMsg(message);
                } else {

                    $("#contacts ul").prepend(newUserLi(data.new_user, data.chat_connection_id)).find('li').addClass('active').siblings().not('li:first').removeClass('active');

                    $(".messages ul").html(data.chat_records);

                    $("input[name='chat_connection_id']").val(data.chat_connection_id);
                    $("input[name='chat_to_user']").val(data.new_user.chat_user_id);
                    $("input[name='last_chat_id']").val(data.user_last_chat.id);
                    $(".chat_input").val("");
                    console.log(data.new_user);


                    if (data.new_user.user_type == "patient") {
                        new_user_type = "Patient";
                        img = base_url + data.new_user.image;
                    } else if (data.new_user.user_type == "staff") {
                        new_user_type = "Staff";
                        img = base_url + "uploads/staff_images/" + data.new_user.image;
                    }
                    $('.contact-profile').find('p').html(data.new_user.name);
                    $('.contact-profile').find('img').attr("src", img);
                    $('.messages').animate({
                        scrollTop: $('.messages')[0].scrollHeight}, "slow"
                            );
                    clearInterval(interval);
                    interval = setInterval(getChatsUpdates, 2000);



                    $('#myModal').modal('hide');
                    successMsg(data.message);
                }
                $button.button('reset');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $button.button('reset');
            },
            complete: function (data) {
                $button.button('reset');
            }
        });

    });
    $('#myModal').on('hidden.bs.modal', function (e) {

        $('.usersearchlist').html("");
        $('#addUser').trigger("reset");
    });



    function newUserLi(user_array, chat_connection_id) {

        var new_user_type = "Staff";
        var img = "";
        if (user_array.user_type == "patient") {
            new_user_type = "Patient";
            img = base_url + user_array.image;
        } else if (user_array.user_type == "staff") {
            new_user_type = "Staff";
            img = base_url + "uploads/staff_images/" + user_array.image;

        }
        var newli = "<li class='contact' data-chat-connection-id='" + chat_connection_id + "'>";
        newli += "<div class='wrap'>";
        newli += "<img src='" + img + "' alt=''>";
        newli += "<div class='meta'>";
        newli += "<p class='name'>" + user_array.name + " (" + new_user_type + ")" + "</p>";
        newli += "<p class='preview'></p>";
        newli += "</div>";
        newli += "</div>";
        newli += "<span class='chatbadge notification_count' style='display: none;'>0</span>";
        newli += "</li>";
        return newli;

    }



    function getChatNotification() {
        $.ajax({
            type: "POST",
            url: base_url + 'admin/chat/mychatnotification',
            data: {},
            dataType: "JSON",
            beforeSend: function () {

            },
            success: function (data) {
                var active_user = $('#contacts').find("ul li.active");

                if (data.notifications.length > 0) {

                    $.each(data.notifications, function (index, value) {
                        if (active_user.data('chatConnectionId') != value.chat_connection_id) {

                            $('#contacts').find("ul li[data-chat-connection-id='" + value.chat_connection_id + "']").find('span.notification_count').text(value.no_of_notification).css("display", "block");
                        }

                    });
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {

            },
            complete: function (data) {

            }
        })
    }


    function js_yyyy_mm_dd_hh_mm_ss(now) {
        var month = [
            "Jan", "Feb", "Marh", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Octr", "Nov", "Dec"
        ];
        now = new Date();
        year = "" + now.getFullYear();
        month = "" + month[now.getMonth()];
        day = "" + now.getDate();
        if (day.length == 1) {
            day = "0" + day;
        }
        hour = "" + now.getHours();
        if (hour.length == 1) {
            hour = "0" + hour;
        }
        minute = "" + now.getMinutes();
        if (minute.length == 1) {
            minute = "0" + minute;
        }
        second = "" + now.getSeconds();
        if (second.length == 1) {
            second = "0" + second;
        }
        var ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12;
        hour = hour ? hour : 12; // the hour '0' should be '12'
        // return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;

        return day + " " + month + " " + year + ", " + hour + ":" + minute + ":" + ampm;
    }

    function mynewUser() {
        var users_Array = []; // more efficient than new Array()
        $("#contacts ul li").each(function (n) {
            var as = $(this).data('chatConnectionId');
            users_Array.push(as);

        });

        $.ajax({
            type: "POST",
            url: base_url + 'admin/chat/mynewuser',
            data: {'users': users_Array},
            dataType: "JSON",
            beforeSend: function () {


            },
            success: function (data) {
                $("#contacts ul").prepend(data.new_user_list);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            },
            complete: function (data) {

            }
        })

    }
</script>