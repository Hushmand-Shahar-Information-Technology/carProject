// resources/js/app.js
import Swiper, { Navigation, Pagination } from 'swiper';
// resources/js/app.js
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';



const swiper = new Swiper('.swiper', {
  loop: true,
  pagination: {
    el: '.swiper-pagination',
  },
});

import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
// import others similarly if installed via npm

import 'bootstrap';
import 'jquery';
import 'owl.carousel';
import 'magnific-popup';

// Your custom JS if needed


import Alpine from 'alpinejs';

window.Alpine = Alpine;


Alpine.start();



// configure Swiper to use modules
Swiper.use([Navigation, Pagination]);

// Initialize Swiper when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  const swiper = new Swiper('.swiper-container', {
    // Optional parameters
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
});
