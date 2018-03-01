<?php 
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-type: application/force-download");
header ("Content-Type: charset=ISO-8859-1");
header ("Content-Disposition: attachment; filename=".date('dmYHis')."_exportacao.xls");
header ("Content-Description: Generated Report" );
?>
<style type="text/css">*{font-size: 10px;font-family: verdana;}</style>
<?php echo utf_iso($content_for_layout); ?>