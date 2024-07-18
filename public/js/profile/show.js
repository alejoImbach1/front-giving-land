//para imágenes
const imageInput = document.getElementById('image_input');
const bigLabelImages = document.getElementById('big_label_images');
const smallLabelImages = document.getElementById('small_label_images');
let files = [];
const imagesContainer = document.getElementById('images_container');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
let images = [];
let currentIndex = 0;


//métodos para las imágenes
// imageInput.addEventListener('input', () => {
//     // console.log(Array.from(imageInput.files).length);
//     if (files.concat(Array.from(imageInput.files)).length > 5) {
//         alert('Sólo puedes subir hasta 5 imágenes');
//         return;
//     }

//     files = files.concat(Array.from(imageInput.files));
//     images = files.map(file => URL.createObjectURL(file));
//     if (images.length) {
//         bigLabelImages.classList.add('hidden');
//         smallLabelImages.classList.remove('hidden');
//     }

//     if(images.length > 4){
//         smallLabelImages.classList.add('hidden');
//     }

//     renderImages();
// });

// prevBtn.addEventListener('click', () => {
//     if (currentIndex > 0) {
//         currentIndex--;
//         updateCarousel();
//     }
// });

// nextBtn.addEventListener('click', () => {
//     if (currentIndex < images.length - 1) {
//         currentIndex++;
//         updateCarousel();
//     }
// });

// function renderImages() {
//     imagesContainer.innerHTML = images.map((src, index) => `
//                 <div class="relative w-full">
//                     <div class="flex justify-center items-center h-72">
//                         <img src="${src}" class="max-w-fit" style="height: 120%;">
//                     </div>
//                     <button class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full" onclick="removeImage(${index})">x</button>
//                 </div>
//     `).join('');

//     if(images.length){
//         currentIndex = 0;
//         updateCarousel();
//     }
// }

function updateCarousel() {
    imagesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
    const containerChildren = Array.from(imagesContainer.children);
    containerChildren.forEach((child) => {
        child.classList.add('hidden');
    });

    containerChildren[currentIndex].classList.remove('hidden');

    if (currentIndex != 0) {
        prevBtn.classList.remove('hidden');
    } else {
        prevBtn.classList.add('hidden');
    }

    if (currentIndex == images.length - 1) {
        nextBtn.classList.add('hidden');
    } else {
        nextBtn.classList.remove('hidden');
    }
    
}

// window.removeImage = (index) => {
//     images.splice(index, 1);
//     files.splice(index, 1);
//     renderImages();

//     if (!images.length) {
//         bigLabelImages.classList.remove('hidden');
//         smallLabelImages.classList.add('hidden');
//     }else{
//         smallLabelImages.classList.remove('hidden');
//     }
// };