  // Mostrar preloader durante la carga
  document.addEventListener('DOMContentLoaded', () => {
    const preloader = document.getElementById('preloader');
    const preloaderBar = document.getElementById('preloader-bar');
    
    if (preloader && preloaderBar) {
      preloader.style.display = 'block';
      
      let progress = 0;
      const interval = setInterval(() => {
        progress += 10;
        preloaderBar.style.width = `${progress}%`;
        
        if (progress >= 100) {
          clearInterval(interval);
          setTimeout(() => {
            preloader.style.opacity = '0';
            setTimeout(() => {
              preloader.style.display = 'none';
            }, 300);
          }, 200);
        }
      }, 100);
    }
  });
