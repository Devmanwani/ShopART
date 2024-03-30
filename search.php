<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/SearchResultsProvider.php");
?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<?php
if (!isset($_GET["term"]) || $_GET["term"] == "") {
    echo "You must enter a search term";
    exit();
}

$term = $_GET["term"];
$filter = isset($_GET["filter"]) ? $_GET["filter"] : 'date'; // Default to 'date' if filter not set

$searchResultsProvider = new SearchResultsProvider($con, $userLoggedInObj);
$artworks = $searchResultsProvider->getArtworksFilter($term, $filter);

$artGrid = new artGrid($con, $userLoggedInObj);
?>

<div class="largeVideoGridContainer">

    <?php
    if (sizeof($artworks) > 0) {
        echo "
        <select name='filters' id='filters' onchange='filters()'>
            <option value='date'>Date</option>
            <option value='name'>Name</option>
            <option value='owner'>Owner</option>
            <option value='price'>Price</option>
        </select>";
        echo $artGrid->createLarge($artworks, sizeof($artworks) . " artworks found");
    } else {
        echo "No results found";
    }
    ?>

</div>

<script>
    function filters() {
        var selectedFilter = $("#filters").val();
        updateQueryStringParameter('filter', selectedFilter);
    }

    function updateQueryStringParameter(key, value) {
        var currentUrl = window.location.href;
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = currentUrl.indexOf('?') !== -1 ? "&" : "?";
        if (currentUrl.match(re)) {
            var newUrl = currentUrl.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            var newUrl = currentUrl + separator + key + "=" + value;
        }
        window.location.href = newUrl;
    }

    // Set the selected value in the dropdown based on the 'filter' parameter in the URL
    $(document).ready(function() {
        var urlFilter = getParameterByName('filter');
        if (urlFilter) {
            $("#filters").val(urlFilter);
        }
    });

    // Function to get URL parameters
    function getParameterByName(name) {
        var url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
</script>

<?php
require_once("assets/includes/footer.php");
?>
