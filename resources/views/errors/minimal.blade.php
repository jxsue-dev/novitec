<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') – Novitec</title>

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@300;400;500;700;800&family=DM+Mono:wght@400;500&display=swap">

        <style>
            :root {
                --blue:   #1a56ff;
                --violet: #7c3aed;
                --gold:   #f5a623;
                --dark:   #020817;
                --dark2:  #0c1a35;
                --text-muted: #64748b;
                --fb: 'Cabinet Grotesk', sans-serif;
                --fm: 'DM Mono', monospace;
            }

            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: var(--fb);
                background: linear-gradient(135deg, var(--dark) 0%, var(--dark2) 50%, var(--dark) 100%);
                color: #ffffff;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow-x: hidden;
                position: relative;
                padding: 1.5rem 0;
            }

            /* Background grid and glows */
            .bg-grid {
                position: absolute;
                inset: 0;
                pointer-events: none;
                background-image: 
                    linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
                background-size: 48px 48px;
                mask-image: radial-gradient(ellipse 60% 60% at 50% 50%, black 40%, transparent 100%);
                -webkit-mask-image: radial-gradient(ellipse 60% 60% at 50% 50%, black 40%, transparent 100%);
                z-index: 1;
            }

            .glow-1 {
                position: absolute;
                top: -10%;
                right: -10%;
                width: 600px;
                height: 600px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(26, 86, 255, 0.12), transparent 70%);
                pointer-events: none;
                z-index: 1;
            }

            .glow-2 {
                position: absolute;
                bottom: -10%;
                left: -10%;
                width: 500px;
                height: 500px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(124, 58, 237, 0.1), transparent 70%);
                pointer-events: none;
                z-index: 1;
            }

            /* Container & Card */
            .error-container {
                position: relative;
                z-index: 10;
                width: 100%;
                max-width: 500px;
                padding: 1rem;
                text-align: center;
            }

            .error-card {
                background: rgba(255, 255, 255, 0.02);
                border: 1px solid rgba(255, 255, 255, 0.06);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-radius: 24px;
                padding: 3rem 2rem;
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
                animation: cardIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
            }

            @keyframes cardIn {
                from { opacity: 0; transform: translateY(30px) scale(0.98); }
                to { opacity: 1; transform: translateY(0) scale(1); }
            }

            /* Error Icon */
            .error-icon {
                font-size: 3rem;
                color: #60a5fa;
                margin-bottom: 1.5rem;
                animation: float 4s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-8px); }
            }

            /* Error Code */
            .error-code {
                font-family: var(--fb);
                font-weight: 900;
                font-size: 6rem;
                line-height: 1;
                margin-bottom: 0.5rem;
                letter-spacing: -0.04em;
                background: linear-gradient(90deg, #60a5fa, #a78bfa, #60a5fa);
                background-size: 200% auto;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: shimmer 4s linear infinite;
            }

            @keyframes shimmer {
                0% { background-position: -200% center; }
                100% { background-position: 200% center; }
            }

            /* Title and Message */
            .error-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #ffffff;
                margin-bottom: 1rem;
                letter-spacing: -0.01em;
            }

            .error-message {
                font-size: 0.95rem;
                color: rgba(255, 255, 255, 0.6);
                font-weight: 300;
                line-height: 1.6;
                margin-bottom: 2.5rem;
            }

            /* Buttons */
            .error-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: var(--blue);
                color: #ffffff;
                text-decoration: none;
                font-family: var(--fb);
                font-size: 0.875rem;
                font-weight: 700;
                padding: 12px 28px;
                border-radius: 12px;
                border: none;
                outline: none;
                cursor: pointer;
                box-shadow: 0 6px 20px rgba(26, 86, 255, 0.25);
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .error-btn:hover {
                background: #0f44e6;
                transform: translateY(-2px);
                box-shadow: 0 10px 24px rgba(26, 86, 255, 0.4);
            }

            .error-btn:active {
                transform: translateY(0);
            }

            .hidden {
                display: none !important;
            }

            /* D-Pad controls */
            .d-btn {
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.08);
                color: #a0aec0;
                width: 48px;
                height: 40px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.15s;
                font-size: 1.1rem;
                outline: none;
            }
            .d-btn:hover, .d-btn:active {
                background: rgba(96, 165, 250, 0.15);
                border-color: rgba(96, 165, 250, 0.3);
                color: #60a5fa;
            }
            .d-btn-center {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.06);
                color: #718096;
                width: 48px;
                height: 40px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.15s;
                outline: none;
            }
            .d-btn-center:hover {
                background: rgba(255, 255, 255, 0.08);
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="bg-grid"></div>
        <div class="glow-1"></div>
        <div class="glow-2"></div>

        @php
            $code = (string) $__env->yieldContent('code');
            
            // Map icons based on error code
            $icons = [
                '401' => 'fa-user-slash',
                '402' => 'fa-credit-card',
                '403' => 'fa-lock',
                '404' => 'fa-compass',
                '419' => 'fa-clock',
                '429' => 'fa-hourglass-half',
                '500' => 'fa-bug',
                '503' => 'fa-wrench',
            ];
            $icon = $icons[$code] ?? 'fa-circle-exclamation';

            // Map Spanish messages based on error code
            $messages = [
                '401' => 'No autorizado. Por favor inicia sesión para acceder.',
                '402' => 'Pago requerido para acceder a este recurso.',
                '403' => 'Acceso denegado. No tienes permisos para ingresar aquí.',
                '404' => 'Página no encontrada. El enlace es incorrecto o ha sido eliminado.',
                '419' => 'La sesión ha expirado por inactividad. Por favor recarga e intenta de nuevo.',
                '429' => 'Demasiadas solicitudes. Por favor espera un momento antes de volver a consultar.',
                '500' => 'Error interno de nuestros servidores. Ya estamos trabajando en solucionarlo.',
                '503' => 'Servicio en mantenimiento temporal. Volveremos muy pronto.',
            ];
            $customMessage = $messages[$code] ?? $__env->yieldContent('message');
        @endphp

        <div class="error-container">
            <div class="error-card">
                
                <!-- Main Error Content -->
                <div id="errorDetails">
                    <div class="error-icon">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>
                    
                    <h1 class="error-code">
                        @yield('code')
                    </h1>
                    
                    <h2 class="error-title">
                        @yield('title')
                    </h2>
                    
                    <p class="error-message">
                        {{ $customMessage }}
                    </p>
                    
                    <div style="display: flex; flex-direction: column; gap: 12px; align-items: center; justify-content: center; width: 100%;">
                        <div style="display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; width: 100%;">
                            <a href="/" class="error-btn">
                                <i class="fa-solid fa-house"></i>
                                Volver al inicio
                            </a>
                            <button id="btnPlayGame" class="error-btn" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: none;">
                                <i class="fa-solid fa-gamepad"></i>
                                Jugar al Gusanito
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Game Section (hidden by default) -->
                <div id="gameArea" class="hidden">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; padding: 0 0.5rem;">
                        <span style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #60a5fa;"><i class="fa-solid fa-gamepad"></i> Gusanito Novitec</span>
                        <span style="font-size: 0.75rem; font-weight: 500; color: #94a3b8; font-family: var(--fm);">
                            Ptos: <strong id="gameScore" style="color: #fff;">0</strong> | Record: <strong id="gameHighScore" style="color: #fff;">0</strong>
                        </span>
                    </div>
                    
                    <canvas id="gameCanvas" width="320" height="320" style="background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; display: block; margin: 0 auto; max-width: 100%;"></canvas>
                    
                    <!-- D-Pad for Mobile/Touch -->
                    <div style="margin-top: 1rem; display: grid; grid-template-columns: repeat(3, 48px); gap: 8px; justify-content: center;">
                        <div></div>
                        <button type="button" class="d-btn" onclick="changeDir('up')"><i class="fa-solid fa-caret-up"></i></button>
                        <div></div>
                        <button type="button" class="d-btn" onclick="changeDir('left')"><i class="fa-solid fa-caret-left"></i></button>
                        <button type="button" class="d-btn-center" onclick="resetGame()"><i class="fa-solid fa-rotate-left"></i></button>
                        <button type="button" class="d-btn" onclick="changeDir('right')"><i class="fa-solid fa-caret-right"></i></button>
                        <div></div>
                        <button type="button" class="d-btn" onclick="changeDir('down')"><i class="fa-solid fa-caret-down"></i></button>
                    </div>
                    
                    <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 12px;">
                        <button id="btnBackToError" class="error-btn" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: none;">
                            <i class="fa-solid fa-arrow-left"></i>
                            Volver al error
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <script>
            let canvas, ctx;
            let snake, food, dx, dy, score, highScore, gameInterval;
            const gridSize = 16;
            const tileCount = 20; // 320 / 16 = 20 tiles

            document.getElementById('btnPlayGame').addEventListener('click', function() {
                document.getElementById('errorDetails').classList.add('hidden');
                document.getElementById('gameArea').classList.remove('hidden');
                initGame();
            });

            document.getElementById('btnBackToError').addEventListener('click', function() {
                if (gameInterval) clearInterval(gameInterval);
                document.getElementById('gameArea').classList.add('hidden');
                document.getElementById('errorDetails').classList.remove('hidden');
            });

            function initGame() {
                canvas = document.getElementById('gameCanvas');
                ctx = canvas.getContext('2d');
                
                // Load High Score
                highScore = localStorage.getItem('snake_highscore') || 0;
                document.getElementById('gameHighScore').textContent = highScore;
                
                resetGame();
                
                // Listen for keys
                document.removeEventListener('keydown', handleKeyPress); // Prevent duplicate listeners
                document.addEventListener('keydown', handleKeyPress);
            }

            function resetGame() {
                snake = [
                    {x: 10, y: 10},
                    {x: 9, y: 10},
                    {x: 8, y: 10}
                ];
                dx = 1;
                dy = 0;
                score = 0;
                document.getElementById('gameScore').textContent = score;
                spawnFood();
                
                if (gameInterval) clearInterval(gameInterval);
                gameInterval = setInterval(updateGame, 100);
            }

            function spawnFood() {
                food = {
                    x: Math.floor(Math.random() * tileCount),
                    y: Math.floor(Math.random() * tileCount)
                };
                // Make sure food is not on snake
                let foodOnSnake = false;
                for (let i = 0; i < snake.length; i++) {
                    if (snake[i].x === food.x && snake[i].y === food.y) {
                        foodOnSnake = true;
                        break;
                    }
                }
                if (foodOnSnake) {
                    spawnFood();
                }
            }

            function updateGame() {
                // Move snake head
                const head = {x: snake[0].x + dx, y: snake[0].y + dy};
                
                // Check wall collision (game over) or self collision
                if (head.x < 0 || head.x >= tileCount || head.y < 0 || head.y >= tileCount || checkSelfCollision(head)) {
                    gameOver();
                    return;
                }
                
                snake.unshift(head);
                
                // Check food collision
                if (head.x === food.x && head.y === food.y) {
                    score += 10;
                    document.getElementById('gameScore').textContent = score;
                    if (score > highScore) {
                        highScore = score;
                        localStorage.setItem('snake_highscore', highScore);
                        document.getElementById('gameHighScore').textContent = highScore;
                    }
                    spawnFood();
                } else {
                    snake.pop();
                }
                
                draw();
            }

            function checkSelfCollision(head) {
                for (let i = 1; i < snake.length; i++) {
                    if (snake[i].x === head.x && snake[i].y === head.y) {
                        return true;
                    }
                }
                return false;
            }

            function draw() {
                // Clear canvas
                ctx.fillStyle = 'rgba(12, 26, 53, 0.9)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Draw grid lines subtly
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.015)';
                ctx.lineWidth = 1;
                for(let i=0; i<tileCount; i++) {
                    ctx.beginPath();
                    ctx.moveTo(i * gridSize, 0);
                    ctx.lineTo(i * gridSize, canvas.height);
                    ctx.stroke();
                    ctx.beginPath();
                    ctx.moveTo(0, i * gridSize);
                    ctx.lineTo(canvas.width, i * gridSize);
                    ctx.stroke();
                }
                
                // Draw Snake
                snake.forEach((part, index) => {
                    // Head is bright blue, body is dark blue
                    ctx.fillStyle = index === 0 ? '#60a5fa' : '#2563eb';
                    ctx.beginPath();
                    
                    const x = part.x * gridSize + 1;
                    const y = part.y * gridSize + 1;
                    const w = gridSize - 2;
                    const h = gridSize - 2;
                    const r = 4;
                    ctx.roundRect ? ctx.roundRect(x, y, w, h, r) : ctx.rect(x, y, w, h);
                    ctx.fill();
                });
                
                // Draw Food (glowing violet orb)
                ctx.fillStyle = '#a78bfa';
                ctx.shadowColor = '#a78bfa';
                ctx.shadowBlur = 8;
                ctx.beginPath();
                ctx.arc(food.x * gridSize + gridSize/2, food.y * gridSize + gridSize/2, gridSize/2 - 2, 0, Math.PI * 2);
                ctx.fill();
                ctx.shadowBlur = 0; // Reset shadow
            }

            function handleKeyPress(e) {
                // Prevent default scrolling keys
                if([32, 37, 38, 39, 40].indexOf(e.keyCode) > -1) {
                    e.preventDefault();
                }
                
                switch(e.keyCode) {
                    case 37: // Left
                    case 65: // A
                        if (dx === 0) { dx = -1; dy = 0; }
                        break;
                    case 38: // Up
                    case 87: // W
                        if (dy === 0) { dx = 0; dy = -1; }
                        break;
                    case 39: // Right
                    case 68: // D
                        if (dx === 0) { dx = 1; dy = 0; }
                        break;
                    case 40: // Down
                    case 83: // S
                        if (dy === 0) { dx = 0; dy = 1; }
                        break;
                }
            }

            function changeDir(dir) {
                switch(dir) {
                    case 'left':
                        if (dx === 0) { dx = -1; dy = 0; }
                        break;
                    case 'up':
                        if (dy === 0) { dx = 0; dy = -1; }
                        break;
                    case 'right':
                        if (dx === 0) { dx = 1; dy = 0; }
                        break;
                    case 'down':
                        if (dy === 0) { dx = 0; dy = 1; }
                        break;
                }
            }

            function gameOver() {
                clearInterval(gameInterval);
                ctx.fillStyle = 'rgba(2, 8, 23, 0.85)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                ctx.fillStyle = '#ef4444';
                ctx.font = 'bold 20px "Cabinet Grotesk", sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('FIN DEL JUEGO', canvas.width/2, canvas.height/2 - 10);
                
                ctx.fillStyle = '#ffffff';
                ctx.font = '13px "Cabinet Grotesk", sans-serif';
                ctx.fillText('Presiona el botón central para volver a intentar', canvas.width/2, canvas.height/2 + 20);
            }
        </script>
    </body>
</html>
