jQuery(document).ready(function($) {

  var mobileNav = function() {
    var body = $('body');
    var mobileNavTrigger = $('.hamburger');
    var mobileNavContainer = $('.main-nav ul');

    mobileNavTrigger.bind('click', function(e){
      e.preventDefault();
      $(this).toggleClass('js-is-active');
      body.toggleClass('js-no-scroll');
      mobileNavContainer.toggleClass('js-is-visible');
    });
  }

  var mobileSearch = function() {
    var mobileSearchTrigger = $('.header-search--trigger');
    var mobileSearchForm = $('.mobile-search');

    mobileSearchTrigger.bind('click', function(e){
      e.preventDefault();
      $(this).toggleClass('js-is-active');
      mobileSearchForm.toggleClass('js-is-visible');
    });
  }

  var cartDrawerToggle = function() {
    var body = $('body');
    var cartDrawer = $('.cart-drawer');
    var cartLink = $('.header-cart-link');
    var cartOverlay = $('.cart-overlay');
    var continueShoppingBtn = $('.continue-shopping-btn');

    cartLink.bind('click', function(e){
      e.preventDefault();
      body.addClass('js-no-scroll');
      cartOverlay.addClass('js-is-visible');
      cartDrawer.addClass('js-is-open');
    });

    cartOverlay.bind('click', function(e){
      e.preventDefault();
      body.removeClass('js-no-scroll');
      cartOverlay.removeClass('js-is-visible');
      cartDrawer.removeClass('js-is-open');
    });

    continueShoppingBtn.bind('click', function(e){
      e.preventDefault();
      body.removeClass('js-no-scroll');
      cartOverlay.removeClass('js-is-visible');
      cartDrawer.removeClass('js-is-open');
    });
  }

  var productFilterToggle = function() {
    var productFilterTrigger = $('.product-filter-toggle');
    var productFilterCategories = $('.product-filter-categories');

    productFilterTrigger.bind('click', function(e){
      e.preventDefault();
      $(this).parent().find(productFilterCategories).slideToggle();
    });
  }

  var productThumbToggle = function() {
    var productThumbLink = $('.product-images--thumb');
    var productMainImage = $('.product-images--main .wp-post-image');

    productThumbLink.bind('click', function(e){
      e.preventDefault();
      var searchSrc = /(-?)([\d]{2,4})((\s*)(x)(\s*))([\d]{2,4})/;

      var searchSrcset = /([\d]{2,4})((\s*)(x)(\s*))([\d]{2,4})/;

      var img = $(this).find('img');
      var src = img.attr('src');
      var srcset = img.attr('srcset');
      var srcUrl = src.replace(searchSrc, '');
      // var srcsetURL = srcset.replace(search, '');

      productMainImage.attr('src', srcUrl);
      productMainImage.attr('srcset', '');
      productThumbLink.removeClass('is-active');
      $(this).addClass('is-active');

      console.log(srcUrl);

    });

  }


  mobileNav();
  mobileSearch();
  cartDrawerToggle();
  productFilterToggle();
  productThumbToggle();

});
