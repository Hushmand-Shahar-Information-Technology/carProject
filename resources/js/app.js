import '../css/app.css';

import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'alpinejs'




import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import '@fortawesome/fontawesome-free/js/all.js';
// Import Bootstrap's JS (requires Popper)



// import others similarly if installed via npm

import 'bootstrap';
import 'jquery';
import 'owl.carousel';
import 'magnific-popup';

// Your custom JS if needed


import Alpine from 'alpinejs';

window.Alpine = Alpine;


Alpine.start();



// Example initialization:
const swiper = new Swiper('.swiper-container', {
  modules: [Navigation, Pagination],
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});
