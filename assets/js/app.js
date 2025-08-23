(function () {
  const stack = document.getElementById('flash-stack');
  if (!stack) return;
  setTimeout(() => {
    stack.style.transition = 'opacity .3s ease';
    stack.style.opacity = '0';
    setTimeout(() => stack.remove(), 300);
  }, 4000);
})();
