jQuery(document).ready(function () {
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
});
