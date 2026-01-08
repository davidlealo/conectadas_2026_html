document.addEventListener("DOMContentLoaded", () => {

  const grid = document.getElementById("portfolioGrid");
  if (!grid) return;

  const cards = [...grid.querySelectorAll(".card")];
  const filterComuna = document.getElementById("filterComuna");
  const filterCategoria = document.getElementById("filterCategoria");
  const filterOrden = document.getElementById("filterOrden");
  const resultsCount = document.getElementById("resultsCount");

  const normalize = s => (s || "").toLowerCase().trim();

  function match(card, attr, value) {
    if (!value) return true;
    const raw = card.dataset[attr] || "";
    return raw.split("|").map(normalize).includes(normalize(value));
  }

  function apply() {
    let visible = 0;

    cards.forEach(card => {
      const okComuna = match(card, "comuna", filterComuna.value);
      const okCategoria = match(card, "categoria", filterCategoria.value);

      const show = okComuna && okCategoria;
      card.style.display = show ? "" : "none";
      if (show) visible++;
    });

    if (resultsCount) resultsCount.textContent = visible;
    sort();
  }

  function sort() {
    const order = filterOrden.value;
    const visibles = cards.filter(c => c.style.display !== "none");

    visibles.sort((a, b) => {
      const ta = a.dataset.title;
      const tb = b.dataset.title;
      return order === "az" ? ta.localeCompare(tb) : tb.localeCompare(ta);
    });

    visibles.forEach(c => grid.appendChild(c));
  }

  filterComuna?.addEventListener("change", apply);
  filterCategoria?.addEventListener("change", apply);
  filterOrden?.addEventListener("change", apply);

  apply();
});
