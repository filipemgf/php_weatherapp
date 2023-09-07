# Weather App

This PHP file is used to display weather forecast information using the OpenWeatherMap API. It grabs the weather information provided by the API and displays it in the browser.

## Installation

1. Clone this repository.
2. Run `composer install` to install the required dependencies.
3. Create a `.env` file in the root directory of your project and add your [OpenWeatherMap API key](https://openweathermap.org/api) as follows:

```
API_KEY=your_api_key_here
```

4. Start a local server by running `php -S localhost:8000`.
5. Navigate to `http://localhost:8000` in your web browser.

## Usage

Enter the name of a city in the input field and click "Get Weather" to display the current weather data for that city.
