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

  $('.categories').fadeOut();

  if ($('#criteria').val() == 'products') {
    $('.categories').slideUp();
    $('.products').slideDown();
  } else {
    $('.categories').slideDown();
    $('.products').slideUp();
  }

  $('#criteria').on('change', function () {
    if (this.value === 'products') {
      $('.categories').slideUp();
      $('.products').slideDown();
    } else {
      $('.categories').slideDown();
      $('.products').slideUp();
    }
  });

  jQuery('').on('click', function () {});
});
