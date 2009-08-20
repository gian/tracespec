<html>
<head><title>Trace Spec</title></head>
<body bgcolor="#abcdef">
<h1>Trace Specification Tool</h1>
<form action="<?php echo $PHP_SELF; ?>" method="POST">
<table width="99%">
<tr>
<td>
<h2>Code</h2>
<textarea name="code" rows="25" cols="80"><?php echo htmlentities($_POST['code']); ?></textarea>
</td>
<td>
<h2>Specification</h2>
<textarea name="spec" rows="25" cols="80">
<?php if(!isset($_POST['spec'])) {
?>
OPERATIONS

NECESSARY

SAFE

FORBIDDEN
<?php } else echo htmlentities($_POST['spec']); ?>
</textarea>
</td>
</tr>
<tr>
<td>
<input type="submit" value="Run Analysis">
</td>
<td></td>
</tr>
</table>
</form>
<hr width="98%" noshade="1"/>
<h2>Output</h2>
<font color="red">
<pre>
<?php
$imgfile = NULL;
if(!empty($_POST['code']) && !empty($_POST['spec'])) {
	$basename = tempnam("tmp/", "tracespec_");
	$codefile = $basename . '.lml';
	$specfile = $basename . '.spec';
	$imgfile =  $basename . '.lml.png';
	$outfile =  $basename . '.out';

	$fp = fopen($codefile, "w");
	fwrite($fp, $_POST['code'], 1024*512);
	fclose($fp);
	$fp = fopen($specfile, "w");
	fwrite($fp, $_POST['spec'], 1024*512);
	fclose($fp);

	system('bin/lml ' . $codefile . ' ' . $specfile . ' &> ' . $outfile);
	system('bin/mkpng.sh ' . $codefile);

	print file_get_contents($outfile);
} else {
	print "No input.";
}
?>
</pre>
</font>
<?php
if($imgfile != NULL) {
	print "<h2>Behavioural Type</h2>";
	print "<img src='$imgfile' alt='behavioural type'>\n";
}
?>
</body>
</html>
