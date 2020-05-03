jQuery(document).ready(function () {
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
