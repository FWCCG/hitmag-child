import $ from 'jquery';

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.resultsDiv = $("#search-overlay__results");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.events();
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
  }

  // 2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }
  

  // 3. methods (function, action...)
  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
      } else {
        this.resultsDiv.html('');
        this.isSpinnerVisible = false;
      }

    }

    this.previousValue = this.searchField.val();
  }

  getResults() {
    $.getJSON(fyldecoastccgsData.root_url + '/wp-json/fyldecoast/v1/search?term=' + this.searchField.val(), (results) => {
      this.resultsDiv.html(`
      <div class="row">
        <div class="one-third">
          <h2 class="search-overlay__section-title">General Information </h2>
          ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No general information matches your search.'}
          ${results.generalInfo.map(item => `<li><a href="${item.url}">${item.title}</a> </li>`).join('')}
          ${results.generalInfo.length ? '</ul>' : ''}          
        </div>
        <div class="one-third">
          <h2 class="search-overlay__section-title">Latest News</h2>
          ${results.news.length ? '<ul class="link-list min-list">' : '<p>No news matches your search.'}
          ${results.news.map(item => `<li><a href="${item.url}">${item.title}</a> </li>`).join('')}
          ${results.news.length ? '</ul>' : ''}
        </div>
        <div class="one-third">
          <h2 class="search-overlay__section-title">Events</h2>
          ${results.events.length ? '<ul class="link-list min-list">' : '<p>No events match your search.'}
          ${results.events.map(item => `<li><a href="${item.url}">${item.title}</a> </li>`).join('')}
          ${results.events.length ? '</ul>' : ''}
          <h2 class="search-overlay__section-title">Documents</h2>
          ${results.documents.length ? '<ul class="link-list min-list">' : '<p>No documents matche your search.'}
          ${results.documents.map(item => `<li><a href="${item.url}">${item.title}</a> </li>`).join('')}
          ${results.documents.length ? '</ul>' : ''}
        </div>
      <div>`);
    })
  }

  keyPressDispatcher(e) {
    if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) {
      this.openOverlay();
    }

    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }

  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    console.log("our open method just ran!");
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    console.log("our close method just ran!");
    this.isOverlayOpen = false;
  }
}
  
  export default Search;