// Бургер-меню
document.addEventListener('DOMContentLoaded', function() {
  // Мобильное меню
  const burger = document.getElementById('burger');
  const navLinks = document.getElementById('nav-links');
  
  if (burger && navLinks) {
    burger.addEventListener('click', function() {
      navLinks.classList.toggle('active');
      burger.classList.toggle('toggle');
    });
  }

  // Обработка выпадающего меню
  const dropdowns = document.querySelectorAll('.dropdown');
  
  dropdowns.forEach(dropdown => {
    const toggle = dropdown.querySelector('.dropdown-toggle');
    
    toggle.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      // Закрываем все остальные выпадающие меню
      dropdowns.forEach(d => {
        if (d !== dropdown) {
          d.classList.remove('active');
        }
      });
      
      // Открываем/закрываем текущее меню
      dropdown.classList.toggle('active');
    });
  });
  
  // Закрытие меню при клике вне его
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown')) {
      dropdowns.forEach(dropdown => {
        dropdown.classList.remove('active');
      });
    }
  });

  // Выпадающее меню на мобильных устройствах
  if (window.innerWidth <= 768) {
    dropdowns.forEach(dropdown => {
      const toggleBtn = dropdown.querySelector('.dropdown-toggle');
      
      if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
          e.preventDefault();
          dropdown.classList.toggle('active');
        });
      }
    });
  }

  // Закрытие меню при клике вне его
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown') && !e.target.closest('.burger')) {
      dropdowns.forEach(dropdown => {
        dropdown.classList.remove('active');
      });
      
      if (window.innerWidth <= 768 && e.target.closest('a') && !e.target.closest('.dropdown-toggle')) {
        navLinks.classList.remove('active');
        burger.classList.remove('toggle');
      }
    }
  });
});

// Анимация появления элементов при скролле
const observerOptions = {
  threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
    }
  });
}, observerOptions);

document.querySelectorAll('.feature-card, .service-card').forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(20px)';
  el.style.transition = 'all 0.6s ease-out';
  observer.observe(el);
});

// Закрытие мобильного меню при клике на ссылку
document.querySelectorAll('nav a').forEach(link => {
  link.addEventListener('click', function() {
    document.getElementById('burger').classList.remove('active');
    document.getElementById('nav-links').classList.remove('active');
  });
});

// Анимация бургер-меню
const burgerLines = document.querySelectorAll('.burger div');
document.getElementById('burger').addEventListener('click', function() {
  burgerLines[0].style.transform = this.classList.contains('active') 
    ? 'rotate(-45deg) translate(-5px, 6px)' 
    : 'none';
  burgerLines[1].style.opacity = this.classList.contains('active') ? '0' : '1';
  burgerLines[2].style.transform = this.classList.contains('active')
    ? 'rotate(45deg) translate(-5px, -6px)'
    : 'none';
}); 