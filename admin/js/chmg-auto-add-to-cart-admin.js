jQuery(document).ready(function ($) {
  jQuery('.chosen-select').chosen();

  jQuery('#aatc_list').DataTable({
    pageLength: 25,
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, 'All'],
    ],
    language: {
      searchPlaceholder: 'search result database...',
    },
  });

  jQuery('.categories').fadeOut();

  jQuery('#aatc-form').on('submit', function (event) {
    var criteria = jQuery('#criteria').val();
    var categories = jQuery('#categories').val();
    var products = jQuery('#products').val();
    var auto_add_product = jQuery('#auto_add_product').val();

    //alert(auto_add_product);

    if (
      (criteria === 'categories' && categories.length <= 0) ||
      (criteria === 'products' && products.length <= 0) ||
      auto_add_product === null ||
      auto_add_product.length <= 0
    ) {
      alert('Ensure that all the required fields were completed');
      event.preventDefault();
    }

    var start_date = $('#start_date').val().split('-');
    var end_date = $('#end_date').val().split('-');

    var g1 = new Date(start_date[0], start_date[1], start_date[2]);
    var g2 = new Date(end_date[0], end_date[1], end_date[2]);

    if (
      $('#start_date').val() !== '0000-00-00' &&
      $('#end_date').val() !== '0000-00-00' &&
      g1 > g2
    ) {
      alert(
        'Oops! Start date is greater than the end date. Please ensure that the start date is less than the end date'
      );
      event.preventDefault();
    }
  });

  if (jQuery('#criteria').val() == 'products') {
    jQuery('.categories').slideUp();
    jQuery('.products').slideDown();
  } else {
    jQuery('.categories').slideDown();
    jQuery('.products').slideUp();
  }

  jQuery('#criteria').on('change', function () {
    if (this.value === 'products') {
      jQuery('.categories').slideUp();
      jQuery('.products').slideDown();
    } else {
      jQuery('.categories').slideDown();
      jQuery('.products').slideUp();
    }
  });
});
