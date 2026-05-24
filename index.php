<?php session_start(); $pageFull = true; include 'includes/header.php'; ?>
<style>
.lp-wrap{width:100%}

/* HERO */
.lp-hero{
  position:relative;min-height:calc(100vh - 64px);display:flex;flex-direction:column;
  align-items:center;justify-content:center;overflow:hidden;background:var(--dark);
}
.lp-hero-bg{
  position:absolute;inset:0;
  background:
    radial-gradient(ellipse 58% 75% at 8% 50%,rgba(192,57,43,.6) 0%,transparent 65%),
    radial-gradient(ellipse 45% 55% at 92% 12%,rgba(232,160,32,.26) 0%,transparent 58%),
    radial-gradient(ellipse 35% 40% at 72% 88%,rgba(192,57,43,.18) 0%,transparent 55%);
}
.lp-dots{
  position:absolute;inset:0;
  background-image:radial-gradient(circle,rgba(255,255,255,.055) 1px,transparent 1px);
  background-size:30px 30px;
}
.lp-hero-body{
  position:relative;z-index:2;text-align:center;
  padding:80px 24px 160px;max-width:880px;width:100%;margin:0 auto;
}
.lp-tag{
  display:inline-flex;align-items:center;gap:8px;
  background:rgba(232,160,32,.13);border:1px solid rgba(232,160,32,.38);
  color:var(--gold);font-size:11px;font-weight:700;
  letter-spacing:2.5px;text-transform:uppercase;
  padding:7px 18px;border-radius:50px;margin-bottom:26px;
}
.lp-tag::before{content:'✦';font-size:9px}
.lp-hero h1{
  font-family:'Playfair Display',serif;
  font-size:clamp(36px,7.5vw,84px);font-weight:800;
  color:#fff;line-height:1.05;letter-spacing:-1.5px;margin-bottom:20px;
}
.lp-hero h1 em{font-style:italic;color:var(--gold)}
.lp-sub{
  color:rgba(255,255,255,.7);font-size:clamp(15px,1.8vw,18px);
  max-width:540px;margin:0 auto 38px;line-height:1.7;
}
.lp-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;align-items:center}
.lp-btn-gold{
  display:inline-flex;align-items:center;gap:8px;
  background:var(--gold);color:var(--dark);
  font-weight:700;font-size:15px;padding:15px 30px;
  border-radius:50px;text-decoration:none;white-space:nowrap;
  box-shadow:0 0 28px rgba(232,160,32,.35);transition:.22s;
}
.lp-btn-gold:hover{transform:translateY(-3px);box-shadow:0 10px 32px rgba(232,160,32,.5)}
.lp-btn-ghost{
  display:inline-flex;align-items:center;gap:8px;
  background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.22);
  color:#fff;font-weight:600;font-size:15px;padding:15px 30px;
  border-radius:50px;text-decoration:none;white-space:nowrap;
  backdrop-filter:blur(6px);transition:.22s;
}
.lp-btn-ghost:hover{background:rgba(255,255,255,.16);transform:translateY(-3px)}

/* Stats */
.lp-stats{
  position:absolute;bottom:0;left:0;right:0;z-index:3;
  display:flex;justify-content:center;flex-wrap:wrap;
  background:rgba(255,255,255,.05);backdrop-filter:blur(14px);
  border-top:1px solid rgba(255,255,255,.08);padding:22px 16px;
}
.lp-stat{flex:1 1 140px;max-width:220px;text-align:center;padding:0 16px;border-right:1px solid rgba(255,255,255,.1)}
.lp-stat:last-child{border-right:none}
.lp-snum{font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,34px);font-weight:700;color:var(--gold);display:block;line-height:1}
.lp-slbl{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.5);margin-top:5px;display:block}

/* FEATURES */
.lp-features{background:var(--bg);padding:80px 24px 70px}
.lp-eye{font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--red);text-align:center;margin-bottom:10px}
.lp-h2{font-family:'Playfair Display',serif;font-size:clamp(26px,4vw,42px);font-weight:800;color:var(--dark);text-align:center;line-height:1.2;margin-bottom:48px}

.lp-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;max-width:1150px;margin:0 auto}
.lp-card{
  background:#fff;border:1.5px solid rgba(192,57,43,.1);
  border-radius:20px;padding:30px 22px;
  transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .28s,border-color .28s;
  position:relative;overflow:hidden;
}
.lp-card::after{content:'';position:absolute;inset:0;border-radius:20px;background:linear-gradient(135deg,rgba(192,57,43,.05),rgba(232,160,32,.05));opacity:0;transition:opacity .28s}
.lp-card:hover{transform:translateY(-10px) scale(1.02);box-shadow:0 20px 46px rgba(192,57,43,.13);border-color:var(--gold)}
.lp-card:hover::after{opacity:1}
.lp-icon{width:56px;height:56px;background:linear-gradient(135deg,#fff4dc,#fde4c0);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;margin-bottom:16px;position:relative;z-index:1}
.lp-card h3{font-size:16px;font-weight:700;color:var(--dark);margin-bottom:8px;position:relative;z-index:1}
.lp-card p{font-size:13.5px;color:#888;line-height:1.65;position:relative;z-index:1}

/* HOW */
.lp-how{background:var(--dark);padding:75px 24px}
.lp-how .lp-eye{color:var(--gold)}
.lp-how .lp-h2{color:#fff}
.lp-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;max-width:880px;margin:0 auto}
.lp-step{text-align:center;padding:18px 14px}
.lp-snum-circle{width:54px;height:54px;border-radius:50%;background:rgba(232,160,32,.12);border:1.5px solid rgba(232,160,32,.35);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:var(--gold);margin:0 auto 14px}
.lp-step h4{font-size:16px;font-weight:700;color:#fff;margin-bottom:6px}
.lp-step p{font-size:13.5px;color:rgba(255,255,255,.5);line-height:1.65}

/* ANIMATIONS */
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
.lp-tag{animation:fadeUp .5s ease both .1s}
.lp-hero h1{animation:fadeUp .5s ease both .24s}
.lp-sub{animation:fadeUp .5s ease both .38s}
.lp-btns{animation:fadeUp .5s ease both .5s}

/* RESPONSIVE */
@media(max-width:1000px){.lp-cards{grid-template-columns:repeat(2,1fr)}}
@media(max-width:760px){
  .lp-hero-body{padding:70px 20px 170px}
  .lp-features{padding:60px 20px 50px}
  .lp-how{padding:60px 20px}
  .lp-steps{grid-template-columns:1fr;gap:8px;max-width:420px}
  .lp-stat{flex:1 1 100px;padding:0 10px;font-size:12px}
}
@media(max-width:460px){
  .lp-cards{grid-template-columns:1fr;gap:14px}
  .lp-btns{flex-direction:column;align-items:stretch;width:100%;max-width:300px;margin:0 auto}
  .lp-btn-gold,.lp-btn-ghost{justify-content:center;width:100%}
  .lp-stat{border-right:none}
}
</style>

<div class="lp-wrap">

  <!-- HERO -->
  <section class="lp-hero">
    <div class="lp-hero-bg"></div>
    <div class="lp-dots"></div>
    <div class="lp-hero-body">
      <div class="lp-tag">Thal University Bhakkar</div>
      <h1>Fresh Food,<br><em>Every Day.</em></h1>
      <p class="lp-sub">Order from your campus cafeteria, track your meal, and pay with your digital wallet — all in one place.</p>
      <div class="lp-btns">
        <a href="user/register.php" class="lp-btn-gold">🍽️ Get Started Free</a>
        <a href="user/login.php"    class="lp-btn-ghost">Sign In →</a>
      </div>
    </div>
    <div class="lp-stats">
      <div class="lp-stat"><span class="lp-snum">50+</span><span class="lp-slbl">Menu Items</span></div>
      <div class="lp-stat"><span class="lp-snum">3 min</span><span class="lp-slbl">Avg Order</span></div>
      <div class="lp-stat"><span class="lp-snum">100%</span><span class="lp-slbl">Campus Delivery</span></div>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="lp-features">
    <p class="lp-eye">Why Choose Us</p>
    <h2 class="lp-h2">Everything you need in one app</h2>
    <div class="lp-cards">
      <div class="lp-card"><div class="lp-icon">🍳</div><h3>Full Menu</h3><p>Breakfast, lunch, snacks &amp; drinks — browse everything from your phone.</p></div>
      <div class="lp-card"><div class="lp-icon">🛒</div><h3>Easy Ordering</h3><p>Add to cart and place your order in just a few taps. No queues.</p></div>
      <div class="lp-card"><div class="lp-icon">💳</div><h3>Digital Wallet</h3><p>Top up via JazzCash, EasyPaisa, or Bank Transfer. Pay instantly.</p></div>
      <div class="lp-card"><div class="lp-icon">📦</div><h3>Live Tracking</h3><p>Know exactly when your food is preparing, ready, or delivered.</p></div>
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section class="lp-how">
    <p class="lp-eye">Simple Process</p>
    <h2 class="lp-h2">Order in 3 easy steps</h2>
    <div class="lp-steps">
      <div class="lp-step"><div class="lp-snum-circle">01</div><h4>Create Account</h4><p>Register with your university email in under a minute.</p></div>
      <div class="lp-step"><div class="lp-snum-circle">02</div><h4>Browse &amp; Order</h4><p>Pick your favourite items from the live menu and add to cart.</p></div>
      <div class="lp-step"><div class="lp-snum-circle">03</div><h4>Pick Up &amp; Enjoy</h4><p>Get notified when ready and collect your meal — done!</p></div>
    </div>
  </section>

</div>
<?php include 'includes/footer.php'; ?>
