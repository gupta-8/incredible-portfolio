const btn = document.getElementById('getJokeBtn');
const categoryEl = document.getElementById('category');

const el = {
  setup: document.getElementById('setup'),
  delivery: document.getElementById('delivery'),
  single: document.getElementById('single'),
  status: document.getElementById('status'),
};

function showStatus(msg) {
  el.status.hidden = false;
  el.status.textContent = msg;
  el.single.hidden = el.setup.hidden = el.delivery.hidden = true;
}

function showSingle(text) {
  el.single.textContent = text;
  el.single.hidden = false;
  el.setup.hidden = el.delivery.hidden = true;
  el.status.hidden = true;
}

function showTwoPart(setup, delivery) {
  el.setup.textContent = setup;
  el.delivery.textContent = delivery;
  el.setup.hidden = el.delivery.hidden = false;
  el.single.hidden = true;
  el.status.hidden = true;
}

async function getJoke() {
  const category = categoryEl.value || 'Any';
  // Safe-mode filters out NSFW/sexist/racist etc.
  const url =
    `https://v2.jokeapi.dev/joke/${encodeURIComponent(category)}?safe-mode`;

  try {
    showStatus('Loading a fresh joke…');
    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
    if (!res.ok) throw new Error(`API error ${res.status}`);
    const data = await res.json();

    if (data.error) throw new Error(data.message || 'API error');

    if (data.type === 'single') {
      showSingle(data.joke);
    } else if (data.type === 'twopart') {
      showTwoPart(data.setup, data.delivery);
    } else {
      showStatus('Unexpected response. Try again.');
    }
  } catch (err) {
    console.error(err);
    showStatus('Couldn’t fetch a joke. Check your connection and try again.');
  }
}

btn.addEventListener('click', getJoke);
