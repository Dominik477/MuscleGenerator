(function () {
  const stack = document.getElementById('flash-stack');
  if (!stack) return;
  setTimeout(() => {
    stack.style.transition = 'opacity .3s ease';
    stack.style.opacity = '0';
    setTimeout(() => stack.remove(), 300);
  }, 4000);
})();
(function () {
  const stack = document.getElementById('flash-stack');
  if (!stack) return;
  setTimeout(() => {
    stack.style.transition = 'opacity .3s ease';
    stack.style.opacity = '0';
    setTimeout(() => stack.remove(), 300);
  }, 4000);
})();

(function () {
  const forms = document.querySelectorAll('form.form');
  forms.forEach(form => {
    const submitBtn = form.querySelector('button[type="submit"]');
    form.querySelectorAll('textarea[maxlength]').forEach(ta => {
      const max = parseInt(ta.getAttribute('maxlength'), 10);
      const counter = document.createElement('div');
      counter.className = 'char-counter';
      counter.textContent = `0 / ${max}`;
      ta.parentElement.appendChild(counter);
      const update = () => { counter.textContent = `${ta.value.length} / ${max}`; };
      ta.addEventListener('input', update);
      update();
    });

    form.addEventListener('submit', (e) => {
      if (!form.checkValidity()) {
        e.preventDefault();
        form.reportValidity();
        return;
      }
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.dataset.origText = submitBtn.textContent;
        submitBtn.textContent = 'Wysyłanie...';
      }
    });
  });
})();

(function(){
  var btn = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');
  if (!btn || !nav) return;

  btn.addEventListener('click', function(){
    var open = document.body.classList.toggle('nav-open');
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });

  nav.addEventListener('click', function(e){
    var a = e.target.closest('a');
    if (!a) return;
    if (window.matchMedia('(max-width: 879px)').matches) {
      document.body.classList.remove('nav-open');
      btn.setAttribute('aria-expanded', 'false');
    }
  }, true);
})();

