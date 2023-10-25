<script type="text/javascript" src="{{ asset('assets/DataTables/DataTables-1.11.4/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('assets/js/213devops-edit-dataTable-2.min.js') }}"></script>
<script src="{{ asset('assets/DataTables/FixedHeader-3.2.1/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/Toast/dist/js/toast.min.js') }}"></script>
{{-- <script src="{{ asset('assets/Semantic-UI-CSS-master/calendar/calendar.min.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.3/components/calendar.min.js"
    integrity="sha512-DoyM2DZYfYFSdyYAK/6DukkUF/eGNxSVdgJZ3zFhOVYiEh1zBZ00gnZXgNnFsviDCIJIRLqF8qxeU9OUIqkWyw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/modal/js/iModal.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.scrollto@2.1.3/jquery.scrollTo.min.js"></script>
<script src="{{ asset('assets/js/script1.0.3.js') }}"></script>
@yield('scripts')
@stack('script')
</body>
<div id="izimodal-main" style="display:none">
    <div id="modal-content-main"></div>
</div>

</html>
