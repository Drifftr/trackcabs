<?php
//var_dump($orders);
?>
<!-- Custom JQuery scroll bars http://manos.malihu.gr/jquery-custom-content-scroller/ -->
<link rel="stylesheet" href="<?= base_url() ?>assets/css/custom_scroll/jquery.mCustomScrollbar.min.css">

<script src="<?= base_url() ?>assets/js/custom_scroll/jquery.mCustomScrollbar.min.js"></script>
<script src="<?= base_url() ?>assets/js/moment/moment.js"></script>

<style>

    .mCSB_inside > .mCSB_container {
        margin-right: 15px;
    }
</style>
<script>
    (function ($) {
        $(window).load(function () {
            $(".mscroll").mCustomScrollbar({
                theme: "inset-dark"
            });
            moment().format();
            checkTimeLimit();
            subscribe('dispatcher1');
            setInterval(checkTimeLimit, 1000);
        });
    })(jQuery);

    function checkTimeLimit() {
        var liveOrdersList = $('#liveOrdersList').find('a');
        var i = 0;
        for (; i < liveOrdersList.length; i++) {
            var latestBooking = $(liveOrdersList[i]);
//        var latestBooking = $('#liveOrdersList').find('a:first');
            var latestBookingDate = latestBooking.data('booktime');
            var timeDifferent = moment.unix(latestBookingDate).diff(moment(), 'minutes', true);
            if (timeDifferent <= 30) {
//                console.log("DEBUG: checking time interval timeDifferent = " + timeDifferent);
                latestBooking.addClass("list-group-item-danger");
            }
            else {
//                console.log("DEBUG: fromNow = " + moment.unix(latestBookingDate).fromNow() + " checking time interval timeDifferent = " + timeDifferent);
            }
            latestBooking.find('.fromNow').html('(' + moment.unix(latestBookingDate).fromNow() + ')');
        }
    }

    //TODO: move this scripts to separate file like dispatcher.js in assets file currentDispatchOrderRefId
    function dispatchOrder(orderId) {
        $("#commonModal").modal('toggle').find(".modal-content").load('dispatcher/newOrder/' + orderId);
        currentDispatchOrderRefId = orderId;
    }

    function disengageOrder(orderId) {
        $("#commonModal").modal('toggle').find(".modal-content").load('dispatcher/disengageOrder/' + orderId);
        currentDispatchOrderRefId = orderId;
    }

    function subscribe(userid) {
        var conn = new ab.Session(
            'ws://' + ApplicationOptions.constance.WEBSOCKET_URL + ':' + ApplicationOptions.constance.WEBSOCKET_PORT,
            function () {
                conn.subscribe(userid, function (topic, data) {
                    // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                    console.log('New Message published to user "' + topic + '" : ' + data.message);
                    var newOrder = data.message;
                    if (newOrder.status === "CANCEL") {
                        removeOrder(newOrder);
                    } else {
                        addNewOrder(newOrder);
                    }
                });
            },
            function () {
                console.warn('WebSocket connection closed');
            },
            {'skipSubprotocolCheck': true}
        );
    }

    function addNewOrder(newOrder) {
        var newOrderUnixTimeStamp = newOrder.bookTime.sec;
        var orderBookingTime = moment.unix(newOrderUnixTimeStamp);

        var $fromNowSpan = $("<span>", {class: "text-warning fromNow"});
        var $labelSpan = $("<span>", {class: "label label-info"}).css({float: 'right'}).text(newOrder.refId);

        var $order = $("<a>", {
            id: newOrder.refId,
            class: "list-group-item",
            onclick: "dispatchOrder(this.id);return false"
        })
            .attr('data-bookTime', newOrderUnixTimeStamp).text(orderBookingTime.format('Do-MMM-YY  hh:mm a')).append($fromNowSpan).append($labelSpan);

        /* Find element ref id which new element need to be insert after*/
        var liveOrdersList = $('#liveOrdersList').find('a');

        $.UIkit.notify({
            message: '<span style="color: dodgerblue">New Order <b>#' + newOrder.refId + ' added.</b></span><br>',
            status: 'success',
            timeout: 3000,
            pos: 'top-center'
        });

        if (liveOrdersList.length == 0) {
            $($order).appendTo('#liveOrdersList .mCSB_container');
            return;
        }
        var targetElement;
        var i = 0;
        /*
         for optimization http://www.brpreiss.com/books/opus4/html/page190.html#progsorted1c
         http://jsfiddle.net/2mBdL/1/

         * */
        for (; i < liveOrdersList.length; i++) {
            var thisOrderUnixTimeStam = $(liveOrdersList[i]).data('booktime');
            if (newOrderUnixTimeStamp < thisOrderUnixTimeStam) {
                targetElement = liveOrdersList[i].id;
                $($order).insertBefore('#liveOrdersList #' + targetElement);
                return;
            }
        }
        $($order).insertAfter('#liveOrdersList a:last');
    }

    function removeOrder(newOrder) {
        console.log("DEBUG: remove order : " + newOrder);
        var orderRefId = newOrder.refId;
        var orderDOM = $('#liveOrdersList').find('#' + orderRefId);
        $.UIkit.notify({
            message: '<span style="color: dodgerblue">Order <b>' + orderRefId + '</b> has been canceled!</span><br>',
            status: 'danger',
            timeout: 3000,
            pos: 'top-center'
        });
        $(orderDOM).fadeOut();
    }

</script>

<div id="newOrdersPane" class="panel panel-default boxElement " style="height: 50%;margin-bottom: 0px">
    <div class="list-group">
        <a href="#" class="list-group-item active text-center">
            New Orders
        </a>

        <div id="liveOrdersList" class="mscroll" style="overflow-y: auto;height: 90%;">
            <?php foreach ($orders as $order) { ?>
                <a id="<?= $order['refId'] ?>" onclick="dispatchOrder(this.id);return false"
                   class="list-group-item" data-bookTime="<?= $order['bookTime']->sec ?>">
                    <?= date('jS-M-y  h:i a', $order['bookTime']->sec) ?>
                    <span class="text-warning fromNow"></span>
                    <span class="label label-info" style="float: right"><?= $order['refId'] ?></span>
                </a>
            <?php } ?>
        </div>
    </div>
</div>

<div id="dispatchedOrders" class="panel panel-default boxElement" style="height: 40%;">
    <div class="list-group">
        <a href="#" class="list-group-item active text-center">
            Dispatched Orders
        </a>

        <div id="dispatchedOrdersList" class="mscroll" style="overflow-y: auto;height: 90%;">
            <?php foreach ($dispatchedOrders as $order) { ?>
                <a id="<?= $order['refId'] ?>" onclick="disengageOrder(this.id);return false"
                   class="list-group-item" data-bookTime="<?= $order['bookTime']->sec ?>">
                    <?= date('jS-M-y  h:i a', $order['bookTime']->sec) ?>
                    <span class="text-warning fromNow"></span>
                    <span class="label label-info" style="float: right"><?= $order['refId'] ?></span>
                </a>
            <?php } ?>
        </div>
    </div>
</div>