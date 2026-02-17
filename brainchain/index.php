<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>BrainChain – Loading</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <style>
    :root {
      --accent: #0ea5e9;
      --accent2: #38bdf8;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

      /* ⭐ BACKGROUND IMAGE */
      background: 
        linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.75)),
        url('https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d')
        no-repeat center center fixed;

      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    /* Fade-in wrapper */
    .logo-wrapper {
      text-align: center;
      animation: fadeIn 1.6s ease-out forwards;
      opacity: 0;
    }

    @keyframes fadeIn {
      to { opacity: 1; }
    }

    /* Title Text */
    .title {
      margin-top: 1.2rem;
      font-size: 2.6rem;
      font-weight: 900;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: #e0f2fe;
      text-shadow: 0 0 18px rgba(255,255,255,0.9);
      animation: titleGlow 2s ease-in-out infinite alternate;
    }

    @keyframes titleGlow {
      0% { text-shadow: 0 0 10px rgba(255,255,255,0.5); }
      100% { text-shadow: 0 0 30px rgba(255,255,255,1); }
    }

    .subtitle {
      font-size: 1rem;
      letter-spacing: 0.14em;
      color: #d1d5db;
      margin-top: 0.4rem;
    }

    /* Enter Button */
    .enter-btn {
      margin-top: 2rem;
      padding: 0.85rem 2.4rem;
      font-size: 1rem;
      font-weight: 700;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: #f0f9ff;
      background: rgba(255,255,255,0.08);
      border: 2px solid rgba(255,255,255,0.6);
      border-radius: 999px;
      cursor: pointer;
      transition: 0.25s ease-in-out;
      box-shadow: 0 0 18px rgba(255,255,255,0.2);
    }

    .enter-btn:hover {
      background: rgba(255,255,255,0.18);
      border-color: white;
      transform: scale(1.08);
      box-shadow: 0 0 35px rgba(255,255,255,0.55);
    }
  </style>

  <script>
    // Auto redirect after 4 seconds
    setTimeout(() => {
      window.location.href = "login.php";
    }, 4000);

    // Manual redirect
    function enterGame() {
      window.location.href = "login.php";
    }
  </script>
</head>

<body>

  <div class="logo-wrapper">
    <!-- (Blue glowing circle removed) -->

    <div class="title">BrainChain</div>
    <div class="subtitle">Thought Connection Game</div>

    <button class="enter-btn" onclick="enterGame()">Enter</button>
  </div>

</body>
</html>
