<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Movimentação de Estoque — Acessórios de Tecnologia</title>
  <style>
    :root{--bg:#f6f8fa;--card:#ffffff;--muted:#6b7280;--accent:#0ea5a4}
    *{box-sizing:border-box}
    body{font-family:Inter,system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial;margin:0;background:var(--bg);color:#0f172a}
    .container{max-width:1100px;margin:28px auto;padding:20px}
    header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
    h1{font-size:20px;margin:0}
    p.lead{margin:6px 0 0;color:var(--muted);font-size:14px}
    .grid{display:grid;grid-template-columns:1fr 380px;gap:18px}
    .card{background:var(--card);border-radius:12px;padding:16px;box-shadow:0 6px 18px rgba(15,23,42,0.06)}
    label{display:block;font-size:13px;margin-bottom:6px;color:#111827}
    input,select,textarea{width:100%;padding:8px 10px;border:1px solid #e6e9ee;border-radius:8px;font-size:14px}
    textarea{resize:vertical}
    .row{display:flex;gap:10px}
    .row .col{flex:1}
    button{background:var(--accent);border:none;color:#fff;padding:10px 14px;border-radius:10px;cursor:pointer;font-weight:600}
    button.ghost{background:transparent;color:var(--accent);border:1px solid #cde; font-weight:600}
    table{width:100%;border-collapse:collapse;margin-top:12px}
    th,td{padding:10px;border-bottom:1px solid #eef2f7;text-align:left;font-size:14px}
    th{background:#fbfdfe;font-weight:700}
    .muted{color:var(--muted)}
    .summary{display:flex;gap:10px;flex-wrap:wrap}
    .stat{background:#0f172a;color:white;padding:10px;border-radius:10px;min-width:140px}
    .actions{display:flex;gap:8px;align-items:center}
    .small{font-size:13px;padding:6px 8px;border-radius:8px}
    .danger{background:#ef4444}
    @media(max-width:900px){.grid{grid-template-columns:1fr;}.stat{min-width:120px}}
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div>
        <h1>Movimentação de Estoque — Acessórios de Tecnologia</h1>
        <p class="lead">Registre entradas e saídas de celulares, relógios, tablets e outros. Dados salvos localmente no navegador.</p>
      </div>
      <div class="actions">
        <button id="exportCsv" class="small">Exportar CSV</button>
        <button id="clearAll" class="small ghost">Limpar tudo</button>
      </div>
    </header>

    <div class="grid">
      <section class="card">
        <h3>Registrar movimentação</h3>
        <form id="movementForm">
          <label for="type">Tipo</label>
          <select id="type" required>
            <option value="entrada">Entrada</option>
            <option value="saida">Saída</option>
          </select>

          <label for="category">Categoria</label>
          <select id="category" required>
            <option value="celular">Celular</option>
            <option value="relógio">Relógio</option>
            <option value="tablet">Tablet</option>
            <option value="acessorio">Acessório</option>
          </select>

          <label for="model">Modelo / Descrição</label>
          <input id="model" placeholder="Ex.: iPhone 15 128GB / Pulseira XYZ" required>

          <div class="row" style="margin-top:8px">
            <div class="col">
              <label for="qty">Quantidade</label>
              <input id="qty" type="number" min="1" value="1" required>
            </div>
            <div class="col">
              <label for="date">Data</label>
              <input id="date" type="date" required>
            </div>
          </div>

          <label for="notes">Observações (opcional)</label>
          <textarea id="notes" rows="2" placeholder="Ex.: Venda online, transferência entre lojas..."></textarea>

          <div style="display:flex;gap:8px;margin-top:10px">
            <button type="submit">Salvar movimentação</button>
            <button type="button" id="addDemo" class="ghost">Adicionar exemplo</button>
          </div>
        </form>

        <section style="margin-top:14px">
          <h4>Resumo rápido</h4>
          <div class="summary" id="summary"></div>
        </section>
      </section>

      <aside class="card">
        <h3>Histórico de Movimentações</h3>
        <div style="display:flex;gap:8px;margin-bottom:8px">
          <input id="search" placeholder="Pesquisar modelo..." class="small" style="flex:1">
          <select id="filterCategory" class="small">
            <option value="">Todas</option>
            <option value="celular">Celular</option>
            <option value="relógio">Relógio</option>
            <option value="tablet">Tablet</option>
            <option value="acessorio">Acessório</option>
          </select>
        </div>

        <div style="max-height:420px;overflow:auto">
          <table id="movementsTable">
            <thead>
              <tr><th>Data</th><th>Tipo</th><th>Categoria</th><th>Modelo</th><th>Qtd</th><th>Notas</th><th></th></tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </aside>
    </div>

    <footer style="margin-top:18px;text-align:center;color:var(--muted)">
      <small>Feito para gerenciar movimentações básicas de estoque. Dados ficam no armazenamento local do navegador.</small>
    </footer>
  </div>

  <script>
    // Estrutura de dados: array de movimentos
    const STORAGE_KEY = 'movimentacoes_tech';

    // Elementos
    const form = document.getElementById('movementForm');
    const tableBody = document.querySelector('#movementsTable tbody');
    const summaryEl = document.getElementById('summary');
    const exportBtn = document.getElementById('exportCsv');
    const clearBtn = document.getElementById('clearAll');
    const search = document.getElementById('search');
    const filterCategory = document.getElementById('filterCategory');
    const addDemo = document.getElementById('addDemo');

    // Load or init
    let movements = loadMovements();
    renderTable();
    renderSummary();

    form.addEventListener('submit', e => {
      e.preventDefault();
      const mov = readForm();
      movements.unshift(mov); // adiciona no topo
      saveMovements();
      renderTable();
      renderSummary();
      form.reset();
      // set default qty back to 1
      document.getElementById('qty').value = 1;
    });

    addDemo.addEventListener('click', ()=>{
      const sample = {
        id: cryptoRandomId(),
        date: (new Date()).toISOString().slice(0,10),
        type: 'entrada',
        category: 'celular',
        model: 'Ex: Samsung Galaxy A54',
        qty: 10,
        notes: 'Recebimento de fabricante'
      };
      movements.unshift(sample);
      saveMovements();renderTable();renderSummary();
    });

    search.addEventListener('input', ()=>renderTable());
    filterCategory.addEventListener('change', ()=>renderTable());

    exportBtn.addEventListener('click', ()=>{
      const csv = toCSV(movements);
      const blob = new Blob([csv],{type:'text/csv;charset=utf-8;'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url; a.download = 'movimentacoes_estoque.csv';
      a.click(); URL.revokeObjectURL(url);
    });

    clearBtn.addEventListener('click', ()=>{
      if(!confirm('Confirma limpar todos os dados de movimentação?')) return;
      movements = []; saveMovements(); renderTable(); renderSummary();
    });

    // Helpers
    function readForm(){
      return {
        id: cryptoRandomId(),
        date: document.getElementById('date').value,
        type: document.getElementById('type').value,
        category: document.getElementById('category').value,
        model: document.getElementById('model').value.trim(),
        qty: Number(document.getElementById('qty').value) || 0,
        notes: document.getElementById('notes').value.trim()
      };
    }

    function renderTable(){
      tableBody.innerHTML = '';
      const q = (search.value||'').toLowerCase();
      const cat = filterCategory.value;
      const list = movements.filter(m => {
        if(cat && m.category !== cat) return false;
        if(q && !(m.model||'').toLowerCase().includes(q) && !(m.notes||'').toLowerCase().includes(q)) return false;
        return true;
      });

      if(list.length === 0){
        tableBody.innerHTML = '<tr><td colspan="7" class="muted">Nenhuma movimentação encontrada.</td></tr>';
        return;
      }

      for(const m of list){
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${m.date}</td>
          <td>${m.type === 'entrada' ? 'Entrada' : 'Saída'}</td>
          <td>${capitalize(m.category)}</td>
          <td>${escapeHtml(m.model)}</td>
          <td>${m.qty}</td>
          <td>${escapeHtml(m.notes||'')}</td>
          <td><button class="small" data-id="${m.id}">Excluir</button></td>
        `;
        tableBody.appendChild(tr);
      }

      // attach delete handlers
      tableBody.querySelectorAll('button[data-id]').forEach(btn=>{
        btn.addEventListener('click', ()=>{
          const id = btn.getAttribute('data-id');
          if(!confirm('Excluir essa movimentação?')) return;
          movements = movements.filter(x=>x.id !== id);
          saveMovements(); renderTable(); renderSummary();
        });
      });
    }

    function renderSummary(){
      // Calcula estoque por (categoria + model)
      const stock = {}; // key -> {category, model, qty}
      for(const m of movements){
        const key = `${m.category}||${m.model}`;
        if(!stock[key]) stock[key] = {category:m.category, model:m.model, qty:0};
        stock[key].qty += (m.type === 'entrada' ? m.qty : -m.qty);
      }

      // transforma em array ordenada por qty desc
      const arr = Object.values(stock).sort((a,b)=>b.qty - a.qty);
      summaryEl.innerHTML = '';
      if(arr.length === 0){
        summaryEl.innerHTML = '<div class="muted">Nenhum item no estoque</div>';
        return;
      }
      // mostrar os 6 primeiros como cards
      arr.slice(0,6).forEach(item=>{
        const div = document.createElement('div');
        div.className = 'stat';
        div.innerHTML = `<strong>${escapeHtml(item.model)}</strong><div style="font-size:12px;margin-top:6px">${capitalize(item.category)} — ${item.qty} unidades</div>`;
        summaryEl.appendChild(div);
      });

      // também mostrar total de SKUs e soma de unidades
      const totalSkus = arr.length;
      const totalUnits = arr.reduce((s,i)=>s + i.qty,0);
      const meta = document.createElement('div');
      meta.style.minWidth = '160px';
      meta.style.background = '#eef2f7';
      meta.style.borderRadius = '10px';
      meta.style.padding = '10px';
      meta.innerHTML = `<div style="font-weight:700">SKUs: ${totalSkus}</div><div class="muted" style="margin-top:6px">Unidades totais: ${totalUnits}</div>`;
      summaryEl.appendChild(meta);
    }

    function loadMovements(){
      try{
        const raw = localStorage.getItem(STORAGE_KEY);
        return raw ? JSON.parse(raw) : [];
      }catch(e){return []}
    }
    function saveMovements(){
      localStorage.setItem(STORAGE_KEY, JSON.stringify(movements));
    }

    function cryptoRandomId(){
      return 'm_' + Math.random().toString(36).slice(2,9);
    }

    function capitalize(s){ if(!s) return ''; return s.charAt(0).toUpperCase() + s.slice(1);} 
    function escapeHtml(s){ return String(s).replace(/[&<>"']/g, function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]; }); }

    function toCSV(list){
      const headers = ['id','date','type','category','model','qty','notes'];
      const rows = [headers.join(',')];
      for(const m of list){
        const row = [m.id, m.date, m.type, m.category, `"${(m.model||'').replace(/"/g,'""')}"`, m.qty, `"${(m.notes||'').replace(/"/g,'""')}"`];
        rows.push(row.join(','));
      }
      return rows.join('\n');
    }

    // utility: seed date field with today
    (function seed(){
      const d = new Date();
      document.getElementById('date').value = d.toISOString().slice(0,10);
    })();

  </script>
</body>
</html>
