<style class="cp-pen-styles">
    .time_date{    position: absolute;
                   text-align: left;
                   display: block;
                   padding-left: 35px;
    }
    .time_date_send {
        text-align: right;
        display: block;
        padding-right: 35px;
        position: absolute;
        right: 0;
        bottom: -18px;
    }

    #frame {
        width: 100%;

        height: 88vh;

        background: #E6EAEA;
    }

    #contacts ul{padding: 0; margin:0; list-style: none;}
    @media screen and (max-width: 360px) {
        #frame {
            width: 100%;
            height: 100vh;
        }
    }
    #frame #sidepanel {
        float: left;
        min-width: 280px;
        max-width: 340px;
        width: 40%;
        height: 100%;
        background: #2c3e50;
        color: #f5f5f5;
        overflow: hidden;
        position: relative;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel {
            width: 58px;
            min-width: 58px;
        }
    }
    #frame #sidepanel #profile {
        width: 80%;
        margin: 25px auto;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile {
            width: 100%;
            margin: 0 auto;
            padding: 5px 0 0 0;
            background: #32465a;
        }
    }
    #frame #sidepanel #profile.expanded .wrap {
        height: 210px;
        line-height: initial;
    }
    #frame #sidepanel #profile.expanded .wrap p {
        margin-top: 20px;
    }
    #frame #sidepanel #profile.expanded .wrap i.expand-button {
        -moz-transform: scaleY(-1);
        -o-transform: scaleY(-1);
        -webkit-transform: scaleY(-1);
        transform: scaleY(-1);
        filter: FlipH;
        -ms-filter: "FlipH";
    }
    #frame #sidepanel #profile .wrap {
        height: 60px;
        line-height: 60px;
        overflow: hidden;
        -moz-transition: 0.3s height ease;
        -o-transition: 0.3s height ease;
        -webkit-transition: 0.3s height ease;
        transition: 0.3s height ease;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap {
            height: 55px;
        }
    }
    #frame #sidepanel #profile .wrap img {
        width: 50px;
        border-radius: 50%;
        padding: 3px;
        border: 2px solid #e74c3c;
        height: auto;
        float: left;
        cursor: pointer;
        -moz-transition: 0.3s border ease;
        -o-transition: 0.3s border ease;
        -webkit-transition: 0.3s border ease;
        transition: 0.3s border ease;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap img {
            width: 40px;
            margin-left: 4px;
        }
    }
    #frame #sidepanel #profile .wrap img.online {
        border: 2px solid #2ecc71;
    }
    #frame #sidepanel #profile .wrap img.away {
        border: 2px solid #f1c40f;
    }
    #frame #sidepanel #profile .wrap img.busy {
        border: 2px solid #e74c3c;
    }
    #frame #sidepanel #profile .wrap img.offline {
        border: 2px solid #95a5a6;
    }
    #frame #sidepanel #profile .wrap p {
        float: left;
        margin-left: 15px;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap p {
            display: none;
        }
    }
    #frame #sidepanel #profile .wrap i.expand-button {
        float: right;
        margin-top: 23px;
        font-size: 0.8em;
        cursor: pointer;
        color: #435f7a;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap i.expand-button {
            display: none;
        }
    }
    #frame #sidepanel #profile .wrap #status-options {
        position: absolute;
        opacity: 0;
        visibility: hidden;
        width: 150px;
        margin: 70px 0 0 0;
        border-radius: 6px;
        z-index: 99;
        line-height: initial;
        background: #435f7a;
        -moz-transition: 0.3s all ease;
        -o-transition: 0.3s all ease;
        -webkit-transition: 0.3s all ease;
        transition: 0.3s all ease;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options {
            width: 58px;
            margin-top: 57px;
        }
    }
    #frame #sidepanel #profile .wrap #status-options.active {
        opacity: 1;
        visibility: visible;
        margin: 75px 0 0 0;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options.active {
            margin-top: 62px;
        }
    }
    #frame #sidepanel #profile .wrap #status-options:before {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 8px solid #435f7a;
        margin: -8px 0 0 24px;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options:before {
            margin-left: 23px;
        }
    }
    #frame #sidepanel #profile .wrap #status-options ul {
        overflow: hidden;
        border-radius: 6px;
    }
    #frame #sidepanel #profile .wrap #status-options ul li {
        padding: 15px 0 30px 18px;
        display: block;
        cursor: pointer;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options ul li {
            padding: 15px 0 35px 22px;
        }
    }
    #frame #sidepanel #profile .wrap #status-options ul li:hover {
        background: #496886;
    }
    #frame #sidepanel #profile .wrap #status-options ul li span.status-circle {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin: 5px 0 0 0;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options ul li span.status-circle {
            width: 14px;
            height: 14px;
        }
    }
    #frame #sidepanel #profile .wrap #status-options ul li span.status-circle:before {
        content: '';
        position: absolute;
        width: 14px;
        height: 14px;
        margin: -3px 0 0 -3px;
        background: transparent;
        border-radius: 50%;
        z-index: 0;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options ul li span.status-circle:before {
            height: 18px;
            width: 18px;
        }
    }
    #frame #sidepanel #profile .wrap #status-options ul li p {
        padding-left: 12px;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #profile .wrap #status-options ul li p {
            display: none;
        }
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-online span.status-circle {
        background: #2ecc71;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-online.active span.status-circle:before {
        border: 1px solid #2ecc71;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-away span.status-circle {
        background: #f1c40f;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-away.active span.status-circle:before {
        border: 1px solid #f1c40f;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-busy span.status-circle {
        background: #e74c3c;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-busy.active span.status-circle:before {
        border: 1px solid #e74c3c;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-offline span.status-circle {
        background: #95a5a6;
    }
    #frame #sidepanel #profile .wrap #status-options ul li#status-offline.active span.status-circle:before {
        border: 1px solid #95a5a6;
    }
    #frame #sidepanel #profile .wrap #expanded {
        padding: 100px 0 0 0;
        display: block;
        line-height: initial !important;
    }
    #frame #sidepanel #profile .wrap #expanded label {
        float: left;
        clear: both;
        margin: 0 8px 5px 0;
        padding: 5px 0;
    }
    #frame #sidepanel #profile .wrap #expanded input {
        border: none;
        margin-bottom: 6px;
        background: #32465a;
        border-radius: 3px;
        color: #f5f5f5;
        padding: 7px;
        width: calc(100% - 43px);
    }
    #frame #sidepanel #profile .wrap #expanded input:focus {
        outline: none;
        background: #435f7a;
    }
    #frame #sidepanel #search {
        border-top: 1px solid #32465a;
        border-bottom: 1px solid #32465a;
        font-weight: 300;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #search {
            display: none;
        }
    }
    #frame #sidepanel #search label {
        position: absolute;
        margin: 10px 0 0 20px;
    }
    #frame #sidepanel #search input {
        padding: 10px 0 10px 46px;
        width: calc(100% - 40px);
        /* width: 100%;*/
        border: none;
        background: #32465a;
        color: #f5f5f5;
    }
    #frame #sidepanel #search input:focus {
        outline: none;
        background: #435f7a;
    }
    #frame #sidepanel #search input::-webkit-input-placeholder {
        color: #f5f5f5;
    }
    #frame #sidepanel #search input::-moz-placeholder {
        color: #f5f5f5;
    }
    #frame #sidepanel #search input:-ms-input-placeholder {
        color: #f5f5f5;
    }
    #frame #sidepanel #search input:-moz-placeholder {
        color: #f5f5f5;
    }
    #frame #sidepanel #contacts {
        /*height: calc(100% - 177px);*/
        height: 100%;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts {
            height: calc(100% - 149px);
            overflow-y: scroll;
            overflow-x: hidden;
        }
        #frame #sidepanel #contacts::-webkit-scrollbar {
            display: none;
        }
    }
    #frame #sidepanel #contacts.expanded {
        height: calc(100% - 334px);
    }
    #frame #sidepanel #contacts::-webkit-scrollbar {
        width: 8px;
        background: #2c3e50;
    }
    #frame #sidepanel #contacts::-webkit-scrollbar-thumb {
        background-color: #243140;
    }
    #frame #sidepanel #contacts ul li.contact {
        position: relative;
        padding: 10px 0 15px 0;
        font-size: 0.9em;
        cursor: pointer;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts ul li.contact {
            padding: 6px 0 46px 8px;
        }
    }
    #frame #sidepanel #contacts ul li.contact:hover {
        background: #32465a;
    }
    #frame #sidepanel #contacts ul li.contact.active {
        background: #32465a;
        border-right: 5px solid #435f7a;
    }
    #frame #sidepanel #contacts ul li.contact.active span.contact-status {
        border: 2px solid #32465a !important;
    }
    #frame #sidepanel #contacts ul li.contact .wrap {
        width: 88%;
        margin: 0 auto;
        position: relative;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts ul li.contact .wrap {
            width: 100%;
        }
    }
    #frame #sidepanel #contacts ul li.contact .wrap span {
        position: absolute;
        left: 0;
        margin: -2px 0 0 -2px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid #2c3e50;
        background: #95a5a6;
    }
    #frame #sidepanel #contacts ul li.contact .wrap span.online {
        background: #2ecc71;
    }
    #frame #sidepanel #contacts ul li.contact .wrap span.away {
        background: #f1c40f;
    }
    #frame #sidepanel #contacts ul li.contact .wrap span.busy {
        background: #e74c3c;
    }
    #frame #sidepanel #contacts ul li.contact .wrap img {
        width: 40px;
        border-radius: 50%;
        float: left;
        margin-right: 10px;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts ul li.contact .wrap img {
            margin-right: 0px;
        }
    }
    #frame #sidepanel #contacts ul li.contact .wrap .meta {
        padding: 5px 0 0 0;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #contacts ul li.contact .wrap .meta {
            display: none;
        }
    }
    #frame #sidepanel #contacts ul li.contact .wrap .meta .name {
        font-family:'Roboto-Medium';
    }
    #frame #sidepanel #contacts ul li.contact .wrap .meta .preview {
        margin: 5px 0 0 0;
        padding: 0 0 1px;
        font-weight: 400;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        -moz-transition: 1s all ease;
        -o-transition: 1s all ease;
        -webkit-transition: 1s all ease;
        transition: 1s all ease;
    }
    #frame #sidepanel #contacts ul li.contact .wrap .meta .preview span {
        position: initial;
        border-radius: initial;
        background: none;
        border: none;
        padding: 0 2px 0 0;
        margin: 0 0 0 1px;
        opacity: .5;
    }
    #frame #sidepanel #bottom-bar {
        position: absolute;
        /* width: 100%;*/
        top: 0; right:0;
    }
    #frame #sidepanel #bottom-bar button {
        border: none;
        width: 100%;
        padding: 8px 15px;
        text-align: center;
        height: 40px;
        width: 40px;
        background: #77a008;
        font-size: 18px;
        color: #fff;
        cursor: pointer;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #bottom-bar button {
            float: none;
            width: 100%;
            padding: 15px 0;
        }
    }
    #frame #sidepanel #bottom-bar button:focus {
        outline: none;
    }
    /* #frame #sidepanel #bottom-bar button:nth-child(1) {
         border-right: 1px solid #2c3e50;
     }*/
    @media screen and (max-width: 735px) {
        #frame #sidepanel #bottom-bar button:nth-child(1) {
            border-right: none;
            border-bottom: 1px solid #2c3e50;
        }
    }
    #frame #sidepanel #bottom-bar button:hover {
        background: #435f7a;
    }
    #frame #sidepanel #bottom-bar button i {
        margin-right: 3px;
        font-size: 1em;
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #bottom-bar button i {
            font-size: 1.3em;
        }
    }
    @media screen and (max-width: 735px) {
        #frame #sidepanel #bottom-bar button span {
            display: none;
        }
    }
    #frame .content {
        float: right;
        width: 60%;
        height: 100%;
        overflow: hidden;
        position: relative;
    }
    @media screen and (max-width: 735px) {
        #frame .content {
            width: calc(100% - 58px);
            min-width: 300px !important;
        }
    }
    @media screen and (min-width: 900px) {
        #frame .content {
            width: calc(100% - 340px);
            padding: 0;
        }
    }
    #frame .content .contact-profile {
        width: 100%;
        height: 60px;
        line-height: 60px;
        background: #fff;
        box-shadow: 0 0 2rem 0 rgba(136,152,170,.15);
    }
    #frame .content .contact-profile img {
        width: 40px;
        border-radius: 50%;
        float: left;
        margin: 9px 12px 0 9px;
    }
    #frame .content .contact-profile p {
        float: left;
    }
    #frame .content .contact-profile .social-media {
        float: right;
    }
    #frame .content .contact-profile .social-media i {
        margin-left: 14px;
        cursor: pointer;
    }
    #frame .content .contact-profile .social-media i:nth-last-child(1) {
        margin-right: 20px;
    }
    #frame .content .contact-profile .social-media i:hover {
        color: #435f7a;
    }
    #frame .content .messages {
        height: auto;
        min-height: calc(100% - 93px);
        max-height: calc(100% - 93px);
        overflow-y: scroll;
        overflow-x: hidden;
        width: 100%;
        padding-bottom: 20px;
    }
    #frame .content .messages ul{padding: 0; margin: 0; list-style: none;}
    @media screen and (max-width: 735px) {
        #frame .content .messages {
            max-height: calc(100% - 105px);
        }
    }
    #frame .content .messages::-webkit-scrollbar {
        width: 8px;
        background: transparent;
    }
    #frame .content .messages::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.3);
    }
    #frame .content .messages ul li {
        display: inline-block;
        clear: both;
        float: left;
        margin: 15px 15px 15px 15px;
        width: calc(100% - 25px);
        font-size: 0.9em;
        position: relative;
    }
    #frame .content .messages ul li:nth-last-child(1) {
        margin-bottom: 20px;
    }
    #frame .content .messages ul li.sent img {
        margin: 6px 8px 0 0;
    }
    #frame .content .messages ul li.sent p {
        background: #435f7a;
        color: #f5f5f5;
    }
    #frame .content .messages ul li.replies img {
        float: right;
        margin: 6px 0 0 8px;
    }
    #frame .content .messages ul li.replies p {
        background: #f5f5f5;
        float: right;
    }
    #frame .content .messages ul li img {
        width: 22px;
        border-radius: 50%;
        float: left;
    }
    #frame .content .messages ul li p {
        display: inline-block;
        padding: 10px 15px;
        border-radius: 20px;
        max-width: 205px;
        line-height: 130%;
    }
    @media screen and (min-width: 735px) {
        #frame .content .messages ul li p {
            max-width: 60%; margin-bottom: 5px;
        }
    }
    #frame .content .message-input {
        position: absolute;
        bottom: 0;
        width: 100%;
        z-index: 99;
    }
    #frame .content .message-input .wrap {
        position: relative;
        box-shadow: 0 0 2rem 0 rgba(136,152,170,.15);
    }
    #frame .content .message-input .wrap input {
        /* float: left;*/
        border: none;
        width: calc(100% - 54px);
        padding: 11px 32px 10px 8px;
        color: #32465a;
    }
    @media screen and (max-width: 735px) {
        #frame .content .message-input .wrap input {
            padding: 15px 32px 16px 8px;
        }
    }
    #frame .content .message-input .wrap input:focus {
        outline: none;
    }
    #frame .content .message-input .wrap .attachment {
        position: absolute;
        right: 60px;
        z-index: 4;
        margin-top: 10px;
        font-size: 1.1em;
        color: #435f7a;
        opacity: .5;
        cursor: pointer;
    }
    @media screen and (max-width: 735px) {
        #frame .content .message-input .wrap .attachment {
            margin-top: 17px;
            right: 65px;
        }
    }
    #frame .content .message-input .wrap .attachment:hover {
        opacity: 1;
    }
    #frame .content .message-input .wrap button {
        /*float: right;*/
        border: none;
        width: 50px;
        padding: 12px 0;
        cursor: pointer;
        background: #32465a;
        color: #f5f5f5;
    }
    @media screen and (max-width: 735px) {
        #frame .content .message-input .wrap button {
            padding: 16px 0;
        }
    }
    #frame .content .message-input .wrap button:hover {
        background: #435f7a;
    }
    #frame .content .message-input .wrap button:focus {
        outline: none;
    }
    #contact-list{height: 340px; overflow: auto;}
    #contact-list li{margin-top: 5px;}
    #contact-list li img{width: 40px; height: 40px; border-radius: 100%; }
    #contact-list .list-group-item:first-child {
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;}
    #contact-list .list-group-item{padding: 5px 0px;}

    .chatbadge{
        position: absolute;
        right: 10px;
        top: 10px;
        width: 15px;
        height: 15px;
        text-align: center;
        background: #779f08;
        border-radius: 100%;
        font-size: 10px;}
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-map-o"></i> Chat --r
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">


            <div class="col-md-12">
                <!-- general form elements -->
                <p id="time"></p>
                <div id="frame">
                    <div id="sidepanel">
                        <input type="hidden" name="chat_connection_id" value="0">
                        <input type="hidden" name="chat_to_user" value="0">
                        <input type="hidden" name="last_chat_id" value="0">

                        <div id="search">
                            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                            <input type="text" placeholder="Search contacts..." />
                            <div id="bottom-bar">
                              <button id="addcontact" data-toggle="modal" data-target="#myModal"><i class="fa fa-ellipsis-v"></i> <!-- <span>Add contact</span> --></button>
                              <!-- <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button> -->
                            </div>
                        </div>
                        <div id="contacts">
                            <ul>


                            </ul>
                        </div>

                    </div>
                    <div class="content">
                        <div class="contact-profile">
                            <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                            <p>Harvey Specter</p>

                        </div>
                        <div class="messages">
                            <ul>

                            </ul>
                        </div>
                        <div class="message-input relative">
                            <div class="wrap">
                                <input type="text" placeholder="Write your message..." class="chat_input" />
                                <!-- <i class="fa fa-paperclip attachment" aria-hidden="true"></i> -->
                                <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-header -->
        </div><!-- /.box-header -->

    </section>




    <script>

        var timestamp = '<?php echo time(); ?>';
        function updateTime() {
            $('#time').html(Date(timestamp));
            timestamp++;
        }
        $(function () {
            setInterval(updateTime, 1000);
        });



        function newMessage() {
            message = $(".message-input input").val();
            if ($.trim(message) == '') {
                return false;
            }
            $('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));

            $('.message-input input').val(null);
            $('.contact.active .preview').html('<span>You: </span>' + message);
            $(".messages").animate({scrollTop: $(document).height()}, "fast");
        }
        ;

        // $('.submit').click(function () {
        //     newMessage();
        // });

        // $(window).on('keydown', function (e) {
        //     if (e.which == 13) {
        //         newMessage();
        //         return false;
        //     }
        // });
        //# sourceURL=pen.js
    </script>

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


<script type="text/javascript">
    var interval;
    var intervalchat;
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


</script>

<script type="text/javascript">
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: base_url + 'admin/chat/myuser',
            data: {},
            dataType: "JSON",
            beforeSend: function () {

            },
            success: function (data) {
                $("#contacts ul").html(data.page);

                clearInterval(intervalchat);
                intervalchat = setInterval(getChatNotification, 15000);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            },
            complete: function (data) {

            }
        })
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

            },
            complete: function (data) {

            }
        })

    });

</script>

<script type="text/javascript">

    $(document).on('keydown', '.chat_input', function (e) {

        var key = e.which;
        if (key == 13)  // the enter key code
        {
            newChatMessage();

            return false;
        }
    });


    function newChatMessage() {
        message = $(".message-input input").val();
        if ($.trim(message) == '') {
            return false;
        }
        var date_time_temp = $('#date_time').html();
        var chat_connection_id = $("input[name='chat_connection_id']").val();
        var chat_to_user = $("input[name='chat_to_user']").val();
        $.ajax({
            type: "POST",
            url: base_url + 'admin/chat/newMessage',
            data: {'chat_connection_id': chat_connection_id, 'message': message, 'chat_to_user': chat_to_user, 'time': date_time_temp},
            dataType: "JSON",
            beforeSend: function () {

            },
            success: function (data) {
                var last_chat_id = $("input[name='last_chat_id']").val(data.last_insert_id);
                $('<li class="sent"><p>' + message + '</p> <span class="time_date"> ' + date_time_temp + '</span></li>').appendTo($('.messages ul'));
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
</script>
<script type="text/javascript">
    $(document).on('click', '.usersearchlist ul li', function () {
        $this = $(this);
        $this.addClass('active').siblings().removeClass('active');

    });

    $("#addUser").submit(function (event) {
        event.preventDefault();

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

                    $("#contacts ul").prepend(newUserLi(data.new_user, data.chat_connection_id));
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
        if (user_array.user_type == "student") {
            new_user_type = "Student";
        } else if (user_array.user_type == "staff") {
            new_user_type = "Staff";

        }
        var newli = "<li class='contact' data-chat-connection-id='" + chat_connection_id + "'>"
        newli += "<div class='wrap'>";
        newli += "<span class='contact-status busy'></span>";
        newli += "<img src='http://emilcarlsson.se/assets/harveyspecter.png' alt='>";
        newli += "<div class='meta'>";
        newli += "<p class='name'>" + user_array.name + "(" + new_user_type + ")" + "</p>";
        newli += "<p class='preview'></p>";
        newli += "</div>";
        newli += "</div>";
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

</script>
<!-- <script type="text/javascript">
    $('.messages').scroll(function() {
     var scrollTop = $(this).scrollTop();
  if (scrollTop + $(this).innerHeight() >= $(this)[0].scrollHeight) {
  console.log('end reached');
  } else if (scrollTop <= 0) {
  console.log('Top reached');
  } else {
  console.log('');
  }
});
</script> -->
<script id="date_time" type="text/template">
    <?php echo date('d M Y, H:i:s'); ?>
</script>


