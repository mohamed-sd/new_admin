<div class="sidebar" id="sidebar">
  <!-- شعار مصغر + نص -->
  <aside class="sidebar-logo" aria-label="Equipation logo">
    <div class="logo-mark">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
           stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="3"/>
        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 
        2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 
        0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 
        0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 
        1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 
        1 1-2.83-2.83l.06-.06c.46-.46.6-1.14.33-1.82a1.65 
        1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09c.7 0 
        1.31-.39 1.51-1a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 
        2 0 1 1 2.83-2.83l.06.06c.46.46 1.14.6 
        1.82.33h.09c.61-.2 1-.81 1-1.51V3a2 2 
        0 0 1 4 0v.09c0 .7.39 1.31 1 
        1.51h.09c.68.27 1.36.13 
        1.82-.33l.06-.06a2 2 0 1 1 
        2.83 2.83l-.06.06c-.46.46-.6 1.14-.33 
        1.82v.09c.2.61.81 1 1.51 1H21a2 2 
        0 0 1 0 4h-.09c-.7 0-1.31.39-1.51 1z"/>
      </svg>
    </div>
    <div class="logo-text">
      <span class="logo-name">Equipation</span>
      <span class="logo-sub">حلول المعدات الذكية</span>
    </div>
  </aside>

  <!-- قائمة -->
  <ul>
    <?php if($_SESSION['role'] == "admin") { ?>
      <li><a href="dashbourd.php">🏠 الرئيسية</a></li>
      <li><a href="home.php">⏱️ التايم شييت</a></li>
      <li><a href="settings.php">⚙️ الاعدادات</a></li>
      <li class="has-submenu">
        <a href="#" onclick="toggleSubmenu(event)">📦 المستهلكات <span class="arrow">▸</span></a>
        <ul class="submenu">
          <li><a href="#">⛽ وقود</a></li>
          <li><a href="#">🍽️ إعاشة</a></li>
          <li><a href="#">🏠 سكن</a></li>
        </ul>
      </li>
    <?php } ?>

    <?php if($_SESSION['role'] == "user") { ?>
      <li><a href="home.php">⏱️ التايم شييت</a></li>
      <li><a href="add_excavator.php">➕ ساعات حفار</a></li>
      <li><a href="add_tipper.php">➕ ساعات قلاب</a></li>
      <li><a href="add.php">➕ اضافة تايم شييت</a></li>
    <?php } ?>

    <li><a href="logout.php" style="font-weight:bold">🚪 تسجيل الخروج</a></li>
  </ul>
</div>

<style>
  .sidebar {
    width: 240px;
    height: 100vh;
    background: linear-gradient(180deg,#111c36,#0a1124);
    color: #fff;
    position: fixed;
    right: 0; top: 0;
    padding: 1rem;
    box-shadow: -4px 0 12px rgba(0,0,0,.25);
    overflow-y:auto;
  }

  /* شعار */
  .sidebar-logo {
    display:flex;
    align-items:center;
    gap:.6rem;
    margin-bottom:1.5rem;
  }
  .logo-mark {
    width:40px; height:40px;
    border-radius:8px;
    background:linear-gradient(135deg,#0ea5a1,#06b6b4);
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 3px 8px rgba(0,0,0,.3);
  }
  .logo-mark svg {width:22px;height:22px;}
  .logo-text {display:flex;flex-direction:column}
  .logo-name {font-weight:700;font-size:.95rem}
  .logo-sub {font-size:.7rem;opacity:.85}

  /* القائمة */
  .sidebar ul {list-style:none;padding:0;margin:0}
  .sidebar ul li {margin:.4rem 0}
  .sidebar ul li a {
    display:flex;align-items:center;justify-content:space-between;
    padding:.6rem .8rem;border-radius:6px;
    text-decoration:none;color:#fff;font-size:.9rem;
    transition:.3s;
  }
  .sidebar ul li a:hover {background:#ffd166;color:#111}
  .arrow {transition:.3s}
  .has-submenu.open .arrow {transform:rotate(90deg)}
  .submenu{display:none;list-style:none;padding-left:1rem}
  .submenu li a{font-size:.85rem;padding:.4rem .8rem}
  .has-submenu.open .submenu{display:block} 
</style>

<script>
  function toggleSubmenu(e) {
    e.preventDefault();
    let parent = e.target.closest(".has-submenu");
    parent.classList.toggle("open");
  }
</script>
