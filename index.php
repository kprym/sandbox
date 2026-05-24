<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Painterly Interactive Beach</title>
  <style>
    html, body {
      margin: 0;
      height: 100%;
      overflow: hidden;
      background: #7ec7ee;
      font-family: "Trebuchet MS", Arial, sans-serif;
    }

    #info {
      position: fixed;
      top: 12px;
      left: 12px;
      padding: 10px 12px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.8);
      color: #17465d;
      font-size: 14px;
      backdrop-filter: blur(2px);
      box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
      z-index: 2;
    }

    canvas {
      display: block;
      width: 100vw;
      height: 100vh;
    }
  </style>
</head>
<body>
  <div id="info">Click the beach to place objects • Move mouse over ocean to guide dolphins</div>
  <canvas id="beach"></canvas>

  <script>
    const canvas = document.getElementById('beach');
    const ctx = canvas.getContext('2d');

    let w = 0;
    let h = 0;
    let t = 0;
    const mouse = { x: -999, y: -999 };

    const placedObjects = [];

    const dolphins = Array.from({ length: 4 }, (_, i) => ({
      x: 220 + i * 220,
      y: 150 + Math.random() * 90,
      vx: 1 + Math.random() * 0.8,
      phase: Math.random() * Math.PI * 2,
      scale: 0.8 + Math.random() * 0.35,
    }));

    function resize() {
      w = canvas.width = window.innerWidth;
      h = canvas.height = window.innerHeight;
    }

    window.addEventListener('resize', resize);
    resize();

    canvas.addEventListener('mousemove', (e) => {
      mouse.x = e.clientX;
      mouse.y = e.clientY;
    });

    canvas.addEventListener('mouseleave', () => {
      mouse.x = -999;
      mouse.y = -999;
    });

    canvas.addEventListener('click', (e) => {
      const types = ['bucket', 'shell', 'starfish', 'pebble'];
      placedObjects.push({
        x: e.clientX,
        y: Math.max(e.clientY, h * 0.58),
        type: types[Math.floor(Math.random() * types.length)],
        rot: Math.random() * Math.PI * 2,
        size: 0.8 + Math.random() * 0.6,
      });
    });

    function drawBackground() {
      const sky = ctx.createLinearGradient(0, 0, 0, h * 0.42);
      sky.addColorStop(0, '#7cc8f2');
      sky.addColorStop(0.55, '#9fdbfb');
      sky.addColorStop(1, '#d8efff');
      ctx.fillStyle = sky;
      ctx.fillRect(0, 0, w, h * 0.42);

      const seaY = h * 0.39;
      const sea = ctx.createLinearGradient(0, seaY, 0, h * 0.68);
      sea.addColorStop(0, '#42a9cd');
      sea.addColorStop(0.4, '#247ea8');
      sea.addColorStop(1, '#185f89');
      ctx.fillStyle = sea;
      ctx.fillRect(0, seaY, w, h * 0.36);

      const sand = ctx.createLinearGradient(0, h * 0.58, 0, h);
      sand.addColorStop(0, '#ebd598');
      sand.addColorStop(0.5, '#dfc078');
      sand.addColorStop(1, '#d2af63');
      ctx.fillStyle = sand;
      ctx.fillRect(0, h * 0.58, w, h * 0.42);

      for (let i = 0; i < 120; i++) {
        const px = (i * 97) % w;
        const py = h * 0.58 + ((i * 53) % (h * 0.4));
        ctx.fillStyle = `rgba(140, 107, 54, ${0.04 + (i % 7) * 0.01})`;
        ctx.fillRect(px, py, 2, 2);
      }
    }

    function drawWaves() {
      for (let band = 0; band < 7; band++) {
        const yBase = h * (0.43 + band * 0.03);
        ctx.beginPath();
        for (let x = 0; x <= w; x += 10) {
          const y = yBase + Math.sin(x * 0.012 + t * 0.002 + band * 1.4) * (6 + band);
          if (x === 0) ctx.moveTo(x, y);
          else ctx.lineTo(x, y);
        }
        ctx.strokeStyle = `rgba(235, 250, 255, ${0.48 - band * 0.055})`;
        ctx.lineWidth = 1.5 + band * 0.25;
        ctx.stroke();
      }

      ctx.fillStyle = 'rgba(255,255,255,0.24)';
      ctx.fillRect(0, h * 0.565, w, 8);
    }

    function drawStarfish(x, y, size, rot) {
      ctx.save();
      ctx.translate(x, y);
      ctx.rotate(rot);
      ctx.fillStyle = '#db7b52';
      ctx.beginPath();
      for (let i = 0; i < 5; i++) {
        const a = i * (Math.PI * 2 / 5);
        ctx.lineTo(Math.cos(a) * size, Math.sin(a) * size);
        const inner = a + Math.PI / 5;
        ctx.lineTo(Math.cos(inner) * size * 0.45, Math.sin(inner) * size * 0.45);
      }
      ctx.closePath();
      ctx.fill();
      ctx.restore();
    }

    function drawBucket(x, y, s) {
      ctx.save();
      ctx.translate(x, y);
      ctx.scale(s, s);
      ctx.fillStyle = '#4aa3d8';
      ctx.beginPath();
      ctx.moveTo(-14, 0);
      ctx.lineTo(14, 0);
      ctx.lineTo(10, 24);
      ctx.lineTo(-10, 24);
      ctx.closePath();
      ctx.fill();

      ctx.strokeStyle = '#2f6f96';
      ctx.lineWidth = 2;
      ctx.beginPath();
      ctx.arc(0, -1, 13, Math.PI, 0);
      ctx.stroke();
      ctx.restore();
    }

    function drawShell(x, y, s, rot) {
      ctx.save();
      ctx.translate(x, y);
      ctx.rotate(rot);
      ctx.scale(s, s);
      const g = ctx.createRadialGradient(0, 0, 1, 0, 0, 18);
      g.addColorStop(0, '#f9e6d0');
      g.addColorStop(1, '#cda37f');
      ctx.fillStyle = g;
      ctx.beginPath();
      ctx.ellipse(0, 0, 18, 11, 0, 0, Math.PI * 2);
      ctx.fill();
      ctx.strokeStyle = 'rgba(130,90,65,0.35)';
      for (let i = -12; i <= 12; i += 6) {
        ctx.beginPath();
        ctx.moveTo(i, -7);
        ctx.lineTo(i, 7);
        ctx.stroke();
      }
      ctx.restore();
    }

    function drawPebble(x, y, s) {
      ctx.save();
      ctx.translate(x, y);
      ctx.scale(s, s);
      ctx.fillStyle = '#8c8a87';
      ctx.beginPath();
      ctx.ellipse(0, 0, 8, 5, 0.2, 0, Math.PI * 2);
      ctx.fill();
      ctx.restore();
    }

    function drawPlacedObjects() {
      for (const item of placedObjects) {
        if (item.type === 'bucket') drawBucket(item.x, item.y, item.size);
        if (item.type === 'shell') drawShell(item.x, item.y, item.size, item.rot);
        if (item.type === 'starfish') drawStarfish(item.x, item.y, 14 * item.size, item.rot);
        if (item.type === 'pebble') drawPebble(item.x, item.y, item.size);
      }

      drawBucket(w * 0.16, h * 0.76, 1.3);
      drawBucket(w * 0.82, h * 0.8, 1.1);
      drawStarfish(w * 0.54, h * 0.74, 16, 0.4);
      drawShell(w * 0.67, h * 0.79, 1.2, -0.5);
      drawPebble(w * 0.47, h * 0.84, 1.4);
    }

    function drawDolphin(x, y, scale, facingRight) {
      ctx.save();
      ctx.translate(x, y);
      ctx.scale(facingRight ? scale : -scale, scale);

      const bodyGrad = ctx.createLinearGradient(-30, -10, 30, 20);
      bodyGrad.addColorStop(0, '#b2c5d0');
      bodyGrad.addColorStop(1, '#6f8fa1');
      ctx.fillStyle = bodyGrad;

      ctx.beginPath();
      ctx.moveTo(-35, 0);
      ctx.quadraticCurveTo(-5, -18, 26, -5);
      ctx.quadraticCurveTo(36, 0, 24, 10);
      ctx.quadraticCurveTo(0, 20, -30, 10);
      ctx.closePath();
      ctx.fill();

      ctx.beginPath();
      ctx.moveTo(-30, 2);
      ctx.lineTo(-45, -8);
      ctx.lineTo(-42, 7);
      ctx.closePath();
      ctx.fill();

      ctx.beginPath();
      ctx.moveTo(-4, -5);
      ctx.lineTo(8, -20);
      ctx.lineTo(10, -4);
      ctx.closePath();
      ctx.fill();

      ctx.fillStyle = '#1f3442';
      ctx.beginPath();
      ctx.arc(19, -2, 1.8, 0, Math.PI * 2);
      ctx.fill();

      ctx.restore();
    }

    function updateAndDrawDolphins() {
      dolphins.forEach((d) => {
        const dx = mouse.x - d.x;
        const dy = mouse.y - d.y;
        const dist = Math.hypot(dx, dy);

        if (dist < 260 && mouse.y < h * 0.58) {
          d.vx += Math.sign(dx) * 0.015;
          d.y += Math.sign(dy) * 0.2;
        }

        d.vx = Math.max(-2.2, Math.min(2.2, d.vx));
        d.x += d.vx;
        d.phase += 0.05;
        d.y += Math.sin(d.phase + t * 0.003) * 0.7;

        if (d.x < -80) d.x = w + 80;
        if (d.x > w + 80) d.x = -80;

        d.y = Math.max(h * 0.16, Math.min(h * 0.48, d.y));
        drawDolphin(d.x, d.y, d.scale, d.vx >= 0);
      });
    }

    function animate(time) {
      t = time;
      ctx.clearRect(0, 0, w, h);
      drawBackground();
      drawWaves();
      updateAndDrawDolphins();
      drawPlacedObjects();
      requestAnimationFrame(animate);
    }

    requestAnimationFrame(animate);
  </script>
</body>
</html>
