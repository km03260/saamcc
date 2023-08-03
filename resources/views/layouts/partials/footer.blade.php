<script type="text/javascript" src="{{ asset('assets/DataTables/DataTables-1.11.4/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('assets/js/5_213devops-edit-dataTable.min.js') }}"></script>
<script src="{{ asset('assets/DataTables/FixedHeader-3.2.1/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/Toast/dist/js/toast.min.js') }}"></script>
<script src="{{ asset('assets/Semantic-UI-CSS-master/calendar/calendar.min.js') }}"></script>
<script src="{{ asset('assets/modal/js/iModal.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="{{ asset('assets/js/script1.0.1.js') }}"></script>
@yield('scripts')
@stack('script')
</body>
<div id="izimodal-main" style="display:none">
    <div id="modal-content-main"></div>
</div>

</html>
