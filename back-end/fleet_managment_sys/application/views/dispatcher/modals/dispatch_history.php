<script>

    $(
        function () {
            $('.cabDetailsPopOver').popover({html: true});
            $('.cancelTooltip').tooltip();
        }
    );
</script>

<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-center">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Dispatch History
    </h4>
</div>
<div class="modal-body">

    <div class="panel panel-default" style="border: none;height: 80%;">
        <div class="panel-body">
            <div class="col-lg-12" style=" overflow: auto">
                <?php if (isset($history_booking) && sizeof($history_booking) != 0): ?>
                    <table class="table table-striped">
                        <tr>
                            <th>Status</th>
                            <th>Ref ID</th>
                            <th>Call Time</th>
                            <th>Book Time</th>
                            <th>Dispatched Time</th>
                            <th>Address</th>
                            <th>Driver Id</th>
                            <th>Cab Id</th>
                            <th>Remark</th>
                        </tr>
                        <?php foreach ($history_booking as $item): ?>
                            <tr>
                                <td>
                                    <?php if ($item['status'] == "DIS_CANCEL" or $item['status'] == "CANCEL"): ?>
                                        <span data-toggle="tooltip" data-placement="right"
                                              title="<?= $item['cancelReason'] ?>" style="cursor: help"
                                              class="cancelTooltip text-danger"> <?= $item['status'] ?> </span>
                                    <?php else: ?>
                                        <?= $item['status'] ?>
                                    <?php endif ?>
                                </td>
                                <td><?= $item['refId']; ?></td>
                                <td><?= date('H:i Y-m-d', $item['callTime']->sec); ?></td>
                                <td><?= date('H:i Y-m-d ', $item['bookTime']->sec); ?></td>
                                <td><?php if (isset($item['dispatchTime'])):
                                        echo date('H:i Y-m-d ', $item['dispatchTime']->sec);
                                    endif ?>
                                </td>
                                <td>
                                    <?= implode(", ", $item['address']); ?>

                                </td>
                                <td><?= $item['driverId']; ?></td>
                                <td>
                                    <?php if ($item['cabId'] != '-'): ?>
                                        <a href="#" tabindex="0" class="btn btn-sm btn-default cabDetailsPopOver"
                                           role="button"
                                           data-toggle="popover" data-trigger="focus" title="Cab Details"
                                           data-placement="left"
                                           data-content='
                                           Plate No: <span class="text-success"> <?= $item['cab']['plateNo'] ?> </span> <br/> <hr style="padding: 0px;margin: 0px" />
                                           Model: <span class="text-success"> <?= $item['cab']['model'] ?> </span><br/><hr style="padding: 0px;margin: 0px" />
                                           Info No: <span class="text-success"> <?= $item['cab']['info'] ?> </span><br/><hr style="padding: 0px;margin: 0px" />
                                           Color: <span class="text-success"> <?= $item['cab']['color'] ?> </span><br/>
                                           '>
                                            <?= $item['cabId']; ?>
                                        </a>
                                    <?php endif ?>
                                </td>
                                <td><?= $item['remark']; ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </table>
                <?php endif ?>

                <?php if (!isset($history_booking)): ?>
                    <div class="col-lg-offset-5 col-lg-5">
                        <h4>No previous bookings made</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f0ad4e;" type="button" class="btn btn-default"
                        onclick="closeAll()">Close
                </button>
            </div>
        </div>
    </div>
</div>
