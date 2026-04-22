
  const stars = document.querySelectorAll('.star');
  const ratingInput = document.getElementById('rating');
  let selectedRating = 0;

  stars.forEach(star => {
    star.addEventListener('mouseover', () => {
      highlightStars(star.dataset.value);
    });

    star.addEventListener('mouseout', () => {
      highlightStars(selectedRating);
    });

    star.addEventListener('click', () => {
      selectedRating = star.dataset.value;
      ratingInput.value = selectedRating;
    });
  });

  function highlightStars(value) {
    stars.forEach(star => {
      star.classList.toggle('active', star.dataset.value <= value);
    });
  }

  document.getElementById('contactForm').addEventListener('submit', e => {
    e.preventDefault();
    if (!ratingInput.value) {
      alert('Please select a rating');
      return;
    }
    alert('Review submitted successfully!');
    e.target.reset();
    highlightStars(0);
  });