<?php
$db = "/tmp/tests.db";
$smResults = "/opt/latestResult";

if (file_exists($smResults)) {
	echo "<pre>\n";
	readfile($smResults);
	echo "</pre>\n";
}
if (!file_exists($db) || filesize($db) == 0) {
	trigger_error("Can't find the databae file..", E_USER_ERROR);
}

$pdo = new PDO("sqlite:$db");
$stmt = $pdo->query("SELECT DISTINCT filename, date FROM tests ORDER BY date DESC, filename");
if (!$stmt) {
	trigger_error(var_export($pdo->errorInfo(), true), E_USER_ERROR);
}

$stmt->setFetchMode(PDO::FETCH_ASSOC);
$sql = "SELECT description, line, status FROM tests WHERE filename=%s AND date=%d";
$files = array();
$sumFailed = $sumPassed = 0;
foreach($stmt as $row) {
  $fn = basename($row["filename"]);

  // Awesome workaround for not-normalized database
  if (in_array($fn, $files)) {
    continue;
  }
  $files[] = $fn;

  echo "<table border=1 width='100%'>";
  printf("<tr><td width='75%%'><strong>%s</strong></td><td>%s</td></tr>\n", $fn, date(DATE_RSS, $row["date"]));
  $tests = $pdo->query(sprintf($sql, $pdo->quote($row["filename"]), (int)$row["date"]));
  $failed = $passed = 0;
  foreach($tests as $test) {
    printf("<tr><td>%s</td><td bgcolor='#%s'>%s</td></tr>\n", $test["description"], $test["status"] ? "00FF00" : "FF0000", $test["status"] ? "PASS" : "FAIL");
	if ($test["status"]) {
		++$passed;
	} else {
		++$failed;
	}
  }
  $sumFailed += $failed;
  $sumPassed += $passed;
  echo "<tr><td>Summary</td><td>Failed: $failed<br />Passed: $passed</td></tr>\n";
  echo "</table><br /><br />";
}
echo "<hr />\n";
echo "Overall failures: $sumFailed<br />\n";
echo "Overall passsess: $sumPassed<br />\n";
?>


