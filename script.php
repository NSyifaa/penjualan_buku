<script src="../assets_adminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../assets_adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="../assets_adminLTE/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../assets_adminLTE/plugins/chart.js/Chart.min.js"></script>


<!-- DataTables  & Plugins -->
<script src="../assets_adminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets_adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets_adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets_adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../assets_adminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../assets_adminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../assets_adminLTE/plugins/jszip/jszip.min.js"></script>
<script src="../assets_adminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../assets_adminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../assets_adminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../assets_adminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../assets_adminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": []
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script><script>
  $(function () {
    $("#example11").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": []
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>

<!-- SweetAlert2 -->
<script src="../assets_adminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../assets_adminLTE/plugins/toastr/toastr.min.js"></script>
