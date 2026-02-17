<?php require "config.php"; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>BrainChain – Login</title>
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
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      color: #e5e7eb;

      /* Same background image as index.php, but no glow animation */
      background:
        linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.8)),
        url('https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d')
        no-repeat center center fixed;
      background-size: cover;
    }

    .card {
      width: 100%;
      max-width: 430px;
      background: radial-gradient(circle at top left, rgba(148, 163, 184, 0.08), var(--panel));
      border-radius: 24px;
      padding: 1.9rem 2rem 1.6rem;
      border: 1px solid rgba(148, 163, 184, 0.4);
      box-shadow:
        0 18px 40px rgba(15, 23, 42, 0.85);
      position: relative;
      overflow: hidden;
    }

    .card::before {
      content: "";
      position: absolute;
      inset: -40px;
      background: radial-gradient(circle at top, var(--accent-soft), transparent 65%);
      opacity: 0.45; /* reduced glow */
      pointer-events: none;
    }

    .card-inner {
      position: relative;
      z-index: 1;
    }

    h1 {
      font-size: 1.7rem;
      margin: 0 0 0.3rem;
      letter-spacing: 0.05em;
    }

    p {
      margin: 0;
      font-size: 0.9rem;
      color: var(--muted);
    }

    .subtitle-pill {
      display: inline-flex;
      margin-top: 0.45rem;
      padding: 0.2rem 0.7rem;
      border-radius: 999px;
      border: 1px solid rgba(148, 163, 184, 0.5);
      font-size: 0.68rem;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: #e0f2fe;
      background: rgba(15, 23, 42, 0.9);
    }

    .forms-wrapper {
      margin-top: 1.2rem;
      display: grid;
      gap: 1.2rem;
    }

    .form-block h2 {
      margin: 0 0 0.3rem;
      font-size: 1rem;
    }

    .field {
      margin-top: 0.4rem;
      font-size: 0.85rem;
    }

    .field label {
      display: block;
      margin-bottom: 0.2rem;
      color: var(--muted);
      font-size: 0.8rem;
    }

    .field input {
      width: 100%;
      padding: 0.6rem 0.75rem;
      border-radius: 999px;
      border: 1px solid rgba(148, 163, 184, 0.7);
      background: rgba(15, 23, 42, 0.96);
      color: #e5e7eb;
      outline: none;
      font-size: 0.9rem;
      transition: border 0.18s ease, box-shadow 0.18s ease, transform 0.12s ease;
    }

    .field input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 1px var(--accent);
      transform: translateY(-1px);
    }

    .btn {
      width: 100%;
      margin-top: 0.7rem;
      padding: 0.65rem 1rem;
      border-radius: 999px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.85rem;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      background: linear-gradient(135deg, #0ea5e9, #2563eb);
      color: #f9fafb;
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.6); /* reduced */
      transition: transform 0.12s ease, box-shadow 0.12s ease, opacity 0.12s ease;
    }

    .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 26px rgba(37, 99, 235, 0.8);
    }

    .msg {
      margin-top: 0.9rem;
      font-size: 0.8rem;
      min-height: 1.2em;
      color: #fca5a5;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-inner">
      <h1>BrainChain</h1>
      <div class="subtitle-pill">Sign in to play</div>
      <p>Use an account to track your creative chains.</p>

      <div class="msg">
        <?php
          if (isset($_SESSION["auth_error"])) {
              echo htmlspecialchars($_SESSION["auth_error"]);
              unset($_SESSION["auth_error"]);
          }
        ?>
      </div>

      <div class="forms-wrapper">
        <div class="form-block">
          <h2>Login</h2>
          <form method="post" action="auth_login.php">
            <div class="field">
              <label>Username</label>
              <input type="text" name="username" required>
            </div>
            <div class="field">
              <label>Password</label>
              <input type="password" name="password" required>
            </div>
            <button class="btn" type="submit">Login</button>
          </form>
        </div>

        <div class="form-block">
          <h2>New Player? Register</h2>
          <form method="post" action="auth_register.php">
            <div class="field">
              <label>Username</label>
              <input type="text" name="username" required>
            </div>
            <div class="field">
              <label>Password (min 4 chars)</label>
              <input type="password" name="password" required>
            </div>
            <button class="btn" type="submit">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
