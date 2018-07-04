//============== GMAPS ================

$(document).ready(function(){
    gmaps.itinerary(addrDestination);
    $("#map-addrDestination").val(addrDestination);
    $("#map-addrDestinationComplete").val(addrDestinationComplete);
});

$("#map-calculBtn").click(function(){
    gmaps.itinerary($("#map-addrDestination").val());
});

console.log('toto');
//====================================
