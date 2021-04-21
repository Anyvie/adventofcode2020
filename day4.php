<?php

$lines = file(__DIR__."/day4_input.txt");

echo "<h1>Part 1</h1>";

$nbValids = 0;

$fields = [
    "byr", // (Birth Year)
    "iyr", // (Issue Year)
    "eyr", // (Expiration Year)
    "hgt", // (Height)
    "hcl", // (Hair Color)
    "ecl", // (Eye Color)
    "pid", // (Passport ID)
    //"cid", // (Country ID)
];

$passport = "";
foreach ($lines as $line) {
	if (! strlen(trim($line))) {
		$passport .= " _";
		$valid = 1;
		
		foreach ($fields as $f) {			
			if (strpos($passport, $f.':') === false) {
				echo "missing ".$f."<br />";
				$valid = 0; break;
			} else {
				$val = preg_replace("/^(.*?)".$f.":(.*?)[ ](.*)$/ism", "$2", $passport);
				
				if ($f == 'byr') {
					$val = intval($val);
					if ($val < 1920 || $val > 2002) { 
						echo "<br />".$passport."<br />";
						echo "invalid ".$f." (".$val.")<br />";
						$valid=0; break; 
					}
				} elseif ($f == 'iyr') {
					$val = intval($val);
					if ($val < 2010 || $val > 2020) { 
						echo "<br />".$passport."<br />";
						echo "invalid ".$f." (".$val.")<br />";
						$valid=0; break; 
					}
				} elseif ($f == 'eyr') {
					$val = intval($val);
					if ($val < 2020 || $val > 2030) { 
						echo "<br />".$passport."<br />";
						echo "invalid ".$f." (".$val.")<br />";
						$valid=0; break; 
					}
				} elseif ($f == 'hgt') {
					if (strpos($val,'cm') !== false) {
						$val = intval(str_replace('cm','',$val));
						if ($val < 150 || $val > 193) { 
							echo "<br />".$passport."<br />";
							echo "invalid ".$f." (".$val.")<br />";
							$valid=0; break; 
						}
					} elseif (strpos($val,'in') !== false) {
						$val = intval(str_replace('in','',$val));
						if ($val < 59 || $val > 76) { 
							echo "<br />".$passport."<br />";
							echo "invalid ".$f." (".$val.")<br />";
							$valid=0; break; 
						}
					} else {
						echo "<br />".$passport."<br />";
						echo "invalid ".$f." : no in/cm (".$val.")<br />";
						$valid=0; break;
					}
				} elseif ($f == 'hcl') {
					if (! preg_match("/^\#([0-9abcdef]){6}$/is", trim($val))) {
						echo "<br />".$passport."<br />";
						echo "invalid ".$f." (".$val.")<br />";
						$valid=0; break;
					}
				} elseif ($f == 'ecl') {
					if (! in_array(trim($val), ['amb','blu','brn','gry','grn','hzl','oth'])) {
						echo "<br />".$passport."<br />";
						echo "invalid ".$f." (".$val.")<br />";
						$valid=0; break;
					}
				} elseif ($f == 'pid') {
					if (! preg_match("/^([0-9]){9}$/is", trim($val))) {
						echo "<br />".$passport."<br />";
						echo "invalid ".$f." (".$val.")<br />";
						$valid=0; break;
					}
				}
			}
		}
		
		if ($valid) {
			$nbValids++;
		}
		
		$passport = "";
	} else {
		$passport .= " ".$line;
	}
}

echo $nbValids."<br />";
