<!-- -->
<div class="breadcrumb">
  <?php
  $nap = new midcom_helper_nav();
  $separator = '<span class="breadcrumb_separator"></span>';
  echo $nap->get_breadcrumb_line($separator, null, 1);
  ?>
</div>
