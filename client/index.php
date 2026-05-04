<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Тестирование</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        .api-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .api-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }
        .api-card:hover {
            transform: translateY(-5px);
        }
        .api-card h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        .api-card button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
            transition: opacity 0.3s;
        }
        .api-card button:hover {
            opacity: 0.9;
        }
        .api-card input, .api-card select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .result {
            background: #f4f4f4;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            font-size: 14px;
            word-wrap: break-word;
            max-height: 200px;
            overflow-y: auto;
        }
        .weather-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .weather-card h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        .flex {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        @media (max-width: 768px) {
            .api-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="api-grid">
            <div class="api-card">
                <h3>Дата и время</h3>
                <button onclick="testAPI('day')">Текущий день</button>
                <button onclick="testAPI('month')">Текущий месяц</button>
                <button onclick="testAPI('year')">Текущий год</button>
                <div id="datetime-result" class="result"></div>
            </div>
            
            <div class="api-card">
                <h3>День недели</h3>
                <input type="date" id="weekday-date">
                <button onclick="getWeekday()">Получить день недели</button>
                <div id="weekday-result" class="result"></div>
            </div>
            
            <div class="api-card">
                <h3>Разница между датами</h3>
                <input type="date" id="date1">
                <input type="date" id="date2">
                <button onclick="getDateDiff()">Рассчитать разницу</button>
                <div id="diff-result" class="result"></div>
            </div>
            
            <div class="api-card">
                <h3>Города по стране</h3>
                <select id="country">
                    <option value="Россия">Россия</option>
                    <option value="США">США</option>
                    <option value="Германия">Германия</option>
                </select>
                <button onclick="getCities()">Получить города</button>
                <div id="cities-result" class="result"></div>
            </div>
            
            <div class="api-card">
                <h3>CRUD Операции</h3>
                <button onclick="getAllItems()">Все записи</button>
                <input type="number" id="item-id" placeholder="ID записи">
                <button onclick="getItem()">Получить запись</button>
                <button onclick="deleteItem()">Удалить запись</button>
                <div id="crud-result" class="result"></div>
            </div>
            
            <div class="api-card">
                <h3>Погода (СПб)</h3>
                <button onclick="getWeather()">Получить погоду</button>
                <div id="weather-result" class="result"></div>
            </div>
        </div>
    </div>

    <script>
        const API_BASE = 'http://api.ponka.ru/public/';
        
        async function testAPI(endpoint) {
            try {
                const response = await fetch(`${API_BASE}${endpoint}.php`);
                const data = await response.json();
                document.getElementById('datetime-result').innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            } catch (error) {
                document.getElementById('datetime-result').innerHTML = `Ошибка: ${error.message}`;
            }
        }
        
        async function getWeekday() {
            const date = document.getElementById('weekday-date').value;
            if (!date) {
                alert('Выберите дату');
                return;
            }
            try {
                const response = await fetch(`${API_BASE}weekday.php?date=${date}`);
                const data = await response.json();
                document.getElementById('weekday-result').innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            } catch (error) {
                document.getElementById('weekday-result').innerHTML = `Ошибка: ${error.message}`;
            }
        }
        
        async function getDateDiff() {
            const date1 = document.getElementById('date1').value;
            const date2 = document.getElementById('date2').value;
            if (!date1 || !date2) {
                alert('Выберите обе даты');
                return;
            }
            try {
                const response = await fetch(`${API_BASE}diff.php?date1=${date1}&date2=${date2}`);
                const data = await response.json();
                document.getElementById('diff-result').innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            } catch (error) {
                document.getElementById('diff-result').innerHTML = `Ошибка: ${error.message}`;
            }
        }
        
        async function getCities() {
            const country = document.getElementById('country').value;
            try {
                const response = await fetch(`${API_BASE}cities.php?country=${encodeURIComponent(country)}`);
                const data = await response.json();
                document.getElementById('cities-result').innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            } catch (error) {
                document.getElementById('cities-result').innerHTML = `Ошибка: ${error.message}`;
            }
        }
        
        async function getAllItems() {
            try {
                const response = await fetch(`${API_BASE}index.php?action=all`);
                const data = await response.json();
                document.getElementById('crud-result').innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            } catch (error) {
                document.getElementById('crud-result').innerHTML = `Ошибка: ${error.message}`;
            }
        }
        
        async function getItem() {
            const id = document.getElementById('item-id').value;
            if (!id) {
                alert('Введите ID');
                return;
            }
            try {
                const response = await fetch(`${API_BASE}index.php?action=get&id=${id}`);
                const data = await response.json();
                document.getElementById('crud-result').innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            } catch (error) {
                document.getElementById('crud-result').innerHTML = `Ошибка: ${error.message}`;
            }
        }
        
        async function deleteItem() {
            const id = document.getElementById('item-id').value;
            if (!id) {
                alert('Введите ID');
                return;
            }
            if (!confirm('Удалить запись?')) return;
            try {
                const response = await fetch(`${API_BASE}index.php?action=del&id=${id}`);
                const data = await response.json();
                document.getElementById('crud-result').innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            } catch (error) {
                document.getElementById('crud-result').innerHTML = `Ошибка: ${error.message}`;
            }
        }
        
        async function getWeather() {
            try {
                const response = await fetch('https://api.open-meteo.com/v1/forecast?latitude=59.9386&longitude=30.2141&current_weather=true');
                const data = await response.json();
                const weather = data.current_weather;
                document.getElementById('weather-result').innerHTML = `
                    <strong>Температура:</strong> ${weather.temperature}°C<br>
                    <strong>Ветер:</strong> ${weather.windspeed} км/ч<br>
                    <strong>Направление:</strong> ${weather.winddirection}°<br>
                    <strong>Время:</strong> ${weather.time}
                `;
            } catch (error) {
                document.getElementById('weather-result').innerHTML = `Ошибка: ${error.message}`;
            }
        }
    </script>
</body>
</html>
