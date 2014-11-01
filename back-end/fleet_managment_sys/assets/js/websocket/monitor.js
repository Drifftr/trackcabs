/*
 *  Copyright (c) 2005-2010, WSO2 Inc. (http://www.wso2.org) All Rights Reserved.
 *
 *  WSO2 Inc. licenses this file to you under the Apache License,
 *  Version 2.0 (the "License"); you may not use this file except
 *  in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

var debugObject; // assign object and debug from browser console, this is for debugging purpose , unless this var is unused
var currentCabsList = {};
var selectedSpatialObject; // This is set when user search for an object from the search box
var webSocketURL = "ws://localhost:9763/outputwebsocket/t/carbon.super/DefaultWebsocketOutputAdaptor/alertsGeoJson";
var websocket;

// Make the function wait until the connection is made...
var waitTime = 1000;
function waitForSocketConnection(socket, callback) {
    setTimeout(
        function () {
            if (socket.readyState === 1) {
                initializeWebSocket();
                waitTime = 1000;
                console.log("Connection is made");
                if (callback != null) {
                    callback();
                }
                return;

            } else {
                websocket = new WebSocket(webSocketURL);
                waitTime += 400;
                $.UIkit.notify({
                    message: "wait for connection " + waitTime / 1000 + " Seconds...",
                    status: 'warning',
                    timeout: waitTime,
                    pos: 'top-center'
                });
                waitForSocketConnection(websocket, callback);
            }

        }, waitTime); // wait 5 milisecond for the connection...
}

var webSocketOnOpen = function () {
    $.UIkit.notify({
        message: 'You Are Connectedto Map Server!!',
        status: 'success',
        timeout: 3000,
        pos: 'top-center'
    });
};

var webSocketOnError = function (e) {
    $.UIkit.notify({
        message: 'Something went wrong when trying to connect to <b>' + webSocketURL + '<b/>',
        status: 'danger',
        timeout: 600,
        pos: 'top-center'
    });
//    waitForSocketConnection(websocket);
};

var webSocketOnClose = function (e) {
    $.UIkit.notify({
        message: 'Connection lost with server!!',
        status: 'danger',
        timeout: 600,
        pos: 'top-center'
    });
    waitForSocketConnection(websocket);
};

var webSocketOnMessage = function processMessage(message) {
    var geoJsonFeature = $.parseJSON(message.data);
    console.log(geoJsonFeature);
    notifyAlert(geoJsonFeature);

    if (geoJsonFeature.id in currentCabsList) { // TODO: actual value properties.cabId
        console.log("DEBUG: geoJsonFeature.id in +" + geoJsonFeature.id);
        var excitingCab = currentCabsList[geoJsonFeature.id];
        excitingCab.update(geoJsonFeature);
    }
    else {
        console.log("DEBUG: geoJsonFeature.id not in =" + geoJsonFeature.id);
        var newCab = new Cab(geoJsonFeature);
        newCab.update(geoJsonFeature);
        currentCabsList[newCab.id] = newCab;
        //currentCabsList[newCab.id].addTo(map);// TODO: This should be add to monitor view
    }
};

function initializeWebSocket() {
    websocket = new WebSocket(webSocketURL);
    websocket.onmessage = webSocketOnMessage;
    websocket.onclose = webSocketOnClose;
    websocket.onerror = webSocketOnError;
    websocket.onopen = webSocketOnOpen;
}

initializeWebSocket();

/*----------------------- Cab Object Definition -----------------------*/

function Cab(geoJSON) {
    this.id = geoJSON.id; // TODO: actual ID geoJSON.properties.cabId;
    this.driver = {id: geoJSON.id};
    this.state = geoJSON.properties.state;
    this.speed = geoJSON.properties.speed;
    this.heading = geoJSON.properties.heading;
    this.orderId = geoJSON.properties.orderId;
    this.locationCoordinates = [geoJSON.geometry.coordinates];
    this.geoJson = geoJSON; // TODO: why again ?

    return this;
}

Cab.prototype.locationName = function () {
    alert("Return location name by quiering DB for MBR $near using this.locationCoordinates");
};

Cab.prototype.addView = function () {
    alert("Add to correct panel");
};

Cab.prototype.setSpeed = function (speed) {
    this.speed = speed;
};

Cab.prototype.stateRow = function () {
    // Performance of if-else, switch or map based conditioning http://stackoverflow.com/questions/8624939/performance-of-if-else-switch-or-map-based-conditioning
    var currentTime = new Date();
    switch (this.state) {
        case "IDLE":
            return (
            "<tr id='" + this.id+ "'>" +
            '<td>' +
            this.driver.id +
            '</td>' +
            '<td>' +
            currentTime.toLocaleString() +
            '</td>' +
            '<td>' +
            this.locationCoordinates.toString() +
            '</td>' +
            "</tr>"
            );
        case "MSG_NOT_COPIED":
            return (
            "<tr id='" + this.id + "'>" +
            '<td>' +
            this.geoJson.properties.orderId +
            '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + currentTime.toLocaleString() + '</td>' + '<td>' + 'N/A' + '</td>' +
            '<td>' + this.geoJson.properties.cabId + '</td>' + '<td>' + 'N/A' + '</td>' + /*Address*/'<td>' + 'N/A' + '</td>' + /*agent*/'<td>' + 'N/A' + '</td>' +
                /*Inquire*/'<td>' + 'N/A' + '</td>' + /*DIM*/'<td>' + 'N/A' + '</td>' + /*VIH*/'<td>' + 'N/A' + '</td>' + /*VIP*/'<td>' + 'N/A' +
            '</td>' + '<td>' + 'N/A' + '</td>' + '</tr>'
            );
        case "MSG_COPIED":
            return (
            "<tr id='" + this.id + "'>" +
            '<td>' +
            this.geoJson.properties.orderId +
            '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + currentTime.toLocaleString() + '</td>' + '<td>' + 'N/A' + '</td>' +
            '<td>' + this.geoJson.properties.cabId + '</td>' + '<td>' + 'N/A' + '</td>' + /*Address*/'<td>' + 'N/A' + '</td>' + /*agent*/'<td>' + 'N/A' + '</td>' +
                /*Inquire*/'<td>' + 'N/A' + '</td>' + /*DIM*/'<td>' + 'N/A' + '</td>' + /*VIH*/'<td>' + 'N/A' + '</td>' + /*VIP*/'<td>' + 'N/A' +
            '</td>' + '<td>' + 'N/A' + '</td>' + '</tr>'
            );
        case "AT_THE_PLACE":
            return (
            "<tr id='" + this.id + "'>" +
            '<td>' +
            this.geoJson.properties.orderId +
            '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + currentTime.toLocaleString() + '</td>' + '<td>' + 'N/A' + '</td>' +
            '<td>' + this.geoJson.properties.cabId + '</td>' + '<td>' + 'N/A' + '</td>' + /*Address*/'<td>' + 'N/A' + '</td>' + /*agent*/'<td>' + 'N/A' + '</td>' +
                /*Inquire*/'<td>' + 'N/A' + '</td>' + /*DIM*/'<td>' + 'N/A' + '</td>' + /*VIH*/'<td>' + 'N/A' + '</td>' + /*VIP*/'<td>' + 'N/A' +
            '</td>' + '<td>' + 'N/A' + '</td>' + '</tr>'
            );
        case "POB":
            return (
            "<tr id='" + this.id + "'>" +
            '<td>' +
            this.geoJson.properties.orderId +
            '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + 'N/A' + '</td>' + '<td>' + currentTime.toLocaleString() + '</td>' + '<td>' + this.geoJson.properties.cabId + '</td>' +
            '<td>' + 'N/A' + '</td>'+ '<td>' + 'N/A' + '</td>' + /*Address*/'<td>' + 'N/A' + '</td>' + /*agent*/'<td>' + 'N/A' + '</td>' +
                /*Inquire*/'<td>' + 'N/A' + '</td>' + /*DIM*/'<td>' + 'N/A' + '</td>' + /*VIH*/'<td>' + 'N/A' + '</td>' + /*VIP*/'<td>' + 'N/A' +
            '</td>' + '<td>' + 'N/A' + '</td>' + '</tr>'
            );
        default:
            return defaultIcon;
    }
};

Cab.prototype.update = function (geoJSON) {
    console.log("DEBUG: updating geoJSON = " + geoJSON);
    this.geoJson = geoJSON;
    this.locationCoordinates = geoJSON.geometry.coordinates;
    this.setSpeed(geoJSON.properties.speed);
    this.state = geoJSON.properties.state;
    this.heading = geoJSON.properties.heading;
    console.log("DEBUG: this.id = " + this.id);
    this.orderDOM = $('#' + this.id);
    debugObject = this.orderDOM;
    console.log("DEBUG: this.orderDOM.lenght = " + this.orderDOM.lenght);
    if (this.orderDOM.length) {
        console.log("DEBUG: this.orderDOM.lenght = " + this.orderDOM.lenght);
        this.orderDOM.fadeOut().remove();
        console.log("DEBUG: Removed");
    }
    this.orderDOM = this.stateRow();
    $('#' + this.state + ' > tbody:last').append(this.orderDOM);
};


/*------------------------------ Helper methods ------------------------------*/
function getLocation(latLng){
    var location;

    $.post('dispatcher/dispatchVehicle', {refId: currentDispatchOrderRefId}, function (response) {
        $.UIkit.notify({
            message: '<span style="color: dodgerblue">' + response.status + '</span><br>' + response.message,
            status: (response.status == 'success' ? 'success' : 'danger'),
            timeout: 3000,
            pos: 'top-center'
        });
    });

    return location;
}

function notifyAlert(message) {
    $.UIkit.notify({
        message: "Alert: " + message,
        status: 'warning',
        timeout: 5000,
        pos: 'bottom-left'
    });
}

function Alert(type, message, level) {
    this.type = type;
    this.message = message;
    if (level)
        this.level = level;
    else
        this.level = 'info';

    this.notify = function () {
        $.UIkit.notify({
            message: this.level + ': ' + this.type + ' ' + this.message,
            status: 'info',
            timeout: 5000,
            pos: 'bottom-left'
        });
    }
}

function LocalStorageArray(id) {
    if (typeof (sessionStorage) === 'undefined') {
        // Sorry! No Web Storage support..
        return ['speed']; // TODO: fetch this array from backend DB rather than keeping as in-memory array
    }
    if (id === undefined) {
        throw 'Should provide an id to create a local storage!';
    }
    var DELIMITER = ','; // Private variable delimiter
    this.storageId = id;
    sessionStorage.setItem(id, 'speed'); // TODO: <note> even tho we use `sessionStorage` because of this line previous it get overwritten in each page refresh
    this.getArray = function () {
        return sessionStorage.getItem(this.storageId).split(DELIMITER);
    };

    this.length = this.getArray().length;

    this.push = function (value) {
        var currentStorageValue = sessionStorage.getItem(this.storageId);
        var updatedStorageValue;
        if (currentStorageValue === null) {
            updatedStorageValue = value;
        } else {
            updatedStorageValue = currentStorageValue + DELIMITER + value;
        }
        sessionStorage.setItem(this.storageId, updatedStorageValue);
        this.length += 1;
    };
    this.isEmpty = function () {
        return (this.getArray().length === 0);
    };
    this.splice = function (index, howmany) {
        var currentArray = this.getArray();
        currentArray.splice(index, howmany);
        var updatedStorageValue = currentArray.toString();
        sessionStorage.setItem(this.storageId, updatedStorageValue);
        this.length -= howmany;
        // TODO: should return spliced section as array
    };
}