<?php
class Library {
    private static function getConfigFromDatabase() {
        $conn = mysqli_connect("localhost", "root", "", "data_qc") or die("Connection failed: " . mysqli_connect_error());
        
        $configs = [];
        $stmt = $conn->query('SELECT * FROM tbconfig');
        while ($row = mysqli_fetch_assoc($stmt)) {
            $configs[$row['nama_config']] = $row['nilai'];
        }
        
        mysqli_close($conn);
        
        return $configs;
    }

    public static function calculateLsf($d) {
        $configs = self::getConfigFromDatabase();
        
        $lsf = null;
        if (!empty($d['SiO2'])) {
            $lsf = ($d['CaO'] * $configs['lsf_1']) / 
                   ($configs['lsf_2'] * $d['SiO2'] + 
                   $configs['lsf_3'] * $d['Al2O3'] + 
                   $configs['lsf_4'] * $d['Fe2O3']);
        }
        
        return !is_null($lsf) ? number_format((float)$lsf, 2, '.', '') : null;
    }

    public static function calculateSum($d) {
        $configs = self::getConfigFromDatabase();
        
        $sum = null;
        if (!empty($d['SiO2'])) {
            $sum = $d['SiO2'] + $d['Al2O3'] + $d['Fe2O3'] + ($d['CaO'] * $configs['sum_1']) + ($d['MgO'] * $configs['sum_2']) + $d['SO3'] + $d['K2O'] + $d['Na2O'] + $d['Cl2'];
        }
        
        return !is_null($sum) ? number_format((float)$sum, 2, '.', '') : null;
    }

    public static function calculateSim($d) {
        $sim = null;
        if (!empty($d['SiO2']) && ($d['Al2O3'] + $d['Fe2O3']) != 0) {
            $sim = $d['SiO2'] / ($d['Al2O3'] + $d['Fe2O3']);
        }
        return !is_null($sim) ? number_format((float)$sim, 2, '.', '') : null;
    }

    public static function calculateAlm($d) {
        $alm = null;
        if (!empty($d['Al2O3']) && $d['Fe2O3'] != 0) {
            $alm = $d['Al2O3'] / $d['Fe2O3'];
        }
        return !is_null($alm) ? number_format((float)$alm, 2, '.', '') : null;
    }

    public static function calculateAlkali($d) {
        $alkali = null;
        if (!empty($d['Na2O']) || !empty($d['K2O'])) {
            $alkali = $d['Na2O'] + ($d['K2O'] * 0.658);
        }
        return !is_null($alkali) ? number_format((float)$alkali, 2, '.', '') : null;
    }

     public static function calculateC3s($d) {
        $c3s = null;
		if (!empty($d['SiO2'])) {
		$c3s = 4.071 * ($d['CaO'] - $d['FCaO']) - 7.6 * $d['SiO2'] - 6.718 * $d['Al2O3'] - 1.43 * $d['Fe2O3'];
		}
		 return !is_null($c3s) ? number_format((float)$c3s, 2, '.', '') : null;
	}
	public static function calculateC3a($d) {
       $c3a = null;
		if (!empty($d['Al2O3'])) {
		$c3a = 2.65 * $d['Al2O3'] - 1.692 * $d['Fe2O3'];
		}
		 return !is_null($c3a) ? number_format((float)$c3a, 2, '.', '') : null;

	}
	public static function calculateSio2($d) {
      $sio2_back = null;
		if (!empty($d['SiO2']) && $d['LS_act'] != 0) {
		$sio2_back = (($d['SiO2'] - ($d['SS_act'] * 70.21 / 100) - ($d['CL_act'] * 48.86 / 100) - ($d['IS_act'] * 26.35 / 100)) / ($d['LS_act'] / 100));
		 return !is_null($sio2_back) ? number_format((float)$sio2_back, 2, '.', '') : null;
		}					
	}
	public static function calculateAl2o3($d) {
     $al2o3_back = null;
	if (!empty($d['Al2O3']) && $d['LS_act'] != 0) {
	$al2o3_back = (($d['Al2O3'] - ($d['SS_act'] * 10.42 / 100) - ($d['CL_act'] * 25.49 / 100) - ($d['IS_act'] * 6.49 / 100)) / ($d['LS_act'] / 100));
	return !is_null($al2o3_back) ? number_format((float)$al2o3_back, 2, '.', '') : null;
		}
	}
	public static function calculateFe2o3($d) {
    $fe2o3_back = null;
	if (!empty($d['Fe2O3']) && $d['LS_act'] != 0) {
	$fe2o3_back = (($d['Fe2O3'] - ($d['SS_act'] * 5.02 / 100) - ($d['CL_act'] * 9.85 / 100) - ($d['IS_act'] * 59.22 / 100)) / ($d['LS_act'] / 100));
	return !is_null($fe2o3_back) ? number_format((float)$fe2o3_back, 2, '.', '') : null;
		}
	}
	public static function calculateCao($d) {
    $cao_back = null;
	if (!empty($d['CaO']) && $d['LS_act'] != 0) {
	$cao_back = (($d['CaO'] - ($d['SS_act'] * 2.98 / 100) - ($d['CL_act'] * 0.83 / 100) - ($d['IS_act'] * 0 / 100)) / ($d['LS_act'] / 100));
	return !is_null($cao_back) ? number_format((float)$cao_back, 2, '.', '') : null;
		}

	}
}




?>
