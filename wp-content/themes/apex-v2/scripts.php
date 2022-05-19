<script>
	
	function defer(method) {
	    if (window.jQuery) {
	        method();
	    } else {
	        setTimeout(function() { defer(method) }, 50);
	    }
	}
	
	defer(fireScripts);

    document.addEventListener('DOMContentLoaded', function () {

        //Mobile navigation trigger
        (function() {
            let navTrigger = document.querySelector('.nav-trigger');
            if (navTrigger) {
                navTrigger.addEventListener('click', function () {
                    let htmlTag = document.querySelector('html');
                    htmlTag.classList.toggle('nav-closed');
                    htmlTag.classList.toggle('nav-open');
                });
            };
        })();

        //Burger menu submenu items
        (function(menuItemSelector = '.nav-mobile .menu-item-has-children', subMenuSelector = '.sub-menu', hoverClass = 'hover' ) {

            document.querySelectorAll(menuItemSelector).forEach(function(menuItem) {
                let aTag = menuItem.querySelector(':scope > a');
                aTag.addEventListener('click', function(e) {
                    e.preventDefault();
                    if(!menuItem.classList.contains(hoverClass)) {
                        document.querySelectorAll(menuItemSelector + '.' + hoverClass).forEach((el) => el.classList.remove(hoverClass));
                        console.log('class added');
                    }
                    menuItem.classList.toggle(hoverClass);
                })
            })

            document.querySelectorAll(subMenuSelector).forEach(function(subMenu) {
                let totalHeight = 0;
                let liElem = subMenu.querySelectorAll('li');
                liElem.forEach(function(el) {
                    totalHeight+= el.offsetHeight;
                });
                subMenu.style.setProperty('--submenu-height', totalHeight + 'px');
            });
        })();

        //One touch for hover on desktop menu for touch devices
        (function() {
            document.querySelectorAll('.nav-main li.menu-item-has-children').forEach(function(subMenu) {
                subMenu.addEventListener('touchstart', function (e) {
                    if(subMenu.classList.contains('touch-hover')) {
                        return true;
                    } else {
                        e.preventDefault();
                        if(document.querySelector('.touch-hover')) {
                            document.querySelector('.touch-hover').classList.remove('touch-hover');
                        }
                        subMenu.classList.add('touch-hover')
                        return false;
                    }
                });
            });
        })();

            function smoothPageTransit() {

                let excludes = ['mailto:','tel:','.pdf','.jpg','.doc','.png','.webp','svg']

                document.querySelectorAll('a').forEach(function (aTag) {

                    let skip = false
                    excludes.forEach( (ex) =>  skip = ( aTag.href.search(ex) !== -1 ) ?? true );

                    if( window.location.origin == aTag.origin && aTag.href.search(window.location.href + '#') == -1 && !skip ) {
                        aTag.addEventListener('click', function (e) {
                            e.preventDefault();
                            let url = aTag.href;
                            document.querySelector('html').classList.add('transition-page', '-start');
                            loadPage(url);
                            setTimeout(() => document.querySelector('html').classList.remove('transition-page', '-end', '-start'), 2300);
                        })
                    }
                });

            }

            function delay(t, v) {
                return new Promise(function(resolve) {
                    setTimeout(resolve.bind(null, v), t)
                });
            }

            function loadPage(url) {
                let page = {};
                fetch(url)
                    .then((response) => console.log(response.headers))
                    .then((html) => {
                        page.header = html.substring(0, html.search('<body '));
                        page.body = html.substring(html.search('<body '), html.length);
                        document.querySelector('html').setAttribute('style', 'background: #3c3842;');
                        window.history.pushState('page2', html.title, url);
                        return page
                    })
                    .then((page) => {
                        return delay(350).then( ()=>document.querySelector('body').innerHTML = page.body);
                    }).then(() => {
                        return delay(800).then( ()=> {
                            document.querySelector('html').classList.add('-end')
                            document.querySelector('html').classList.remove('-start')
                        });
                    })
                    .then(() => {
                        return delay(200).then( ()=> {
                            document.querySelector('html').removeAttribute('style');
                            document.querySelector('head').innerHTML = page.header
                            console.log(page.header);
                        })
                    })
                    .then(() => {
                        document.querySelector('body').setAttribute('style', 'display:block;');
                    })
                    .then( ()=> setTimeout(() => smoothPageTransit(), 100) )
                    .catch((error) => {
                        console.warn(error);
                    });
            }

            //smoothPageTransit();



    })
	
function fireScripts() {

	//Scroll offset event
    <?php
    $stickyHeaderBreakpoint = ( get_field('override-sticky-header-breakpoint', 'option') ) ? get_field('dev-sticky-header-breakpoint', 'option') : 500;
    $mobNavBreakpoint = ( get_field('override-mob-navi-breakpoint', 'option') ) ? get_field('mob-navi-breakpoint', 'option') : 950;
    ?>

    if ( jQuery( window ).width() > <?=$mobNavBreakpoint;?> ) {

        jQuery(document).on("scroll",function(){
            if(jQuery(document).scrollTop()><?=$stickyHeaderBreakpoint; ?>){
                jQuery(".page-wrapper").removeClass("scroll-top").addClass("scroll-offset");
            }
            else{
                jQuery(".page-wrapper").removeClass("scroll-offset").addClass("scroll-top");
            }
        });

    }

    //Menu hover for tochh


    jQuery('.woocommerce-message').on('click', function() {
            jQuery(this).addClass('hide');
            setTimeout(function() {
                jQuery(this).remove();
            }, 300);

    })

}
</script>