  <!-- JAVASCRIPT -->
  <script src="{{ asset('admin_theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin_theme/assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('admin_theme/assets/libs/node-waves/waves.min.js') }}"></script>
  <script src="{{ asset('admin_theme/assets/libs/feather-icons/feather.min.js') }}"></script>
  <script src="{{ asset('admin_theme/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
  <script src="{{ asset('admin_theme/assets/js/plugins.js') }}"></script>

  <!-- apexcharts -->
  <script src="{{ asset('admin_theme/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

  <!-- Vector map-->
  <script src="{{ asset('admin_theme/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
  <script src="{{ asset('admin_theme/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

  <!--Swiper slider js-->
  <script src="{{ asset('admin_theme/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Dashboard init -->
  <script src="{{ asset('admin_theme/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

  <!-- App js -->
  <script src="{{ asset('admin_theme/assets/js/app.js') }}"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <!-- Custom Scripts -->
  <script>
    // When typing in #title, auto-generate slug in #slug, using _ for spaces
    $(document).ready(function() {
        function slugify(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '_')           // Replace spaces with underscores
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars except -
                .replace(/\_+/g, '_');          // Collapse multiple underscores
        }

        $('#title').on('input', function() {
            var value = $(this).val() || '';
            var slug = slugify(value);
            $('#slug').val(slug);
        });
    });
</script>

<!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/tiet9qauswpk6vc5sg5njp2z3xekpixcpe9kgee0ty67zcba/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
      tinymce.init({
        selector: 'textarea',
        plugins: [
          // Core editing features
          'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'searchreplace', 'table', 'visualblocks', 'wordcount',
           ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        uploadcare_public_key: 'ff3c326165b9645573af',
      });
    </script>

  @livewireScripts
  @yield('scripts')
