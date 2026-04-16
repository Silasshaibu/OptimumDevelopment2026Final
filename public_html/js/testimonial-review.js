(function () {
    var maxVisibleCharacters = 149;
    var collapsedCharacterCount = 146;
    var extraCards = document.querySelectorAll('.tst-card--hidden');
    var viewAllButton = document.querySelector('.tst-view-all-btn');
    var reviewToggles = [];

    function createCollapsedText(text) {
        return text.slice(0, collapsedCharacterCount).trimEnd() + '...';
    }

    document.querySelectorAll('.review-platform-default').forEach(function (review) {
        var fullHtml = review.innerHTML.trim();
        var fullText = review.textContent.replace(/\s+/g, ' ').trim();

        if (fullText.length <= maxVisibleCharacters) {
            review.innerHTML = fullHtml;
            return;
        }

        var textNode = document.createElement('span');
        var toggleButton = document.createElement('button');
        var isExpanded = false;

        textNode.className = 'tst-card__review-text';
        toggleButton.className = 'tst-card__read-more';
        toggleButton.type = 'button';

        function renderReview() {
            if (isExpanded) {
                textNode.innerHTML = fullHtml;
            } else {
                textNode.textContent = createCollapsedText(fullText);
            }

            toggleButton.textContent = isExpanded ? 'Read Less' : 'Read More';
            toggleButton.setAttribute('aria-expanded', String(isExpanded));
        }

        function setExpanded(nextExpanded) {
            isExpanded = nextExpanded;
            renderReview();
        }

        toggleButton.addEventListener('click', function () {
            if (!isExpanded) {
                reviewToggles.forEach(function (toggle) {
                    toggle.setExpanded(false);
                });
            }

            setExpanded(!isExpanded);
        });

        review.textContent = '';
        review.appendChild(textNode);
        review.appendChild(toggleButton);
        reviewToggles.push({
            setExpanded: setExpanded
        });
        renderReview();
    });

    if (viewAllButton && extraCards.length > 0) {
        viewAllButton.addEventListener('click', function () {
            var isExpanded = viewAllButton.getAttribute('aria-expanded') === 'true';

            extraCards.forEach(function (card) {
                card.classList.toggle('is-visible', !isExpanded);
            });

            viewAllButton.setAttribute('aria-expanded', String(!isExpanded));
            viewAllButton.querySelector('span').textContent = isExpanded ? 'View All' : 'View Less';
        });
    }
}());