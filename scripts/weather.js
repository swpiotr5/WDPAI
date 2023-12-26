const apiKey = 'd7314ee0b2e53c8f26eb1fc846de3317';
const apiUrlForecastBase = 'https://api.openweathermap.org/data/2.5/forecast?';
const apiUrlWeatherBase = 'https://api.openweathermap.org/data/2.5/weather?';
const getCurrLocation = document.getElementById('get-curr-location');
const getLocationBtn = document.getElementById('get-location-btn');

async function getUserLocation() {
  if ("geolocation" in navigator) {
    try {
      const position = await new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject);
      });

      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;

      const apiUrlForecast = `${apiUrlForecastBase}lat=${latitude}&lon=${longitude}&appid=${apiKey}&cnt=5&units=metric`;
      const apiUrlWeather = `${apiUrlWeatherBase}lat=${latitude}&lon=${longitude}&appid=${apiKey}&units=metric`;

      await checkWeather(apiUrlForecast);
      await checkCurrentWeather(apiUrlWeather);
    } catch (error) {
      handleLocationError(error);
    }
  } else {
    console.error("Geolocation is not supported by this browser.");
  }
}

function handleLocationError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      console.error("User denied the request for Geolocation.");
      break;
    case error.POSITION_UNAVAILABLE:
      console.error("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      console.error("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      console.error("An unknown error occurred.");
      break;
    default:
      console.error("An error occurred:", error.message);
  }
}

async function getLocationFromAddress(address) {
  const apiUrlForecast = `${apiUrlForecastBase}q=${address}&appid=${apiKey}&cnt=5&units=metric`;
  const apiUrlWeather = `${apiUrlWeatherBase}q=${address}&appid=${apiKey}&units=metric`;

  await checkWeather(apiUrlForecast);
  await checkCurrentWeather(apiUrlWeather);
}

async function handleLocationButtonClick() {
  const locationInput = document.getElementById('locationInput');
  const address = locationInput.value.trim();

  if (address !== '') {
    await getLocationFromAddress(address);
  } else {
    console.error('Please enter a valid location.');
  }
}

async function checkWeather(apiUrl) {
  try {
    const response = await fetch(apiUrl);
    const data = await response.json();
    const sunriseTimestamp = data["city"]["sunrise"];
    const sunsetTimestamp = data["city"]["sunset"];
    const formattedSunrise = convertUnixTimestampToTime(sunriseTimestamp);
    const formattedSunset = convertUnixTimestampToTime(sunsetTimestamp);

    const newData = {
      cityName: data["city"]["name"],
      sunrise: formattedSunrise,
      sunset: formattedSunset,
      forecasts: [],
      isCurrent: false
    };

    data.list.forEach((item) => {
      const timestampHour = item.dt;
      const formattedTimestampHour = convertUnixTimestampToTime(timestampHour);
      const rainInches = item.rain ? item.rain["3h"] : 0;
      const rainMillimeters = rainInches * 25.4;

      const forecastData = {
        weatherMain: item.weather[0].main,
        windSpeed: item.wind.speed,
        pressure: item.main.pressure,
        humidity: item.main.humidity,
        formattedTimestampHour: formattedTimestampHour,
        rain: rainMillimeters // Dodaj wartość "rain" lub "0"
      };

      newData.forecasts.push(forecastData);
      // Do something with forecast weather data here
    })
    await sendWeatherDataToServer(newData);
  } catch (error) {
    console.error('An error occurred while fetching forecast weather data:', error);
  }
}

function convertUnixTimestampToTime(timestamp) {
  const date = new Date(timestamp * 1000); // Konwersja na milisekundy
  const hours = date.getHours().toString().padStart(2, '0'); // Godzina
  const minutes = date.getMinutes().toString().padStart(2, '0'); // Minuty
  return `${hours}:${minutes}`; // Zwraca sformatowaną godzinę i minutę (HH:mm)
}

async function checkCurrentWeather(apiUrl) {
  try {
    const response = await fetch(apiUrl);
    const data = await response.json();
    const sunriseTimestamp = data["sys"]["sunrise"];
    const sunsetTimestamp = data["sys"]["sunset"];
    const formattedSunrise = convertUnixTimestampToTime(sunriseTimestamp);
    const formattedSunset = convertUnixTimestampToTime(sunsetTimestamp);
    const timestampHour = data["dt"];
    const formattedTimestampHour = convertUnixTimestampToTime(timestampHour);
    const rainInches = data["rain"] ? data["rain"]["1h"] : 0;
    const rainMillimeters = rainInches * 25.4;
    console.log("Current ForecastRepository Data:", data);
    // Do something with current weather data here
    const newData = {
      cityName: data["name"],
      sunrise: formattedSunrise,
      sunset: formattedSunset,
      forecasts: [],
      isCurrent: true
    };

    const forecastData = {
      weatherMain: data["weather"]["0"]["main"],
      windSpeed: data["wind"]["speed"],
      pressure: data["main"]["pressure"],
      humidity: data["main"]["humidity"],
      formattedTimestampHour: formattedTimestampHour,
      rain: rainMillimeters // Dodaj wartość "rain" lub "0"
    };

    newData.forecasts.push(forecastData);
    await sendWeatherDataToServer(newData);
  } catch (error) {
    console.error('An error occurred while fetching current weather data:', error);
  }
}

async function sendWeatherDataToServer(weatherData) {
  try {
    const response = await fetch('/forecast', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(weatherData),
    });

    if (response.ok) {
      console.log('Weather data sent successfully to the server.');
    } else {
      throw new Error('Failed to send weather data to the server.');
    }
  } catch (error) {
    console.error('An error occurred while sending weather data to the server:', error);
  }
}

if (getCurrLocation) {
  getCurrLocation.addEventListener('click', getUserLocation);
}

if (getLocationBtn) {
  getLocationBtn.addEventListener('click', handleLocationButtonClick);
}