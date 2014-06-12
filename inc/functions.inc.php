<?php
	$year = date('Y');
	$month = date('m');
	$day = date('d');

	function age($value){
		global $year;
		global $month;
		global $day;
		$birthDate = explode('-', $value);

		$birthYear = $birthDate[0];
		$birthMonth = $birthDate[1];
		$birthDay = $birthDate[2];

		$age = $year-$birthYear;
		$diffMonth = $month-$birthMonth;
		if($diffMonth < 0) {
			$age = $age-1;
		}elseif($diffMonth == 0) {
			$diffDay = $day-$birthDay;
			if ($diffDay < 0) {
				$age = $age-1;
			}
		}
		return $age;
	}

	function month($value){
		if($value=='01'){$month_text='Janvier';}
		elseif($value=='02'){$month_text='Février';}
		elseif($value=='03'){$month_text='Mars';}
		elseif($value=='04'){$month_text='Avril';}
		elseif($value=='05'){$month_text='Mai';}
		elseif($value=='06'){$month_text='Juin';}
		elseif($value=='07'){$month_text='Juillet';}
		elseif($value=='08'){$month_text='Août';}
		elseif($value=='09'){$month_text='Septembre';}
		elseif($value=='10'){$month_text='Octobre';}
		elseif($value=='11'){$month_text='Novembre';}
		elseif($value=='12'){$month_text='Décembre';}
		return $month_text;
	}
?>