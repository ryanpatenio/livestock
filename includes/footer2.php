</div>
 <!-- /.content-wrapper -->
  <footer class="main-footer">
 <!--    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div> -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Popper -->
<script src="plugins/popper/umd/popper.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- Core plugin JavaScript-->
<script src="plugins/jquery-easing/jquery.easing.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script> 
<!-- CropperJS -->
<script src="plugins/cropper/cropper.min.js"></script>

<!-- USING CDN ###############################################################################-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.15/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script> -->
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<?php 
  if (isset($_SESSION['status']) && $_SESSION['status'] != "") {
?>
    <script>
      Swal.fire({
        position:'center',
        icon:'<?php echo $_SESSION['status'] ?>',
        title: "<?php echo $_SESSION['message'] ?>",
        showConfirmButton: 'true',
        timer: 2500
      })
    </script>
<?php
  unset($_SESSION['status']);
  unset($_SESSION['message']);
}
?>
<!-- Personal JavaScript -->
<script src="js/myFunctions.js"></script>
<script src="js/myScript.js"></script>
<script src="js/table.js"></script>
</body>
</html>
