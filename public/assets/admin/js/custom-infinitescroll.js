$('ul.pagination:visible:first').hide();

$(".announce-home").infinitescroll({
        navSelector: 'ul.pagination',    // selector for the paged navigation
        nextSelector: 'ul.pagination li:last-child a',  // selector for the NEXT link (to page 2)
        itemSelector: '.announce-home div.announce-item',     // selector for all items you'll retrieve
        loading: {
            selector: '#announce-load',
            finishedMsg: 'Tidak ada pengumuman lagi',
            msgText: "<em>Memuat pengumuman . . .</em>",
        }
    },
    // call masonry as a callback
    function (newElements) {
        var $newElems = $(newElements);
        $(".announce-home").masonry('appended', $newElems);
        BlankonBlog.masonryGrid();
    }
);