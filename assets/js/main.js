// AJAX add-to-cart: updates cart count without redirecting
document.addEventListener('click', function(e){
  const btn = e.target.closest('.add-cart-btn');
  if(!btn) return;
  e.preventDefault();
  const id = btn.dataset.id;
  btn.disabled = true;
  btn.textContent = 'Adding...';
  fetch('add_to_cart.php?id=' + encodeURIComponent(id), {credentials:'same-origin'})
    .then(r => r.json())
    .then(data => {
      if(data.success){
        const c = document.querySelector('.cart-count');
        if(c) c.textContent = data.count;
        btn.textContent = '✓ Added';
        setTimeout(()=>{ btn.textContent='Add to Cart'; btn.disabled=false; }, 1200);
      } else {
        btn.textContent = data.message || 'Error';
        setTimeout(()=>{ btn.textContent='Add to Cart'; btn.disabled=false; }, 1500);
      }
    })
    .catch(()=>{ btn.textContent='Error'; btn.disabled=false; });
});
