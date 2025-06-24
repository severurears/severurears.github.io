const scrollContent = document.querySelector('.scroll-content');

let isDown = false;
let startX;
let scrollLeft;

scrollContent.addEventListener('mousedown', (e) => {
  isDown = true;
  scrollContent.classList.add('active');
  startX = e.pageX - scrollContent.offsetLeft;
  scrollLeft = scrollContent.scrollLeft;
});

scrollContent.addEventListener('mouseleave', () => {
  isDown = false;
  scrollContent.classList.remove('active');
});

scrollContent.addEventListener('mouseup', () => {
  isDown = false;
  scrollContent.classList.remove('active');
});

scrollContent.addEventListener('mousemove', (e) => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - scrollContent.offsetLeft;
  const walk = (x - startX) * 2; // multiply for speed
  scrollContent.scrollLeft = scrollLeft - walk;
});

const cards = document.querySelectorAll('.card');

cards.forEach((card) => {
  card.addEventListener('click', () => {
    // If this card is already expanded, collapse it
    if (card.classList.contains('expanded')) {
      card.classList.remove('expanded');
    } else {
      // Collapse any previously expanded card
      cards.forEach((c) => c.classList.remove('expanded'));
      // Expand the clicked card
      card.classList.add('expanded');
    }
  });
});
