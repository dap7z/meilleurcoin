var gmaps = {
    msg: {
        loading: $("#map-msg-loading").html(),  //Please wait while the map is loading ...
        notfound: $("#map-msg-notfound").html(), //Not found address.
    },
    defaultPos: {lat: 47.063906, lng: -0.871050}, //AGENA
    obj: {
        map:{},
        directionsService:{},
        directionsDisplay:{}
    },
    init: function(callback) {
        $(document).ready(function () {
            $("#map-msg").html('<div class="alert alert-info">'+ gmaps.msg.loading +'</div>');
            setTimeout(function () {
                if (typeof $("#map").attr("init") == 'undefined')
                {
                    //initialize gmaps object :
                    var latLng = new google.maps.LatLng(gmaps.defaultPos.lat, gmaps.defaultPos.lng);
                    var myOptions = {
                        zoom: 14,
                        center: latLng,
                        mapTypeId: google.maps.MapTypeId.TERRAIN, //HYBRID, ROADMAP, SATELLITE, TERRAIN
                        maxZoom: 20
                    };
                    gmaps.obj.map = new google.maps.Map(document.getElementById('map'), myOptions);

                    gmaps.obj.directionsService = new google.maps.DirectionsService(); //Itinary calcul service
                    gmaps.obj.directionsDisplay = new google.maps.DirectionsRenderer({map: gmaps.obj.map});	//Only map, no instructions

                    $("#map").attr("init", true);
                }
                else
                {
                    gmaps.obj.directionsDisplay.set('directions', null);    //clear itinary
                }
                callback();
            }, 100);
        });
    },
    getLocation: function(callback){


        var isHttps = false;
        if(location.protocol == 'https:')
        {
            isHttps = true;
            //chrome:
            //getCurrentPosition() and watchPosition() no longer work on insecure origins.
            //To use this feature, you should consider switching your application to a secure origin, such as HTTPS.
        }

        //try HTML5 geolocation :
        if(isHttps && navigator.geolocation)
        {
            navigator.geolocation.getCurrentPosition(function(position){
                //location found
                callback({lat: position.coords.latitude, lng: position.coords.longitude});
            }, function(){
                //user doesnt share his location
                callback(gmaps.defaultPos);
            });
        }
        else
        {
            //browser doesnt support Geolocation
            callback(gmaps.defaultPos);
        }
    },
    itinerary: function(addr1, addr2) {
        setTimeout(function(){
            gmaps.init(function(){
                if (addr1)
                {
                    if (addr2){
                        gmaps.itinerary_process(addr1, addr2);
                    }
                    else {
                        gmaps.getLocation(function(currentPos){
                            gmaps.itinerary_process(currentPos, addr1);
                        });
                    }
                }
            });
        }, 100);  //time required to show modal with css transition
    },
    itinerary_process: function(_origin, _destination)
    {
        gmaps.obj.directionsService.route({
            origin: _origin,
            destination: _destination,
            travelMode: 'DRIVING'
        }, function(response, status) {
            $("#map-apiResponse").val(response.status);
            if (status === 'OK') {
                $("#map-msg").html("");
                $("#map").show();
                gmaps.obj.directionsDisplay.setDirections(response);
            }else{
                $("#map-msg").html('<div class="alert alert-danger">'+ gmaps.msg.notfound +'</div>');
            }
            $(window).resize(); //refresh gmaps
        });
    }
};