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
// const swup = new Swup();

if (document.readyState === 'complete') {init();
} else {
    document.addEventListener('DOMContentLoaded', () => init());
} 
swup.hooks.on('page:view', () => init());

let previousUrl;
document.addEventListener('swup:page:view', ({ detail: { visit } }) => { previousUrl = visit.from.url; });

function init() {
    UnLazy.lazyLoad()

    // Footer Info Open
    if (document.querySelector('.footer.mobile')) {
        let footer = document.querySelector('.footer.mobile');
        let arrow = document.querySelector('.footer .open-arrow');
        let extraInfo = document.querySelector('.extra-info');

        footer.addEventListener('click', () => {
            arrow.classList.toggle('open');
            extraInfo.classList.toggle('open');
        });
    }

    //Get URL for filtering
    if(document.querySelector('.extra-info.filters')){
        let tags = document.querySelectorAll('.filters .tag');
        let filterButton = document.querySelector('.extra-info button')

        tags.forEach(tag => tag.addEventListener('click', () =>{
            [...tag.parentElement.children].forEach(child => child.classList.remove('active'));
            tag.classList.add('active');
        }));

        function createURL(){
            let url = '';
            let activetags = document.querySelectorAll('.filters .active');
            activetags.forEach(active => {
                if (active.dataset.value != ''){
                url += '/' + active.dataset.value;}
            });
            // window.Location.href = window.location.origin + url;
            swup.navigate(window.location.origin + url)
        }
        filterButton.addEventListener('click', createURL);
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