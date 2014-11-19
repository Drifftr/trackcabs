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
        <th>Action</th>
        <th>Amount Receivable</th>

    </tr>


    <?php foreach ($data as $item):?>

        <tr>
            <td><p id="<?= $item['refId'];?>"><?= $item['refId'];?></p></td>
            <td><?= $item['address']["no"].",".$item['address']["road"].",".$item['address']["city"].",".$item['address']["town"].",".$item['address']["landmark"];?></td>
            <td><?= $item['address']["no"].",".$item['address']["road"].",".$item['address']["city"].",".$item['address']["town"].",".$item['address']["landmark"];?></td>
            <td><?= $item['cabId'];?></td>
            <td><?= $item['driverId'];?></td>
            <td><?= $item['vType'];?></td>
            <td><?= $item['croId'];?></td>
            <td><input type="text" id="bookingCharge<?= $item['refId'];?>" value="<?= $item['bookingCharge'];?>"/></td>
            <td><button type="submit" class="btn btn-default" onclick="updateAccounts('<?= $item['refId'];?>','<?php echo "bookingCharge".$item['refId'];?>')">Save</button></td>
            <td><font id="amount_percentage_of_<?php echo $item['refId']?>" color="<?php if($item['payType'] === 'cash'){echo '3300CC';}else{echo 'D80000 ';}?>"></font></td>
            <td><button type="submit" class="btn btn-default" onclick="">Paid</button></td>
        </tr>

    <?php endforeach;?>
</table>