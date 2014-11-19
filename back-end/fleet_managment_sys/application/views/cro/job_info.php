<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title">Job Information</h5>
    </div>
    <div class="panel-body" >
        <div class="col-lg-12">
    <div class="col-lg-2">
        <div class="input-group">
            <span class="input-group-addon">JobCount</span>
            <input type="text" class="form-control" value="<?= $tot_job;?>">
        </div>

        <div class="input-group">
            <span class="input-group-addon">Cancel[Total]</span>
            <input type="text" class="form-control" value="<?= $tot_cancel;?>">
        </div>

        <div class="input-group">
            <span class="input-group-addon">Cancel[Dispatch]</span>
            <input type="text" class="form-control" value="<?= $dis_cancel;?>">
        </div>

    </div>

    <?php if(!(isset($live_booking)) && isset($history_booking) && sizeof($history_booking) != 0 ):?>

        <div class="col-lg-10" style="border-left: 2px solid #a6a6a6" >
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Booking Status</h3>
                </div>
                <div class="panel-body" id="bookingStatus">
                    <?php $index=sizeof($history_booking)-1;?>
                    <div class="col-lg-3">

                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge" id="jobStatus"><?= $history_booking[$index]['status']; ?></span>
                                Status
                            </li>
                            <li class="list-group-item">
                                <span class="badge" id="jobRefId"><?= $history_booking[$index]['refId']; ?></span>
                                Reference ID
                            </li>
                            <li class="list-group-item">
                                <span class="badge" id="jobDriverId"><?php if($history_booking[$index]['driverId'] == '-' )echo 'NOT_ASSIGNED';else echo $history_booking[$index]['driverId'];?></span>
                                Driver ID
                            </li>
                            <li class="list-group-item">
                                <span class="badge" id="jobCabId"><?php if($history_booking[$index]['cabId'] == '-' )echo 'NOT_ASSIGNED';else $history_booking[$index]['cabId']; ?></span>
                                Cab ID
                            </li>
                            <li class="list-group-item">
                                <span class="badge" id="jobVehicleType"><?= $history_booking[sizeof($history_booking)-1]['vType']; ?></span>
                                Vehicle Type
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-9">
                        <div class="col-lg-4">
                            <?php $status =$history_booking[$index]['status']; ?>
                            <h5>Address </h5>
                        <span id="jobAddress">
                            <?= $history_booking[$index]['address']['no'] ." ".
                            $history_booking[$index]['address']['road'] ." ".
                            $history_booking[$index]['address']['city'] ." ".
                            $history_booking[$index]['address']['town'];?>
                        </span>
                            <h5>Remark </h5>
                            <span id="jobRemark"><?= $history_booking[$index]['remark']?></span>
                            <h5>Specifications</h5>
                            <span id="jobSpecifications"> <?php if($history_booking[$index]['isVip'])echo 'VIP | ';?>
                                <?php if($history_booking[$index]['isVih'])echo  'VIH | ';?>
                                <?php if($history_booking[$index]['isUnmarked']) echo 'UNMARK |'?>
                                <?php if($history_booking[$index]['isTinted']) echo 'Tinted'?>
                            </span>
                        </div>

                        <div class="col-lg-3">

                            <h5>Book Time </h5>
                            <span id="jobBookTime"><?php echo date('H:i Y-m-d ', $history_booking[$index]['bookTime']->sec);?></span>
                            </br>
                            <h5>Call Time</h5>
                            <span id="jobCallTime"><?php echo date('H:i Y-m-d ', $history_booking[$index]['callTime']->sec);?></span>
                            </br>
                            <h5>Dispatch Before </h5>
                            <span id="jobDispatchB4"><?= $history_booking[$index]['dispatchB4'];?> min
                            <h5>Pay Type</h5>
                            <span id="jobPayType"><?= $live_booking[$index]['payType'];?>
                        </div>

                        <div class="col-lg-3">

                            <h5>Driver Mobile</h5>
                            <span id="jobDriverTp"><?= $history_booking[$index]['driverTp'];?></span>
                            <h5>Cab Color</h5>
                            <span id="jobCabColor"><?= $history_booking[$index]['cabColor'];?></span>
                            <h5>Plate No</h5>
                            <span id="jobCabPlateNo"><?= $history_booking[$index]['cabPlateNo'];?></span>
                            <h5>Paging Board</h5>
                            <span id="jobPagingBoard"><?php echo $history_booking[$index]['pagingBoard'];?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if(isset($live_booking) ):?>
        <div class="col-lg-10" style="border-left: 2px solid #a6a6a6" >
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Booking Status</h3>
                </div>
                <div class="panel-body" id="bookingStatus">
                    <?php $index=sizeof($live_booking)-1;?>
                    <div class="col-lg-3">

                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge" id="jobStatus"><?= $live_booking[$index]['status']; ?></span>
                                Status
                            </li>
                            <li class="list-group-item">
                                <span class="badge" id="jobRefId"><?= $live_booking[$index]['refId']; ?></span>
                                Reference ID
                            </li>
                            <li class="list-group-item">
                                <span class="badge" id="jobDriverId"><?php if($live_booking[$index]['driverId'] == '-' )echo 'NOT_ASSIGNED';else echo $live_booking[$index]['driverId'];?></span>
                                Driver ID
                            </li>
                            <li class="list-group-item">
                                <span class="badge" id="jobCabId"><?php if($live_booking[$index]['cabId'] == '-' )echo 'NOT_ASSIGNED';else $live_booking[$index]['cabId']; ?></span>
                                Cab ID
                            </li>
                            <li class="list-group-item">
                                <span class="badge" id="jobVehicleType"><?= $live_booking[sizeof($live_booking)-1]['vType']; ?></span>
                                Vehicle Type
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-9">
                        <div class="col-lg-4">
                            <?php $status =$live_booking[$index]['status']; ?>

                            <h5>Address </h5>
                        <span id="jobAddress">
                            <?= $live_booking[$index]['address']['no'] ." ".
                            $live_booking[$index]['address']['road'] ." ".
                            $live_booking[$index]['address']['city'] ." ".
                            $live_booking[$index]['address']['town'];?>
                        </span>
                            <h5>Destination</h5>
                            <span id="jobRemark"><?= $live_booking[$index]['destination']?></span>
                            <h5>Remark </h5>
                            <span id="jobRemark"><?= $live_booking[$index]['remark']?></span>
                            <h5>Specifications</h5>
                            <span id="jobSpecifications"> <?php if($live_booking[$index]['isVip'])echo 'VIP | ';?>
                                <?php if($live_booking[$index]['isVih'])echo  'VIH | ';?>
                                <?php if($live_booking[$index]['isUnmarked']) echo 'UNMARK |'?>
                                <?php if($live_booking[$index]['isTinted']) echo 'Tinted'?>
                            </span>
                        </div>

                        <div class="col-lg-3">

                            <h5>Book Time </h5>
                            <span id="jobBookTime"><?php echo date('H:i Y-m-d ', $live_booking[$index]['bookTime']->sec);?></span>
                            </br>
                            <h5>Call Time</h5>
                            <span id="jobCallTime"><?php echo date('H:i Y-m-d ', $live_booking[$index]['callTime']->sec);?></span>
                            </br>
                            <h5>Dispatch Before </h5>
                            <span id="jobDispatchB4"><?= $live_booking[$index]['dispatchB4'];?> min
                            <h5>Pay Type</h5>
                            <span id="jobPayType"><?= $live_booking[$index]['payType'];?>
                        </div>

                        <div class="col-lg-3">

                            <h5>Driver Mobile</h5>
                            <span id="jobDriverTp"><?= $live_booking[$index]['driverTp'];?></span>
                            <h5>Cab Color</h5>
                            <span id="jobCabColor"><?= $live_booking[$index]['cabColor'];?></span>
                            <h5>Plate No</h5>
                            <span id="jobCabPlateNo"><?= $live_booking[$index]['cabPlateNo'];?></span>
                            <h5>Paging Board</h5>
                            <span id="jobPagingBoard"><?php echo $live_booking[$index]['pagingBoard'];?>
                            </span>
                        </div>

                        <div class="col-lg-2">
                            <div id="jobEditButton" class="col-lg-12">
                                <?php if( ($status == "START") || ($status == 'MSG_COPIED') || ($status =='MSG_NOT_COPIED') || ($status =='AT_THE_PLACE')):?>

                                    <div class="btn-group ">
                                        <button type="button" class="btn btn-warning" onclick="operations('editBooking', '<?= $live_booking[$index]['_id'];?>')">Edit Booking</button>
                                    </div>

                                <?php endif;?>
                            </div>
                            <hr>

                            <div id="jobCancelButton" class="col-lg-12">
                                <?php if( ($status == "START") || ($status == 'MSG_COPIED') || ($status =='MSG_NOT_COPIED') || ($status =='AT_THE_PLACE')):?>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger" onclick="operations('cancel', '<?= $live_booking[$index]['_id'];?>')">Cancel</button>
                                    </div>

                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
    </div>
        <div class="col-lg-12" style="max-height: 200px ; overflow: auto">
            <?php if(isset($live_booking) && sizeof($live_booking) != 1):?>
                <table class="table table-striped" style="margin-top: 3%;">
                    <tr>
                        <th>Status</th>
                        <th>Ref ID</th>
                        <th>Call Time</th>
                        <th>Book Time</th>
                        <th>Address</th>
                        <th>Driver Id</th>
                        <th>Cab Id</th>
                        <th>Remark</th>
                    </tr>
                    <?php foreach(array_reverse($live_booking) as $item):?>
                        <tr>
                            <td><a href="#" onclick="changeJobInfoViewByRefId('<?= $item['_id']?>')"><?= $item['status'];?></a></td>
                            <td><?= $item['refId'];?></td>
                            <td><?=  date('H:i:s Y-m-d ', $item['callTime']->sec);?></td>
                            <td><?=  date('H:i:s Y-m-d ', $item['bookTime']->sec);?></td>
                            <td>
                                <a href="#" onclick="operations('fillAddressToBooking', '<?= $item['_id']?>')">
                                <?= $item['address']['no'] ." ". $item['address']['road'] ." ". $item['address']['city'] ." ". $item['address']['town'];?>
                                </a>
                            </td>
                            <td><?= $item['driverId'];?></td>
                            <td><?= $item['cabId'];?></td>
                            <td><?= $item['remark'];?></td>
                        </tr>

                    <?php endforeach?>
                </table>
            <?php endif;?>
        </div>
    </div>
</div>








