let data = [];
const grid = document.getElementById('portafolio-grid');
const perfil = document.getElementById('perfil-emprendedora');

fetch('data/emprendedoras.json')
  .then(res => res.json())
  .then(json => {
    data = json;
    renderGrid(data);
    populateFilters(data);
  });

function renderGrid(items){
  grid.innerHTML = '';
  items.forEach(item => {
    const card = document.createElement('div');
    card.className = 'card';
    card.innerHTML = `
      <div class="thumb">
        <img src="${item.productos[0].imagen}" alt="${item.emprendimiento}">
      </div>
      <div class="card-body">
        <h4>${item.emprendimiento}</h4>
        <div class="badges">
          <span>${item.comuna}</span>
          <span>${item.categoria}</span>
        </div>
      </div>
    `;
    card.onclick = () => renderPerfil(item);
    grid.appendChild(card);
  });
}

function renderPerfil(item){
  const rrssHTML = [];

  if(item.rrss?.instagram){
    rrssHTML.push(`
      <a href="${item.rrss.instagram}" target="_blank" rel="noopener">
        Instagram
      </a>
    `);
  }

  if(item.rrss?.facebook){
    rrssHTML.push(`
      <a href="${item.rrss.facebook}" target="_blank" rel="noopener">
        Facebook
      </a>
    `);
  }

  perfil.innerHTML = `
    <div class="profile">
      <div class="profile-inner">

        <div class="profile-img">
          <img src="${item.imagenEmprendedora}" alt="${item.emprendedora}">
        </div>

        <div class="profile-content">
          <h3>${item.emprendimiento}</h3>
          <small>by ${item.emprendedora} · ${item.comuna}</small>

          <p style="margin-top:12px;">${item.descripcion}</p>

          ${rrssHTML.length ? `
            <strong>Redes sociales</strong>
            <div class="rrss">
              ${rrssHTML.join('')}
            </div>
          ` : ''}

          <strong>Productos destacados</strong>
          <div class="products">
            ${item.productos.map(p => `
              <div>
                <div class="product-img">
                  <img src="${p.imagen}" alt="${p.nombre}">
                </div>
                <div>${p.nombre}</div>
              </div>
            `).join('')}
          </div>

          <div style="margin-top:20px">
            <button class="btn secondary" onclick="perfil.innerHTML=''">
              Volver al portafolio
            </button>
          </div>
        </div>

      </div>
    </div>
  `;

  perfil.scrollIntoView({behavior:'smooth'});
}


function populateFilters(items){
  const comunas = [...new Set(items.map(i => i.comuna))];
  const categorias = [...new Set(items.map(i => i.categoria))];

  const comunaSelect = document.getElementById('filter-comuna');
  const categoriaSelect = document.getElementById('filter-categoria');

  comunas.forEach(c => comunaSelect.innerHTML += `<option>${c}</option>`);
  categorias.forEach(c => categoriaSelect.innerHTML += `<option>${c}</option>`);

  comunaSelect.onchange = categoriaSelect.onchange = () => {
    const c = comunaSelect.value;
    const cat = categoriaSelect.value;

    renderGrid(
      data.filter(i =>
        (!c || i.comuna === c) &&
        (!cat || i.categoria === cat)
      )
    );
  };
}
