// SWUP
const options = {
    plugins: [
        new SwupFragmentPlugin({
            rules: [
                {
                    from: /.*/,
                    to:['/about', '/contact'],
                    containers: ['#info-modal'],
                    name: "open-info"
                },
                {
                    from: ['/about', '/contact'],
                    to: /.*/,
                    containers: ['#info-modal', '#menu'],
                    name: 'close-info'
                }
            ]
    })]
};
const swup = new Swup(options);

if(redirect){
    setTimeout(() => {
        // Use Swup to handle the page transition
        if (typeof swup !== 'undefined') {
            swup.navigate( gotoURL );
        } else {
            // Fallback in case Swup is not available
            window.location.assign(gotoURL);
        }
    }, 1000);
}

if (document.readyState === 'complete') {init();
} else {
    document.addEventListener('DOMContentLoaded', () => init());
} 
swup.hooks.on('page:view', () => init());

let previousUrl;
document.addEventListener('swup:page:view', ({ detail: { visit } }) => { previousUrl = visit.from.url; });

function init() {
    UnLazy.lazyLoad();

    //accessibility
    let accessibilityModal = document.querySelector('.accessibility-container');
    let accessibilityOpen = document.querySelector('.menu-button.accessibility');
    let accessibilityClose = document.querySelector('table.accessibility .close');

    let resetButton = document.querySelector('table.accessibility .reset');

    let contrastButtons = document.querySelectorAll('table.accessibility .contrast');
    let saturationButtons = document.querySelectorAll('table.accessibility .saturation');
    let sizeButtons = document.querySelectorAll('table.accessibility .size');
    let heightButtons = document.querySelectorAll('table.accessibility .height');
    let spacingButtons = document.querySelectorAll('table.accessibility .spacing');

    // Open / Close

    accessibilityOpen.addEventListener('click', () => { openDiv(accessibilityModal); });
    accessibilityClose.addEventListener('click', () => { closeDiv(accessibilityModal); });

    // Storing values
    let fontSize = parseInt(localStorage.getItem("fontSize")) || 15,
        contrastType = localStorage.getItem("contrastType") || 'light',
        saturationType = localStorage.getItem("saturationType") || 'bright',
        lineHeight = parseFloat(localStorage.getItem("lineHeight")) || 1.4,
        iconGap = parseFloat(localStorage.getItem("iconGap")) || 60,
        letterSpacing = parseFloat(localStorage.getItem("letterSpacing")) || 0;


    function updateLocalStorage() {
        localStorage.setItem("fontSize", fontSize);
        localStorage.setItem("contrastType", contrastType);
        localStorage.setItem("saturationType", saturationType);
        localStorage.setItem("lineHeight", lineHeight);
        localStorage.setItem("iconGap", iconGap);
        localStorage.setItem("letterSpacing", letterSpacing);

    }

    function changeContrast(type) {
        if (type == 'light') {
            document.documentElement.style.setProperty('--background', '#e6e6e6');
            document.documentElement.style.setProperty('--main', '#000');
        } else if (type == 'dark') {
            document.documentElement.style.setProperty('--background', '#000');
            document.documentElement.style.setProperty('--main', '#fff');
        }
        contrastType = type;
        updateLocalStorage();
    }

    function changeSaturation(type) {
        if (type == 'bright') {
            document.documentElement.style.setProperty('--highlight-one', '#fe4d4d');
            document.documentElement.style.setProperty('--highlight-two', '#ec1bde');
            document.documentElement.style.setProperty('--highlight-one-gradient', '#fe4d4d80');
            document.documentElement.style.setProperty('--highlight-two-gradient', '#ec1bde80');
        } else if (type == 'muted') {
            document.documentElement.style.setProperty('--highlight-two', '#c6bdc5');
            document.documentElement.style.setProperty('--highlight-one', '#936464');
            document.documentElement.style.setProperty('--highlight-two-gradient', '#c6bdc580');
            document.documentElement.style.setProperty('--highlight-one-gradient', '#93646480');
        }
        contrastType = type;
        updateLocalStorage();
    }

    function valueChange(value, min, max, increment, direction) {
        let increase;
        switch (value) {
            case 'size':
                increase = direction == 'up' ? Math.min(fontSize + increment, max) : Math.max(fontSize - increment, min);
                document.documentElement.style.setProperty('--font-size', `${increase}px`);
                fontSize = increase;
                break;
            case 'height':
                increase = direction == 'up' ? Math.min(lineHeight + increment, max) : Math.max(lineHeight - increment, min);
                document.documentElement.style.setProperty('--line-height', increase);
                lineHeight = increase;
                break;
            case 'spacing':
                increase = direction == 'up' ? Math.min(letterSpacing + increment, max) : Math.max(letterSpacing - increment, min);
                document.documentElement.style.setProperty('--letter-spacing', `${increase}px`);
                letterSpacing = increase;
                break;
            case 'gap':
                increase = direction == 'up' ? Math.min(iconGap + increment, max) : Math.max(iconGap - increment, min);
                document.documentElement.style.setProperty('--gap', `${increase}px`);
                iconGap = increase;
                break;
            default:
                break;
        }
        updateLocalStorage();
        updateButtonStates();
    }

    function updateButtonStates() {
        // Update the disabled state of size buttons
        sizeButtons.forEach(button => {
            if (button.dataset.value === 'up') {
                button.classList.toggle('disabled', fontSize >= 20);
            } else {
                button.classList.toggle('disabled', fontSize <= 15);
            }
        });

        // Update the disabled state of line height buttons
        heightButtons.forEach(button => {
            if (button.dataset.value === 'up') {
                button.classList.toggle('disabled', lineHeight >= 2.2);
            } else {
                button.classList.toggle('disabled', lineHeight <= 1.4);
            }
        });

        // Update the disabled state of spacing buttons
        spacingButtons.forEach(button => {
            if (button.dataset.value === 'up') {
                button.classList.toggle('disabled', letterSpacing >= 3);
            } else {
                button.classList.toggle('disabled', letterSpacing <= 0);
            }
        });
    }


    contrastButtons.forEach(button => button.addEventListener('click', () => { changeContrast(button.dataset.value); }));
    saturationButtons.forEach(button => button.addEventListener('click', () => { changeSaturation(button.dataset.value); }));
    sizeButtons.forEach(button => button.addEventListener('click', () => { valueChange('size', 15, 20, 1, button.dataset.value); }));
    heightButtons.forEach(button => button.addEventListener('click', () => { 
        valueChange('height', 1.4, 2.2, 0.2, button.dataset.value); 
        valueChange('gap', 60, 124, 8, button.dataset.value); 
    }
    ));
    spacingButtons.forEach(button => button.addEventListener('click', () => { 
        valueChange('spacing', 0, 3, 1, button.dataset.value); 
         valueChange("gap", 60, 124, 8, button.dataset.value); 
    }));

    updateButtonStates();

    // reset all
    resetButton.addEventListener('click', resetAcc);

    function resetAcc() {
        fontSize = 15;
        contrastType = 'light';
        saturationType = 'bright';
        lineHeight = 1.4;
        letterSpacing = 0;
        iconGap = 60;

        document.documentElement.style.setProperty('--background', '#e6e6e6');
        document.documentElement.style.setProperty('--main', '#000');
        document.documentElement.style.setProperty('--highlight-one', '#fe4d4d');
        document.documentElement.style.setProperty('--highlight-two', '#ec1bde');
        document.documentElement.style.setProperty('--highlight-one-gradient', '#fe4d4d80');
        document.documentElement.style.setProperty('--highlight-two-gradient', 'rgba(236, 27, 222, 0.5)');
        document.documentElement.style.setProperty('--font-size', `${fontSize}px`);
        document.documentElement.style.setProperty('--line-height', lineHeight);
        document.documentElement.style.setProperty('--letter-spacing', `${letterSpacing}px`);
        document.documentElement.style.setProperty('--gap', `${iconGap}px`);

        updateLocalStorage();
        updateButtonStates();
    }


    //Menu on Mobile
    if (document.querySelector('header .showMenu')){
        let menuShowBttn = document.querySelector('header .showMenu');
        let menu = document.querySelector('header .menu');
        let menuLinks = document.querySelectorAll('.menu .menu-button');

        menuShowBttn.addEventListener('click', () => { toggleDiv(menu); });
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                setTimeout(() => {
                    toggleDiv(menu);
                }, 500);
            })
        });
    }

    // Footer Info Open
    if (document.querySelector('.footer.mobile')) {
        let footer = document.querySelector('.footer.mobile');
        let arrow = document.querySelector('.footer .open-arrow');
        let extraInfo = document.querySelector('.modal');

        footer.addEventListener('click', () => {
            arrow.classList.toggle('open');
            extraInfo.classList.toggle('open');
        });
    }

    //EVENTS FUNCTIONS
    if(document.querySelector('.gallery') && document.querySelector('.mobile').style.display == 'none'){
        setTimeout(() => {
            updateGalleryPadding();
        }, 500);

        let gallery = document.querySelector(".gallery");
        let arrow = document.querySelector(".scroll-arrow");

         function updateArrowVisibility() {
           if (gallery.scrollWidth > gallery.clientWidth) {
             arrow.classList.remove("hidden"); 
           } else {
             arrow.classList.add("hidden"); 
           }
         }

         function handleScroll() {
           arrow.classList.add("hidden"); 
            console.log(window.scrollY, window.scrollX);
           clearTimeout(gallery.dataset.scrollTimer);
           gallery.dataset.scrollTimer = setTimeout(() => {
             if (
               gallery.scrollLeft + gallery.clientWidth <
               gallery.scrollWidth
             ) {
               arrow.classList.remove("hidden");
             }
           }, 500); 
         }
         updateArrowVisibility();

         // Event listeners
         gallery.addEventListener("scroll", handleScroll);
         window.addEventListener("resize", () =>{
            updateGalleryPadding;
            updateArrowVisibility;
         });
    }

    if(document.querySelector('.event-title')){
        let fancyLinks = document.querySelectorAll(".info .pdf-button a");
        fancyLinks.forEach((link) => {
          link.insertAdjacentHTML(
            "beforebegin",
            '<svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71.76 71.42"><path class="star-1" d="M39.81,0s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/> <path class="star-2" d="M32.41,7.55s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/></svg>'
          );
        });
    }

    // LIGHTBOX FUNCTIONS
    if ( document.querySelector(".main-container.media-file")){
        function captionCheck(){
            if(window.matchMedia("(max-width: 750px)").matches){
                if (document.querySelector(".image-info .lightbox.modal")) {
                   document.querySelector(".mobile.footer").style.display = "flex";
                } else {
                   document.querySelector(".mobile.footer").style.display = "none";
                }
            } else { document.querySelector(".mobile.footer").style.display = "none";}
        }
        captionCheck()
        window.addEventListener("resize", captionCheck);
    } 
    

    function updateGalleryPadding() {
        let gallery = document.querySelector('.gallery');
        let firstImage = gallery.querySelector('.gallery-item');
        if (firstImage) {
            const firstImageWidth = firstImage.offsetWidth;
            const padding = `0 calc(50vw - ${firstImageWidth / 2}px)`;

            gallery.style.padding = padding;
        }
    }

    //Get URL for filtering
    if(document.querySelector('.extra-info.filters')){
        let tags = document.querySelectorAll('.filters .tag');
        let allTags = document.querySelectorAll('.filters .tag.all');
        let filterButton = document.querySelector('.extra-info button.apply');
        let clearButton = document.querySelector('.extra-info button.clear');

        tags.forEach(tag => tag.addEventListener('click', () =>{
            const filterGroup = tag.parentElement;
            const allTag = filterGroup.querySelector('.tag.all');
            if (tag === allTag) {
                const otherTags = filterGroup.querySelectorAll('.tag:not(.all)'); 
                otherTags.forEach(otherTag => otherTag.classList.remove('active'));
                allTag.classList.add('active');
            } else {
                if (allTag) { allTag.classList.remove('active');}
                tag.classList.toggle('active');

                const activeTags = filterGroup.querySelectorAll('.tag.active');
                if (activeTags.length === 0) {
                    allTag.classList.add('active');
                }
            }
        }));

        function clearTags(){
            tags.forEach(tag => { tag.classList.remove('active');});
            allTags.forEach(tag => { tag.classList.add('active');});
        }

        function createURL(){
            let url = '/archive';
            let filters = {};
            document.querySelectorAll('.filters .active').forEach(active => {
                let type = active.classList[0];  // 'year', 'type', 'subject'
                if (!filters[type]) filters[type] = [];
                if (active.dataset.value !== '') filters[type].push(active.dataset.value.split(':')[1]);
            });

            Object.keys(filters).forEach(type => {
                if (filters[type].length > 0) {
                    url += `/${type}:${filters[type].join('+')}`;
                }
            });
            swup.navigate(url);
        }
        filterButton.addEventListener('click', createURL);
        clearButton.addEventListener('click', clearTags);
    }

    //Play audio
    if (document.querySelectorAll('.audio-player').length > 0){
        let audioPlayers = document.querySelectorAll('.audio-player');

        audioPlayers.forEach(player => {
            playerFunctions(player);
        });
    }

    // Modal Close
    document.getElementById('info-modal').addEventListener('click', function (event) {
        const content = document.querySelector('.info-content');
        if (!content.contains(event.target)) {
            let url;
            if (previousUrl) { url = previousUrl;
            }else {  
                let currentUrl = window.location.href;
                let trimmedUrl = currentUrl.endsWith('/') ? currentUrl.slice(0, -1) : currentUrl;
                url = trimmedUrl.substring(0, trimmedUrl.lastIndexOf('/') + 1);
                // url = window.location.origin;
            }
            swup.navigate(url);
        }
    });
}


// Audio Player function
function playerFunctions(player) {
    let playBttn = player.querySelector('.play-icon');
    const audio = player.querySelector('audio');
    const durationContainer = player.querySelector('.duration');
    let rAF = null;

    const calculateTime = (secs) => {
        const minutes = Math.floor(secs / 60);
        const seconds = Math.floor(secs % 60);
        const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
        return `${minutes}:${returnedSeconds}`;
    }
    const displayDuration = () => {
        durationContainer.innerText = calculateTime(audio.duration);
    }
    const seekSlider = player.querySelector('.seek-slider');
    const setSliderMax = () => {
        seekSlider.max = Math.floor(audio.duration);
    }
    const currentTimeContainer = player.querySelector('.current-time');

    const whilePlaying = () => {
        seekSlider.value = Math.floor(audio.currentTime);
        currentTimeContainer.textContent = calculateTime(seekSlider.value);
        player.style.setProperty('--seek-before-width', `${seekSlider.value / seekSlider.max * 100}%`);
        rAF = requestAnimationFrame(whilePlaying);
    }
    playBttn.addEventListener('click', () => {
        playBttn.classList.toggle('playing');
        if (playBttn.classList.contains('playing')) {
            audio.play();
            requestAnimationFrame(whilePlaying);
        } else {
            audio.pause();
            cancelAnimationFrame(rAF);
        }
    });

    seekSlider.addEventListener('input', () => {
        currentTimeContainer.textContent = calculateTime(seekSlider.value);
        if (!audio.paused) { cancelAnimationFrame(rAF); }
    });
    seekSlider.addEventListener('change', () => {
        audio.currentTime = seekSlider.value;
        if (!audio.paused) { requestAnimationFrame(whilePlaying); }
    });

    audio.addEventListener('loadedmetadata', () => { displayDuration(audio.duration); });
    audio.addEventListener('timeupdate', () => { seekSlider.value = Math.floor(audio.currentTime); });
    audio.addEventListener('ended', () => {
        audio.currentTime = 0;
        playBttn.classList.toggle('playing');
    });

    if (audio.readyState > 0) {
        displayDuration();
        setSliderMax();
    } else {
        audio.addEventListener('loadedmetadata', () => {
            displayDuration();
            setSliderMax();
        });
    }
}

function openDiv(object) {  object.classList.remove('hidden')}
function closeDiv(object) {  object.classList.add('hidden')}
function toggleDiv(object) { object.classList.toggle('shown') }