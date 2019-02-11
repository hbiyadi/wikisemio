<?php include('lecture.php') ;?> 

<script type="text/javascript">
  
var styleFeatures = new ol.style.Style({
  fill: new ol.style.Fill({
    color: 'rgbA(192, 192, 192, 0.2)',
  }),
  stroke: new ol.style.Stroke({
    color: 'rgba(255, 255, 255, 1)',
    width: 1
  })
})

var styleFeaturesHover = new ol.style.Style({
  fill: new ol.style.Fill({
    color: 'rgbA(148, 199, 47, 0.4)',
  }),
  stroke: new ol.style.Stroke({
    color: 'rgba(255, 255, 255, 0.5)',
    width: 2
  })
})

var styleFeaturesSelected = new ol.style.Style({
  fill: new ol.style.Fill({
    color: 'rgbA(192, 192, 192, 0)',
  }),
  stroke: new ol.style.Stroke({
    color: 'rgbA(148, 199, 47, 1)',
    width: 2
  })
})



//initialisation

var modele01_01 =  new ol.layer.Tile({
    source: new ol.source.TileWMS({
        url: 'http://territoires1.engref.fr:8080/geoserver/ows?service=wms&version=1.3.0&request=GetCapabilities',
        params: {'LAYERS': 'TELETIQ:modele01_01', 'TILED': true},
        serverType: 'geoserver',
        transition: 0
    }),
    opacity: 0.7
})


var bingMapsAerial = new ol.layer.Tile({
  source: new ol.source.BingMaps({
    key: 'AgszpA_SgN7fc7AoY6ULVmZ88kcA1BTsI_OaocFssZ4aYh2ZF9Gw2bmAKwMGLJ0y',
    imagerySet: 'Aerial',
  })
});


var mblite = new ol.layer.Tile({
  source: new ol.source.XYZ({
    url: 'https://api.mapbox.com/styles/v1/mapbox/light-v9/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZ2Fibm9pcmUiLCJhIjoiY2poaXdsNmNvMDJldzNjcWtzY2xkbWM2eCJ9.EELXK-Qdma388k_rciSfCQ'
  })
})


//Couches de la cartes
var layers = [mblite, modele01_01];

//Paramètre de la carte 
var  centreCarte = ol.proj.fromLonLat([4.61058, 45.465969]);

var view = new ol.View({
  center:  centreCarte,
      zoom: 7,
      minZoom: 7,
      maxZoom: 12,
      extent: ol.proj.transformExtent([2.00,44.55, 7.15,46.74], 'EPSG:4326', 'EPSG:3857'),
});

//1 La carte
var map = new ol.Map({
  layers: layers, 
  loadTilesWhileAnimating: true, 
  target: 'map',
  view: view
});


//Lecture des fichier geojson

var myArray = <?php echo json_encode($ma_liste); ?>;


var doc = [];

for (var i = 0; i < myArray.length; i++) 
{
    var fichier = 'couches/' + myArray[i].replace(/\n|\r/g,'') + '.geojson';
    doc.push(new ol.layer.Vector({
        source: new ol.source.Vector({
          url: fichier,
          format: new ol.format.GeoJSON()
        }),
        style: styleFeatures
    }))    
}




//ZONES

function myFunction()
{
  var bool = false;
  var i = 0;
  while((bool == false) && ( i < myArray.length))
  {
    var checkbox = document.getElementById(myArray[i].replace(/\n|\r/g,''));
    if(checkbox.checked == true)
    {
      for(var j = 0; j < myArray.length; j++)
      {
        if(j != i)
        {
            map.removeLayer(doc[j]);
        }
      }
      map.addLayer(doc[i]);
      changeInteraction();
      bool = true;
    }
    else
    {
        map.removeLayer(doc[i]);
        i++;
    }
  }
}


var selectFeatures = []
var mes_cle = <?php echo json_encode($ma_cle); ?>;

function constructionZonQuery()
{
    $('#supZones').css("visibility", "visible");

    zoneSeleted = []
    tabzoneSeleted = []

    document.getElementById('zones').innerHTML = '';
    zones_query = ''
    for (var i = selectFeatures.length - 1; i >= 0; i--) 
    {
      //Type De Géometry
      // console.log(selectFeatures)
      var bool = 0;
      for (var j = 0; (j < mes_cle.length) && (bool == 0); j++) 
      {
          if (selectFeatures[i].get(mes_cle[j].replace(/\n|\r/g,'')))
          {
            var CODE = mes_cle[j].replace(/\n|\r/g,'');
            bool = 1;
          }
      }
      if(bool == 0)
      {
          console.log("autres");
      }
       // var ol3Geom = selectFeatures[i].getGeometry();
      // var format = new ol.format.WKT();
      // var wktRepresenation  = format.writeGeometry(ol3Geom);
      // console.log(wktRepresenation)
      
      zoneSeleted.push(selectFeatures[i].get(CODE))
    } 

    zoneSeleted.sort();
    //Creation de la chaine decaratère query pour la table ZONES
    for (var i = 0; i < zoneSeleted.length; i++) 
    {
        zones_query += CODE + zoneSeleted[i] +'_';
    }

    zones_query = zones_query.substr(0,zones_query.length - 1);
    zones_query = zones_query.toLowerCase();

    //Création du tableau pour la table ZONES
    for (var i = 0; i < zoneSeleted.length; i++) 
    {
        zoneSeleted[i]
        tabzoneSeleted.push((CODE + zoneSeleted[i]).toLowerCase());
    }

    $("#zones").empty();
    $("#zones").append(zones_query);

    return zones_query;
}


function removeDeselected(arr) 
{
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
      what = a[--L];
      while ((ax= arr.indexOf(what)) !== -1) {
      arr.splice(ax, 1);
      }
    }
    return arr;
}


var changeInteraction = function() 
{
      $('#boutonwiki p').text('Voir la page WIKI');
      var select =  new ol.interaction.Select({
        style : styleFeaturesSelected
      });
      var selectPointerMove = new ol.interaction.Select({
        condition: ol.events.condition.pointerMove,
        style : styleFeaturesHover
      });

      map.addInteraction(select);
      map.addInteraction(selectPointerMove);

      select.on('select', function(select){

        for (var i = select.selected.length - 1; i >= 0; i--) 
        {
            selectFeatures.push(select.selected[i])
        }
        
        for (var i = select.deselected.length - 1; i >= 0; i--) 
        {
            removeDeselected(selectFeatures, select.deselected[i])
        }
  
        removeDeselected();
        constructionZonQuery();
        $('#results').empty();
      });

}

function zeroZones()
{
    zoneSeleted = []
    tabzoneSeleted = []
    selectFeatures = []
    constructionZonQuery()

    $(".zone").prop('checked', false);
    $("#supZones").css("visibility", "hidden");
}


$("#supZones").click(function(){
    zeroZones();
  })


function addr_search() 
{
    $('#results').empty();
    $('<p>', { html: "Recherche en cours ..." }).appendTo('#results');
    var inp = document.getElementById("addr");
    $.getJSON('http://nominatim.openstreetmap.org/search?format=json&limit=14&q=' + inp.value, function(data) {
        var items = [];

        $.each(data, function(key, val) {
          items.push("<li><a href='#' onclick='chooseAddr(" + val.lat + ", " + val.lon + ");return false;'>" + val.display_name + '</a></li>');
          });

        $('#results').empty();
        if (items.length != 0) 
        {
            $('<ul/>', {
              'class': 'my-new-list',
              html: items.join('')
            }).appendTo('#results');
        } else {
            $('<p>', { html: "No results found" }).appendTo('#results');
          }
    });
}


function chooseAddr(lat, lng, type) 
{
    var  centreCarte = ol.proj.fromLonLat([lng, lat]);
    view.animate({
              center: centreCarte,
              zoom : 10,
              duration: 2000
            });
    $('#results').empty();
}


$("#recentrer").click(function(){
  view.animate({
            center: centreCarte,
            zoom : 7,
            duration: 2000
          });
})

</script>