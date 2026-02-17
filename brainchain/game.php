<?php
require "config.php";
require_login();
$username = $_SESSION["username"];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>BrainChain – Game</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
  :root {
    --bg1: #020617;
    --bg2: #002b36;
    --bg3: #0f172a;
    --accent: #0ea5e9;        /* cyan/blue */
    --accent-soft: rgba(14, 165, 233, 0.18);
    --muted: #9ca3af;
    --panel: rgba(15, 23, 42, 0.94);
  }

  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    min-height: 100vh;
    max-height: 100vh;
    overflow: hidden;
    display: flex;
    align-items: stretch;
    justify-content: stretch;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: #e5e7eb;

    /* Same background image as index/login, no pulsing animation */
    background:
      linear-gradient(rgba(0,0,0,0.68), rgba(0,0,0,0.85)),
      url('https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d')
      no-repeat center center fixed;
    background-size: cover;
  }

  .shell {
    width: 100vw;
    height: 100vh;
    padding: 1.5rem 2.4rem;
    display: flex;
    flex-direction: column;
    border-radius: 0;
    background: radial-gradient(circle at top left, rgba(148, 163, 184, 0.06), var(--panel));
    border-top: 1px solid rgba(148, 163, 184, 0.25);
    border-left: 1px solid rgba(148, 163, 184, 0.2);
    box-shadow: 0 18px 50px rgba(15, 23, 42, 0.9);
  }

  @media (max-width: 900px) {
    .shell {
      padding: 1.2rem 1.2rem 1.4rem;
    }
  }

  .top-row {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 0.8rem;
  }

  /* new: wrapper for user & logout on right */
  .top-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
  }

  h1 {
    margin: 0;
    font-size: 1.6rem;
    letter-spacing: 0.04em;
  }

  .subtitle {
    font-size: 0.85rem;
    color: var(--muted);
    margin-top: 0.2rem;
  }

  .user-pill {
    font-size: 0.8rem;
    padding: 0.3rem 0.9rem;
    border-radius: 999px;
    border: 1px solid rgba(148, 163, 184, 0.75);
    background: rgba(15, 23, 42, 0.92);
    display: flex;
    align-items: center;
    gap: 0.3rem;
    box-shadow: 0 0 10px rgba(56, 189, 248, 0.25); /* reduced glow */
  }

  .user-pill::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 999px;
    background: #22c55e;
    box-shadow: 0 0 8px rgba(34, 197, 94, 0.8);
  }

  .main-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.65fr) minmax(260px, 1fr);
    gap: 1.3rem;
    flex: 1;
    min-height: 0;
  }

  @media (max-width: 900px) {
    .main-layout {
      grid-template-columns: minmax(0, 1fr);
    }
  }

  .left-col,
  .right-col {
    border-radius: 18px;
    padding: 0.9rem 1.1rem;
    background: radial-gradient(circle at top left, rgba(148, 163, 184, 0.08), rgba(15, 23, 42, 0.98));
    border: 1px solid rgba(148, 163, 184, 0.35);
    display: flex;
    flex-direction: column;
    min-height: 0;
    position: relative;
    overflow: hidden;
  }

  .left-col::before,
  .right-col::before {
    content: "";
    position: absolute;
    inset: -40px;
    background: radial-gradient(circle at top, var(--accent-soft), transparent 65%);
    opacity: 0.35; /* reduced glow a lot */
    pointer-events: none;
  }

  .card-inner {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 0;
  }

  .stat-row {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.7rem;
    margin: 0.2rem 0 0.8rem;
  }

  @media (max-width: 700px) {
    .stat-row {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  .stat-box {
    border-radius: 999px;
    background: rgba(15, 23, 42, 0.96);
    border: 1px solid rgba(148, 163, 184, 0.45);
    padding: 0.45rem 0.75rem;
    font-size: 0.8rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .label {
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    font-size: 0.7rem;
  }

  .value {
    font-weight: 600;
  }

  .value.gold {
    color: #facc15;
  }

  .value.green {
    color: #4ade80;
  }

  .current-word-box {
    border-radius: 16px;
    border: 1px solid rgba(148, 163, 184, 0.55);
    padding: 0.8rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.9rem;
    background: rgba(15, 23, 42, 0.97);
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.7); /* reduced */
  }

  .current-word-label {
    font-size: 0.75rem;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.15em;
    margin-bottom: 0.15rem;
  }

  .current-word {
    font-size: 1.35rem;
    font-weight: 700;
    text-transform: capitalize;
    letter-spacing: 0.06em;
  }

  .hint-pill {
    font-size: 0.75rem;
    padding: 0.25rem 0.8rem;
    border-radius: 999px;
    border: 1px solid rgba(56, 189, 248, 0.7);
    background: rgba(15, 118, 110, 0.25);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #e0f2fe;
  }

  .input-row {
    display: flex;
    gap: 0.6rem;
    margin-bottom: 0.25rem;
  }

  .input-row input {
    flex: 1;
    padding: 0.6rem 0.8rem;
    border-radius: 999px;
    border: 1px solid rgba(148, 163, 184, 0.6);
    background: rgba(15, 23, 42, 0.98);
    color: #e5e7eb;
    outline: none;
    font-size: 0.9rem;
    transition: border 0.18s ease, box-shadow 0.18s ease, transform 0.12s ease;
  }

  .input-row input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 1px var(--accent);
    transform: translateY(-1px);
  }

  .small-hint {
    font-size: 0.78rem;
    color: var(--muted);
    margin-bottom: 0.6rem;
  }

  .btn {
    border-radius: 999px;
    border: none;
    cursor: pointer;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 0.6rem 1rem;
    transition: transform 0.12s ease, box-shadow 0.12s ease, background 0.15s ease, opacity 0.15s ease;
  }

  .btn-primary {
    background: linear-gradient(135deg, #0ea5e9, #2563eb);
    color: #f9fafb;
    box-shadow: 0 7px 20px rgba(37, 99, 235, 0.65); /* reduced */
  }

  .btn-primary:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 10px 26px rgba(37, 99, 235, 0.85);
  }

  .btn-primary:disabled {
    opacity: 0.55;
    box-shadow: none;
    cursor: not-allowed;
  }

  .btn-ghost {
    background: rgba(15, 23, 42, 0.96);
    color: var(--muted);
    border: 1px solid rgba(148, 163, 184, 0.7);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .btn-ghost:hover {
    transform: translateY(-1px);
    border-color: rgba(209, 213, 219, 0.9);
  }

  .controls-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.7rem;
    margin: 0.6rem 0 0.4rem;
    flex-wrap: wrap;
  }

  .controls-row-left {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .chain-box {
    border-radius: 14px;
    border: 1px dashed rgba(148, 163, 184, 0.6);
    padding: 0.6rem;
    margin-top: 0.4rem;
    max-height: 150px;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    background: rgba(15, 23, 42, 0.96);
  }

  .chain-strip {
    display: inline-flex;
    gap: 0.5rem;
    align-items: center;
  }

  .bubble {
    padding: 0.3rem 0.7rem;
    border-radius: 999px;
    border: 1px solid rgba(59, 130, 246, 0.9);
    background: rgba(15, 118, 110, 0.82);
    font-size: 0.8rem;
    box-shadow: 0 6px 14px rgba(15, 118, 110, 0.7); /* reduced */
  }

  .bubble span {
    margin-left: 0.35rem;
    font-size: 0.7rem;
    opacity: 0.9;
  }

  .arrow {
    width: 20px;
    height: 1px;
    background: linear-gradient(to right, rgba(148, 163, 184, 0.4), rgba(56, 189, 248, 0.9));
    position: relative;
  }

  .arrow::after {
    content: "";
    position: absolute;
    right: -3px;
    top: -2px;
    border-left: 5px solid rgba(56, 189, 248, 0.9);
    border-top: 3px solid transparent;
    border-bottom: 3px solid transparent;
  }

  .empty-chain {
    font-size: 0.8rem;
    color: var(--muted);
  }

  .meter-row {
    margin-top: 0.7rem;
    font-size: 0.8rem;
  }

  .meter-bar {
    width: 100%;
    height: 8px;
    border-radius: 999px;
    background: rgba(15, 23, 42, 0.92);
    margin-top: 0.25rem;
    overflow: hidden;
    position: relative;
  }

  .meter-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #22c55e, #a3e635, #eab308);
    transition: width 0.25s ease;
  }

  .log {
    margin-top: 0.6rem;
    max-height: 120px;
    overflow-y: auto;
    font-size: 0.78rem;
    color: var(--muted);
    padding-right: 0.2rem;
  }

  .log div {
    padding: 0.08rem 0;
  }

  .msg-banner {
    margin-top: 0.5rem;
    padding: 0.5rem 0.7rem;
    border-radius: 12px;
    border: 1px solid rgba(148, 163, 184, 0.6);
    font-size: 0.8rem;
    display: none;
    background: rgba(15, 23, 42, 0.96);
  }

  .msg-good {
    border-color: #22c55e;
  }

  .msg-bad {
    border-color: #f97373;
  }

  .leaderboard {
    margin-top: 0.3rem;
    font-size: 0.8rem;
  }

  .leaderboard-title {
    font-weight: 600;
    margin-bottom: 0.3rem;
  }

  .leaderboard table {
    width: 100%;
    border-collapse: collapse;
  }

  .leaderboard th,
  .leaderboard td {
    border-bottom: 1px solid rgba(55, 65, 81, 0.7);
    padding: 0.3rem;
    text-align: left;
  }

  .leaderboard th {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--muted);
  }

  .right-col-scroll {
    margin-top: 0.3rem;
    overflow-y: auto;
    flex: 1;
    min-height: 0;
    padding-right: 0.15rem;
  }
</style>

</head>
<body>
<div class="shell">
  <div class="top-row">
    <div>
      <h1>BrainChain</h1>
      <div class="subtitle">Connect words fast. Train your creative associations.</div>
    </div>
    <div class="top-right">
      <div class="user-pill">
        Logged in as <strong><?php echo htmlspecialchars($username); ?></strong>
      </div>
      <a href="logout.php" class="btn btn-ghost">Logout</a>
    </div>
  </div>

  <div class="main-layout">
    <!-- LEFT: gameplay -->
    <div class="left-col">
      <div class="card-inner">
        <div class="stat-row">
          <div class="stat-box">
            <span class="label">Score</span>
            <span id="scoreDisplay" class="value gold">0</span>
          </div>
          <div class="stat-box">
            <span class="label">Chain</span>
            <span id="chainLengthDisplay" class="value">0</span>
          </div>
          <div class="stat-box">
            <span class="label">Best streak</span>
            <span id="bestStreakDisplay" class="value green">0</span>
          </div>
          <div class="stat-box">
            <span class="label">Time</span>
            <span id="timerDisplay" class="value">30s</span>
          </div>
        </div>

        <div class="current-word-box">
          <div>
            <div class="current-word-label">Current prompt</div>
            <div id="currentWordDisplay" class="current-word">—</div>
          </div>
          <div class="hint-pill">Objects · Places · Feelings</div>
        </div>

        <div class="input-row">
          <input id="wordInput" type="text" placeholder="Example: ocean → waves" disabled>
          <button id="submitBtn" class="btn btn-primary" disabled>Submit</button>
        </div>
        <div class="small-hint">Press Enter or click Submit. No duplicates allowed.</div>

        <div class="controls-row">
          <div class="controls-row-left">
            <button id="startBtn" class="btn btn-primary">Start Round</button>
            <button id="resetBtn" class="btn btn-ghost">Reset Stats</button>
          </div>
          <div style="font-size:0.8rem;color:#9ca3af;">Round length: <strong>30s</strong></div>
        </div>

        <div class="msg-banner" id="msgBanner"></div>

        <div class="chain-box">
          <div class="chain-strip" id="chainStrip">
            <div class="empty-chain">Start a round to see your thought bubbles here.</div>
          </div>
        </div>

        <div class="meter-row">
          Creative Thinking Meter: <span id="creativityText">0%</span>
          <div class="meter-bar">
            <div class="meter-fill" id="meterFill"></div>
          </div>
        </div>

        <div class="log" id="logArea"></div>
      </div>
    </div>

    <!-- RIGHT: leaderboard & info -->
    <div class="right-col">
      <div class="card-inner">
        <div class="leaderboard">
          <div class="leaderboard-title">Top Players</div>
          <div id="leaderboardContainer" style="font-size:0.78rem;color:#9ca3af;">
            Loading leaderboard...
          </div>
        </div>
        <div class="right-col-scroll">
          <!-- extra info / tips if needed -->
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const startBtn = document.getElementById("startBtn");
  const resetBtn = document.getElementById("resetBtn");
  const submitBtn = document.getElementById("submitBtn");
  const wordInput = document.getElementById("wordInput");
  const scoreDisplay = document.getElementById("scoreDisplay");
  const chainLengthDisplay = document.getElementById("chainLengthDisplay");
  const bestStreakDisplay = document.getElementById("bestStreakDisplay");
  const timerDisplay = document.getElementById("timerDisplay");
  const currentWordDisplay = document.getElementById("currentWordDisplay");
  const chainStrip = document.getElementById("chainStrip");
  const creativityText = document.getElementById("creativityText");
  const meterFill = document.getElementById("meterFill");
  const logArea = document.getElementById("logArea");
  const msgBanner = document.getElementById("msgBanner");
  const leaderboardContainer = document.getElementById("leaderboardContainer");

  let currentWord = null;
  let chain = [];
  let score = 0;
  let bestStreak = 0;
  let currentStreak = 0;
  let timeLeft = 30;
  let roundActive = false;
  let timerId = null;

  function renderChain() {
    chainStrip.innerHTML = "";
    if (chain.length === 0) {
      const div = document.createElement("div");
      div.className = "empty-chain";
      div.textContent = "Start a round to see your thought bubbles here.";
      chainStrip.appendChild(div);
      return;
    }
    chain.forEach((w, i) => {
      const bubble = document.createElement("div");
      bubble.className = "bubble";
      bubble.textContent = w;
      const span = document.createElement("span");
      span.textContent = "#" + (i+1);
      bubble.appendChild(span);
      chainStrip.appendChild(bubble);
      if (i !== chain.length - 1) {
        const arrow = document.createElement("div");
        arrow.className = "arrow";
        chainStrip.appendChild(arrow);
      }
    });
    chainStrip.parentElement.scrollLeft = chainStrip.parentElement.scrollWidth;
  }

  function logLine(html) {
    const div = document.createElement("div");
    div.innerHTML = "• " + html;
    logArea.appendChild(div);
    logArea.scrollTop = logArea.scrollHeight;
  }

  function updateMeter() {
    const percent = computeCreativityPercent();
    creativityText.textContent = percent + "%";
    meterFill.style.width = percent + "%";
  }

  function computeCreativityPercent() {
    if (chain.length === 0) return 0;
    const uniqueCount = new Set(chain.map(w => w.toLowerCase())).size;
    const avgLen = chain.reduce((s,w)=>s+w.length,0) / chain.length;
    let val = uniqueCount * 8 + avgLen * 4;
    if (val > 100) val = 100;
    return Math.round(val);
  }

  function showMessage(text, good=true) {
    msgBanner.style.display = "block";
    msgBanner.textContent = text;
    msgBanner.className = "msg-banner " + (good ? "msg-good" : "msg-bad");
  }

  function clearMessage() {
    msgBanner.style.display = "none";
  }

  function resetRoundState() {
    chain = [];
    currentStreak = 0;
    timeLeft = 30;
    roundActive = false;
    currentWord = null;
    timerDisplay.textContent = "30s";
    currentWordDisplay.textContent = "—";
    wordInput.value = "";
    wordInput.disabled = true;
    submitBtn.disabled = true;
    clearInterval(timerId);
    timerId = null;
    renderChain();
    logArea.innerHTML = "";
    clearMessage();
    updateMeter();
  }

  function resetAll() {
    resetRoundState();
    score = 0;
    bestStreak = 0;
    scoreDisplay.textContent = "0";
    bestStreakDisplay.textContent = "0";
    chainLengthDisplay.textContent = "0";
  }

  async function startRound() {
    resetRoundState();
    roundActive = true;
    timeLeft = 30;
    timerDisplay.textContent = "30s";

    try {
      const res = await fetch("api/start_word.php");
      const data = await res.json();
      if (!data.success) {
        showMessage(data.error || "Error starting round", false);
        roundActive = false;
        return;
      }
      currentWord = data.word;
    } catch (e) {
      showMessage("Server error while starting round.", false);
      roundActive = false;
      return;
    }

    chain.push(currentWord);
    renderChain();
    currentWordDisplay.textContent = currentWord;
    chainLengthDisplay.textContent = chain.length;
    wordInput.disabled = false;
    submitBtn.disabled = false;
    wordInput.focus();
    logLine("Round started with <span>" + currentWord + "</span>.");

    timerId = setInterval(() => {
      if (!roundActive) return;
      timeLeft--;
      if (timeLeft < 0) timeLeft = 0;
      timerDisplay.textContent = timeLeft + "s";
      if (timeLeft === 0) {
        endRound();
      }
    }, 1000);
  }

  async function handleSubmit() {
    if (!roundActive) return;
    const raw = wordInput.value.trim();
    if (!raw) return;
    const inputWord = raw.toLowerCase();
    wordInput.value = "";

    if (chain.map(w => w.toLowerCase()).includes(inputWord)) {
      showMessage(`"${inputWord}" already used in this chain. Try something new.`, false);
      logLine("Duplicate rejected: <span>" + inputWord + "</span>.");
      return;
    }

    let result;
    try {
      const res = await fetch("api/check_word.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ currentWord, inputWord })
      });
      result = await res.json();
    } catch (e) {
      showMessage("Server error validating word.", false);
      return;
    }

    if (!result.success || !result.valid) {
      currentStreak = 0;
      showMessage(`Chain broke: "${inputWord}" is not linked to "${currentWord}".`, false);
      logLine(`Chain break: <span>${inputWord}</span> not linked to <span>${currentWord}</span>.`);
      return;
    }

    chain.push(inputWord);
    currentStreak++;
    if (currentStreak > bestStreak) bestStreak = currentStreak;

    const gained = 10 + Math.max(0, inputWord.length - 3) * 2;
    score += gained;

    currentWord = result.nextWord || inputWord;
    currentWordDisplay.textContent = currentWord;
    scoreDisplay.textContent = score;
    bestStreakDisplay.textContent = bestStreak;
    chainLengthDisplay.textContent = chain.length;
    renderChain();
    updateMeter();

    showMessage(`Nice! "${inputWord}" accepted. +${gained} points.`, true);
    logLine(`Accepted: <span>${inputWord}</span> → new prompt <span>${currentWord}</span> ( +${gained} pts ).`);
  }

  function endRound() {
    if (!roundActive) return;
    roundActive = false;
    wordInput.disabled = true;
    submitBtn.disabled = true;
    clearInterval(timerId);
    timerId = null;

    const length = chain.length;
    const creativity = computeCreativityPercent();
    showMessage(`Round over. Chain length ${length}, score ${score}, creativity ${creativity}%.`, true);
    logLine(`Round ended. Chain length <span>${length}</span>, creativity <span>${creativity}%</span>.`);

    saveRound(score, length, creativity);
  }

  async function saveRound(score, chainLength, creativityPercent) {
    try {
      const res = await fetch("api/save_round.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ score, chainLength, creativityPercent })
      });
      const data = await res.json();
      if (!data.success) {
        logLine("Failed to save round: " + (data.error || "Error"));
      } else {
        logLine("Round saved.");
        loadLeaderboard();
      }
    } catch (e) {
      logLine("Server error saving round.");
    }
  }

  async function loadLeaderboard() {
    try {
      const res = await fetch("api/leaderboard.php");
      const data = await res.json();
      if (!data.success) {
        leaderboardContainer.textContent = "Unable to load leaderboard.";
        return;
      }
      const lb = data.leaderboard;
      if (!lb.length) {
        leaderboardContainer.textContent = "No rounds played yet.";
        return;
      }
      let html = "<table><tr><th>#</th><th>Player</th><th>Score</th><th>Chain</th><th>Creativity</th></tr>";
      lb.forEach((row, i) => {
        html += `<tr>
          <td>${i+1}</td>
          <td>${row.username}</td>
          <td>${row.score}</td>
          <td>${row.chain_length}</td>
          <td>${row.creativity_percent}%</td>
        </tr>`;
      });
      html += "</table>";
      leaderboardContainer.innerHTML = html;
    } catch (e) {
      leaderboardContainer.textContent = "Error loading leaderboard.";
    }
  }

  startBtn.addEventListener("click", startRound);
  resetBtn.addEventListener("click", resetAll);
  submitBtn.addEventListener("click", handleSubmit);
  wordInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") handleSubmit();
  });

  // Initial
  resetAll();
  loadLeaderboard();
</script>
</body>
</html>
