 <div class="row">
            <div class="col-lg-4 col-md-12">
              <div class="car-item gray-bg text-center">
               <div class="car-image">
                 <img class="img-fluid" src="images/car/02.jpg" alt="">
                 <div class="car-overlay-banner">
                  <ul>
                    <li><a href="#"><i class="fa fa-link"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                   </ul>
                 </div>
               </div>
              </div>
             </div>
              <div class="col-lg-8 col-md-12">
                <div class="car-details">
                <div class="car-title">
                 <a href="#">Lexus GS 450h</a>
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero numquam repellendus non voluptate. Harum blanditiis ullam deleniti.</p>
                  </div>
                  <div class="price">
                       <span class="old-price">$35,568</span>
                       <span class="new-price">$32,698 </span>
                       <a class="button red float-end" href="#">Details</a>
                     </div>
                   <div class="car-list">
                     <ul class="list-inline">
                       <li><i class="fa fa-registered"></i> 2016</li>
                       <li><i class="fa fa-cog"></i> Manual </li>
                       <li><i class="fa fa-shopping-cart"></i> 6,000 mi</li>
                     </ul>
                   </div>
                  </div>
                </div>
               </div>
{{--
// function fetchFilteredCars(query = '') {
//   axios.get(API_URL + '?' + query)
//     .then(response => {
//       const cars = response.data;
//       container.innerHTML = ''; // Clear results

//       if (!cars.length) {
//         container.innerHTML = '<p style="font-size: 24px; text-align: center; padding: 16px 0; font-weight: bold; color: red; ">No cars found.</p>';
//         return;
//       }

//       cars.forEach(car => {
//         const images = JSON.parse(car.images || '[]');
//         const imageSrc = images.length ? `/${images[0]}` : '/images/no-image.png';

//         const carDiv = document.createElement('div');
//         carDiv.className = 'grid-item';

//         carDiv.innerHTML = `
//           <div class="car-item gray-bg text-center">
//             <div class="car-image">
//               <img class="img-fluid fixed-img" src="${imageSrc}" alt="">
//               <div class="car-overlay-banner">
//                 <ul>
//                   <li><a href="#"><i class="fa fa-link"></i></a></li>
//                   <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
//                 </ul>
//               </div>
//             </div>
//             <div class="car-list">
//               <ul class="list-inline">
//                 <li><i class="fa fa-registered"></i> ${car.year}</li>
//                 <li><i class="fa fa-cog"></i> ${car.transmission_type}</li>
//                 <li><i class="fa fa-shopping-cart"></i> 6,000 mi</li>
//               </ul>
//             </div>
//             <div class="car-content">
//               <div class="star">
//                 <i class="fa fa-star orange-color"></i>
//                 <i class="fa fa-star orange-color"></i>
//                 <i class="fa fa-star orange-color"></i>
//                 <i class="fa fa-star orange-color"></i>
//                 <i class="fa fa-star-o orange-color"></i>
//               </div>
//               <a href="#">${car.model}</a>
//               <div class="separator"></div>
//               <div class="price">
//                 <span class="old-price">$${car.regular_price}</span>
//                 <span class="new-price">$${car.sale_price}</span>
//               </div>
//             </div>
//           </div>
//         `;
//         container.appendChild(carDiv);
//       });
//     })
//     .catch(error => {
//       console.error('Error fetching cars:', error);
//       container.innerHTML = '<p>Failed to load cars.</p>';
//     });
// }                --}}
<select id="sort-select" style="" onchange="console.log('asdfsfd')">
                <option value="">Sort by Default</option>
                <option value="name">Sort by Name</option>
                <option value="price">Sort by Price</option>
                <option value="date">Sort by Date</option>
             </select>
