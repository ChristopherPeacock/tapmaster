import robot from 'robotjs';
import Tesseract from 'tesseract.js';

// Capture a screenshot of a specific area (x, y, width, height)
const screen = robot.screen.capture(-1529, -65, 500, 500); // Adjust the area as needed

// Convert the image to a buffer
const imageBuffer = screen.image;

// Run OCR on the captured image
Tesseract.recognize(imageBuffer, 'eng', {
  logger: (m) => console.log(m), // Show progress
})
.then(({ data: { text } }) => {
  console.log('Extracted Text:', text);
})
.catch((err) => {
  console.error('OCR error:', err);
});