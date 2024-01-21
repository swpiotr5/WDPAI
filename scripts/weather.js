const apiKey = 'd7314ee0b2e53c8f26eb1fc846de3317';
const apiUrlForecastBase = 'https://api.openweathermap.org/data/2.5/forecast?';
const apiUrlWeatherBase = 'https://api.openweathermap.org/data/2.5/weather?';
const getCurrLocation = document.getElementById('get-curr-location');
const getLocationBtn = document.getElementById('get-location-btn');

let dialog = document.querySelector("#dialog");
let errorDialog = document.querySelector("#errorDialog");

async function getUserLocation() {
    if ('geolocation' in navigator) {
        try {
            const position = await new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject);
            });

            const { latitude, longitude } = position.coords;

            const apiUrlForecast = `${apiUrlForecastBase}lat=${latitude}&lon=${longitude}&appid=${apiKey}&cnt=5&units=metric`;
            const apiUrlWeather = `${apiUrlWeatherBase}lat=${latitude}&lon=${longitude}&appid=${apiKey}&units=metric`;

            try {
                await fetch('/deleteForecasts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });

                // Fetch and send new weather data
                await checkWeather(apiUrlForecast);
                await checkCurrentWeather(apiUrlWeather);
            } catch (error) {
                console.error('An error occurred while updating weather data:', error);
                errorDialog.showModal();
            }
        } catch (error) {
            handleLocationError(error);
        }
    } else {
        console.error('Geolocation is not supported by this browser.');
    }
}

async function getLocationFromAddress(address) {
    const apiUrlForecast = `${apiUrlForecastBase}q=${address}&appid=${apiKey}&cnt=5&units=metric`;
    const apiUrlWeather = `${apiUrlWeatherBase}q=${address}&appid=${apiKey}&units=metric`;

    try {
        await fetch('/deleteForecasts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        // Fetch and send new weather data
        await checkWeather(apiUrlForecast);
        await checkCurrentWeather(apiUrlWeather);
    } catch (error) {
        console.error('An error occurred while updating weather data:', error);
        errorDialog.showModal();
    }
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
        if (!response.ok) {
            errorDialog.showModal();
        } else {
            dialog.showModal();
        }
        const data = await response.json();
        const sunriseTimestamp = data.city.sunrise;
        const sunsetTimestamp = data.city.sunset;
        const timezone = data.city.timezone;
        const formattedSunrise = convertUnixTimestampToTime(sunriseTimestamp, timezone);
        const formattedSunset = convertUnixTimestampToTime(sunsetTimestamp, timezone);
        for (const item of data.list) {
            const timestampHour = item.dt;
            const formattedTimestampHour = convertUnixTimestampToTime(timestampHour, timezone);
            const rainInches = item.rain ? item.rain['3h'] : 0;
            const rainMillimeters = rainInches * 25.4;
            let temp = Math.round(parseFloat(item.main.temp));
            let weatherIcon = item.weather[0].icon;
            let weatherIconUrl = `https://openweathermap.org/img/wn/${weatherIcon}.png`;
            const forecastData = {
                cityName: data.city.name,
                weatherDescription: item.weather[0].main,
                preciseWeatherDescription: item.weather[0].description,
                wind: item.wind.speed,
                pressure: item.main.pressure,
                temperature: temp,
                humidity: item.main.humidity,
                sunset: formattedSunset,
                sunrise: formattedSunrise,
                rain: rainMillimeters,
                time: formattedTimestampHour,
                isCurrent: false,
                weatherIconUrl: weatherIconUrl,
            };

            await sendWeatherDataToServer(forecastData);
        }
    } catch (error) {
        console.error('An error occurred while fetching forecast weather data:', error);
    }
}

function convertUnixTimestampToTime(timestamp, timezoneOffset) {
    if (typeof timestamp !== 'number' || typeof timezoneOffset !== 'number') {
        console.error('Invalid arguments:', timestamp, timezoneOffset);
        return 'Invalid time';
    }

    const date = new Date((timestamp + timezoneOffset) * 1000);
    const hours = date.getUTCHours();
    const minutes = "0" + date.getUTCMinutes();
    const formattedTime = hours + ':' + minutes.substr(-2);
    return formattedTime;
}

async function checkCurrentWeather(apiUrl) {
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            errorDialog.showModal();
        } else {
            dialog.showModal();
        }
        const data = await response.json();
        const sunriseTimestamp = data.sys.sunrise;
        const sunsetTimestamp = data.sys.sunset;
        const timezone = data.timezone;
        const formattedSunrise = convertUnixTimestampToTime(sunriseTimestamp, timezone);
        const formattedSunset = convertUnixTimestampToTime(sunsetTimestamp, timezone);
        const timestampHour = data.dt;
        const formattedTimestampHour = convertUnixTimestampToTime(timestampHour, timezone);
        const rainInches = data.rain ? data.rain['1h'] : 0;
        const rainMillimeters = rainInches * 25.4;
        let temp = Math.round(parseFloat(data.main.temp));
        let weatherIcon = data.weather[0].icon;
        let weatherIconUrl = `https://openweathermap.org/img/wn/${weatherIcon}.png`;
        const forecastData = {
            cityName: data.name,
            weatherDescription: data.weather[0].main,
            preciseWeatherDescription: data.weather[0].description,
            wind: data.wind.speed,
            pressure: data.main.pressure,
            temperature: temp,
            humidity: data.main.humidity,
            sunset: formattedSunset,
            sunrise: formattedSunrise,
            rain: rainMillimeters,
            time: formattedTimestampHour,
            isCurrent: true,
            weatherIconUrl: weatherIconUrl,
        };

        await sendWeatherDataToServer(forecastData);
    } catch (error) {
        console.error('An error occurred while fetching current weather data:', error);
    }
}

async function sendWeatherDataToServer(weatherData) {
    try {
        const response = await fetch('/addForecast', {
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

function handleLocationError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            console.error('User denied the request for Geolocation.');
            break;
        case error.POSITION_UNAVAILABLE:
            console.error('Location information is unavailable.');
            break;
        case error.TIMEOUT:
            console.error('The request to get user location timed out.');
            break;
        case error.UNKNOWN_ERROR:
            console.error('An unknown error occurred.');
            break;
        default:
            console.error('An error occurred:', error.message);
    }
}

if (getCurrLocation) {
    getCurrLocation.addEventListener('click', getUserLocation);
}

if (getLocationBtn) {
    getLocationBtn.addEventListener('click', handleLocationButtonClick);
}
