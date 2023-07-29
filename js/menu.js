  // Função para exibir/ocultar o menu móvel
  function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenu.classList.toggle('active');
  }

  // Event listener para o clique no ícone de menu
  const menuIcon = document.getElementById('menu-icon');
  menuIcon.addEventListener('click', toggleMobileMenu);