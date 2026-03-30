(function () {
    'use strict';

    if (!window.gtfGame) {
        return;
    }

    var maxAttempts = gtfGame.maxAttempts || 5;
    var blurLevels = gtfGame.blurLevels || [20, 15, 10, 5, 0];

    var storageKeys = {
        game: 'gtf_current_game',
        stats: 'gtf_stats'
    };

    var elements = {
        root: document.getElementById('gtf-game'),
        image: document.getElementById('gtf-player-image'),
        form: document.getElementById('gtf-guess-form'),
        input: document.getElementById('gtf-guess-input'),
        message: document.getElementById('gtf-message'),
        streak: document.getElementById('gtf-streak-count'),
        newGame: document.getElementById('gtf-new-game')
    };

    if (!elements.root) {
        return;
    }

    var state = {
        footballerId: null,
        photoUrl: '',
        attempts: 0,
        guesses: [],
        completed: false,
        won: false
    };

    var stats = {
        current_streak: 0,
        total_games: 0,
        total_wins: 0
    };

    function loadStorage(key, fallback) {
        if (!window.localStorage) {
            return fallback;
        }
        try {
            var value = localStorage.getItem(key);
            return value ? JSON.parse(value) : fallback;
        } catch (e) {
            return fallback;
        }
    }

    function saveStorage(key, value) {
        if (!window.localStorage) {
            return;
        }
        localStorage.setItem(key, JSON.stringify(value));
    }

    function setMessage(text, type) {
        elements.message.textContent = text || '';
        elements.message.classList.remove('is-wrong', 'is-correct');
        if (type === 'wrong') {
            elements.message.classList.add('is-wrong');
        }
        if (type === 'correct') {
            elements.message.classList.add('is-correct');
        }
    }

    function updateStreak() {
        elements.streak.textContent = stats.current_streak || 0;
    }

    function setBlur(level) {
        if (!elements.image) {
            return;
        }
        elements.image.style.filter = 'blur(' + level + 'px)';
    }

    function renderGuessRow(row, guess, status) {
        var container = row.querySelector('.gtf-attempt-boxes');
        if (!container) {
            return;
        }

        container.innerHTML = '';
        var letters = guess ? guess.split('') : [];
        var maxBoxes = Math.max(letters.length, 5);

        for (var i = 0; i < maxBoxes; i++) {
            var box = document.createElement('span');
            box.className = 'gtf-letter-box';
            var char = letters[i] || '';
            if (char === ' ') {
                box.textContent = '•';
                box.classList.add('is-space');
            } else {
                box.textContent = char ? char.toUpperCase() : '';
            }
            container.appendChild(box);
        }

        row.classList.remove('is-wrong', 'is-correct', 'is-active');
        if (status === 'wrong') {
            row.classList.add('is-wrong');
        }
        if (status === 'correct') {
            row.classList.add('is-correct');
        }
    }

    function renderAttempts() {
        var rows = elements.root.querySelectorAll('.gtf-attempt-row');
        rows.forEach(function (row, index) {
            var guess = state.guesses[index] || '';
            var status = '';
            if (state.completed && state.won && index === state.attempts - 1) {
                status = 'correct';
            } else if (guess) {
                status = 'wrong';
            }
            renderGuessRow(row, guess, status);
        });

        setActiveRow();
    }

    function setActiveRow() {
        var rows = elements.root.querySelectorAll('.gtf-attempt-row');
        rows.forEach(function (row, index) {
            if (!state.completed && index === state.attempts) {
                row.classList.add('is-active');
            } else {
                row.classList.remove('is-active');
            }
        });
    }

    function setFormDisabled(disabled) {
        elements.input.disabled = disabled;
        elements.form.querySelector('button').disabled = disabled;
    }

    function saveGameState() {
        saveStorage(storageKeys.game, {
            footballer_id: state.footballerId,
            photo_url: state.photoUrl,
            attempts: state.attempts,
            guesses: state.guesses,
            is_completed: state.completed,
            is_won: state.won
        });
    }

    function startNewGame() {
        setMessage('', '');
        setFormDisabled(true);

        fetch(gtfGame.ajaxUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
            body: new URLSearchParams({
                action: 'get_random_footballer',
                nonce: gtfGame.nonce
            })
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (!data || !data.success) {
                    throw new Error();
                }

                state.footballerId = data.data.id;
                state.photoUrl = data.data.photo_url;
                state.attempts = 0;
                state.guesses = [];
                state.completed = false;
                state.won = false;

                elements.image.src = state.photoUrl;
                elements.image.alt = '';
                setBlur(blurLevels[0]);
                renderAttempts();
                setFormDisabled(false);
                elements.input.focus();
                saveGameState();
            })
            .catch(function () {
                setMessage(gtfGame.strings.loadError, 'wrong');
                setFormDisabled(false);
            });
    }

    function handleGuess(guess) {
        if (state.completed || state.attempts >= maxAttempts) {
            return;
        }

        setFormDisabled(true);

        fetch(gtfGame.ajaxUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
            body: new URLSearchParams({
                action: 'validate_guess',
                nonce: gtfGame.nonce,
                footballer_id: state.footballerId,
                guess: guess
            })
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (!data || !data.success) {
                    throw new Error();
                }

                state.attempts += 1;
                state.guesses.push(guess);

                if (data.data.is_correct) {
                    state.completed = true;
                    state.won = true;
                    stats.current_streak += 1;
                    stats.total_wins += 1;
                    stats.total_games += 1;
                    setMessage(gtfGame.strings.correctGuess + ' ' + data.data.correct_name, 'correct');
                    setBlur(0);
                } else if (state.attempts >= maxAttempts) {
                    state.completed = true;
                    state.won = false;
                    stats.current_streak = 0;
                    stats.total_games += 1;
                    setMessage(gtfGame.strings.gameOver + ' ' + data.data.correct_name, 'wrong');
                    setBlur(0);
                } else {
                    setMessage(gtfGame.strings.wrongGuess, 'wrong');
                    var blurIndex = Math.min(state.attempts, blurLevels.length - 1);
                    setBlur(blurLevels[blurIndex]);
                }

                renderAttempts();
                updateStreak();
                saveGameState();
                saveStorage(storageKeys.stats, stats);
                setFormDisabled(state.completed);
                if (!state.completed) {
                    elements.input.focus();
                }
            })
            .catch(function () {
                setMessage(gtfGame.strings.loadError, 'wrong');
                setFormDisabled(false);
            });
    }

    function restoreState() {
        stats = loadStorage(storageKeys.stats, stats);
        updateStreak();

        var saved = loadStorage(storageKeys.game, null);
        if (saved && saved.footballer_id && saved.photo_url) {
            state.footballerId = saved.footballer_id;
            state.photoUrl = saved.photo_url;
            state.attempts = saved.attempts || 0;
            state.guesses = saved.guesses || [];
            state.completed = !!saved.is_completed;
            state.won = !!saved.is_won;

            elements.image.src = state.photoUrl;
            setBlur(state.completed ? 0 : blurLevels[Math.min(state.attempts, blurLevels.length - 1)]);
            renderAttempts();
            setFormDisabled(state.completed);
            if (!state.completed) {
                elements.input.focus();
            }
            return;
        }

        startNewGame();
    }

    elements.form.addEventListener('submit', function (event) {
        event.preventDefault();
        var guess = elements.input.value.trim();
        if (!guess) {
            setMessage(gtfGame.strings.missingGuess, 'wrong');
            return;
        }
        elements.input.value = '';
        handleGuess(guess);
    });

    elements.newGame.addEventListener('click', function () {
        stats.current_streak = state.won ? stats.current_streak : 0;
        saveStorage(storageKeys.stats, stats);
        updateStreak();
        startNewGame();
    });

    restoreState();
})();