// Get the menu box element by its ID
let menuBox = document.getElementById("menu-box");

// Get the hamburger icon button element by its ID
let hamButton = document.getElementById("ham-icon");

// Get all elements with the class "menu-link"
let links = document.querySelectorAll(".menu-link");

// Variable to toggle the visibility of the menu, default is "none" (hidden)
let toggle = "none";

// Add a click event listener to each menu link
links.forEach(link => {
    link.addEventListener("click", () => {
        // Hide the menu when a link is clicked
        toggle = "none";
        console.log(0); // Log a value to the console for debugging
        menuBox.style.display = toggle;
    });
});

// Add a click event listener to the hamburger button
hamButton.addEventListener("click", () => {
    // Toggle the menu display between "block" (visible) and "none" (hidden)
    if (toggle == "none") {
        toggle = "block"; // Show the menu
    } else {
        toggle = "none"; // Hide the menu
    }

    // Apply the updated display style to the menu box
    menuBox.style.display = toggle;
});







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

