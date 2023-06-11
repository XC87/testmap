<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var $APPLICATION CMain
 */
?>
<div class="map-container">
    <h2>Наши офисы</h2>
    <div id="map"></div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=<?= $arParams["MAP_API_KEY"] ?>&lang=ru_RU" type="text/javascript"></script>
<script>
    ymaps.ready(function() {
        var myMap = new ymaps.Map('map', {
                center: [55.76, 37.64],
                zoom: 4
            }, {
                searchControlProvider: 'yandex#search'
            }),
            offices = <?=json_encode($arResult["OFFICES"])?>;

        for (var i = 0; i < offices.length; i++) {
            var office = offices[i],
                placemark = new ymaps.Placemark(office.coords, {
                        hintContent: office.name,
                        balloonContent: getBalloonContent(office),
                    }, {
                        preset: "islands#yellowStretchyIcon",
                        balloonCloseButton: false,
                        hideIconOnBalloonOpen: false
                    }
                );

            myMap.geoObjects.add(placemark);
        }

        function getBalloonContent(office) {
            var content = "<div class='office'>";
            content += "<h3>" + office.name + "</h3>";
            content += "<p>" + office.city + "</p>";
            content += "<p>E-mail: " + office.email + "</p>";
            content += "<p>Телефон: " + office.phone + "</p>";
            content += "</div>";
            return content;
        }
    });
</script>