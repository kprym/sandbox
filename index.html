<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Interactive Beach</title>
  <style>
    html, body { margin: 0; height: 100%; background: linear-gradient(#87ceeb 0%, #bfeaff 40%, #f6e6b3 40%, #ecd18a 100%); overflow: hidden; font-family: Arial, sans-serif; }
    #info { position: fixed; top: 10px; left: 10px; background: rgba(255,255,255,0.8); padding: 8px 10px; border-radius: 8px; font-size: 14px; }
    canvas { display: block; width: 100vw; height: 100vh; }
  </style>
</head>
<body>
  <div id="info">Click anywhere to drop fun beach items. Move mouse to attract dolphins 🐬</div>
  <canvas id="beach"></canvas>
  <script>
    const canvas = document.getElementById('beach');
    const ctx = canvas.getContext('2d');
    let w, h;
    const mouse = { x: 0, y: 0 };
    const items = [];

    function resize() {
      w = canvas.width = window.innerWidth;
      h = canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    const emojiPool = ['🪣', '🏖️', '⭐', '🐚', '🦀', '🦞', '🏐'];

    function addItem(x, y) {
      items.push({
        x, y,
        emoji: emojiPool[(Math.random() * emojiPool.length) | 0],
        size: 22 + Math.random() * 18,
        bob: Math.random() * Math.PI * 2,
      });
    }

    for (let i = 0; i < 20; i++) addItem(Math.random() * w, h * 0.45 + Math.random() * h * 0.5);

    canvas.addEventListener('click', (e) => addItem(e.clientX, e.clientY));
    canvas.addEventListener('mousemove', (e) => { mouse.x = e.clientX; mouse.y = e.clientY; });

    const dolphins = Array.from({ length: 5 }, (_, i) => ({
      x: w * (0.15 + i * 0.17),
      y: h * (0.2 + Math.random() * 0.13),
      vx: (Math.random() * 1.2 + 0.8) * (Math.random() > 0.5 ? 1 : -1),
      t: Math.random() * Math.PI * 2,
      s: 30 + Math.random() * 12,
    }));

    function drawSkyAndSea() {
      // sea
      const seaY = h * 0.4;
      const grad = ctx.createLinearGradient(0, seaY, 0, h);
      grad.addColorStop(0, '#48b7dd');
      grad.addColorStop(1, '#0f6c96');
      ctx.fillStyle = grad;
      ctx.fillRect(0, seaY, w, h - seaY);

      // sand
      ctx.fillStyle = '#e7cb84';
      ctx.fillRect(0, h * 0.58, w, h * 0.42);

      // horizon haze
      ctx.fillStyle = 'rgba(255,255,255,0.2)';
      ctx.fillRect(0, seaY - 8, w, 20);
    }

    function drawWaves(time) {
      for (let j = 0; j < 6; j++) {
        const baseY = h * (0.42 + j * 0.035);
        ctx.beginPath();
        for (let x = 0; x <= w; x += 12) {
          const y = baseY + Math.sin(x * 0.012 + time * 0.002 + j) * (8 + j * 1.5);
          if (x === 0) ctx.moveTo(x, y);
          else ctx.lineTo(x, y);
        }
        ctx.strokeStyle = `rgba(255,255,255,${0.45 - j * 0.06})`;
        ctx.lineWidth = 2;
        ctx.stroke();
      }
    }

    function drawItems(time) {
      items.forEach((it) => {
        const wetLine = h * 0.61;
        const y = it.y + Math.sin(time * 0.003 + it.bob) * (it.y < wetLine ? 3 : 0.8);
        ctx.font = `${it.size}px serif`;
        ctx.globalAlpha = it.y < wetLine ? 0.9 : 1;
        ctx.fillText(it.emoji, it.x, y);
        ctx.globalAlpha = 1;
      });

      // Always-visible stars and buckets explicitly requested
      ctx.font = '30px serif'; ctx.fillText('⭐', w * 0.12, h * 0.72);
      ctx.font = '34px serif'; ctx.fillText('🪣', w * 0.84, h * 0.78);
      ctx.font = '30px serif'; ctx.fillText('🪣', w * 0.67, h * 0.70);
      ctx.font = '32px serif'; ctx.fillText('🌟', w * 0.5, h * 0.76);
    }

    function drawDolphins(time) {
      dolphins.forEach((d) => {
        const dx = mouse.x - d.x;
        const dy = mouse.y - d.y;
        const dist = Math.hypot(dx, dy);
        if (dist < 220) {
          d.vx += Math.sign(dx) * 0.02;
          d.y += Math.sign(dy) * 0.35;
        }

        d.x += d.vx;
        d.t += 0.06;
        d.y += Math.sin(d.t + time * 0.004) * 0.8;

        if (d.x < -60 || d.x > w + 60) d.vx *= -1;
        d.y = Math.min(h * 0.34, Math.max(h * 0.12, d.y));

        ctx.save();
        ctx.translate(d.x, d.y);
        ctx.scale(d.vx < 0 ? -1 : 1, 1);
        ctx.font = `${d.s}px serif`;
        ctx.fillText('🐬', -d.s * 0.5, 0);
        ctx.restore();
      });
    }

    function animate(time) {
      ctx.clearRect(0, 0, w, h);
      drawSkyAndSea();
      drawWaves(time);
      drawItems(time);
      drawDolphins(time);
      requestAnimationFrame(animate);
    }

    requestAnimationFrame(animate);
  </script>
</body>
</html>
