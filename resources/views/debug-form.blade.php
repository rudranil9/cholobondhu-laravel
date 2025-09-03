<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Debug Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            white-space: pre-wrap;
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Debug Form - Registration Test</h1>
    
    <form id="debug-form">
        <input type="text" id="name" placeholder="Name" value="Test User" required>
        <input type="email" id="email" placeholder="Email" value="test@example.com" required>
        <input type="tel" id="phone" placeholder="Phone" value="01234567890">
        <input type="password" id="password" placeholder="Password" value="password123" required>
        <input type="password" id="password_confirmation" placeholder="Confirm Password" value="password123" required>
        <button type="submit">Submit Form</button>
    </form>
    
    <div id="result"></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Debug form loaded');
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            const form = document.getElementById('debug-form');
            const resultDiv = document.getElementById('result');
            
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                console.log('Form submitted!');
                resultDiv.textContent = 'Submitting...';
                resultDiv.className = 'result';
                
                const data = {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                    password: document.getElementById('password').value,
                    password_confirmation: document.getElementById('password_confirmation').value
                };
                
                console.log('Data to send:', data);
                
                try {
                    const response = await fetch('/api/auth/register/initiate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                    
                    console.log('Response status:', response.status);
                    console.log('Response headers:', [...response.headers.entries()]);
                    
                    const result = await response.json();
                    console.log('Response data:', result);
                    
                    resultDiv.textContent = JSON.stringify({
                        status: response.status,
                        ok: response.ok,
                        data: result
                    }, null, 2);
                    
                    resultDiv.className = response.ok ? 'result success' : 'result error';
                    
                } catch (error) {
                    console.error('Error:', error);
                    resultDiv.textContent = 'Network Error: ' + error.message;
                    resultDiv.className = 'result error';
                }
            });
        });
    </script>
</body>
</html>
