const gameContent = document.getElementById('game-content');

function replaceGameContent(html, transition) {
    if (transition === 'none') {
        gameContent.classList.remove('is-switching');
        gameContent.innerHTML = html;
        return;
    }

    gameContent.classList.add('is-switching');

    window.setTimeout(() => {
        gameContent.innerHTML = html;

        requestAnimationFrame(() => {
            gameContent.classList.remove('is-switching');
        });
    }, 180);
}

async function submitGameForm(form) {
    const submitButton = form.querySelector('button');
    const formData = new FormData(form);
    const transition = form.dataset.transition || 'full';

    if (submitButton) {
        submitButton.disabled = true;
    }

    try {
        const response = await fetch(form.action, {
            method: form.method || 'POST',
            body: formData,
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        if (!response.ok) {
            throw new Error('Game request failed.');
        }

        const data = await response.json();

        replaceGameContent(data.html, transition);
    } catch (error) {
        if (submitButton) {
            submitButton.disabled = false;
        }

        console.error(error);
    }
}

async function resetGame(link) {
    try {
        const response = await fetch(link.href, {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        if (!response.ok) {
            throw new Error('Reset request failed.');
        }

        const data = await response.json();

        replaceGameContent(data.html, 'full');
    } catch (error) {
        console.error(error);
        window.location.href = link.href;
    }
}

if (gameContent) {
    gameContent.addEventListener('submit', (event) => {
        const form = event.target.closest('[data-game-form]');

        if (!form) {
            return;
        }

        event.preventDefault();
        submitGameForm(form);
    });
}

document.addEventListener('click', (event) => {
    const resetLink = event.target.closest('[data-reset-game]');

    if (!resetLink || !gameContent) {
        return;
    }

    event.preventDefault();
    resetGame(resetLink);
});
