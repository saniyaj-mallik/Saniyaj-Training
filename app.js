let menuBox = document.getElementById("menu-box");
let hamButton = document.getElementById("ham-icon")
let links = document.querySelectorAll(".menu-link");
let toggle = "none";

links.forEach(link => {
    link.addEventListener("click", () => {
        toggle = "none"
        console.log(0)
        menuBox.style.display = toggle
    });
});

hamButton.addEventListener("click", () => {
    if (toggle == "none") {
        toggle = "block"
    }
    else {
        toggle = "none"
    }

    menuBox.style.display = toggle
})






// Slider

const slide = document.querySelector('.slide');
const leftArrow = document.getElementById('left-arrow');
const rightArrow = document.getElementById('right-arrow');
const slides = document.querySelectorAll('.slide img');
const totalSlides = slides.length;

let currentIndex = 0;
let autoSlideInterval;

// Function to update the slider position
function updateSlider() {
    slide.style.transform = `translateX(-${currentIndex * 100}%)`;
}

// Event listeners for arrows
rightArrow.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % totalSlides; // Loop back to the first slide
    updateSlider();
    resetAutoSlide(); // Reset auto-slide timer on manual interaction
});

leftArrow.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; // Loop back to the last slide
    updateSlider();
    resetAutoSlide(); // Reset auto-slide timer on manual interaction
});

// Function to start auto-sliding
function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlider();
    }, 3000); // Change slide every 3 seconds
}

// Function to reset the auto-slide timer
function resetAutoSlide() {
    clearInterval(autoSlideInterval);
    startAutoSlide();
}

// Start auto-slide when the page loads
startAutoSlide();

