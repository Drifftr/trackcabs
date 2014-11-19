<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-------------------------------- CSS Files------------------------------------>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/css/bootstrapValidator.css">

    <!-------------------------------- JS Files------------------------------------>
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/cro_operations.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/webLibs/bootstrapvalidator-dist-0.5.2/dist/js/bootstrapValidator.js" charset="UTF-8"></script>


    <script>
        var docs_per_page= 100 ;
        var page = 1 ;
        var obj = null;
        var tp;
        var url = '<?= site_url(); ?>';
        var bookingObj = null;
        var customerObj = null;
    </script>
</head>
<body>
<div id="navBarField">
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Hao Cabs</a>
        </div>

        <ul class="nav navbar-nav">
            <li ><a href="<?= site_url('cro_controller')?>">CRO</a></li>
            <li><a href="<?= site_url('cro_controller/loadMyBookingsView')?>" >My Bookings</a></li>
            <li class="active"><a href="<?= site_url('cro_controller/loadBookingsView')?>" >Bookings</a></li>
            <li><a href="<?= site_url('cro_controller/loadMapView')?>" >Map</a></li>
            <li><a href="<?= site_url('cro_controller/loadLocationBoardView')?>" >Location Board</a></li>
            <li><a href="<?= site_url('cro_controller/loadPOBBoardView')?>" >POB Board</a></li>
            <li><a href="<?= site_url('cro_controller/refresh')?>" >Refresh</a></li>
        </ul>



        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $uName;?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= site_url('login/logout')?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</div>

<div class="container-fluid">

    <div class="row" style="background: #d7ddeb; min-height: 1000px">


        <div class="col-lg-12" style="margin-top: 10px;" id="bookingSearch" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Booking Search</h5>
                </div>

                <div class="panel-body" >

                    <div class="col-lg-4">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label for="inputPassword2" class="sr-only">Password</label>
                                <input type="text" class="form-control" id="inputPassword2" placeholder="REF ID">
                            </div>
                            <button type="submit" class="btn btn-default" onsubmit="bookingsOperations('getBookingById');return false;" onclick="operations()">Search</button>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label for="inputPassword2" class="sr-only">Password</label>
                                <input type="text" class="form-control" id="inputPassword2" placeholder="Customer Name">
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <label for="inputPassword2" class="sr-only">Password</label>
                                <input type="text" class="form-control" id="inputPassword2" placeholder="Address">
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-12" style="margin-top: 10px" id="customerInformation">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">Search Details</h5>
                </div>

                <div class="panel-body" >

                </div>

            </div>

        </div>


    </div>

    <script>

        function bookingsOperations(request){

            if(request == 'getBookingById'){
                var data;
                url = '/customer_retriever/getSimilarTpNumbers';
                ajaxPost(data , url , false);




            }
            if(request == 'getBookingByAddress'){

            }
            if(request == 'getBookingByCustomer'){

            }
        }


        function ajaxPost(data,urlLoc, asynchronicity)    {
            var result=null;
            $.ajax({
                type: 'POST', url: urlLoc,
                contentType: 'application/json; charset=utf-8',
                data: JSON.stringify(data),
                async: asynchronicity ? true : false,
                success: function(data, textStatus, jqXHR) {
                    result = JSON.parse(jqXHR.responseText);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.status == 400) {
                        var message= JSON.parse(jqXHR.responseText);
                        $('#messages').empty();
                        $.each(messages, function(i, v) {
                            var item = $('<li>').append(v);
                            $('#messages').append(item);
                        });
                    } else {
                        alert('Unexpected server error.');
                    }
                }
            });
            return result;
        }

    </script>

</body>
</html>