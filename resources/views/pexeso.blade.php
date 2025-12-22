<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vánoční pexeso</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .game-container {
            text-align: center;
            max-width: 900px;
            width: 100%;
        }

        h1 {
            color: white;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            background: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }

        .btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
            transform: none;
        }

        .game-info {
            display: flex;
            justify-content: center;
            gap: 40px;
            align-items: center;
            background: rgba(255,255,255,0.9);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }

        .timer, .moves, .matches {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .game-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
            padding: 20px;
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .memory-card {
            width: 100px;
            height: 100px;
            position: relative;
            cursor: pointer;
            perspective: 1000px;
        }

        .card-inner {
            position: absolute;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            border-radius: 10px;
        }

        .memory-card.flipped .card-inner {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .card-front {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .card-back {
            transform: rotateY(180deg);
            background-size: cover;
            background-position: center;
            border: 3px solid white;
        }

        .memory-card.matched .card-inner {
            transform: rotateY(180deg);
        }

        .memory-card.matched {
            opacity: 0.7;
        }

        .memory-card.matched .card-back {
            border-color: #4CAF50;
            box-shadow: 0 0 15px rgba(76, 175, 80, 0.5);
        }

        .celebration-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.5s ease-in-out;
        }

        .celebration-modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            max-width: 90vw;
            max-height: 90vh;
            overflow: auto;
            position: relative;
            animation: slideIn 0.5s ease-in-out;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .close-modal:hover {
            background: #f0f0f0;
        }

        .celebration-title {
            font-size: 32px;
            margin-bottom: 20px;
            color: #4CAF50;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .reconstructed-image {
            max-width: 500px;
            max-height: 400px;
            border: 5px solid #4CAF50;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            animation: imageReveal 1s ease-in-out;
        }

        .celebration-stats {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 16px;
            color: #333;
        }

        .fireworks {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .firework {
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #FFD700;
            animation: fireworkAnimation 1.5s ease-out infinite;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #ff6b6b;
            animation: confettiAnimation 3s ease-in-out infinite;
        }

        .welcome-screen {
            background: rgba(255,255,255,0.9);
            padding: 40px;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .welcome-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .welcome-description {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .laravel-badge {
            background: #FF2D20;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes imageReveal {
            from {
                opacity: 0;
                transform: scale(0.8) rotate(-5deg);
            }
            to {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }

        @keyframes fireworkAnimation {
            0% {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) scale(0);
                opacity: 0;
            }
        }

        @keyframes confettiAnimation {
            0% {
                transform: translateY(-100px) rotateZ(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotateZ(720deg);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            .memory-card {
                width: 80px;
                height: 80px;
            }

            .game-info {
                flex-direction: column;
                gap: 15px;
            }

            .modal-content {
                padding: 20px;
                margin: 10px;
            }

            .celebration-title {
                font-size: 24px;
            }

            .reconstructed-image {
                max-width: 300px;
                max-height: 250px;
            }

            .game-grid {
                gap: 8px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <h1>🎴 Vánoční hra <span class="laravel-badge">Z lásky vytvořeno</span></h1>

        <div class="welcome-screen" id="welcomeScreen">
            <div class="welcome-title">Není to zadarno, je potřeba trochu zahřát 🧠 a odhalit,
                co si pro tebe ježíšek připravil</div>
            <button class="btn" id="newGameBtn">🎯 Začni novou hru</button>
        </div>

        <div class="game-info" id="gameInfo">
            <div class="timer">⏱️ Čas: <span id="timeDisplay">00:00</span></div>
            <div class="moves">🔄 Otočení: <span id="flipCount">0</span></div>
            <div class="matches">✅ Párů: <span id="matchCount">0</span>/<span id="totalPairs">18</span></div>
        </div>

        <div class="game-grid" id="gameGrid"></div>
    </div>

    <!-- Celebration Modal -->
    <div class="celebration-modal" id="celebrationModal">
        <div class="fireworks" id="fireworks"></div>
        <div class="modal-content">
            <button class="close-modal" id="closeModal">×</button>
            <div class="celebration-title">🎉 Šťastné a veselé vánoce! 🎉</div>
            <p style="font-size: 18px; color: #666; margin-bottom: 20px;">Je na čase si užít trochu odpočinku!</p>
            <img class="reconstructed-image" id="reconstructedImage" alt="Your completed picture">
            <!--<button class="btn" onclick="game.startNewGame()" style="margin-top: 20px; font-size: 18px; padding: 15px 30px;">🎯 Play Again!</button> -->
        </div>
    </div>

    <script>
        class PexesoGame {
            constructor() {
                this.gridCols = 6;
                this.gridRows = 6;
                this.totalPairs = 18;
                this.cards = [];
                this.flippedCards = [];
                this.matchedPairs = 0;
                this.flips = 0;
                this.startTime = null;
                this.timerInterval = null;
                this.gameActive = false;
                this.image = null;
                this.canFlip = true;

                this.initEventListeners();
                this.loadImage();
            }

            initEventListeners() {
                const newGameButton = document.getElementById('newGameBtn');
                newGameButton.addEventListener('click', this.startNewGame.bind(this));

                document.getElementById('closeModal').onclick = () => {
                    document.getElementById('celebrationModal').classList.remove('show');
                    this.clearEffects();
                };
            }

            loadImage() {
                const img = new Image();
                img.onload = () => {
                    this.image = img;
                    console.log('Image loaded successfully from Laravel storage');
                };
                img.onerror = () => {
                    console.error('Failed to load image from Laravel storage');
                    document.querySelector('.welcome-description').innerHTML = `
                        ❌ <strong>Error: Game image not found!</strong><br>
                        Please ensure the game image is properly uploaded to Laravel storage.<br>
                        Contact administrator to upload the game image.
                    `;
                    document.getElementById('newGameBtn').disabled = true;
                };
                // Use Laravel asset helper for the image path
                img.src = '{{ asset("storage/game-image.png") }}';
            }

            startNewGame() {
                if (!this.image) {
                    alert('Image is still loading. Please wait a moment and try again.');
                    return;
                }

                document.getElementById('welcomeScreen').style.display = 'none';
                document.getElementById('gameInfo').style.display = 'flex';
                document.getElementById('celebrationModal').classList.remove('show');

                this.initializeGame();
                this.createCards();
                this.shuffleCards();
                this.renderCards();
            }

            initializeGame() {
                this.cards = [];
                this.flippedCards = [];
                this.matchedPairs = 0;
                this.flips = 0;
                this.gameActive = true;
                this.canFlip = true;

                document.getElementById('matchCount').textContent = '0';
                document.getElementById('flipCount').textContent = '0';

                this.startTimer();
            }

            createCards() {
                const pieceWidth = this.image.width / this.gridCols;
                const pieceHeight = this.image.height / this.gridRows;

                for (let i = 0; i < this.totalPairs; i++) {
                    const row = Math.floor(i / (this.gridCols / 2));
                    const col = (i % (this.gridCols / 2)) * 2;

                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = 100;
                    canvas.height = 100;

                    const sourceX = col * pieceWidth / 2;
                    const sourceY = row * pieceHeight;
                    const sourceWidth = pieceWidth;
                    const sourceHeight = pieceHeight;

                    ctx.drawImage(
                        this.image,
                        sourceX, sourceY, sourceWidth, sourceHeight,
                        0, 0, 100, 100
                    );

                    const imageData = canvas.toDataURL();

                    this.cards.push({
                        id: i,
                        imageData: imageData,
                        matched: false
                    });

                    this.cards.push({
                        id: i,
                        imageData: imageData,
                        matched: false
                    });
                }
            }

            shuffleCards() {
                for (let i = this.cards.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [this.cards[i], this.cards[j]] = [this.cards[j], this.cards[i]];
                }
            }

            renderCards() {
                const grid = document.getElementById('gameGrid');
                grid.innerHTML = '';

                this.cards.forEach((card, index) => {
                    const cardElement = document.createElement('div');
                    cardElement.className = 'memory-card';
                    cardElement.dataset.index = index;
                    cardElement.dataset.cardId = card.id;

                    cardElement.innerHTML = `
                        <div class="card-inner">
                            <div class="card-front">?</div>
                            <div class="card-back" style="background-image: url(${card.imageData})"></div>
                        </div>
                    `;

                    cardElement.addEventListener('click', this.handleCardClick.bind(this));
                    grid.appendChild(cardElement);
                });
            }

            handleCardClick(e) {
                if (!this.gameActive || !this.canFlip) return;

                const cardElement = e.currentTarget;
                const cardIndex = parseInt(cardElement.dataset.index);

                if (cardElement.classList.contains('flipped') || cardElement.classList.contains('matched')) {
                    return;
                }

                this.flipCard(cardElement, cardIndex);
            }

            flipCard(cardElement, cardIndex) {
                cardElement.classList.add('flipped');
                this.flippedCards.push({ element: cardElement, index: cardIndex });
                this.flips++;
                document.getElementById('flipCount').textContent = this.flips;

                if (this.flippedCards.length === 2) {
                    this.canFlip = false;
                    setTimeout(() => this.checkMatch(), 1000);
                }
            }

            checkMatch() {
                const [card1, card2] = this.flippedCards;
                const cardId1 = parseInt(card1.element.dataset.cardId);
                const cardId2 = parseInt(card2.element.dataset.cardId);

                if (cardId1 === cardId2) {
                    card1.element.classList.add('matched');
                    card2.element.classList.add('matched');
                    this.cards[card1.index].matched = true;
                    this.cards[card2.index].matched = true;
                    this.matchedPairs++;
                    document.getElementById('matchCount').textContent = this.matchedPairs;

                    if (this.matchedPairs === this.totalPairs) {
                        this.gameWon();
                    }
                } else {
                    card1.element.classList.remove('flipped');
                    card2.element.classList.remove('flipped');
                }

                this.flippedCards = [];
                this.canFlip = true;
            }

            startTimer() {
                this.startTime = Date.now();
                this.timerInterval = setInterval(() => {
                    if (this.gameActive) {
                        const elapsed = Math.floor((Date.now() - this.startTime) / 1000);
                        const minutes = Math.floor(elapsed / 60).toString().padStart(2, '0');
                        const seconds = (elapsed % 60).toString().padStart(2, '0');
                        document.getElementById('timeDisplay').textContent = `${minutes}:${seconds}`;
                    }
                }, 1000);
            }

            gameWon() {
                this.gameActive = false;
                clearInterval(this.timerInterval);

                const timeText = document.getElementById('timeDisplay').textContent;

                setTimeout(() => {
                    this.showCelebrationModal(timeText);
                }, 500);
            }

            showCelebrationModal(timeText) {
                const modal = document.getElementById('celebrationModal');
                const reconstructedImage = document.getElementById('reconstructedImage');

                reconstructedImage.src = this.image.src;
                modal.classList.add('show');
                this.createFireworks();
                this.createConfetti();
            }

            createFireworks() {
                const fireworksContainer = document.getElementById('fireworks');
                fireworksContainer.innerHTML = '';

                for (let i = 0; i < 15; i++) {
                    setTimeout(() => {
                        const firework = document.createElement('div');
                        firework.className = 'firework';
                        firework.style.left = Math.random() * 100 + '%';
                        firework.style.bottom = '0px';
                        firework.style.background = this.getRandomColor();
                        firework.style.animationDelay = Math.random() * 0.5 + 's';
                        fireworksContainer.appendChild(firework);

                        setTimeout(() => firework.remove(), 1500);
                    }, i * 100);
                }
            }

            createConfetti() {
                const fireworksContainer = document.getElementById('fireworks');

                for (let i = 0; i < 25; i++) {
                    setTimeout(() => {
                        const confetti = document.createElement('div');
                        confetti.className = 'confetti';
                        confetti.style.left = Math.random() * 100 + '%';
                        confetti.style.top = '-10px';
                        confetti.style.background = this.getRandomColor();
                        confetti.style.animationDelay = Math.random() * 1 + 's';
                        confetti.style.animationDuration = (2 + Math.random() * 2) + 's';
                        fireworksContainer.appendChild(confetti);

                        setTimeout(() => confetti.remove(), 5000);
                    }, i * 50);
                }
            }

            getRandomColor() {
                const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57', '#ff9ff3', '#54a0ff', '#5f27cd'];
                return colors[Math.floor(Math.random() * colors.length)];
            }

            clearEffects() {
                const fireworksContainer = document.getElementById('fireworks');
                fireworksContainer.innerHTML = '';
            }
        }

        let game;
        document.addEventListener('DOMContentLoaded', () => {
            game = new PexesoGame();
        });
    </script>
</body>
</html>
