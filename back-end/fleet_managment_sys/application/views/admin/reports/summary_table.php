<table class="table table-striped" >
    <tr>
        <th>Ref ID</th>
        <th>Address</th>
        <th>Destination</th>
        <th>Cab ID</th>
        <th>Driver ID</th>
        <th>Vehicle Type</th>
        <th>CRO Id</th>
        <th>Booking Charge</th>


    </tr>


    <?php $i=0;
    foreach ($data as $item):?>

        <tr>
            <td><p id="<?= $item['refId'];?>"><?= $item['refId'];?></p></td>
            <td><?= $item['address']["no"].",".$item['address']["road"].",".$item['address']["city"].",".$item['address']["town"].",".$item['address']["landmark"];?></td>
            <td><?= $item['address']["no"].",".$item['address']["road"].",".$item['address']["city"].",".$item['address']["town"].",".$item['address']["landmark"];?></td>
            <td><?= $item['cabId'];?></td>
            <td><?= $item['driverId'];?></td>
            <td><?= $item['vType'];?></td>
            <td><?= $item['croId'];?></td>
            <td><input disabled type="text" id="bookingCharge<?= $item['refId'];?>" value="<?php if(isset($item['bookingCharge'])){echo $item['bookingCharge'];}else{echo "live Order";}?>"/></td>
            <td><font id="amount_percentage_of_<?php echo $item['refId']?>" color="<?php if($item['payType'] === 'cash'){echo '3300CC';}else{echo 'D80000 ';}?>"></font></td>

        </tr>

    <?php $i++;
    endforeach;?>
    <tr>
        <td><h1>Hire Count</h1></td>
        <td><h1><?= $i ?></h1></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>