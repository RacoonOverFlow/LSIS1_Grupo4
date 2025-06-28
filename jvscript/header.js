document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('.tab-button');

  // Clear existing active buttons
  buttons.forEach(btn => btn.classList.remove('active'));

  // Set active tab based on current URL
  const currentPage = window.location.pathname;

  if (currentPage.includes('equipas.php')) {
    document.querySelector('[data-tab="Equipas"]')?.classList.add('active');
  } else if (currentPage.includes('perfil.php')){
    document.querySelector('[data-tab="Perfil"]')?.classList.add('active');
  } else if (currentPage.includes('dashboard.php')){
    document.querySelector('[data-tab="Dashboard"]')?.classList.add('active');
  } 

  // Tab switching for same-page tabs (like Tab 1 and Tab 3)
  buttons.forEach(button => {
    // Only add event listener if it's a button (not an <a>)
    if (button.tagName === 'BUTTON') {
      button.addEventListener('click', () => {
        const tabId = button.getAttribute('data-tab');

        // Activate selected tab button
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

      });
    }
  });
});
