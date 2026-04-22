<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Manrope", "Inter", system-ui, sans-serif;
            background: linear-gradient(135deg, #3C88C3 0%, #245275 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #ffffff;
        }

        .error-container {
            text-align: center;
            padding: 2rem;
            max-width: 600px;
        }

        .error-code {
            font-size: 120px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 0.8s ease-out;
        }

        .error-message {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 1rem;
            animation: fadeIn 1s ease-out 0.3s both;
        }

        .error-description {
            font-size: 16px;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeIn 1s ease-out 0.6s both;
        }

        .redirect-button {
            display: inline-block;
            padding: 16px 40px;
            font-size: 16px;
            font-weight: 600;
            color: #667eea;
            background: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-out 0.9s both;
        }

        .redirect-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background: #f0f0f0;
        }

        .redirect-button:active {
            transform: translateY(0);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 80px;
            }

            .error-message {
                font-size: 22px;
            }

            .error-description {
                font-size: 14px;
            }

            .redirect-button {
                padding: 14px 32px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-message">Page Not Found</div>
        <div class="error-description" id="countdown-text">Redirecting to home page in 8 secs</div>
        <button class="redirect-button" id="redirect-btn" onclick="redirectHome()">
            Redirecting to home in <span id="countdown">8</span> secs
        </button>
    </div>

    <script>
        let countdown = 8;
        const countdownElement = document.getElementById('countdown');
        const countdownTextElement = document.getElementById('countdown-text');
        
        function redirectHome() {
            window.location.href = '/';
        }

        function updateCountdown() {
            countdown--;
            countdownElement.textContent = countdown;
            countdownTextElement.textContent = `Redirecting to home page in ${countdown} secs`;
            
            if (countdown <= 0) {
                redirectHome();
            }
        }

        // Start countdown after 1 second
        setTimeout(() => {
            const countdownInterval = setInterval(() => {
                updateCountdown();
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);
        }, 1000);
    </script>
</body>
</html>