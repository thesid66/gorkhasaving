<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Developed by <a href="https://www.facebook.com/thesid66" onclick="window.open('http://www.twitter.com/iamrealsid')" target="_blank">@thesid66</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">VETNepal</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->


<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<script src="dist/js/jquery.tagsinput.min.js"></script>
<script src="dist/tinymce/tinymce.min.js"></script>
<script>
  tinymce.init({
    selector: ".textarea",
theme: "modern",
height: 300,
subfolder:"",
plugins: [
"advlist autolink link image lists charmap print preview hr anchor pagebreak",
"searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
"table contextmenu directionality emoticons paste textcolor filemanager"
],

image_advtab: true,
toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | link unlink anchor | image media | print preview code |  ",
/*external_filemanager_path:"/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
*/}); 

$('.tagss').tagsInput();
  
  </script>
<!-- Data table -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>

<script>
$(function () {
    $("#dataTable").DataTable({"aaSorting": []});
})
$('.datepicker').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd'
    });
$('.btn-tooltips .btn').tooltip()
function process_response(response) {
	var frm = $("#AllForm");
	var i;
	for (i in response) {
		frm.find('[name="txt' + i + '"]').val(response[i]);
		
	}
}
tinymce.execCommand('mceRemoveControl', true, 'txtShortInfo');

$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });

</script>

</body>
</html>
