<?php
/**
 * This PHP file is used to display weather forecast information using an API.
 * It uses the OpenWeatherMap service to implement this with PHP.

 * It grabs the weather information provided by the API and 
 * displays it in the browser.
 * 
 * PHP version 8.2
 *
 * @category Web_App
 * @package  Weather_App
 *
 * @author  Filipe Ferreira <filipeferreira94@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version CVS: <cvs_id>
 * @link    https://phppot.com/php/forecast-weather-using-openweathermap-with-php/
 * @since   2023-09-06
 */
?>

<?php
// requiring the file to load Composer packages
require __DIR__ . '/vendor/autoload.php';


 //importing the API secret to global var
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeload();
$API_KEY = $_ENV["API_KEY"];

$cityInput = $requestStatus = $temp = $country = $descrption = $error = "";


if (isset($_POST["city"]) && !empty($_POST["city"])) {
    $cityInput = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);

    $API_CALL 
        = "https://api.openweathermap.org/data/2.5/weather?"
        . "q=$cityInput" . "&appid=$API_KEY" . "&units=metric";

    $API_RESPONSE = @file_get_contents($API_CALL);
    

    if ($API_RESPONSE) {
        $weatherData = json_decode($API_RESPONSE, true);

        if ($weatherData["cod"] !== 404) {
            $temp = round($weatherData["main"]["temp"]);
            $iconSrc = "https://openweathermap.org/img/wn/"
            . "{$weatherData["weather"][0]["icon"]}@2x.png";
            $weatherDescription = "{$weatherData["weather"][0]["description"]}";
            $cityName = $weatherData["name"];
            $countryTag = $weatherData["sys"]["country"];
            $windSpeed = $weatherData["wind"]["speed"];
        } else {
            $error = $weatherData["message"];
        }
        

    } else {
        $error = "Error getting the weather data from Open Weather Map.";
    }

} else {
    $error = "Please enter a city name.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<body>
    <h1>My Weather App</h1>
    <form method="post">
        <input type="text" name="city" placeholder="London">
        <input type="submit" value="Submit" name="submit">
    </form>
    <?php if (empty($error)) { ?>
        <p>It is currently <?php echo $temp ?> ºC in 
        <?php echo $cityName ?>, 
        <?php echo $countryTag ?>.</p>
        <?php if ($windSpeed > 0) { ?>
            <p>The wind is blowing at <?php echo $windSpeed ?> m/s</p>
        <?php } ?>
        
        <img src="<?php echo $iconSrc ?>" alt="<?php echo $weatherDescription ?>">
        <p><?php echo $weatherDescription ?></p>
    <?php } else { ?>
        <p> <?php echo $error ?>

    <?php } ?>
    
    
</body>
</html>
