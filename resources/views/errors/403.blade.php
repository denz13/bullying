<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Forbidden | Guidance Office</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sancreek&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: "Sancreek", cursive;
            margin: 0;
            padding: 0;
        }

        .container {
            position: relative;
            height: 100vh;
            overflow: hidden;
            background: #282820;
            z-index: 0;
        }

        .message {
            text-align: center;
            position: absolute;
            left: 0;
            right: 0;
            z-index: 1;
            top: 150px;
            width: 432px;
            height: 324px;
            margin: 0 auto;
            border: 20px solid #b1811d;
            background: #b1811d;
            border-radius: 20px;
            box-shadow: 0px 0px 0px 4px #471f05;
            animation: bounceInDown 1.3s ease-out;
            animation-delay: 1s;
            animation-fill-mode: both;
        }

        .message::before,
        .message::after {
            content: "";
            position: absolute;
            bottom: 107%;
            width: 50px;
            height: 300px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"><circle cx="25" cy="10" r="3" fill="%238f6002"/><circle cx="25" cy="25" r="3" fill="%238f6002"/><circle cx="25" cy="40" r="3" fill="%238f6002"/><line x1="25" y1="0" x2="25" y2="50" stroke="%238f6002" stroke-width="2"/></svg>') repeat-y center;
            z-index: -10;
        }

        .message::before {
            left: 20px;
        }

        .message::after {
            right: 20px;
        }

        .message-inner {
            padding: 40px;
            border-radius: 20px;
            position: absolute;
            top: 2%;
            right: 2%;
            bottom: 2%;
            left: 2%;
            color: #291b03;
            background: #825301;
        }

        .message-title {
            font-size: 4em;
            margin: 0 0 20px;
            color: #f1c40f;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .message-subtitle {
            font-size: 2em;
            margin: 0;
            color: #f1c40f;
        }

        .chain {
            position: absolute;
            top: 0;
            height: 200%;
            width: 50px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"><circle cx="25" cy="10" r="3" fill="%238f6002"/><circle cx="25" cy="25" r="3" fill="%238f6002"/><circle cx="25" cy="40" r="3" fill="%238f6002"/><line x1="25" y1="0" x2="25" y2="50" stroke="%238f6002" stroke-width="2"/></svg>') repeat-y center;
            animation: chain 1.8s ease-in-out infinite;
        }

        .chain.left {
            left: 0;
        }

        .chain.right {
            right: 0;
        }

        .cog {
            position: absolute;
            bottom: -50px;
        }

        .cog.left {
            left: -50px;
            animation: cog-spin-left 1.8s ease-in-out infinite;
        }

        .cog.right {
            right: -50px;
            animation: cog-spin-right 1.8s ease-in-out infinite;
        }

        .cog-outer {
            fill: #955112;
        }

        .cog-inner {
            fill: #633d03;
        }

        .rivet {
            position: absolute;
            background-color: #8f6002;
            width: 3%;
            border-radius: 100px;
            padding-bottom: 3%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .rivet.top-left {
            top: -7px;
            left: -7px;
        }

        .rivet.top-right {
            top: -7px;
            right: -7px;
        }

        .rivet.bottom-left {
            bottom: -7px;
            left: -7px;
        }

        .rivet.bottom-right {
            bottom: -7px;
            right: -7px;
        }

        .action-buttons {
            position: absolute;
            bottom: 50px;
            left: 0;
            right: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            z-index: 10;
        }

        .btn {
            padding: 12px 24px;
            font-family: "Sancreek", cursive;
            font-size: 1.2em;
            border: 3px solid #b1811d;
            border-radius: 10px;
            background: #825301;
            color: #f1c40f;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .btn:hover {
            background: #955112;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        @keyframes cog-spin-left {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes cog-spin-right {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(-360deg);
            }
        }

        @keyframes chain {
            from {
                top: 0;
            }
            to {
                top: -100%;
            }
        }

        @keyframes bounceInDown {
            0% {
                opacity: 0;
                transform: translateY(-200px);
            }
            60% {
                opacity: 1;
                transform: translateY(10px);
            }
            80% {
                transform: translateY(-5px);
            }
            100% {
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .message {
                width: 90%;
                max-width: 432px;
                height: auto;
                min-height: 324px;
            }

            .message-title {
                font-size: 3em;
            }

            .message-subtitle {
                font-size: 1.5em;
            }

            .cog {
                width: 100px;
                height: 100px;
            }

            .cog svg {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="chain left"></div>
        <div class="chain right"></div>
        
        <div class="cog left">
            <svg width="150px" height="150px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="cog" fill-rule="nonzero">
                        <path d="M36.601563,23.199219 C36.699219,22.5 36.800781,21.800781 36.800781,21 C36.800781,20.199219 36.699219,19.5 36.601563,18.800781 L41.101563,15.601563 C41.5,15.300781 41.699219,14.699219 41.398438,14.199219 L37,6.800781 C36.699219,6.300781 36.199219,6.101563 35.699219,6.398438 L30.699219,8.699219 C29.5,7.800781 28.300781,7.101563 26.898438,6.5 L26.398438,1 C26.300781,0.5 25.898438,0.101563 25.398438,0.101563 L16.800781,0.101563 C16.300781,0.101563 15.800781,0.5 15.800781,1 L15.300781,6.5 C13.898438,7.101563 12.601563,7.800781 11.5,8.699219 L6.5,6.398438 C6,6.199219 5.398438,6.398438 5.199219,6.800781 L0.898438,14.199219 C0.601563,14.699219 0.800781,15.300781 1.199219,15.601563 L5.699219,18.800781 C5.601563,19.5 5.5,20.199219 5.5,21 C5.5,21.800781 5.601563,22.5 5.699219,23.199219 L1,26.398438 C0.601563,26.699219 0.398438,27.300781 0.699219,27.800781 L5,35.199219 C5.300781,35.699219 5.800781,35.898438 6.300781,35.601563 L11.300781,33.300781 C12.5,34.199219 13.699219,34.898438 15.101563,35.5 L15.601563,41 C15.699219,41.5 16.101563,41.898438 16.601563,41.898438 L25.199219,41.898438 C25.699219,41.898438 26.199219,41.5 26.199219,41 L26.699219,35.5 C28.101563,34.898438 29.398438,34.199219 30.5,33.300781 L35.5,35.601563 C36,35.800781 36.601563,35.601563 36.800781,35.199219 L41.101563,27.800781 C41.398438,27.300781 41.199219,26.699219 40.800781,26.398438 L36.601563,23.199219 Z M21,31 C15.5,31 11,26.5 11,21 C11,15.5 15.5,11 21,11 C26.5,11 31,15.5 31,21 C31,26.5 26.5,31 21,31 Z" id="Shape" fill="#C7A005" class="cog-outer"></path>
                        <path d="M21,9 C14.398438,9 9,14.398438 9,21 C9,27.601563 14.398438,33 21,33 C27.601563,33 33,27.601563 33,21 C33,14.398438 27.601563,9 21,9 Z M21,26 C18.199219,26 16,23.800781 16,21 C16,18.199219 18.199219,16 21,16 C23.800781,16 26,18.199219 26,21 C26,23.800781 23.800781,26 21,26 Z" id="Shape" fill="#F1C40F" class="cog-inner"></path>
                    </g>
                </g>
            </svg>
        </div>
        
        <div class="cog right">
            <svg width="150px" height="150px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="cog" fill-rule="nonzero">
                        <path d="M36.601563,23.199219 C36.699219,22.5 36.800781,21.800781 36.800781,21 C36.800781,20.199219 36.699219,19.5 36.601563,18.800781 L41.101563,15.601563 C41.5,15.300781 41.699219,14.699219 41.398438,14.199219 L37,6.800781 C36.699219,6.300781 36.199219,6.101563 35.699219,6.398438 L30.699219,8.699219 C29.5,7.800781 28.300781,7.101563 26.898438,6.5 L26.398438,1 C26.300781,0.5 25.898438,0.101563 25.398438,0.101563 L16.800781,0.101563 C16.300781,0.101563 15.800781,0.5 15.800781,1 L15.300781,6.5 C13.898438,7.101563 12.601563,7.800781 11.5,8.699219 L6.5,6.398438 C6,6.199219 5.398438,6.398438 5.199219,6.800781 L0.898438,14.199219 C0.601563,14.699219 0.800781,15.300781 1.199219,15.601563 L5.699219,18.800781 C5.601563,19.5 5.5,20.199219 5.5,21 C5.5,21.800781 5.601563,22.5 5.699219,23.199219 L1,26.398438 C0.601563,26.699219 0.398438,27.300781 0.699219,27.800781 L5,35.199219 C5.300781,35.699219 5.800781,35.898438 6.300781,35.601563 L11.300781,33.300781 C12.5,34.199219 13.699219,34.898438 15.101563,35.5 L15.601563,41 C15.699219,41.5 16.101563,41.898438 16.601563,41.898438 L25.199219,41.898438 C25.699219,41.898438 26.199219,41.5 26.199219,41 L26.699219,35.5 C28.101563,34.898438 29.398438,34.199219 30.5,33.300781 L35.5,35.601563 C36,35.800781 36.601563,35.601563 36.800781,35.199219 L41.101563,27.800781 C41.398438,27.300781 41.199219,26.699219 40.800781,26.398438 L36.601563,23.199219 Z M21,31 C15.5,31 11,26.5 11,21 C11,15.5 15.5,11 21,11 C26.5,11 31,15.5 31,21 C31,26.5 26.5,31 21,31 Z" id="Shape" fill="#927d0a" class="cog-outer"></path>
                        <path d="M21,9 C14.398438,9 9,14.398438 9,21 C9,27.601563 14.398438,33 21,33 C27.601563,33 33,27.601563 33,21 C33,14.398438 27.601563,9 21,9 Z M21,26 C18.199219,26 16,23.800781 16,21 C16,18.199219 18.199219,16 21,16 C23.800781,16 26,18.199219 26,21 C26,23.800781 23.800781,26 21,26 Z" id="Shape" fill="#F1C40F" class="cog-inner"></path>
                    </g>
                </g>
            </svg>
        </div>

        <div class="message animated bounceInDown">
            <div class="rivet top-left"></div>
            <div class="rivet top-right"></div>
            <div class="rivet bottom-left"></div>
            <div class="rivet bottom-right"></div>
            <div class="message-inner">
                <h1 class="message-title">Access <br />Forbidden</h1>
                <p class="message-subtitle">Error code 403</p>
                <p style="margin-top: 20px; font-size: 1em; color: #f1c40f;">Admin Role Required</p>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('dashboard') }}" class="btn">Go to Dashboard</a>
            <button onclick="window.history.back()" class="btn">Go Back</button>
        </div>
    </div>
</body>
</html>

