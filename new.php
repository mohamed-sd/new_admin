<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php"); // رجعه لصفحة تسجيل الدخول
  exit;
}

include 'config.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>نموذج إضافة بيانات المشروع</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <style>
    :root {
      --bg: #ffffff;
      /* أبيض */
      --gold: #D4AF37;
      /* ذهبي */
      --yellow: #FFD95A;
      /* أصفر ناعم */
      --ink: #1f2937;
      /* رمادي داكن للنص */
      --muted: #6b7280;
      /* رمادي للنص الثانوي */
      --line: #f1f5f9;
      /* حدود فاتحة */
      --focus: #b08900;
      /* تركيز ذهبي أعمق */
      --chip: #fff7cd;
      /* خلفيات شرائح */
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background: linear-gradient(180deg, #fff 0%, #fffaf0 100%);
      font-family: "Cairo", system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
      color: var(--ink);
    }

    .wrap {
      max-width: 1100px;
      margin-inline: auto;
      padding: 24px;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 18px;
    }

    .logo {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: radial-gradient(110% 110% at 70% 30%, var(--yellow), var(--gold));
      box-shadow: 0 6px 18px rgba(212, 175, 55, .35), inset 0 1px 0 rgba(255, 255, 255, .6);
    }

    h1 {
      font-size: clamp(20px, 3vw, 28px);
      margin: 0;
      font-weight: 800;
      letter-spacing: .3px;
      background: linear-gradient(90deg, var(--gold), #8a6a0a);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    p.sub {
      margin: 4px 0 20px;
      color: var(--muted);
      font-size: 14px;
    }

    .card {
      background: var(--bg);
      border: 1px solid var(--line);
      border-radius: 18px;
      padding: 18px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
    }

    .section-title {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 4px 0 14px;
      font-weight: 800;
      color: #7a5a00;
    }

    .section-title .chip {
      background: var(--chip);
      color: #7a5a00;
      padding: 6px 10px;
      border-radius: 999px;
      font-size: 12px;
      border: 1px dashed var(--yellow);
    }

    .grid {
      display: grid;
      gap: 14px;
      grid-template-columns: repeat(12, 1fr);
    }

    /* عنصر حقل أنيق */
    .field {
      grid-column: span 12;
    }

    @media (min-width: 640px) {
      .field.sm-6 {
        grid-column: span 6;
      }

      .field.sm-4 {
        grid-column: span 4;
      }

      .field.sm-3 {
        grid-column: span 3;
      }
    }

    @media (min-width: 900px) {
      .field.md-6 {
        grid-column: span 6;
      }

      .field.md-4 {
        grid-column: span 4;
      }

      .field.md-3 {
        grid-column: span 3;
      }
    }

    label {
      display: block;
      font-size: 12px;
      color: var(--muted);
      margin-bottom: 6px;
      font-weight: 700;
    }

    .control {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #fff;
      border: 1px solid var(--line);
      padding: 10px 12px;
      border-radius: 12px;
      transition: border-color .2s, box-shadow .2s;
    }

    .control:focus-within {
      border-color: var(--gold);
      box-shadow: 0 0 0 4px rgba(212, 175, 55, .18);
    }

    .control input,
    .control select,
    .control textarea {
      border: none;
      outline: none;
      flex: 1;
      font: inherit;
      color: inherit;
      background: transparent;
      min-width: 0;
    }

    .unit {
      font-size: 12px;
      color: #7a5a00;
      background: var(--chip);
      border: 1px solid var(--yellow);
      padding: 4px 8px;
      border-radius: 999px;
    }

    .muted {
      color: var(--muted);
      font-size: 12px;
    }

    .toolbar {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: flex-end;
      margin-top: 20px;
    }

    button {
      border: none;
      border-radius: 12px;
      padding: 12px 18px;
      font-weight: 800;
      cursor: pointer;
      box-shadow: 0 6px 18px rgba(212, 175, 55, .25);
      transition: transform .06s ease, box-shadow .2s;
    }

    .primary {
      background: linear-gradient(90deg, var(--gold), #b58500);
      color: #fff;
    }

    .ghost {
      background: #fff7e6;
      color: #7a5a00;
      border: 1px solid var(--yellow);
      box-shadow: none;
    }

    button:active {
      transform: translateY(1px);
    }

    .two-col {
      display: grid;
      gap: 16px;
    }

    @media (min-width: 920px) {
      .two-col {
        grid-template-columns: 1fr 1fr;
      }
    }

    .totals {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 12px;
      margin-top: 10px;
    }

    .kpi {
      background: linear-gradient(180deg, #fff, #fffaf0);
      border: 1px solid var(--yellow);
      border-radius: 14px;
      padding: 14px;
      text-align: center;
    }

    .kpi .v {
      font-weight: 900;
      font-size: clamp(18px, 3vw, 24px);
      color: #7a5a00;
    }

    .kpi .t {
      color: var(--muted);
      font-size: 12px;
    }

    .hr {
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--yellow), transparent);
      margin: 18px 0;
      border: none;
    }
  </style>
</head>

<body>


  <!-- Include the sidebar -->
  <?php include 'sidebar.php'; ?>

  <div class="main full" id="main">
    <div class="wrap">

      <div class="brand">
        <div class="container-fluid">
          <span class="navbar-brand mb-0 h1"> <span class="menu-btn" onclick="toggleSidebar()">☰</span>
          </span>
        </div>
        <div class="logo" aria-hidden="true"></div>
        <div>
          <h1>نموذج إضافة بيانات المشروع</h1>
          <p class="sub">شركة إيكوبيشن .</p>
        </div>
      </div>

      <form id="projectForm" class="card" novalidate>
        <!-- القسم 1: البيانات الأساسية للعميل والعقد -->
        <div class="section-title"><span class="chip">1</span> البيانات الأساسية للعميل والعقد</div>
        <div class="grid">
          <div class="field md-6 sm-6">
            <label>أسم العميل (Customer Name)</label>
            <div class="control"><input name="customer_name" type="text" placeholder="مثال: شركة اليمامة" required>
            </div>
          </div>
          <div class="field md-6 sm-6">
            <label>أسم المشروع (Project Name)</label>
            <div class="control"><input name="project_name" type="text" placeholder="مثال: طريق السواحل" required></div>
          </div>
          <div class="field md-6 sm-6">
            <label>موقع المشروع (Project Location)</label>
            <div class="control"><input name="project_location" type="text" placeholder="المدينة / الإحداثيات"></div>
          </div>
          <div class="field md-3 sm-6">
            <label>تاريخ توقيع العقد (Contract signing date)</label>
            <div class="control"><input name="contract_signing_date" type="date"></div>
          </div>
          <div class="field md-3 sm-6">
            <label>فترة السماح بين التوقيع والتنفيذ (Grace period)</label>
            <div class="control"><input name="grace_period_days" type="number" min="0" placeholder="عدد الأيام"><span
                class="unit">أيام</span></div>
          </div>
          <div class="field md-3 sm-6">
            <label>مدة العقد بالشهور (Contract Duration Per Month)</label>
            <div class="control"><input name="contract_duration_months" id="contract_duration_months" type="number"
                min="0" placeholder="بالشهور"></div>
          </div>
          <div class="field md-3 sm-6">
            <label>بداية التنفيذ الفعلي المتفق عليه</label>
            <div class="control"><input name="actual_start" type="date"></div>
          </div>
          <div class="field md-3 sm-6">
            <label>نهاية التنفيذ الفعلي المتفق عليه</label>
            <div class="control"><input name="actual_end" type="date"></div>
          </div>
          <div class="field md-3 sm-6">
            <label>الترحيل (Transportation)</label>
            <div class="control">
              <select name="transportation">
                <option value="">— اختر —</option>
                <option>مشمولة</option>
                <option>غير مشمولة</option>
              </select>
            </div>
          </div>
          <div class="field md-3 sm-6">
            <label>الإعاشة (Accommodation)</label>
            <div class="control">
              <select name="accommodation">
                <option value="">— اختر —</option>
                <option>مشمولة</option>
                <option>غير مشمولة</option>
              </select>
            </div>
          </div>
          <div class="field md-3 sm-6">
            <label>السكن (Place for Living)</label>
            <div class="control">
              <select name="place_for_living">
                <option value="">— اختر —</option>
                <option>مشمولة</option>
                <option>غير مشمولة</option>
              </select>
            </div>
          </div>
          <div class="field md-3 sm-6">
            <label>الورشة (Workshop)</label>
            <div class="control">
              <select name="workshop">
                <option value="">— اختر —</option>
                <option>مشمولة</option>
                <option>غير مشمولة</option>
              </select>
            </div>
          </div>
        </div>

        <hr class="hr" />

        <!-- القسم 2: بيانات ساعات العمل المطلوبة للمعدات -->
        <div class="section-title"><span class="chip">2</span> بيانات ساعات العمل المطلوبة <strong>للمعدات</strong>
        </div>
        <div class="grid">
          <div class="field md-4 sm-6">
            <label>نوع المعدة المطلوبة (Type of equipment)</label>
            <div class="control"><input name="equip_type" type="text" placeholder="مثال: حفار" value="حفار"></div>
          </div>
          <div class="field md-4 sm-6">
            <label>حجم المعدة المطلوبة (Size)</label>
            <div class="control"><input name="equip_size" type="number" placeholder="مثال: 340" value="340"><span
                class="unit">وحدة</span></div>
          </div>
          <div class="field md-4 sm-6">
            <label>عدد المعدات المطلوبة</label>
            <div class="control"><input name="equip_count" id="equip_count" type="number" min="0" value="2"><span
                class="unit">عدد</span></div>
          </div>
          <div class="field md-4 sm-6">
            <label>ساعات العمل المستهدفة للمعدة شهرياً</label>
            <div class="control"><input name="equip_target_per_month" id="equip_target_per_month" type="number" min="0"
                value="600"><span class="unit">ساعة</span></div>
          </div>
          <div class="field md-4 sm-6">
            <label>إجمالي الساعات المستهدفة للمعدات شهرياً</label>
            <div class="control"><input name="equip_total_month" id="equip_total_month" type="number" readonly
                placeholder="يُحتسب تلقائياً"><span class="unit">ساعة</span></div>
          </div>
          <div class="field md-4 sm-6">
            <label>إجمالي ساعات العقد المستهدفة للمعدات</label>
            <div class="control"><input name="equip_total_contract" id="equip_total_contract" type="number" readonly
                placeholder="يُحتسب تلقائياً"><span class="unit">ساعة</span></div>
          </div>
        </div>

        <hr class="hr" />

        <!-- القسم 3: بيانات ساعات العمل المطلوبة للآليات -->
        <div class="section-title"><span class="chip">3</span> بيانات ساعات العمل المطلوبة <strong>للآليات</strong>
        </div>
        <div class="grid">
          <div class="field md-4 sm-6">
            <label>نوع الآلية المطلوبة</label>
            <div class="control"><input name="mach_type" type="text" placeholder="مثال: قلاب" value="قلاب"></div>
          </div>
          <div class="field md-4 sm-6">
            <label>حجم حمولة الآلية</label>
            <div class="control"><input name="mach_size" type="number" placeholder="مثال: 340" value="340"><span
                class="unit">وحدة</span></div>
          </div>
          <div class="field md-4 sm-6">
            <label>عدد الآليات المطلوبة</label>
            <div class="control"><input name="mach_count" id="mach_count" type="number" min="0" value="8"><span
                class="unit">عدد</span></div>
          </div>
          <div class="field md-4 sm-6">
            <label>ساعات العمل المستهدفة للآلية شهرياً</label>
            <div class="control"><input name="mach_target_per_month" id="mach_target_per_month" type="number" min="0"
                value="600"><span class="unit">ساعة</span></div>
          </div>
          <div class="field md-4 sm-6">
            <label>إجمالي الساعات المستهدفة للآليات شهرياً</label>
            <div class="control"><input name="mach_total_month" id="mach_total_month" type="number" readonly
                placeholder="يُحتسب تلقائياً"><span class="unit">ساعة</span></div>
          </div>
          <div class="field md-4 sm-6">
            <label>إجمالي ساعات العقد المستهدفة للآليات</label>
            <div class="control"><input name="mach_total_contract" id="mach_total_contract" type="number" readonly
                placeholder="يُحتسب تلقائياً"><span class="unit">ساعة</span></div>
          </div>
        </div>

        <hr class="hr" />

        <!-- القسم 4: الإجماليات -->
        <div class="section-title"><span class="chip">4</span> إجماليات الساعات (شهرياً وللعقد)</div>
        <div class="totals">
          <div class="kpi">
            <div class="v" id="kpi_month_total">0</div>
            <div class="t">الساعات المستهدفة شهرياً - معدات وآليات</div>
            <input type="hidden" name="hours_monthly_target" id="hours_monthly_target" value="0" />
          </div>
          <div class="kpi">
            <div class="v" id="kpi_contract_total">0</div>
            <div class="t">ساعات العقد المستهدفة - معدات وآليات</div>
            <input type="hidden" name="forecasted_contracted_hours" id="forecasted_contracted_hours" value="0" />
          </div>
          <div class="kpi">
            <div class="v" id="kpi_equip_month">0</div>
            <div class="t">إجمالي معدات (شهري)</div>
          </div>
          <div class="kpi">
            <div class="v" id="kpi_mach_month">0</div>
            <div class="t">إجمالي آليات (شهري)</div>
          </div>
        </div>

        <div class="toolbar">
          <button type="reset" class="ghost">تفريغ الحقول</button>
          <button type="submit" class="primary">حفظ البيانات</button>
        </div>

        <p class="muted" style="margin-top:8px">* يتم احتساب الحقول الإجمالية تلقائياً بناءً على المدخلات.</p>
      </form>
    </div>

</body>

<script>
  const $ = (sel) => document.querySelector(sel);

  const fields = {
    contractMonths: $('#contract_duration_months'),
    equipCount: $('#equip_count'),
    equipTarget: $('#equip_target_per_month'),
    equipTotalMonth: $('#equip_total_month'),
    equipTotalContract: $('#equip_total_contract'),
    machCount: $('#mach_count'),
    machTarget: $('#mach_target_per_month'),
    machTotalMonth: $('#mach_total_month'),
    machTotalContract: $('#mach_total_contract'),
    kpiMonthTotal: $('#kpi_month_total'),
    kpiContractTotal: $('#kpi_contract_total'),
    kpiEquipMonth: $('#kpi_equip_month'),
    kpiMachMonth: $('#kpi_mach_month'),
    hoursMonthlyTarget: $('#hours_monthly_target'),
    forecastedContractedHours: $('#forecasted_contracted_hours'),
  };

  function num(v) {
    const n = parseFloat(v);
    return isFinite(n) ? n : 0;
  }

  function fmt(n) {
    return new Intl.NumberFormat('ar-EG').format(Math.max(0, Math.round(n)));
  }

  function recalc() {
    const months = num(fields.contractMonths.value);

    // معدات
    const equipCount = num(fields.equipCount.value);
    const equipTarget = num(fields.equipTarget.value);
    const equipMonth = equipCount * equipTarget;
    const equipContract = equipMonth * months;

    // آليات
    const machCount = num(fields.machCount.value);
    const machTarget = num(fields.machTarget.value);
    const machMonth = machCount * machTarget;
    const machContract = machMonth * months;

    // تحديث الحقول
    fields.equipTotalMonth.value = Math.max(0, Math.round(equipMonth));
    fields.equipTotalContract.value = Math.max(0, Math.round(equipContract));
    fields.machTotalMonth.value = Math.max(0, Math.round(machMonth));
    fields.machTotalContract.value = Math.max(0, Math.round(machContract));

    const monthTotal = equipMonth + machMonth;
    const contractTotal = equipContract + machContract;

    fields.kpiEquipMonth.textContent = fmt(equipMonth);
    fields.kpiMachMonth.textContent = fmt(machMonth);
    fields.kpiMonthTotal.textContent = fmt(monthTotal);
    fields.kpiContractTotal.textContent = fmt(contractTotal);

    fields.hoursMonthlyTarget.value = Math.max(0, Math.round(monthTotal));
    fields.forecastedContractedHours.value = Math.max(0, Math.round(contractTotal));
  }

  const inputs = document.querySelectorAll('input, select');
  inputs.forEach(el => el.addEventListener('input', recalc));
  recalc();

  // عرض معاينة بيانات على شكل JSON عند الحفظ (يمكن استبدالها بإرسال للخادم)
  const form = document.getElementById('projectForm');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(form).entries());
    alert('تم تجهيز البيانات للحفظ:\n\n' + JSON.stringify(data, null, 2));
    // TODO: إرسال البيانات إلى السيرفر عبر fetch
    // fetch('/api/projects', {method:'POST', body: JSON.stringify(data), headers:{'Content-Type':'application/json'}})
  });

  form.addEventListener('reset', () => setTimeout(recalc, 0));

  function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("hide");
    document.getElementById("main").classList.toggle("full");
  }

</script>
</body>

</html>