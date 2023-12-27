/**
 * WEBSITE: https://themefisher.com
 * TWITTER: https://twitter.com/themefisher
 * FACEBOOK: https://www.facebook.com/themefisher
 * GITHUB: https://github.com/themefisher/
 */

function redirectToProfileDetails() {
  // 導向到指定的網頁
window.location.href = "dashboard.html";
}

(function () { //分頁+搜尋功能
  var pageSize = 5;
  var currentPage = 1;
  var originalOrders;

  window.onload = function () {
      // 保存原始的訂單數據
      originalOrders = document.querySelectorAll(".table tbody tr");

      updateTable();
      updatePagination();
  };

  function searchOrders() {
      currentPage = 1;
      updateTable();
      updatePagination();
  }

  function clearSearch() {
      document.getElementById("searchInput").value = "";
      updateTable();
      updatePagination();
  }

  function updateTable() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.querySelector(".table");
      tr = originalOrders; // 使用保存的原始訂單數據

      var filteredOrders = [];
      for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
          if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  filteredOrders.push(tr[i].cloneNode(true));
              }
          }
      }

      var start = (currentPage - 1) * pageSize;
      var end = start + pageSize;
      var tbody = document.getElementById("ordersTableBody");
      tbody.innerHTML = "";
      for (i = start; i < end && i < filteredOrders.length; i++) {
          tbody.appendChild(filteredOrders[i]);
      }
  }

  function updatePagination() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.querySelector(".table");
      tr = originalOrders; // 使用保存的原始訂單數據

      var filteredOrders = [];
      for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
          if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  filteredOrders.push(tr[i]);
              }
          }
      }

      var totalPages = Math.ceil(filteredOrders.length / pageSize);

      // 選擇第二個分頁控制元件
      var pagination = document.getElementById("pagination2");
      pagination.innerHTML = "";
      for (var page = 1; page <= totalPages; page++) {
          var pageLink = document.createElement("a");
          pageLink.href = "#";
          pageLink.textContent = page;
          pageLink.onclick = function () {
              currentPage = parseInt(this.textContent);
              updateTable();
              updatePagination();
              return false;
          };
          if (page === currentPage) {
              pageLink.classList.add("active");
          }
          pagination.appendChild(pageLink);
      }
  }

  // 監聽按下 Enter 鍵的事件
  document.getElementById('searchInput').addEventListener('keyup', function (event) {
      // keyCode 13 代表 Enter 鍵
      if (event.keyCode === 13) {
          searchOrders(); // 執行搜索函式
      }
  });

  // 監聽按下搜尋按鈕的事件
  document.getElementById('searchButton').addEventListener('click', function () {
    searchOrders(); // 執行搜索函式
  });
})();


(function ($) {
  'use strict';

  // Preloader
  $(window).on('load', function () {
    $('#preloader').fadeOut('slow', function () {
      $(this).remove();
    });
  });

  
  // Instagram Feed
  if (($('#instafeed').length) !== 0) {
    var accessToken = $('#instafeed').attr('data-accessToken');
    var userFeed = new Instafeed({
      get: 'user',
      resolution: 'low_resolution',
      accessToken: accessToken,
      template: '<a href="{{link}}"><img src="{{image}}" alt="instagram-image"></a>'
    });
    userFeed.run();
  }

  setTimeout(function () {
    $('.instagram-slider').slick({
      dots: false,
      speed: 300,
      // autoplay: true,
      arrows: false,
      slidesToShow: 6,
      slidesToScroll: 1,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 4
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2
          }
        }
      ]
    });
  }, 1500);


  // e-commerce touchspin
  $('input[name=\'product-quantity\']').TouchSpin();


  // Video Lightbox
  $(document).on('click', '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox();
  });


  // Count Down JS
  $('#simple-timer').syotimer({
    year: 2022,
    month: 5,
    day: 9,
    hour: 20,
    minute: 30
  });

  //Hero Slider
  $('.hero-slider').slick({
    // autoplay: true,
    infinite: true,
    arrows: true,
    prevArrow: '<button type=\'button\' class=\'heroSliderArrow prevArrow tf-ion-chevron-left\'></button>',
    nextArrow: '<button type=\'button\' class=\'heroSliderArrow nextArrow tf-ion-chevron-right\'></button>',
    dots: true,
    autoplaySpeed: 7000,
    pauseOnFocus: false,
    pauseOnHover: false
  });
  $('.hero-slider').slickAnimation();


})(jQuery);
