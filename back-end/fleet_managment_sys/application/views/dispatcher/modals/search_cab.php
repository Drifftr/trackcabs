<script>

    var vehicle;
    var vehicles = new Bloodhound({
        datumTokenizer : function(d) {
            return Bloodhound.tokenizers.whitespace(d.value);
        },
        queryTokenizer : Bloodhound.tokenizers.whitespace,
        remote : {
            url : 'dispatcher/search_cabs/%QUERY',
            filter : function(vehicles) {
                vehicle = vehicles;
                return ($.map(vehicles, function(vehicles) {
                    return {
                        value : vehicles.vehicle_registration_number
                    };
                }));

            }
        }
    });

    function init_typeahead() {
        vehicles.initialize();
        $('#cabSearch').typeahead({
            hint : true,
            highlight : true,
            minLength : 1
        }, {
            name : 'vehicles',
            displayKey : 'value',
            source : vehicles.ttAdapter()
        }).on('typeahead:autocompleted', function($e, datum) {
            selected_value = datum["value"];
            for (var v in vehicle) {
                aler(vehicle[v]);
            }
            alert(datum["value"]);
        }).on('typeahead:selected', function($e, datum) {
            selected_value = datum["value"];
            // alert(datum["value"]);

            for (var v in vehicle) {
                // alert(vehicle[v]);
                if (vehicle[v].vehicle_registration_number == selected_value) {
                    // for(var g in currentVehicleList){
                    // alert(currentVehicleList[g].vehicle_id);
                    // }
                    // alert(parseInt(vehicle[v].vehicle_id));
                    map.setView(currentVehicleList[vehicle[v].vehicle_id].marker.getLatLng(),16);

                }
            }

        });
    }

</script>
<div class="modal-header"
     style="cursor: move;background: #f9f9f9;-webkit-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);-moz-box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);box-shadow: inset 0px 0px 14px 1px rgba(0,0,0,0.2);">
    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-center">
        <!-- TODO: Trigger bootstrap tooltip $('#aboutTileUrl').tooltip(); to enable tooltip -->
        Search Cab
    </h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="input-group input-group">
                <span class="input-group-addon" style="padding: 0px;margin: 0px;width: 120px;">
                <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                    <button id="searchByCabId" type="button" class="btn btn-default active">ID</button>
                    <button id="searchByCabModel" type="button" class="btn btn-default">Model</button>
                    <button id="searchByCabDriver" type="button" class="btn btn-default">Driver</button>
                    <!--                    <button id="searchByCabId" type="button" class="btn btn-default">Cab#</button>-->
                </div>
                </span>
            <input autofocus="true" id="cabSearch" type="text" class="form-control" placeholder="Search cabs"/>
                <span class="input-group-addon">
                <i id="resetSearch"
                   onclick="$('#searchCabsContainer').empty();$.each(unDispatchedOrders, function (i, order) {addNewOrder(order);});$('#orderSearch').val('');"
                   style="cursor: pointer;" class="fa fa-repeat"></i>
                </span>
        </div>
    </div>
    <div id="searchCabsContainer" class="row" style="min-height: 100px">
    </div>
    <div class="row">
        <div style="margin-bottom: -15px" class="btn-group btn-group-justified">
            <div class="btn-group">
                <button style="background-color: #f0ad4e;" type="button" class="btn btn-default" onclick="closeAll()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>