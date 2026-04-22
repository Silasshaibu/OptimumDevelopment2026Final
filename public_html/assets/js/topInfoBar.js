function toggleLangDropdown() {
    document.getElementById('langDropdown').classList.toggle('active');
}

function selectLang(flagSrc, langName, event) {
    event.stopPropagation();
    const langDiv = document.querySelector('.lang');
    langDiv.querySelector('img').src = flagSrc;
    langDiv.querySelector('img').alt = langName + ' Flag';
    langDiv.querySelector('span').textContent = langName;
    document.getElementById('langDropdown').classList.remove('active');
}

document.addEventListener('click', function (e) {
    const langDiv = document.querySelector('.lang');
    if (!langDiv.contains(e.target)) {
        document.getElementById('langDropdown').classList.remove('active');
    }
});

const locationLink = document.getElementById('location-link');
const fullLocationText = ' Illinois, Indiana, Ohio, and Florida.';
const shortLocationText = 'Indiana...';

const mq = window.matchMedia('(max-width: 968px)');

function handleLocationText(e) {
    locationLink.textContent = e.matches ? shortLocationText : fullLocationText;
}

handleLocationText(mq);
mq.addEventListener('change', handleLocationText);
