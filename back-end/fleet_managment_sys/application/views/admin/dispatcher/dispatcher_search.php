<div class="col-lg-7">

            <div >
                <table class="table table-striped" >
                    <tr>
                        <th>Dispatcher ID</th>
                        <th>Name</th>
                        <th>User Name</th>
                        <th>Pass</th>
                        <th>NIC</th>
                        <th>tp</th>
                        <th>User Type</th>
                        <th>Blocked</th>
                        <th>Action</th>
                    </tr>


                     <tr>
                            <td><?= $userId;?></td>
                            <td><?= $name?></td>
                            <td><?= $uName;?></td>
                            <td><?= $pass;?></td>
                            <td><?= $nic;?></td>
                            <td><?= $tp;?></td>
                            <td><?= $user_type;?></td>
                            <td><?= $blocked; ?></td>
                            <td><div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success" onclick="makeCROFormEditable(<?= $userId;?>,url, '<?php echo $user_type;?>')">Edit</button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                </table>


    </div>
</div>