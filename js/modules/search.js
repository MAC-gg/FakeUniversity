import $ from 'jquery';

class Search {
    constructor() {
        // ELEMENTS
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("input#search-term");
        this.searchResults = $("#search-overlay__results");

        // FLAGS
        this.isSpinnerActive = false;
        this.isOverlayActive = false;

        // DECLARATIONS
        this.typingTimer;
        this.prevValue;

        //LISTEN FOR EVENTS
        this.events();
    }

    //EVENTS
    events() {
        // click
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));
        // key press
        $(document).on("keydown", this.keyPressDispatcher.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this));
    }

    // METHODS
    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.isOverlayActive = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.isOverlayActive = false;
    }

    keyPressDispatcher(e) {
        // S key pressed AND overlay is NOT opened AND input or textarea is NOT focused
        if(e.keyCode == 83 && !this.isOverlayActive && !$("input, textarea").is(':focus')) {
            this.openOverlay();
        }

        // ESC is pressed AND overlay IS active
        if(e.keyCode == 27 && this.isOverlayActive) {
            this.closeOverlay();
        }
    }

    typingLogic() {
        // if there is a change to the search field
        if(this.searchField.val() != this.prevValue) {
            clearTimeout(this.typingTimer); // reset timeout
            if(this.searchField.val()) {
                // if search field is NOT empty, show feedback
                if(!this.isSpinnerActive) {
                    this.searchResults.html('<div class="spinner-loader"></div>');
                    this.isSpinnerActive = true;
                }
                // set timeout for results
                this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
            } else {
                // if search field is empty, show nothing
                // no timeout needed cuz no results needed
                this.searchResults.html('');
                this.isSpinnerActive = false;
            }
        }
        this.prevValue = this.searchField.val();
    }

    getResults() {
        this.searchResults.html("imaaaaagine");
        this.isSpinnerActive = false;
    }
}

export default Search;