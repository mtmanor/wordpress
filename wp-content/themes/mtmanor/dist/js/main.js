jQuery(document).ready(function($) {

  var stickyHeader = function() {
    var body = $('body');
    var header = $('.header');
    var headerPos = header.offset();
    var headerTopPos = headerPos.top;

    $(window).on('scroll', function(e) {
      var topPos = $(window).scrollTop();
      if(topPos >= headerTopPos) {
        header.addClass('js-is-sticky');
        body.addClass('js-sticky-header');
      } else {
        header.removeClass('js-is-sticky');
        body.removeClass('js-sticky-header');
      }
    });
  };

  var mobileNav = function() {
    var body = $('body');
    var windowWidth = $(window).width();
    var header = $('.header');
    var mobileNavTrigger = $('.hamburger');
    var mobileNavContainer = $('.menu');
    var mobileNavParentItem = $('.main-nav .menu > li > a');

    mobileNavTrigger.bind('click', function(e){
      e.preventDefault();
      $(this).toggleClass('js-is-active');
      body.toggleClass('js-no-scroll');
      header.toggleClass('js-is-sticky');
      mobileNavContainer.toggleClass('js-is-visible');
    });

    if(windowWidth < 1000) {
      mobileNavParentItem.bind('click', function(e){
        e.preventDefault();
        $(this).parent().find('.sub-menu').slideToggle();
        $(this).parent().toggleClass('js-is-active');
      });
    }
  }

  var mobileSearch = function() {
    var mobileSearchTrigger = $('.header-search--trigger');
    var mobileSearchForm = $('.mobile-search');
    var mobileSearchInput = $('.mobile-search--input');

    mobileSearchTrigger.bind('click', function(e) {
      e.preventDefault();
      $(this).toggleClass('js-is-active');

      if ($(this).is('.js-is-active')) {
        setTimeout(function() {
          $('.mobile-search--input').val('');
        }, 1000);
        $('.mobile-search--input').blur();
        mobileSearchForm.removeClass('js-is-visible');
      } else {
        $('.mobile-search--input').focus();
        mobileSearchForm.addClass('js-is-visible');
      }
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
    var productFilterTrigger = $('.sidebar-nav--title');
    var productFilterCategories = $('.sidebar-nav--categories');

    productFilterTrigger.bind('click', function(e){
      e.preventDefault();
      $(this).parent().find(productFilterCategories).slideToggle();
    });
  }

  var couponToggle = function() {
    couponTrigger = $('.cart-coupon--trigger');
    couponForm = $('.cart-coupon--form');

    couponTrigger.bind('click', function(e){
      e.preventDefault();
      couponForm.toggle();
    })
  }

  stickyHeader();
  mobileNav();
  mobileSearch();
  couponToggle();
  productFilterToggle();
  // cartDrawerToggle();

});
